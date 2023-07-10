<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php include "inc/db.php" ?>
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
                                        <th>FULL NAME</th>
                                        <th>Address</th>
                                        <th>Suburb</th>
                                        <th>State</th>
                                        <th>POSTAL CODE</th>
                                        <th>PRODUCT NAME</th>
                                        <th>Contact Number</th>
                                        <th>Date</th>
                                        <th>SENT DATE</th>
                                        <th>Check Tracking</th>
                                        <th>Cargo Picture</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $suankim = $_SESSION['staff_user_id'];
                                    if ($suankim == "1") {
                                        $query = $db->prepare("SELECT * FROM tblkargo WHERE durum=?");
                                        $query->execute(array("Gönderildi"));
                                        $results = $query->fetchAll(PDO::FETCH_ASSOC);
                                    } else {
                                        $query = $db->prepare("SELECT * FROM tblkargo WHERE durum=? AND gonderenkisi=?");
                                        $query->execute(array("Gönderildi", $suankim));
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
                                            $urunismi = $urunismi . $urunsonuc['productname'] . " Total = " . $urunadetex[$x] . "<br>";
                                        }

                                        $staf = $db->prepare("SELECT * FROM tblstaff WHERE staffid=?");
                                        $staf->execute(array($result['staff_user_id']));
                                        $stafsonuc = $staf->fetch(PDO::FETCH_ASSOC);

                                        $staf2 = $db->prepare("SELECT * FROM tblstaff WHERE staffid=?");
                                        $staf2->execute(array($result['gonderenkisi']));
                                        $stafsonuc2 = $staf2->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                        <tr>

                                            <th>
                                                <?= $result['id'] ?>
                                            </th>
                                            <th>
                                                <a href="../clients/client/<?= $result['musteri_id'] ?>">
                                                    <?= $musterisonuc['company'] ?></a>
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
                                            <th><?= $urunismi ?></th>
                                            <th>
                                                <?= $musterisonuc['phonenumber'] ?>
                                            </th>
                                            <th>
                                                <?= $result['tarih'] ?>
                                            </th>
                                            
                                            <th><?= $result['gonderilenkargotarih'] ?></th>
                                            <th><?= $result['takip_numarası'] ?><br>
                                                <a onclick="kargo_control('<?= $result['takip_numarası'] ?>')" class="btn btn-warning">Check Tracking</a>
                                            </th>
                                            <th><?php
                                                if (!empty($result['kargo_foto'])) {
                                                    echo "<div id='resimdiv'>";
                                                    echo "<a href='../../assets/images/kargo/kargo/" . $result['kargo_foto'] . "'><img src='../../assets/images/kargo/kargo/" . $result['kargo_foto'] . "' width='50' height='50'></a></div>";
                                                }
                                                ?> </th>
                                           

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
    <input type="hidden" id="staff_user_id" value="<?= $_SESSION['staff_user_id'] ?>">


    <?php init_tail(); ?>
    <script src="../../inc/lightgallery-all.js"></script>
    <script src="../../inc/printthis/printThis.js"></script>

    <script>
        $(document).on('change', '.change-status', function() {
            var id = $(this).data('id');
            var status = $(this).data('target');
            var userid = $('#staff_user_id').val();
            $.ajax({
                method: 'POST',
                url: '../../exec/ajaxkargostatus.php',
                dataType: 'json',
                data: {
                    'active_passive': status,
                    'id': id,
                    'userid': userid
                },
                success: function(results) {
                    if (results == "1") {
                        location.reload();
                    }
                }
            });
        });
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