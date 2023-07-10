<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php include "inc/db.php" ?>
<?php session_start(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">

                        <div class="_buttons">

                            <?php
                            if (has_permission('kargo', '', 'tablo')) {
                            ?>
                                <a class="btn btn-primary" href="../kargo">Kargo Listesine Dön</a>

                            <?php
                            }
                            ?>
                            <?php
                            if (has_permission('kargo', '', 'iadeekle')) {
                            ?>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    İade Kutu Ekle
                                </button>

                            <?php
                            }
                            ?>
                        </div>




                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table style="width:100%;" id="digiturktable" class="table dt-table">
                                <thead>
                                    <tr>

                                        <th>ID</th>
                                        <th>Gönderecek Kişinin İsmi</th>
                                        <th>Takip Numarası</th>
                                        <th>Fotoğrafı</th>
                                        <th>Durum</th>
                                        <th>Açıklama</th>
                                        <th>Oluşturan Kişi</th>
                                        <th>Tarih</th>
                                        <th>İade Mac</th>
                                        <th>Düzenle</th>
                                        <th>Sil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($_GET['sorgu'] == "0") {
                                        $sqldurum = "İade Edildi";
                                    } else if ($_GET['sorgu'] == "1") {
                                        $sqldurum = "Bekleniyor";
                                    }
                                    $suankim = $_SESSION['staff_user_id'];
                                    if ($suankim == "1") {
                                        $query = $db->prepare("SELECT * FROM tblkargo_iade WHERE durum=? ");
                                        $query->execute(array($sqldurum));
                                        $results = $query->fetchAll(PDO::FETCH_ASSOC);
                                    } else {
                                        $query = $db->prepare("SELECT * FROM tblkargo_iade WHERE durum=? AND personel=?");
                                        $query->execute(array($sqldurum, $suankim));
                                        $results = $query->fetchAll(PDO::FETCH_ASSOC);
                                    }
                                    foreach ($results as $result) {
                                        $musteri = $db->prepare("SELECT * FROM tblclients WHERE userid=?");
                                        $musteri->execute(array($result['gonderen_adisoyadi']));
                                        $musterisonuc = $musteri->fetch(PDO::FETCH_ASSOC);

                                        $staf = $db->prepare("SELECT * FROM tblstaff WHERE staffid=?");
                                        $staf->execute(array($result['personel']));
                                        $stafsonuc = $staf->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                        <tr>

                                            <th>
                                                <?= $result['id'] ?>
                                            </th>
                                            <th>
                                                <a href="../clients/client/<?= $musterisonuc['userid'] ?>">
                                                    <?= $musterisonuc['company'] ?></a>
                                            </th>
                                            <th>
                                                <?= $result['takip_numarasi'] ?><br>
                                                <a onclick="kargo_control2('<?= $result['takip_numarasi'] ?>')" class="btn btn-warning">Kargo Kontrol Et</a>

                                            </th>
                                            <th><?php
                                                if (!empty($result['fotograf'])) {
                                                    echo "<div id='resimdiv'>";
                                                    echo "<a href='../../assets/images/kargo/kargo/" . $result['kargo_foto'] . "'><img src='../../assets/images/kargo/iade/" . $result['fotograf'] . "' width='50' height='50'></a></div>";
                                                }
                                                ?></th>
                                            <th>
                                                <?php
                                                if ($result['durum'] == "Bekleniyor") {
                                                    echo "<a target='_blank' href='../clients/client/" . $musterisonuc['userid'] . "?group=kargo'>Cihaz İadesi Bekliyoruz</a>";
                                                } else if ($iadesonuc['durum'] == "İade Edildi") {
                                                    echo "<a href='kargo/iade_kargolar?sorgu=0'>İade Edildi</a>";
                                                } ?>
                                            </th>
                                            <th>
                                                <?= $result['aciklama'] ?>
                                            </th>
                                            <th><?= $stafsonuc['firstname'] ?> <?= $stafsonuc['lastname'] ?></th>
                                            <th><?= $result['tarih'] ?></th>
                                            <th><?= $result['iademac'] ?></th>
                                            <th>
                                                <?php
                                                if (has_permission('kargo', '', 'iadeduzenle')) {
                                                ?>

                                                    <a href="javascript:void(0);" data-target="#Modalupdate" data-toggle="modal" class="btn btn-primary" onclick="iade_get(<?= $result['id'] ?>)">
                                                        Düzenle
                                                    </a>
                                                <?php
                                                }
                                                ?>
                                            </th>
                                            <th>
                                                <?php
                                                if (has_permission('kargo', '', 'iadesilme')) {
                                                ?>
                                                    <a href="javascript:void(0);" onclick="iade_delete('<?= $result['id'] ?>')" class="btn btn-danger mb-1 mb-md-0">
                                                        Sil
                                                    </a>
                                                <?php
                                                }
                                                ?>

                                            </th>


                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Güncelle MODAL -->
<form id="iadeguncelle" action="" method="POST" enctype="multipart/form-data">

    <div class="modal fade" id="Modalupdate" tabindex="-1" role="dialog" aria-labelledby="ModalUpdate" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalUpdate">İade Güncelle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="hidden" name="idgnc" id="idgnc">
                                <label for="clientid" class="control-label"> <small class="req text-danger">*
                                    </small>Gönderen Adı Soyadı</label>
                                <div class="dropdown bootstrap-select ajax-search bs3 open" style="width: 100%;"><select id="clientid" name="gonderenadgnc1" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="Seçim yapılmadı" tabindex="-98" title="Seçin ve yazmaya başlayın">
                                        <option class="bs-title-option" value=""></option>
                                    </select>
                                </div>
                                <input type="hidden" name="gonderenadgnc" id="gonderenadgnc">

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">

                                <label class="control-label">Takip Numarası</label>
                                <input type="text" class="form-control" autocomplete="off" name="takipnognc" id="takipnognc">

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">

                                <label class="control-label">Fotoğraf Ekle</label>
                                <input type="file" class="form-control" autocomplete="off" name="iadefotognc" id="iadefotognc">
                                <img id="iadefotosrcgnc" name="iadefotosrcgnc" width="50%" height="50%">
                                <input type="hidden" id="eskiiadefoto" name="eskiiadefoto">



                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <p>Durum</p>
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <input class="form-check-input durumgnc" type="radio" name="durumgnc" id="iadeedildignc" value="İade Edildi">
                                        <label class="control-label" for="iadeedildignc">İade Edildi</label>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <input class="form-check-input durumgnc" type="radio" name="durumgnc" id="bekleniyorgnc" value="Bekleniyor">
                                        <label class="control-label" for="bekleniyorgnc">Bekleniyor</label>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label" for="iademac">Mac</label>
                                <input type="text" class="form-control" autocomplete="off" required name="iademacgnc" id="iademacgnc">

                            </div>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">

                                <label class="control-label">Açıklama</label>
                                <textarea class="form-control" autocomplete="off" name="aciklamagnc" id="aciklamagnc" rows="4" cols="50">
                                </textarea>
                                <input type="hidden" name="staff_user_id1" value="<?= $_SESSION['staff_user_id'] ?>">



                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a style="float:left;" onclick="kargo_control1()" class="btn btn-warning">Kargo Kontrol Et</a>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button type="submit" name="cron_insert" id="guncellebut" class="btn btn-primary submit">
                            Güncelle
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
<!-- EKLE MODAL -->
<form id="iadeekle" action="" method="POST" enctype="multipart/form-data">

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">

                                <label for="clientid" class="control-label"> <small class="req text-danger">*
                                    </small>Gönderen Adı Soyadı</label>
                                <div class="dropdown bootstrap-select ajax-search bs3 open" style="width: 100%;"><select id="clientid" name="gonderenad" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="Seçim yapılmadı" tabindex="-98" title="Seçin ve yazmaya başlayın">
                                        <option class="bs-title-option" value=""></option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">

                                <label class="control-label">Takip Numarası</label>
                                <input type="text" class="form-control" autocomplete="off" name="takipno" id="takipno">

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">

                                <label class="control-label">Fotoğraf Ekle</label>
                                <input type="file" class="form-control" autocomplete="off" name="iadefoto" id="iadefoto">


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <p>Durum</p>
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <input class="form-check-input durum" required type="radio" name="durum" id="iadeedildi" value="İade Edildi">
                                        <label class="control-label" for="iadeedildi">İade Edildi</label>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <input class="form-check-input durum" required type="radio" name="durum" id="bekleniyor" value="Bekleniyor">
                                        <label class="control-label" for="bekleniyor">Bekleniyor</label>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label" for="iademac">Mac</label>
                                <input type="text" class="form-control" autocomplete="off" required name="iademac" id="iademac">

                            </div>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">

                                <label class="control-label">Açıklama</label>
                                <textarea class="form-control" autocomplete="off" name="aciklama" id="aciklama" rows="4" cols="50" required></textarea>
                                <input type="hidden" name="staff_user_id" value="<?= $_SESSION['staff_user_id'] ?>">



                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a style="float:left;" onclick="kargo_control()" class="btn btn-warning">Kargo Kontrol Et</a>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button type="submit" id="iadeeklebut" name="cron_insert" class="btn btn-primary submit">
                            Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>







<?php init_tail(); ?>
<script src="../../inc/lightgallery-all.js"></script>

<script>
    $(document).ready(function() {
        $('#resimdiv').lightGallery({
            thumbnail: true,
            animateThumb: false,
            showThumbByDefault: false
        });
        $("#iadeekle").submit(function() {
            $("#iadeeklebut").prop('disabled', true);
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "../../exec/ajaxiadeekle.php",
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                cache: false,
                data: formData,
                type: "POST",
                dataType: 'json',
                success: function(e) {
                    if (e == "0") {
                        alert_float("success", "Ekleme Başarılı");
                        window.location.href =
                            "iade_kargolar?sorgu=0";

                    } else if (e == "1") {
                        alert_float("success", "Ekleme Başarılı");
                        window.location.href =
                            "iade_kargolar?sorgu=1";
                    } else if (e == "3") {
                        alert_float("danger",
                            "Sadece JPG, JPEG, PNG & GIF bu uzantılar resimdir ve bunları yükleyebilirsiniz!"
                        );
                        $('#iadeeklebut').prop("disabled", false);



                    }


                },
                error: function(e) {
                    alert_float("danger", "Eksik bilgi girildi");
                    $('#iadeeklebut').prop("disabled", false);


                }
            });
            return false;
        });
        $("#iadeguncelle").submit(function() {
            $('#guncellebut').prop("disabled", false);

            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "../../exec/ajaxiadeguncelle.php",
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                cache: false,
                data: formData,
                type: "POST",
                dataType: 'json',
                success: function(e) {
                    if (e == "0") {
                        alert_float("success", "Ekleme Başarılı");
                        window.location.href =
                            "iade_kargolar?sorgu=0";

                    } else if (e == "1") {
                        alert_float("success", "Ekleme Başarılı");
                        window.location.href =
                            "iade_kargolar?sorgu=1";
                    } else if (e == "3") {
                        alert_float("danger",
                            "Sadece JPG, JPEG, PNG & GIF bu uzantılar resimdir ve bunları yükleyebilirsiniz!"
                        );
                        $('#guncellebut').prop("disabled", false);

                    }


                },
                error: function(e) {
                    alert_float("danger", "Eksik bilgi girildi");
                    $('#guncellebut').prop("disabled", false);

                }
            });
            return false;
        });

    });

    function kargo_control2(no) {

        if (no != "") {
            window.open('https://auspost.com.au/mypost/track/#/details/' + no, '_blank');
        } else {
            alert_float("danger", "Takip Numarası Girin");
        }
    }

    function kargo_control1() {
        var takipnumarasi = $('#takipnognc').val();
        if (takipnumarasi != "") {
            window.open('https://auspost.com.au/mypost/track/#/details/' + takipnumarasi, '_blank');
        } else {
            alert_float("danger", "Takip Numarası Girin");
        }
    }

    function kargo_control() {
        var takipnumarasi = $('#takipno').val();
        if (takipnumarasi != "") {
            window.open('https://auspost.com.au/mypost/track/#/details/' + takipnumarasi, '_blank');
        } else {
            alert_float("danger", "Takip Numarası Girin");
        }
    }

    function iade_delete(id) {
        $.ajax({
            url: '../../exec/ajaxdeleteiade.php',
            method: 'post',
            dataType: "json",

            data: {
                'id': id

            },
            success: function(results) {
                if (results == "1") {
                    window.location.reload();
                }
            }
        });
    }

    function iade_get(id) {
        $.ajax({
            url: '../../exec/ajaxgetiade.php',
            method: 'post',
            dataType: "json",

            data: {
                'id': id

            },
            success: function(results) {
                $('#idgnc').val(id);
                $('#gonderenadgnc').val(results[0].gonderenadgnc);
                $('#takipnognc').text(results[0].takipnognc);
                $('#aciklamagnc').val(results[0].aciklamagnc);
                $('#iademacgnc').val(results[0].iademac);
                if (results[0].foto != "") {
                    $('#iadefotosrcgnc').attr("src", "../../assets/images/kargo/iade/" + results[0].foto);
                }
                $('#eskiiadefoto').val(results[0].foto);

                if (results[0].durum == "İade Edildi") {
                    $('#iadeedildignc').prop("checked", true);
                }
                if (results[0].durum == "Bekleniyor") {
                    $('#bekleniyorgnc').prop("checked", true);
                }


            }
        });
    }
</script>
</body>

</html>