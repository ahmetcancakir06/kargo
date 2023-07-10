<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
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
                            <button type="button" class="multiple btn btn-primary" style="display:none;" onclick="multipleprint()">
                                Çoklu Yazdır
                            </button>
                        </div>




                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table style="width:100%;" id="digiturktable" class="table dt-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="custom-checkbox custom-control ml-3">
                                                <input type="checkbox" id="chBoxAll" class="custom-control-input chckboox">
                                                <label class="custom-control-label" for="chBoxAll">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Müşteri İsmi</th>
                                        <th>Adres</th>
                                        <th>Mahalle</th>
                                        <th>Eyalet</th>
                                        <th>Posta Kodu</th>
                                        <th>Ürün İsmi</th>
                                        <th>Müşteri Telefon Numarası</th>
                                        <th>Tarih</th>
                                        <th>Gönderim</th>
                                        <th>İade</th>
                                        <th>Fatura No</th>
                                        <th>Fatura Not</th>
                                        <th>Kim Ekledi</th>
                                        <th>Durum</th>
                                        <th>Print</th>
                                        <th>Gönderildi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    /*$suankim = $_SESSION['staff_user_id'];

                                    $query = $db->prepare("SELECT * FROM tblkargo WHERE durum=? AND staff_user_id=?");
                                    $query->execute(array("Göndermeye Hazır", $suankim));
                                    $results = $query->fetchAll(PDO::FETCH_ASSOC);

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

                                        $staf = $db->prepare("SELECT * FROM tblstaff WHERE staffid=?");
                                        $staf->execute(array($result['staff_user_id']));
                                        $stafsonuc = $staf->fetch(PDO::FETCH_ASSOC);

                                        $faturaget = $db->prepare("SELECT * FROM tblinvoices WHERE hash=?");
                                        $faturaget->execute(array($result['fatura_no']));
                                        $faturasonuc = $faturaget->fetch(PDO::FETCH_ASSOC);
*/
                                    ?>
                                        <tr>
                                            <th>
                                                <div class="custom-checkbox custom-control ml-3">
                                                    <input type="checkbox" id="chckboox" value="<?php // $result['id'] ?>" class="custom-control-input chckboox">
                                                    <label class="custom-control-label" for="chckboox">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>
                                                <?php // $result['id'] ?>
                                            </th>
                                            <th>
                                                <a href="../clients/client/<?php // $result['musteri_id'] ?>">
                                                    <?php // $musterisonuc['company'] ?></a>
                                            </th>
                                            <th>
                                                <?php // $result['adres'] ?>
                                            </th>
                                            <th><?php // $result['mahalle'] ?></th>
                                            <th>
                                                <?php // $result['eyalet'] ?>
                                            </th>
                                            <th>
                                                <?php // $result['postakodu'] ?>
                                            </th>
                                            <th><?php // $urunismi ?></th>
                                            <th>
                                                <?php // $musterisonuc['phonenumber'] ?>
                                            </th>

                                            <th>
                                                <?php // $result['tarih'] ?>
                                            </th>
                                            <th>

                                                <?php // $result['gonderim'] ?>
                                            </th>
                                            <th><?php /*if ($result['iadedurum'] == "Cihaz İadesi Bekliyoruz") {
                                                    echo "<a target='_blank' href='../clients/client/" . $result['musteri_id'] . "?group=kargo'>Cihaz İadesi Bekliyoruz</a>";
                                                } else {
                                                    echo $result['gonderim'];
                                                } */?></th>
                                            <th><?php // $result['fatura_no'] ?><br><?php // (!empty($result['fatura_no']) ? "<a href='../../invoice/" . $faturasonuc["id"] . "/" . $faturasonuc["hash"] . "' target='_blank'>Göster</a>" : "") ?></th>
                                            <th><?php // $result['fatura_not'] ?></th>
                                            <th><?php // $stafsonuc['firstname'] ?> <?php // $stafsonuc['lastname'] ?></th>
                                            <th><?php // $result['durum'] ?></th>
                                            <th>
                                                <a href="print?id=<?php // $result['id'] ?>" target="_blank" class="btn btn-warning">Print</a>
                                            </th>

                                            <th>
                                                <button id="gonderbutton" onclick="kargo_gonder(<?php // $result['id'] ?>)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Gönder</button>
                                            </th>

                                        </tr>
                                    <?php
                                    //}
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="../../exec/ajaxkargogonder.php" method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <input type="hidden" name="staff_user_id" value="<?php // $_SESSION['staff_user_id'] ?>">

                        <h5 class="modal-title" id="exampleModalLabel">Kargoyu Gönder</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="gonderid" name="gonderid">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label">Takip Numarası</label>
                                    <input type="text" required="true" class="form-control" autocomplete="off" name="takipnumarasi" id="takipnumarasi">

                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Kargo Fotoğraf Yükle</label>
                                    <input type="file" class="form-control" autocomplete="off" name="kargoresim" id="kargoresim">

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary">Gönder</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form id="cokyaz" method="POST" action="print" >
        <input type="hidden" name="idlerprint" id="idlerprint">
    </form>
    <?php init_tail(); ?>
    <script src="../../inc/lightgallery-all.js"></script>
    <script>
        function kargo_gonder(id) {
            $('#gonderid').val(id);
        }

        $(document).ready(function() {


            $('#resimdiv').lightGallery({
                thumbnail: true,
                animateThumb: false,
                showThumbByDefault: false
            });


        });
        var check = [];
        $(document).on('click', '.chckboox', function(event) {

            var el = $(this);
            var id = el.val();
            if (el.is(':checked')) {
                check.push(id);
                $('.multiple').css("display", "inline-block");

            } else {
                var i = 0;
                var checkuzunluk = check.length;

                check = check.filter(function(key, val) {
                    return key !== id;

                });
                while (checkuzunluk == 1) {
                    $('.multiple').css("display", "none");

                    i++;
                    break;

                }

            }

            console.log(check);

        });
        $(document).on('click', '#chBoxAll', function(event) {
            var g = $('.chckboox');
            g.prop('checked', this.checked);
            if ($(this).is(':checked')) {
                $.each(g, function() {
                    var el = $(this);
                    var id = el.val();
                    check.push(id);
                    $('.multiple').css("display", "inline-block");

                });

            } else {
                check = [];
                $('.multiple').css("display", "none");

            }
        });

        function multipleprint() {
            $('#idlerprint').val(check);
            window.open('print?' + no, '_blank');


        }

        function kargo_control(no) {

            if (no != "") {
                window.open('https://auspost.com.au/mypost/track/#/details/' + no, '_blank');
            } else {
                alert_float("danger", "Takip Numarası Yok");

            }
        }
    </script>
    </body>

    </html>