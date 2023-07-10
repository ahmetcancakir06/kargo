<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php include "inc/db.php" ?>


<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">

                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <table id="youtubetable" class="table dt-table">
                            <thead>
                                <tr>
                                    <th>Gönderilmeyi Bekleyen</th>
                                    <th>İletilmiş</th>
                                    <th>İade Edilmiş</th>
                                    <th>Teslim Edilmiş</th>
                                    <th>Son 1 Haftada Gönderilen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $birhafta = strtotime("-1 week");
                                $simdi = strtotime("now");
                                $birhaftaonce = date("d/m/Y", $birhafta);
                                $suan = date("d/m/Y", $simdi);

                                $teslimedilenq = $db->prepare("SELECT COUNT(id) as teslimedilen FROM tblkargo WHERE durum=? ");
                                $teslimedilenq->execute(array("Teslim Edildi"));
                                $teslimedilenr = $teslimedilenq->fetch(PDO::FETCH_ASSOC);

                                $iadeedilenq = $db->prepare("SELECT COUNT(id) as iadeedilen FROM tblkargo_iade WHERE durum=? OR durum=?");
                                $iadeedilenq->execute(array("Bekleniyor", "İade Edildi"));
                                $iadeedilenr = $iadeedilenq->fetch(PDO::FETCH_ASSOC);

                                $gonderilmeyibekleyenq = $db->prepare("SELECT COUNT(id) as gonderilmeyibekleyen FROM tblkargo WHERE durum=?");
                                $gonderilmeyibekleyenq->execute(array("Göndermeye Hazır"));
                                $gonderilmeyibekleyenr = $gonderilmeyibekleyenq->fetch(PDO::FETCH_ASSOC);

                                $gonderilenq = $db->prepare("SELECT COUNT(id) as gonderilen FROM tblkargo WHERE durum=?");
                                $gonderilenq->execute(array("Gönderildi"));
                                $gonderilenr = $gonderilenq->fetch(PDO::FETCH_ASSOC);


                                $haftagonderilenq = $db->prepare("SELECT COUNT(id) as haftagonderilen FROM tblkargo WHERE STR_TO_DATE(tarih, '%d/%m/%Y') BETWEEN STR_TO_DATE(?, '%d/%m/%Y') AND STR_TO_DATE(?, '%d/%m/%Y') ");
                                $haftagonderilenq->execute(array($birhafta, $suan));
                                $haftagonderilenq = $haftagonderilenq->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <tr>
                                    <th><?= $teslimedilenr['teslimedilen'] ?></th>
                                    <th><?= $iadeedilenr['iadeedilen'] ?> </th>
                                    <th><?= $gonderilmeyibekleyenr['gonderilmeyibekleyen'] ?></th>
                                    <th><?= $gonderilenr['gonderilen'] ?></th>
                                    <th><?= $haftagonderilenq['haftagonderilen'] ?></th>
                                    
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php init_tail(); ?>