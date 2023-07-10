<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php /*include "inc/db.php" */?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">

                        <div class="_buttons">
                            <?php
                            if (has_permission('kargo', '', 'kargoekle')) {
                            ?>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    Kargo Ekle
                                </button>
                            <?php
                            }
                            ?>
                            <?php
                            if (has_permission('kargo', '', 'gonderilenkargolar')) {
                            ?>
                                <a class="btn btn-primary" href="kargo/gonderilen_kargolar">Gönderilen Kargolar</a>
                            <?php
                            }
                            ?>
                            <?php
                            if (has_permission('kargo', '', 'gonderilmeyibekleyen')) {
                            ?>
                                <a class="btn btn-primary" href="kargo/gonderilmeyi_bekleyen_kargolar">Gönderilmeyi Bekleyen
                                    Kargolar</a>
                            <?php
                            }
                            ?>
                            <?php
                            if (has_permission('kargo', '', 'teslimedilen')) {
                            ?>
                                <a class="btn btn-primary" href="kargo/teslim_edilen">Teslim Edilen Kargolar</a>

                            <?php
                            }
                            ?>
                        </div>


                        <form id="faturaekle" action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="staff_user_id" value="<?= $_SESSION['staff_user_id'] ?>">
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Yeni kargo ekle</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <!--div class="form-group">
                                                        <label class="control-label">Müşteri İsmi</label>
                                                        <select class="form-control" onchange="musteribilgiler(this);"
                                                            id="musteri_ismi" name="musteri_ismi">
                                                            <option>Seçiniz</option>
                                                            <?php
                                                            /*
                                                                $musteriget=$db->prepare("SELECT * FROM tblclients");
                                                                $musteriget->execute();
                                                                $musteriresult=$musteriget->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($musteriresult as $ff){
                                                                    echo "<option value='".$ff['userid']."'>".$ff['company']."</option>";
                                                                }
                                                                */
                                                            ?>
                                                        </select>
                                                    </div-->

                                                    <label for="clientid" class="control-label"> <small class="req text-danger">* </small>Müşteri</label>
                                                    <div class="dropdown bootstrap-select ajax-search bs3 open" style="width: 100%;"><select onchange="musteribilgiler(this);" id="clientid" name="musteri_ismi" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="Seçim yapılmadı" tabindex="-98" title="Seçin ve yazmaya başlayın" required>
                                                            <option class="bs-title-option" value=""></option>
                                                        </select>
                                                    </div>


                                                    <a style="display:none;" id="fatura_adresi" target="_blank">Faturayı Gör</a>
                                                </div><!-- Col -->
                                                <div class="col-sm-3">
                                                    <div class="form-group">

                                                        <label class="control-label">Eyalet</label>
                                                        <input type="text" class="form-control" autocomplete="off" name="eyaletmodal1" id="eyaletmodal1" disabled>
                                                        <input type="hidden" name="eyaletmodal" id="eyaletmodal">
                                                    </div>


                                                </div><!-- Col -->
                                                <div class="col-sm-3">

                                                    <div class="form-group">

                                                        <label class="control-label">Mahalle</label>
                                                        <input type="text" class="form-control" autocomplete="off" name="mahallemodal1" id="mahallemodal1" disabled>
                                                        <input type="hidden" name="mahallemodal" id="mahallemodal">
                                                    </div>

                                                </div><!-- Col -->
                                                <div class="col-sm-2">
                                                    <div class="form-group">

                                                        <label class="control-label">Posta Kodu</label>
                                                        <input type="text" class="form-control" autocomplete="off" name="zipmodal1" id="zipmodal1" disabled>
                                                        <input type="hidden" name="zipmodal" id="zipmodal">
                                                    </div>

                                                </div><!-- Col -->
                                                <div class="col-sm-12">
                                                    <div class="form-group">

                                                        <label class="control-label">Adres</label>
                                                        <textarea class="form-control" autocomplete="off" name="adresmodal1" id="adresmodal1" disabled></textarea>
                                                        <input type="hidden" name="adresmodal" id="adresmodal">
                                                    </div>

                                                </div><!-- Col -->
                                            </div><!-- Row -->
                                            <br>
                                            <hr>
                                            <br>
                                            <div class="row" id="kargourundiv">

                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                </div>
                                                <div class="col-sm-4" style="text-align: center;">
                                                    <input type="button" value="Ürün Ekle" onclick="urunekle()" class="btn btn-primary" style="text-align: center;">
                                                </div>
                                                <div class="col-sm-4">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">

                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <input required class="form-check-input gonderim" type="radio" name="gonderim" id="ucretligonderim" value="Ücretli Gönderim">
                                                        <label class="control-label" for="ucretligonderim">Ücretli
                                                            Gönderim</label>

                                                    </div>


                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <input class="form-check-input gonderim" type="radio" name="gonderim" id="ucretsizgonderim" value="Ücretsiz Gönderim">
                                                        <label class="control-label" for="ucretsizgonderim">Ücretsiz
                                                            Gönderim</label>

                                                    </div>


                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <input class="form-check-input gonderim" type="radio" name="gonderim" id="degisim" value="Değişim">
                                                        <label class="control-label" for="degisim">Ücretsiz
                                                            Değişim</label>

                                                    </div>


                                                </div>


                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <input required class="form-check-input durum" type="radio" name="durum" id="gonderimehazir" value="Göndermeye Hazır">
                                                        <label class="control-label" for="gonderimehazir">Göndermeye
                                                            Hazır</label>

                                                    </div>


                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <input class="form-check-input durum" type="radio" name="durum" id="gonderildi" value="Gönderildi">
                                                        <label class="control-label" for="gonderildi">Gönderildi</label>

                                                    </div>


                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <input class="form-check-input durum" type="radio" name="durum" id="teslimedildi" value="Teslim Edildi">
                                                        <label class="control-label" for="teslimedildi">Teslim
                                                            Edildi</label>

                                                    </div>


                                                </div>
                                                <div id="iadegizle" style="display:none;">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <input class="form-check-input iadedurum" type="radio" name="iadedurum" id="cihaziadesibekliyoruz" value="Cihaz İadesi Bekliyoruz">
                                                            <label class="control-label" for="cihaziadesibekliyoruz">Cihaz İadesi
                                                                Bekliyoruz</label>

                                                        </div>


                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <input class="form-check-input iadedurum" type="radio" name="iadedurum" id="cihaziadesibeklemiyoruz" value="Cihaz İadesi Beklemiyoruz">
                                                            <label class="control-label" for="cihaziadesibeklemiyoruz">Cihaz İadesi
                                                                Beklemiyoruz</label>

                                                        </div>


                                                    </div>
                                                    <div id="iadeaciklamagizle" style="display:none;">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label class="control-label" for="iadeaciklama">Açıklama</label>
                                                                <textarea class="form-control" autocomplete="off" name="iadeaciklama" id="iadeaciklama" rows="2" cols="50"></textarea>

                                                            </div>


                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-group">
                                                                <label class="control-label" for="iademac">Mac</label>
                                                                <input type="text" class="form-control" autocomplete="off" name="iademac" id="iademac">

                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-8" style="display:none" id="takipdiv">
                                                        <div class="form-group">
                                                            <label class="control-label">Takip Numarası</label>
                                                            <input type="text" class="form-control" autocomplete="off" name="takipnumarasi" id="takipnumarasi">

                                                        </div>

                                                    </div>
                                                    <div class="col-sm-4" style="display:none" id="fotodiv">
                                                        <div class="form-group">
                                                            <label class="control-label">Kargo Fotoğraf Yükle</label>
                                                            <input type="file" class="form-control" autocomplete="off" name="kargoresim" id="kargoresim">

                                                        </div>

                                                    </div>
                                                    <div class="col-sm-12" style="display:none" id="faturanumara">
                                                        <div class="form-group">
                                                            <label class="control-label">Fatura Numarası</label>
                                                            <input type="text" class="form-control" autocomplete="off" name="faturanumarasi" id="faturanumarasi">

                                                        </div>

                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Kargo Notu - Ödeme ile alakali
                                                                notunuz </label>
                                                            <input required type="text" class="form-control" autocomplete="off" name="faturanot" id="faturanot">

                                                        </div>


                                                    </div>
                                                </div>



                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <a style="float:left; " id="kargokonrol" onclick="kargo_control()" class="btn btn-warning">Kargo Kontrol Et</a>
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Kapat</button>
                                            <button type="submit" name="cron_insert" class="btn btn-primary submit">
                                                Ekle
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <table class="table dt-table scroll-responsive" data-order-col="2" data-order-type="desc">
                            <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>Müşteri İsmi</th>
                                    <th>Adres</th>
                                    <th>Mahalle</th>
                                    <th>Eyalet</th>
                                    <th>Posta Kodu</th>
                                    <th width="50%">Ürün İsmi</th>
                                    <th>Müşteri Telefon Numarası</th>
                                    <th>Tarih</th>
                                    <th>Gönderim</th>
                                    <th>Fatura No</th>
                                    <th>Kargo Notu</th>
                                    <th>Kim Ekledi</th>
                                    <th>Durum</th>
                                    <th>Gönderilen Tarih</th>
                                    <th>Gönderen Kişi</th>
                                    <th>Teslim Edilen Tarih</th>
                                    <th>Teslim Eden Kişi</th>
                                    <th>Takip Numarası</th>
                                    <th>Kargo Resmi</th>
                                    <th>İade</th>
                                    <th>
                                        <?php
                                        if (has_permission('kargo', '', 'kargoduzenle')) {
                                            echo "Güncelle ";
                                        }
                                        if (has_permission('kargo', '', 'kargosilme')) {
                                            echo "Sil";
                                        }


                                        ?>

                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $kimsuan = $_SESSION['staff_user_id'];
                                if ($kimsuan == "1") {
                                    $query = $db->prepare("SELECT * FROM tblkargo");
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                                } else {
                                    $query = $db->prepare("SELECT * FROM tblkargo WHERE staff_user_id=?");
                                    $query->execute(array($kimsuan));
                                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                                }
                                foreach ($results as $result) {
                                    $urunismi = "";
                                    $musteri = $db->prepare("SELECT * FROM tblclients WHERE userid=?");
                                    $musteri->execute(array($result['musteri_id']));
                                    $musterisonuc = $musteri->fetch(PDO::FETCH_ASSOC);
                                    $urunidler = explode(",", $result['urun_id']);
                                    $urunadetex = explode(",", $result['adet']);
                                    for ($x = 0; $x < count($urunidler); $x++) {
                                        $urun = $db->prepare("SELECT * FROM tblkargolist WHERE id=?");
                                        $urun->execute(array($urunidler[$x]));
                                        $urunsonuc = $urun->fetch(PDO::FETCH_ASSOC);
                                        $urunismi = $urunismi . $urunsonuc['urun_ismi'] . " Adet = " . $urunadetex[$x] . "<br>";
                                    }

                                    $iade = $db->prepare("SELECT * FROM tblkargo_iade WHERE kargo_id=?");
                                    $iade->execute(array($result['id']));
                                    $iadesonuc = $iade->fetch(PDO::FETCH_ASSOC);

                                    $staf = $db->prepare("SELECT * FROM tblstaff WHERE staffid=?");
                                    $staf->execute(array($result['staff_user_id']));
                                    $stafsonuc = $staf->fetch(PDO::FETCH_ASSOC);

                                    $staf2 = $db->prepare("SELECT * FROM tblstaff WHERE staffid=?");
                                    $staf2->execute(array($result['gonderenkisi']));
                                    $stafsonuc2 = $staf2->fetch(PDO::FETCH_ASSOC);

                                    $staf3 = $db->prepare("SELECT * FROM tblstaff WHERE staffid=?");
                                    $staf3->execute(array($result['teslimkisi']));
                                    $stafsonuc3 = $staf3->fetch(PDO::FETCH_ASSOC);
                                ?>
                                    <tr>

                                        <th>
                                            <?= $result['id'] ?>
                                        </th>
                                        <th>
                                            <a href="clients/client/<?= $result['musteri_id'] ?>"> <?= $musterisonuc['company'] ?></a>
                                        </th>
                                        <th>
                                            <?= $result['adres'] ?>
                                        </th>
                                        <th><?= $result['mahalle'] ?></th>
                                        <th>
                                            <?= $result['eyalet'] ?>
                                        </th>
                                        <th>
                                            <?= $result['postakodu'] ?>
                                        </th>
                                        <td width="50%"><?= $urunismi ?></td>
                                        <th><?= $musterisonuc['phonenumber'] ?></th>
                                        <th><?= $result['tarih'] ?></th>
                                        <th><?= $result['gonderim'] ?></th>
                                        <th><?= $result['fatura_no'] ?></th>
                                        <th><?= $result['fatura_not'] ?></th>
                                        <th><?= $stafsonuc['firstname'] ?> <?= $stafsonuc['lastname'] ?></th>
                                        <th><?= $result['durum'] ?></th>
                                        <th><?= $result['gonderilenkargotarih'] ?></th>
                                        <th><?= $stafsonuc2['firstname'] ?> <?= $stafsonuc2['lastname'] ?></th>
                                        <th><?= $result['teslimtarih'] ?></th>
                                        <th><?= $stafsonuc3['firstname'] ?> <?= $stafsonuc3['lastname'] ?></th>
                                        <th><?= $result['takip_numarası'] ?></th>

                                        <th><?php
                                            if (!empty($result['kargo_foto'])) {
                                                echo "<div class='resimkut' id='resimdiv'>";
                                                echo "<a href='../assets/images/kargo/kargo/" . $result['kargo_foto'] . "'><img src='../assets/images/kargo/kargo/" . $result['kargo_foto'] . "' width='50' height='50'></a></div>";
                                            }
                                            ?>
                                        </th>
                                        <th>
                                            <?php
                                            if ($iadesonuc['durum'] == "Bekleniyor") {
                                                echo "<a href='clients/client/" . $result['musteri_id'] . "?group=kargo'>Bekleniyor</a>";
                                            } else if ($iadesonuc['durum'] == "İade Edildi") {
                                                echo "<a href='kargo/iade_kargolar?sorgu=0'>İade Edildi</a>";
                                            }

                                            ?>
                                        </th>
                                        <th>
                                            <?php
                                            /*if (has_permission('kargo', '', 'kargoduzenle')) {
                                            ?>
                                                <a href="javascript:void(0);" data-target="#Modal" data-toggle="modal" class="btn btn-primary" onclick="kargo_get(<?= $result['id'] ?>)">
                                                    Düzenle
                                                </a>
                                            <?php
                                            }*/
                                            if ($_SESSION['staff_user_id'] == "1") {
                                            ?>
                                                <a href="javascript:void(0);" data-target="#Modaldurum" data-toggle="modal" class="btn btn-primary" onclick="durumguncelle(<?= '\'' . $result['id'] . '\',\'' . $result['durum'] . '\',\'' . $result['takip_numarası'] . '\',\'' . $result['kargo_foto'] . '\',\'' . $result['fatura_not'] . '\'' ?>)">
                                                    Düzenle
                                                </a>
                                            <?php
                                            }
                                            if (has_permission('kargo', '', 'kargosilme')) {
                                            ?>
                                                <a href="javascript:void(0);" onclick="kargo_delete('<?= $result['id'] ?>')" class="btn btn-danger mb-1 mb-md-0">
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

    <form id="guncelle" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="staff_user_id1" value="<?= $_SESSION['staff_user_id'] ?>">
        <input type="hidden" name="updateid" id="updateid">

        <div class="modal fade bd-example-modal-l" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="exampleModalLabel">Ürün Güncelleme </p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <!--div class="form-group">
                                    <label class="control-label">Müşteri İsmi</label>
                                    <select class="form-control" onchange="musteribilgiler1(this);" id="musteri_ismignc"
                                        name="musteri_ismignc">
                                        <option id="musteriopt">Seçiniz</option>
                                        <?php
                                        /*
                                                                $musteriget=$db->prepare("SELECT * FROM tblclients");
                                                                $musteriget->execute();
                                                                $musteriresult=$musteriget->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach($musteriresult as $ff){
                                                                    echo "<option value='".$ff['userid']."'>".$ff['company']."</option>";
                                                                }
*/
                                        ?>
                                    </select>
                                </div-->
                                <label for="clientid" class="control-label"> <small class="req text-danger">*
                                    </small>Müşteri</label>
                                <div class="dropdown bootstrap-select ajax-search bs3 open" style="width: 100%;"><select onchange="musteribilgiler1(this);" id="clientid" name="musteri_ismignc" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="Seçim yapılmadı" tabindex="-98" title="Seçin ve yazmaya başlayın">
                                        <option class="bs-title-option" value=""></option>
                                    </select>
                                </div>
                                <input type="hidden" name="musteriopt" id="musteriopt">

                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="form-group">

                                    <label class="control-label">Eyalet</label>
                                    <input type="text" class="form-control" autocomplete="off" name="eyaletmodalgnc1" id="eyaletmodalgnc1" disabled>
                                    <input type="hidden" name="eyaletmodalgnc" id="eyaletmodalgnc">
                                </div>


                            </div><!-- Col -->
                            <div class="col-sm-3">

                                <div class="form-group">

                                    <label class="control-label">Mahalle</label>
                                    <input type="text" class="form-control" autocomplete="off" name="mahallemodalgnc1" id="mahallemodalgnc1" disabled>
                                    <input type="hidden" name="mahallemodalgnc" id="mahallemodalgnc">
                                </div>

                            </div><!-- Col -->
                            <div class="col-sm-2">
                                <div class="form-group">

                                    <label class="control-label">Posta Kodu</label>
                                    <input type="text" class="form-control" autocomplete="off" name="zipmodalgnc1" id="zipmodalgnc1" disabled>
                                    <input type="hidden" name="zipmodalgnc" id="zipmodalgnc">
                                </div>

                            </div><!-- Col -->
                            <div class="col-sm-12">
                                <div class="form-group">

                                    <label class="control-label">Adres</label>
                                    <textarea class="form-control" autocomplete="off" name="adresmodalgnc1" id="adresmodalgnc1" disabled></textarea>
                                    <input type="hidden" name="adresmodalgnc" id="adresmodalgnc">
                                </div>

                            </div><!-- Col -->
                        </div><!-- Row -->
                        <br>
                        <hr>
                        <br>
                        <div class="row" id="guncelleurundiv">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Ürün İsmi</label>
                                    <select class="form-control" onchange="urunbilgiler1(this);" id="urun_ismignc" name="urun_ismignc">
                                        <option id="urunopt">Seçiniz</option>
                                        <?php
                                        $urunget = $db->prepare("SELECT * FROM tblkargolist");
                                        $urunget->execute();
                                        $urunresult = $urunget->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($urunresult as $ff) {
                                            echo "<option value='" . $ff['id'] . "'>" . $ff['urun_ismi'] . "</option>";
                                        }

                                        ?>
                                    </select>
                                </div>


                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">

                                    <label class="control-label">Ürün Adet</label>
                                    <input type="text" class="form-control" autocomplete="off" name="urun_adetmodalgnc" id="urun_adetmodalgnc">
                                    <input type="hidden" name="urun_adetmodal1gnc" id="urun_adetmodal1gnc">
                                </div>


                            </div><!-- Col -->
                            <div class="col-sm-2">
                                <div class="form-group">

                                    <label class="control-label">Ürün Stok</label>
                                    <input type="text" class="form-control" disabled autocomplete="off" name="urun_stokmodal1gnc" id="urun_stokmodal1gnc">
                                    <input type="hidden" name="urun_stokmodalgnc" id="urun_stokmodalgnc">
                                </div>


                            </div><!-- Col -->
                            <div class="col-sm-4">

                                <div class="form-group">

                                    <label class="control-label">Ürün Fiyat</label>
                                    <input type="text" class="form-control" disabled autocomplete="off" name="urun_fiyatmodal1gnc" id="urun_fiyatmodal1gnc">
                                    <input type="hidden" name="urun_fiyatmodalgnc" id="urun_fiyatmodalgnc">
                                </div>

                            </div><!-- Col -->
                            <div class="col-sm-12">
                                <div class="form-group">

                                    <label class="control-label">Ürün Açıklama</label>
                                    <input type="text" class="form-control" disabled autocomplete="off" name="urun_aciklamamodal1gnc" id="urun_aciklamamodal1gnc">
                                    <input type="hidden" name="urun_aciklamamodalgnc" id="urun_aciklamamodalgnc">

                                </div>

                            </div><!-- Col -->

                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input class="form-check-input gonderimgnc" type="radio" name="gonderimgnc" id="ucretligonderimgnc" value="Ücretli Gönderim">
                                    <label class="control-label" for="ucretligonderimgnc">Ücretli Gönderim</label>

                                </div>


                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input class="form-check-input gonderimgnc" type="radio" name="gonderimgnc" id="ucretsizgonderimgnc" value="Ücretsiz Gönderim">
                                    <label class="control-label" for="ucretsizgonderimgnc">Ücretsiz Gönderim</label>

                                </div>


                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input class="form-check-input gonderimgnc" type="radio" name="gonderimgnc" id="degisimgnc" value="Değişim">
                                    <label class="control-label" for="degisimgnc">Ücretsiz Değişim</label>

                                </div>


                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input class="form-check-input durumgnc" type="radio" name="durumgnc" id="gonderimehazirgnc" value="Göndermeye Hazır">
                                    <label class="control-label" for="gonderimehazirgnc">Göndermeye Hazır</label>

                                </div>


                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input class="form-check-input durumgnc" type="radio" name="durumgnc" id="gonderildignc" value="Gönderildi">
                                    <label class="control-label" for="gonderildignc">Gönderildi</label>

                                </div>


                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input class="form-check-input durumgnc" type="radio" name="durumgnc" id="teslimedildignc" value="Teslim Edildi">
                                    <label class="control-label" for="teslimedildignc">Teslim Edildi</label>

                                </div>


                            </div>
                            <div id="iadegizlegnc" style="display:none;">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-check-input iadedurumgnc" type="radio" name="iadedurumgnc" id="cihaziadesibekliyoruzgnc" value="Cihaz İadesi Bekliyoruz">
                                        <label class="control-label" for="cihaziadesibekliyoruzgnc">Cihaz İadesi
                                            Bekliyoruz</label>

                                    </div>


                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-check-input iadedurumgnc" type="radio" name="iadedurumgnc" id="cihaziadesibeklemiyoruzgnc" value="Cihaz İadesi Beklemiyoruz">
                                        <label class="control-label" for="cihaziadesibeklemiyoruzgnc">Cihaz İadesi
                                            Beklemiyoruz</label>

                                    </div>


                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" id="iadeaciklamagizlegnc" style="display:none;">
                                        <label class="control-label" for="iadeaciklamagnc">Açıklama</label>
                                        <textarea class="form-control" autocomplete="off" name="iadeaciklamagnc" id="iadeaciklamagnc" rows="2" cols="50"></textarea>

                                    </div>


                                </div>
                            </div>
                            <div class="col-sm-8" style="display:none" id="takipdivgnc">
                                <div class="form-group">
                                    <label class="control-label">Takip Numarası</label>
                                    <input type="text" class="form-control" autocomplete="off" name="takipnumarasignc" id="takipnumarasignc">

                                </div>

                            </div>
                            <div class="col-sm-4" style="display:none" id="fotodivgnc">
                                <div class="form-group">
                                    <label class="control-label">Kargo Fotoğraf Yükle</label>
                                    <img id="kargoresimsrcgnc" name="kargoresimsrcgnc" width="50%" height="50%">
                                    <input type="hidden" id="eskikargoresim" name="eskikargoresim">
                                    <input type="file" class="form-control" autocomplete="off" name="kargoresimgnc" id="kargoresimgnc">

                                </div>

                            </div>
                            <div class="col-sm-12" style="display:none" id="faturanumaragnc">
                                <div class="form-group">
                                    <label class="control-label">Fatura Numarası</label>
                                    <input type="text" class="form-control" autocomplete="off" name="faturanumarasignc" id="faturanumarasignc">

                                </div>

                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Kargo Notu - Ödeme ile alakali notunuz </label>
                                    <input type="text" class="form-control" autocomplete="off" name="faturanotgnc" id="faturanotgnc">

                                </div>


                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <a style="float:left;" onclick="kargo_control1()" class="btn btn-warning">Kargo Kontrol Et</a>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" name="cron_update" class="btn btn-primary submit">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--DURUM GÜNCELLEME MODAL -->
    <form id="durumguncellemodal" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="staff_user_id2" value="<?= $_SESSION['staff_user_id'] ?>">
        <input type="hidden" name="updateiddurum" id="updateiddurum">

        <div class="modal fade bd-example-modal-l" id="Modaldurum" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="exampleModalLabel">Durum Güncelleme </p>
                        <div class="row">
                            <div class="col-sm-8">
                                <h5 class="modal-title" id="exampleModalLabel">Değişiklik yapma</h5>

                                <div class="onoffswitch">

                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox change-status" id="status" data-target="1" checked>
                                    <label class="onoffswitch-label" for="status"></label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input class="form-check-input durumgncdurum" type="radio" name="durumgncdurum" id="gonderimehazirgncdurum" value="Göndermeye Hazır">
                                    <label class="control-label" for="gonderimehazirgncdurum">Göndermeye Hazır</label>

                                </div>


                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input class="form-check-input durumgncdurum" type="radio" name="durumgncdurum" id="gonderildigncdurum" value="Gönderildi">
                                    <label class="control-label" for="gonderildigncdurum">Gönderildi</label>

                                </div>


                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input class="form-check-input durumgncdurum" type="radio" name="durumgncdurum" id="teslimedildigncdurum" value="Teslim Edildi">
                                    <label class="control-label" for="teslimedildigncdurum">Teslim Edildi</label>

                                </div>


                            </div>

                            <div class="col-sm-6" style="display:none" id="takipdivgncdurum">
                                <div class="form-group">
                                    <label class="control-label">Takip Numarası</label>
                                    <input type="text" class="form-control" autocomplete="off" name="takipnumarasigncdurum" id="takipnumarasigncdurum">

                                </div>

                            </div>
                            <div class="col-sm-6" style="display:none" id="fotodivgncdurum">
                                <div class="form-group">
                                    <label class="control-label">Kargo Fotoğraf Yükle</label>
                                    <img id="kargoresimsrcgncdurum" name="kargoresimsrcgncdurum" width="50%" height="50%">
                                    <input type="hidden" id="eskikargoresimdurum" name="eskikargoresimdurum">
                                    <input type="file" class="form-control" autocomplete="off" name="kargoresimgncdurum" id="kargoresimgncdurum">

                                </div>

                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Kargo Notu - Ödeme ile alakali notunuz </label>
                                    <input type="text" class="form-control" autocomplete="off" name="faturanotgncdurum" id="faturanotgncdurum">

                                </div>


                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <a style="float:left;" id="kargokonroldurum" onclick="kargo_controldurum()" class="btn btn-warning">Kargo Kontrol Et</a>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" name="durum_update" class="btn btn-primary submit">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php init_tail(); ?>
    <script src="../inc/lightgallery-all.js"></script>
    <script>
        var urunsayac = 0;

        function urunekle() {
            urunsayac += 1;
            $.ajax({
                url: '../exec/ajaxgetkargos.php',
                dataType: 'html',
                method: 'post',
                data: {
                    'urunsayac': urunsayac

                },
                success: function(results) {
                    $('#kargourundiv').append(results);


                }
            });
        }

        function durumguncelle(id, durum, takipnumarasi, kargofoto, faturanot) {

            $('#takipnumarasigncdurum').val("");
            $('#kargoresimgncdurum').val("");
            $('#eskikargoresimdurum').val("");
            $('#kargoresimsrcgncdurum').attr("src", "");
            $('#faturanumarasigncdurum').val("");
            $('#eskikargoresimdurum').val("");
            $('#updateiddurum').val("");

            $('#updateiddurum').val(id);
            if (durum == "Gönderildi") {
                $('#gonderildigncdurum').prop("checked", true);
                $('#takipnumarasigncdurum').val(takipnumarasi);
                $('#kargoresimsrcgncdurum').attr("src",
                    "../assets/images/kargo/kargo/" + kargofoto);
                $('#eskikargoresimdurum').val(kargofoto);
                $('#takipdivgncdurum').css("display", "block");
                $('#fotodivgncdurum').css("display", "block");

            }
            if (durum == "Teslim Edildi") {
                $('#teslimedildigncdurum').prop("checked", true);
                $('#takipnumarasigncdurum').val(takipnumarasi);
                $('#kargoresimsrcgncdurum').attr("src",
                    "../assets/images/kargo/kargo/" + kargofoto);
                $('#eskikargoresimdurum').val(kargofoto);

                $('#takipdivgncdurum').css("display", "block");
                $('#fotodivgncdurum').css("display", "block");

            }
            if (durum == "Göndermeye Hazır") {
                $('#gonderimehazirgncdurum').prop("checked", true);
                $('#takipnumarasigncdurum').val(takipnumarasi);
                $('#kargoresimsrcgncdurum').attr("src",
                    "../assets/images/kargo/kargo/" + kargofoto);
                $('#eskikargoresimdurum').val(kargofoto);

                $('#takipdivgncdurum').css("display", "none");
                $('#fotodivgncdurum').css("display", "none");

            }
            $('#faturanotgncdurum').val(faturanot);

        }

        function urunekle1() {
            urunsayac += 1;
            $.ajax({
                url: '../exec/ajaxgetkargos.php',
                dataType: 'html',
                method: 'post',
                data: {
                    'urunsayac': urunsayac

                },
                success: function(results) {
                    $('#kargourundiv1').append(results);


                }
            });
        }
        $(document).ready(function() {
            $(window).off('beforeunload');

            $('.resimkut').lightGallery({
                thumbnail: true,
                animateThumb: false,
                showThumbByDefault: false
            });
            $('#guncelle').submit(function() {
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: "../exec/ajaxkargoguncelle.php",
                    enctype: 'multipart/form-data',
                    processData: false, // Important!
                    contentType: false,
                    cache: false,
                    data: formData,
                    type: "POST",
                    dataType: 'json',
                    success: function(e) {
                        if (e == "1") {
                            alert_float("success", "Ekleme Başarılı");
                            window.location.reload();

                        } else if (e == "2") {
                            alert_float("danger", "Fatura numarası yanlış!");
                        } else if (e == "3") {
                            alert_float("danger", "Sadece JPG, JPEG, PNG & GIF bu uzantılar resimdir ve bunları yükleyebilirsiniz!");

                        } else if (e != "1" && e != "2" && e != "3") {
                            alert_float("danger", "Eksik bilgi girildi");
                        }


                    },
                    error: function(e) {
                        window.location.reload();

                    }
                });
                return false;
            });
            $('#durumguncellemodal').submit(function() {
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: "../exec/ajaxkargodurumguncelle.php",
                    enctype: 'multipart/form-data',
                    processData: false, // Important!
                    contentType: false,
                    cache: false,
                    data: formData,
                    type: "POST",
                    dataType: 'json',
                    success: function(e) {
                        if (e == "1") {
                            alert_float("success", "Güncelleme Başarılı");
                            window.location.reload();

                        } else if (e == "2") {
                            alert_float("danger", "Fatura numarası yanlış!");
                        } else if (e == "3") {
                            alert_float("danger", "Sadece JPG, JPEG, PNG & GIF bu uzantılar resimdir ve bunları yükleyebilirsiniz!");

                        } else if (e != "1" && e != "2" && e != "3") {
                            alert_float("danger", "Eksik bilgi girildi");
                        }


                    },
                    error: function(e) {
                        alert_float("danger", "HATA");

                        //window.location.reload();

                    }
                });
                return false;
            });
            $("#faturaekle").submit(function() {
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: "../exec/ajaxfaturaekle.php",
                    enctype: 'multipart/form-data',
                    processData: false, // Important!
                    contentType: false,
                    cache: false,
                    data: formData,
                    type: "POST",
                    dataType: 'json',
                    success: function(e) {
                        if (e == "1") {
                            alert_float("success", "Ekleme Başarılı");

                            window.location.reload();

                        } else if (e == "2") {
                            alert_float("danger", "Fatura numarası yanlış!");

                        } else if (e == "3") {
                            alert_float("danger", "Sadece JPG, JPEG, PNG & GIF bu uzantılar resimdir ve bunları yükleyebilirsiniz!");


                        } else if (e == "4") {
                            alert_float("danger", "Ürün Eklenmedi!");


                        } else if (e == "5") {
                            alert_float("danger", "Adres Boş Olmamalı!");


                        } else if (e == "6") {
                            alert_float("danger", "Müşterinin Gönderilmemiş Kargosu Var");

                        } else if (e != "1" && e != "2" && e != "3" && e != "4" && e != "5" && e != "6") {
                            alert_float("danger", "Eksik bilgi girildi");

                        }


                    },
                    error: function(e) {
                        alert_float("danger", e);
                    }
                });
                return false;
            });
        });
        $('.gonderimgnc').change(function() {
            if (this.value == "Ücretli Gönderim") {
                $('#faturanumaragnc').css("display", "block");
            }
            if (this.value == "Ücretsiz Gönderim") {
                $('#faturanumaragnc').css("display", "none");
                $('#faturanumarasignc').val("");
            }
            if (this.value == "Değişim") {
                $('#faturanumaragnc').css("display", "block");
            }
        });
        $('.durumgnc').change(function() {
            if (this.value == "Gönderildi") {
                $('#takipdivgnc').css("display", "block");
                $('#fotodivgnc').css("display", "block");
                $('#kargokonrol').show();
            }
            if (this.value == "Teslim Edildi") {
                $('#takipdivgnc').css("display", "block");
                $('#fotodivgnc').css("display", "block");
                $('#kargokonrol').show();

            }
            if (this.value == "Göndermeye Hazır") {
                $('#takipdivgnc').css("display", "none");
                $('#fotodivgnc').css("display", "none");
                $('#kargokonrol').hide();

                $('#takipnumarasignc').val("");
                $('#eskikargoresim').val("");
            }

        });
        $('.durumgncdurum').change(function() {
            if (this.value == "Gönderildi") {
                $('#takipdivgncdurum').css("display", "block");
                $('#fotodivgncdurum').css("display", "block");
                $('#kargokonroldurum').show();
            }
            if (this.value == "Teslim Edildi") {
                $('#takipdivgncdurum').css("display", "block");
                $('#fotodivgncdurum').css("display", "block");
                $('#kargokonroldurum').show();

            }
            if (this.value == "Göndermeye Hazır") {
                $('#takipnumarasigncdurum').val("");
                $('#kargoresimsrcgncdurum').attr("src", "");
                $('#eskikargoresimdurum').val("");
                $('#takipdivgncdurum').css("display", "none");
                $('#fotodivgncdurum').css("display", "none");
                $('#kargokonroldurum').hide();

                $('#takipnumarasignc').val("");
                $('#eskikargoresim').val("");
            }

        });
        $('.iadedurumgnc').change(function() {
            if (this.value == "Cihaz İadesi Bekliyoruz") {
                $('#iadeaciklamagizlegnc').css("display", "block");
                $('#iadeaciklamagnc').prop("required", true);
            } else {
                $('#iadeaciklamagizlegnc').css("display", "none");
                $('#iadeaciklamagnc').prop("required", false);
            }
        });
        $('.iadedurum').change(function() {
            if (this.value == "Cihaz İadesi Bekliyoruz") {
                $('#iadeaciklamagizle').css("display", "block");
                $('#iadeaciklama').prop("required", true);
                $('#iademac').prop("required", true);
            } else {
                $('#iadeaciklamagizle').css("display", "none");
                $('#iadeaciklama').prop("required", false);
                $('#iademac').prop("required", false);
            }
        });
        $('.gonderim').change(function() {
            if (this.value == "Ücretli Gönderim") {
                $('#faturanumara').css("display", "block");
                $('#iadegizle').css("display", "block");
                $('.iadedurum').prop("required", true);
            }
            if (this.value == "Ücretsiz Gönderim") {
                $('#faturanumara').css("display", "none");
                $('#iadegizle').css("display", "none");
                $('.iadedurum').prop("required", false);

            }
            if (this.value == "Değişim") {
                $('#faturanumara').css("display", "block");
                $('#iadegizle').css("display", "block");
                $('.iadedurum').prop("required", true);

            }
        });
        $('.durum').change(function() {
            if (this.value == "Gönderildi") {
                $('#takipdiv').css("display", "block");
                $('#fotodiv').css("display", "block");

            }
            if (this.value == "Teslim Edildi") {
                $('#takipdiv').css("display", "block");
                $('#fotodiv').css("display", "block");

            }
            if (this.value == "Göndermeye Hazır") {
                $('#takipdiv').css("display", "none");
                $('#fotodiv').css("display", "none");

            }

        });



        function kargo_get(id) {

            $.ajax({
                url: '../exec/ajaxgetkargo.php',
                method: 'post',
                dataType: "json",

                data: {
                    'id': id

                },
                success: function(results) {
                    $('#updateid').val(id);
                    $('#musteriopt').val(results[0].musterid);
                    $('#musteriopt').text(results[0].musteriisim);
                    $('#eyaletmodalgnc').val(results[0].eyalet);
                    $('#mahallemodalgnc').val(results[0].mahalle);
                    $('#zipmodalgnc').val(results[0].postakodu);
                    $('#adresmodalgnc').val(results[0].adres);
                    $('#eyaletmodalgnc1').val(results[0].eyalet);
                    $('#mahallemodalgnc1').val(results[0].mahalle);
                    $('#zipmodalgnc1').val(results[0].postakodu);
                    $('#adresmodalgnc1').val(results[0].adres);
                    $('#urunopt').val(results[0].urunid);
                    $('#urunopt').text(results[0].urunisim);
                    $('#urun_adetmodal1gnc').val(results[0].urunadet);
                    $('#urun_adetmodalgnc').val(results[0].urunadet);
                    $('#urun_stokmodal1gnc').val(results[0].urunstok);
                    $('#urun_stokmodalgnc').val(results[0].urunstok);
                    $('#urun_fiyatmodal1gnc').val(results[0].urunfiyat);
                    $('#urun_fiyatmodalgnc').val(results[0].urunfiyat);
                    $('#urun_aciklamamodal1gnc').val(results[0].urunaciklama);
                    $('#urun_aciklamamodalgnc').val(results[0].urunaciklama);
                    if (results[0].gonderim == "Ücretli Gönderim") {
                        $('#ucretligonderimgnc').prop("checked", true);
                        $('#faturanumaragnc').css("display", "block");
                        $('#faturanumarasignc').val(results[0].faturano);
                    }
                    if (results[0].gonderim == "Ücretsiz Gönderim") {
                        $('#ucretsizgonderimgnc').prop("checked", true);
                        $('#faturanumaragnc').css("display", "none");
                    }
                    if (results[0].gonderim == "Değişim") {
                        $('#degisimgnc').prop("checked", true);
                        $('#faturanumaragnc').css("display", "block");
                        $('#faturanumarasignc').val(results[0].faturano);
                    }
                    if (results[0].durum == "Gönderildi") {
                        $('#gonderildignc').prop("checked", true);
                        $('#takipnumarasignc').val(results[0].takip_numarasi);
                        $('#kargoresimsrcgnc').attr("src",
                            "../assets/images/kargo/kargo/" + results[0]
                            .kargo_foto);
                        $('#eskikargoresim').val(results[0].kargo_foto);
                        $('#takipdivgnc').css("display", "block");
                        $('#fotodivgnc').css("display", "block");

                    }
                    if (results[0].durum == "Teslim Edildi") {
                        $('#teslimedildignc').prop("checked", true);
                        $('#takipnumarasignc').val(results[0].takip_numarasi);
                        $('#kargoresimsrcgnc').attr("src",
                            "../assets/images/kargo/kargo/" + results[0]
                            .kargo_foto);
                        $('#eskikargoresim').val(results[0].kargo_foto);

                        $('#takipdivgnc').css("display", "block");
                        $('#fotodivgnc').css("display", "block");

                    }
                    if (results[0].durum == "Göndermeye Hazır") {
                        $('#gonderimehazirgnc').prop("checked", true);
                        $('#takipnumarasignc').val(results[0].takip_numarasi);
                        $('#kargoresimsrcgnc').attr("src",
                            "../assets/images/kargo/kargo/" + results[0]
                            .kargo_foto);
                        $('#eskikargoresim').val(results[0].kargo_foto);

                        $('#takipdivgnc').css("display", "none");
                        $('#fotodivgnc').css("display", "none");

                    }
                    $('#faturanotgnc').val(results[0].faturanot);
                    if (!empty(results[0].iadedurum)) {
                        $('#iadegizlegnc').css("display", "block");
                        if (results[0].iadedurum == "Cihaz İadesi Bekliyoruz") {
                            $('#cihaziadesibekliyoruzgnc').prop("checked", true);
                            $('#iadeaciklamagizlegnc').css("display", "block");
                            $('#iadeaciklamagnc').val(results[0].iadeaciklama);
                        } else if (results[0].iadedurum == "Cihaz İadesi Beklemiyoruz") {
                            $('#cihaziadesibeklemiyoruzgnc').prop("checked", true);
                        }
                    }

                }
            });


        }

        function urunbilgiler(item) {
            var id = item.value;
            var rowid = item.id;
            console.log(rowid);
            var dataid = $('#' + rowid).data("id");
            console.log(dataid);
            $.ajax({
                url: '../exec/ajaxgeturun.php',
                method: 'post',
                dataType: "json",

                data: {
                    'id': id

                },
                success: function(results) {
                    if (parseInt(results[0].urunstok) > 0) {
                        $('#urun_stokmodal' + dataid).val(results[0].urunstok);
                        $('#urun_fiyatmodal' + dataid).val(results[0].urunfiyat);
                        $('#urun_aciklamamodal' + dataid).val(results[0].urunaciklama);
                        $('#urun_stokmodal1' + dataid).val(results[0].urunstok);
                        $('#urun_fiyatmodal1' + dataid).val(results[0].urunfiyat);
                        $('#urunresimsrc' + dataid).attr("src",
                            "../assets/images/kargo/urunler/" + results[0]
                            .urunresim);

                        $('#urun_aciklamamodal1' + dataid).val(results[0].urunaciklama);
                    } else {
                        alert_float("danger", "ÜRÜN STOKTA YOK");
                    }
                }
            });
        }

        function kargo_control1() {
            var takipnumarasi = $('#takipnumarasignc').val();
            if (takipnumarasi != "") {
                window.open('https://auspost.com.au/mypost/track/#/details/' + takipnumarasi, '_blank');
            } else {
                alert_float("danger", "Takip Numarası Girin");
            }
        }

        function kargo_controldurum() {
            var takipnumarasi = $('#takipnumarasigncdurum').val();
            if (takipnumarasi != "") {
                window.open('https://auspost.com.au/mypost/track/#/details/' + takipnumarasi, '_blank');
            } else {
                alert_float("danger", "Takip Numarası Girin");
            }
        }

        function kargo_control() {
            var takipnumarasi = $('#takipnumarasi').val();
            if (takipnumarasi != "") {
                window.open('https://auspost.com.au/mypost/track/#/details/' + takipnumarasi, '_blank');
            } else {
                alert_float("danger", "Takip Numarası Girin");
            }
        }

        function musteribilgiler(item) {
            var id = item.value;
            $.ajax({
                url: '../exec/ajaxgetmusteri.php',
                method: 'post',
                dataType: "json",

                data: {
                    'id': id

                },
                success: function(results) {
                    $('#mahallemodal').val(results[0].mahalle);
                    $('#eyaletmodal').val(results[0].eyalet);
                    $('#zipmodal').val(results[0].postakodu);
                    $('#adresmodal').val(results[0].adres);
                    $('#fatura_adresi').css("display", "block");
                    $('#fatura_adresi').attr("href", "../admin/clients/client/" + id + "?group=invoices");
                    $('#mahallemodal1').val(results[0].mahalle);
                    $('#eyaletmodal1').val(results[0].eyalet);
                    $('#zipmodal1').val(results[0].postakodu);
                    $('#adresmodal1').val(results[0].adres);

                }
            });
        }

        function urunbilgiler1(item) {
            var id = item.value;
            $.ajax({
                url: '../exec/ajaxgeturun.php',
                method: 'post',
                dataType: "json",

                data: {
                    'id': id

                },
                success: function(results) {
                    if (parseInt(results[0].urunstok) > 0) {
                        $('#urun_stokmodalgnc').val(results[0].urunstok);
                        $('#urun_fiyatmodalgnc').val(results[0].urunfiyat);
                        $('#urun_aciklamamodalgnc').val(results[0].urunaciklama);
                        $('#urun_stokmodal1gnc').val(results[0].urunstok);
                        $('#urun_fiyatmodal1gnc').val(results[0].urunfiyat);
                        $('#urun_aciklamamodal1gnc').val(results[0].urunaciklama);
                    } else {
                        alert_float("danger", "ÜRÜN STOKTA YOK");

                    }

                }
            });
        }

        function musteribilgiler1(item) {
            var id = item.value;
            $.ajax({
                url: '../exec/ajaxgetmusteri.php',
                method: 'post',
                dataType: "json",

                data: {
                    'id': id

                },
                success: function(results) {
                    $('#mahallemodalgnc').val(results[0].mahalle);
                    $('#eyaletmodalgnc').val(results[0].eyalet);
                    $('#zipmodalgnc').val(results[0].postakodu);
                    $('#adresmodalgnc').val(results[0].adres);
                    $('#mahallemodalgnc1').val(results[0].mahalle);
                    $('#eyaletmodalgnc1').val(results[0].eyalet);
                    $('#zipmodalgnc1').val(results[0].postakodu);
                    $('#adresmodalgnc1').val(results[0].adres);

                }
            });
        }



        function kargo_delete(id) {

            $.ajax({
                url: '../exec/ajaxdeletekargo.php',
                method: 'post',
                data: {
                    'id': id,
                },
                success: function(e) {
                    if (e == 1) {
                        window.location.reload()
                    } else {
                        window.location.reload()
                    }
                }
            });
        }
    </script>
    </body>

    </html>