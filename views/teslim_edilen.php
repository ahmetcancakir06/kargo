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

                        </div>




                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table style="width:100%;" id="digiturktable" class="table dt-table">
                                <thead>
                                    <tr>

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
                                        <th>Fatura No</th>
                                        <th>Fatura Not</th>
                                        <th>Kim Ekledi</th>
                                        <th>Durum</th>
                                        <th>Teslim Tarih</th>
                                        <th>Teslim Eden</th>
                                        <th>Takip Numarası</th>
                                        <th>Kargo Resmi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    /*$suankim = $_SESSION['staff_user_id'];
                                    if ($suankim == "1") {
                                        $query = $db->prepare("SELECT * FROM tblkargo WHERE durum=? ");
                                        $query->execute(array("Teslim Edildi"));
                                        $results = $query->fetchAll(PDO::FETCH_ASSOC);
                                    } else {
                                        $query = $db->prepare("SELECT * FROM tblkargo WHERE durum=? AND staff_user_id=?");
                                        $query->execute(array("Teslim Edildi", $suankim));
                                        $results = $query->fetchAll(PDO::FETCH_ASSOC);
                                    }
                                    foreach ($results as $result) {
                                        $musteri = $db->prepare("SELECT * FROM tblclients WHERE userid=?");
                                        $musteri->execute(array($result['musteri_id']));
                                        $musterisonuc = $musteri->fetch(PDO::FETCH_ASSOC);

                                        $urun = $db->prepare("SELECT * FROM tblkargolist WHERE id=?");
                                        $urun->execute(array($result['urun_id']));
                                        $urunsonuc = $urun->fetch(PDO::FETCH_ASSOC);

                                        $staf = $db->prepare("SELECT * FROM tblstaff WHERE staffid=?");
                                        $staf->execute(array($result['staff_user_id']));
                                        $stafsonuc = $staf->fetch(PDO::FETCH_ASSOC);
                                        $staf2 = $db->prepare("SELECT * FROM tblstaff WHERE staffid=?");
                                        $staf2->execute(array($result['teslimkisi']));
                                        $stafsonuc2 = $staf2->fetch(PDO::FETCH_ASSOC);
                                    */
                                    ?>
                                        <tr>

                                            <th>
                                                <?php // $result['id'] ?>
                                            </th>
                                            <th>
                                                <a href="../clients/client/<?php // $result['musteri_id'] ?>"> <?php // $musterisonuc['company'] ?></a>
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
                                            <th><?php // $urunsonuc['urun_ismi'] ?></th>
                                            <th>
                                                <?php // $musterisonuc['phonenumber'] ?>
                                            </th>

                                            <th>
                                                <?php // $result['tarih'] ?>
                                            </th>
                                            <th>
                                                <?php // $result['gonderim'] ?>
                                            </th>
                                            <th><?php // $result['fatura_no'] ?></th>
                                            <th><?php // $result['fatura_not'] ?></th>
                                            <th><?php // $stafsonuc['firstname'] ?> <?php // $stafsonuc['lastname'] ?></th>
                                            <th><?php // $result['durum'] ?></th>
                                            <th><?php // $result['teslimtarih'] ?></th>
                                            <th><?php // $stafsonuc2['firstname'] ?> <?php // $stafsonuc2['lastname'] ?></th>
                                            <th><?php // $result['takip_numarası'] ?><br>
                                                <a onclick="kargo_control('<?php // $result['takip_numarası'] ?>')" class="btn btn-warning">Kargo Kontrol Et</a>

                                            </th>
                                            <th><?php
                                                /*if (!empty($result['kargo_foto'])) {
                                                    echo "<div id='resimdiv'>";
                                                    echo "<a href='../../assets/images/kargo/kargo/" . $result['kargo_foto'] . "'><img src='../../assets/images/kargo/kargo/" . $result['kargo_foto'] . "' width='50' height='50'></a></div>";
                                                }*/
                                                ?> </th>


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


    <?php init_tail(); ?>
    <script src="../../inc/lightgallery-all.js"></script>
    <script>
        $(document).ready(function() {


            $('#resimdiv').lightGallery({
                thumbnail: true,
                animateThumb: false,
                showThumbByDefault: false
            });


        });

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