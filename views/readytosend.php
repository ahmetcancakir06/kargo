<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php include "inc/db.php" ?>
<style>
    #my_camera {
        width: 320px;
        height: 240px;
        border: 1px solid black;
    }
</style>
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
                                BULK PRINT
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
                                        <th>FULL NAME</th>
                                        <th>Address</th>
                                        <th>Suburb</th>
                                        <th>State</th>
                                        <th>POSTAL CODE</th>
                                        <th>PRODUCT NAME</th>
                                        <th>Contact Number</th>
                                        <th>Print</th>

                                        <th>Send Now</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $query = $db->prepare("SELECT * FROM tblkargo WHERE durum=?");
                                    $query->execute(array("Göndermeye Hazır"));
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
                                            $urunismi = $urunismi . $urunsonuc['productname'] . " Total = " . $urunadetex[$x] . "<br>";
                                        }

                                        $staf = $db->prepare("SELECT * FROM tblstaff WHERE staffid=?");
                                        $staf->execute(array($result['staff_user_id']));
                                        $stafsonuc = $staf->fetch(PDO::FETCH_ASSOC);

                                        $faturaget = $db->prepare("SELECT * FROM tblinvoices WHERE hash=?");
                                        $faturaget->execute(array($result['fatura_no']));
                                        $faturasonuc = $faturaget->fetch(PDO::FETCH_ASSOC);

                                    ?>
                                        <tr>
                                            <th>
                                                <div class="custom-checkbox custom-control ml-3">
                                                    <input type="checkbox" id="chckboox" value="<?= $result['id'] ?>" class="custom-control-input chckboox">
                                                    <label class="custom-control-label" for="chckboox">&nbsp;</label>
                                                </div>
                                            </th>
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
                                                <a href="../../exec/kargoprint.php?id=<?= $result['id'] ?>" target="_blank" class="btn btn-warning">Print</a>
                                            </th>
                                            <th>
                                                <button id="gonderbutton" onclick="kargo_gonder(<?= $result['id'] ?>)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">SEND NOW!</button>
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
    <form id="sendkargo" method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <input type="hidden" name="staff_user_id" value="<?= $_SESSION['staff_user_id'] ?>">

                        <h5 class="modal-title" id="exampleModalLabel">Kargoyu Gönder</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="gonderid" name="gonderid">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Takip Numarası</label>
                                    <input type="text" required="true" class="form-control" autocomplete="off" name="takipnumarasi" id="takipnumarasi">

                                </div>

                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Kargo Fotoğraf Yükle</label>
                                    <video id="video" width="1152" height="648" autoplay></video>
                                    <input type="button" class="form-control" id="snap" value="Take Snapshot">
                                    <canvas name="canvas" id="canvas" width="1152" height="648" style="display:none;"></canvas>

                                    <img id="testsnp" name="testsnp">
                                    <input type="hidden" id="gizliresim" name="gizliresim">
                                    <!--input type="file" class="form-control" autocomplete="off" name="kargoresim" id="kargoresim"-->

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form id="cokyaz" method="POST" action="../../exec/kargoprintcoklu.php" enctype="multipart/form-data">
        <input type="hidden" name="idlerprint" id="idlerprint">
    </form>
    <?php init_tail(); ?>
    <script src="../../inc/lightgallery-all.js"></script>
    <script type="text/javascript" src="../../inc/webcam.min.js"></script>

    <script>
        var video = document.getElementById('video');
        var img = document.getElementById("testsnp");
        // Get access to the camera!
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            // Not adding `{ audio: true }` since we only want video now
            const hdConstraints = {
                video: {
                    width: {
                        min: 1152
                    },
                    height: {
                        min: 648
                    }
                },
            };

            navigator.mediaDevices.getUserMedia(hdConstraints).then((stream) => {
                video.srcObject = stream;
            });
        }

        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        var video = document.getElementById('video');

        // Trigger photo take


        $('#snap').click(function() {
            context.drawImage(video, 0, 0, 1152, 648);
            img.src = canvas.toDataURL("image/webp");

            $('#gizliresim').val($('#testsnp').attr('src'));
        });





        function kargo_gonder(id) {
            $('#gonderid').val(id);
        }


        $(document).ready(function() {
            $('#sendkargo').submit(function() {
                var gonder = 1;
                var sayimi = 0;
                var takipno = $('#takipnumarasi').val();
                
                var resim = $('#gizliresim').val();
                if (takipno == "" || resim == "") {
                    gonder = 0;
                    alert_float("danger", "Check Tracking and Photo is required");
                }
                if (takipno.length < 10) {
                    gonder = 0;
                    alert_float("danger", "Check Tracking is required length more 10 digits");
                }
                if (gonder == 1) {
                    var formData = new FormData($(this)[0]);
                    $.ajax({
                        url: "../../exec/ajaxkargosent.php",
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
                }
                return false;
            });

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
            $('#cokyaz').submit();

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