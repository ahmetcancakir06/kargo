<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php include "inc/db.php" ?>
<?php
$durum = $_GET['durum'];
$gonderim = $_GET['gonderim'];
$musteri = $_GET['musteri'];
$urun = $_GET['urun'];
$assigned=$_GET['personel'];


$sqlsorguek = "";
$sorguok = 0;
$sqlsorgu = "";

if (!empty($durum)) {
    $sorguok += 1;
    $sqlsorguek = " durum='" . $durum . "' ";
}
if (!empty($gonderim)) {
    $sorguok += 1;
    if ($sorguok > 1) {
        $sqlsorguek = $sqlsorguek . " AND ";
    }
    $sqlsorguek = $sqlsorguek . " gonderim='" . $gonderim . "' ";
}
if (!empty($musteri)) {
    $sorguok += 1;
    if ($sorguok > 1) {
        $sqlsorguek = $sqlsorguek . " AND ";
    }
    $sqlsorguek = $sqlsorguek . " musteri_id=" . $musteri . " ";
}
if (!empty($urun)) {
    $sorguok += 1;
    
    if ($sorguok > 1) {
        $sqlsorguek = $sqlsorguek . " AND ";
    }
    $sqlsorguek = $sqlsorguek . " urun_id=" . $urun . " ";
}
if (!empty($assigned)) {
    $sorguok += 1;
    if ($sorguok > 1) {
        $sqlsorguek = $sqlsorguek . " AND ";
    }
    $sqlsorguek = $sqlsorguek . " staff_user_id=" . $assigned . " ";
}
$sqlsorgu = "SELECT * FROM tblkargo WHERE" . $sqlsorguek;

?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php


                            ?>
                            <!--a class="btn btn-primary" href="../musteriistek">Geri Dön</a-->


                        </div>

                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table id="sikayettaleptable" class="table dt-table">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = $db->prepare($sqlsorgu);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($results as $result) {
                                        $musteri = $db->prepare("SELECT * FROM tblclients WHERE userid=?");
                                        $musteri->execute(array($result['musteri_id']));
                                        $musterisonuc = $musteri->fetch(PDO::FETCH_ASSOC);

                                        $urun = $db->prepare("SELECT * FROM tblkargolist WHERE id=?");
                                        $urun->execute(array($result['urun_id']));
                                        $urunsonuc = $urun->fetch(PDO::FETCH_ASSOC);

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
                                            <th><?= $urunsonuc['urun_ismi'] ?></th>
                                            <th>
                                                <?= $musterisonuc['phonenumber'] ?>
                                            </th>
                                            <th>
                                                <?= $result['tarih'] ?>
                                            </th>
                                            <th>
                                                <?= $result['gonderim'] ?>
                                            </th>
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
                                                    echo "<div id='resimdiv'>";
                                                    echo "<a href='../assets/images/kargo/kargo/" . $result['kargo_foto'] . "'><img src='../assets/images/kargo/kargo/" . $result['kargo_foto'] . "' width='50' height='50'></a></div>";
                                                }
                                                ?>
                                            </th>
                                            <th>
                                                <?php
                                                if ($iadesonuc['durum'] == "Bekleniyor") {
                                                    echo "<a href='kargo/iade_kargolar?sorgu=1'>Bekleniyor</a>";
                                                } else if ($iadesonuc['durum'] == "İade Edildi") {
                                                    echo "<a href='kargo/iade_kargolar?sorgu=0'>İade Edildi</a>";
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

    <?php init_tail(); ?>

    </body>

    </html>