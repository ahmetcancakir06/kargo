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
                            if (has_permission('kargo', '', 'urunekle')) {
                            ?>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    Ürün Ekle
                                </button>
                            <?php
                            }
                            ?>

                        </div>


                        <form action="../../exec/ajaxurunekle.php" method="POST" enctype="multipart/form-data">

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Yeni ürün ekle</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Ürün İsmi</label>
                                                        <input type="text" class="form-control" autocomplete="off" id="urunismimodal" name="urunismimodal">
                                                    </div>


                                                </div><!-- Col -->
                                                <div class="col-sm-4">
                                                    <div class="form-group">

                                                        <label class="control-label">Ürün Stok</label>
                                                        <input type="text" class="form-control" autocomplete="off" name="urunstokmodal" id="urunstokmodal">
                                                    </div>


                                                </div><!-- Col -->
                                                <div class="col-sm-4">

                                                    <div class="form-group">

                                                        <label class="control-label">Ürün Fiyat</label>
                                                        <input type="text" class="form-control" autocomplete="off" name="urunfiyatmodal" id="urunfiyatmodal">
                                                    </div>

                                                </div><!-- Col -->

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">

                                                        <label class="control-label">Bayi Seç</label>
                                                        <select class="form-control" id="bayisec" name="bayisec">
                                                            <option value="">Seçiniz</option>
                                                            <?php
                                                            $selectsbayi = $db->prepare("SELECT * FROM kargobayi");
                                                            $selectsbayi->execute();
                                                            $resultsbayi = $selectsbayi->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($resultsbayi as $bayis) {

                                                            ?>
                                                                <option value="<?= $bayis['id'] ?>"><?= $bayis['bayi'] ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                </div><!-- Col -->
                                                <div class="col-sm-6">
                                                    <div class="form-group">

                                                        <label class="control-label">Ürün Resmi</label>
                                                        <input type="file" class="form-control" autocomplete="off" name="urunresimmodal" id="urunresimmodal">
                                                    </div>

                                                </div><!-- Col -->
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">

                                                        <label class="control-label">Ürün Açıklama</label>
                                                        <textarea class="form-control" autocomplete="off" name="urunacikalamamodal" id="urunacikalamamodal"></textarea>
                                                    </div>

                                                </div><!-- Col -->
                                            </div><!-- Row -->
                                        </div>


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Kapat</button>
                                            <button type="submit" name="cron_insert" class="btn btn-primary submit">
                                                Ekle
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php

                        ?>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <table id="kargoreport" class="table dataTable no-footer" style="border:0 !important;">
                            <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Product Explanation</th>

                                    <th>Product Stock</th>
                                    <th>Total Sent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $urunsonucar = array();
                                $getkargos = $db->prepare("SELECT * FROM tblkargo WHERE gonderenkisi=?");
                                $getkargos->execute(array("10"));
                                $reskargos = $getkargos->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($reskargos as $kargo) {
                                    $urunidler = explode(",", $kargo['urun_id']);
                                    $urunadetex = explode(",", $kargo['adet']);

                                    for ($x = 0; $x < count($urunidler); $x++) {
                                        $urun = $db->prepare("SELECT * FROM tblkargolist WHERE id=?");
                                        $urun->execute(array($urunidler[$x]));
                                        $urunsonuc = $urun->fetch(PDO::FETCH_ASSOC);
                                        $urunismi = $urunismi . $urunsonuc['urun_ismi'] . " Adet = " . $urunadetex[$x] . "<br>";
                                        if (empty($urunsonucar[$urunidler[$x]])) {
                                            $urunsonucar[$urunidler[$x]] = 0 + $urunadetex[$x];
                                        } else {
                                            $urunsonucar[$urunidler[$x]] = $urunsonucar[$urunidler[$x]] + $urunadetex[$x];
                                        }
                                    }
                                }

                                $query = $db->prepare("SELECT * FROM tblkargolist WHERE bayi_id=1");
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($results as $result) {

                                    if ($result['urun_stok'] == 0) {
                                        $renk = "style='color:red;'";
                                    } elseif ($result['urun_stok'] < 10) {
                                        $renk = "style='color:orange;'";
                                    } else {
                                        $renk = "style='color:green;'";
                                    }


                                ?>
                                    <tr>

                                        <th>
                                            <p <?= $renk ?>><?= $result['id'] ?></p>
                                        </th>
                                        <th>
                                            <p <?= $renk ?>><?= $result['productname'] ?></p>
                                        </th>
                                        <th>
                                            <p <?= $renk ?>><?= $result['productexplanation'] ?></p>
                                        </th>

                                        <th>
                                            <p <?= $renk ?>><?= $result['urun_stok'] ?></p>
                                        </th>
                                        <th>
                                            <p><?= $urunsonucar[$result['id']] ?></p>
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

    <form action="../../exec/ajaxkargoupdate.php" method="POST" enctype="multipart/form-data">
        <div class="modal fade bd-example-modal-l" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-l" role="document">
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
                                <input type="hidden" name="gizliid" id="gizliid">
                                <div class="form-group">
                                    <label class="control-label">Ürün İsmi</label>
                                    <input type="text" class="form-control" autocomplete="off" id="urunismi" name="urunismi">
                                </div>


                            </div><!-- Col -->
                            <div class="col-sm-2">
                                <div class="form-group">

                                    <label class="control-label">Ürün Stok</label>
                                    <input type="text" class="form-control" autocomplete="off" name="urunstok" id="urunstok">
                                </div>


                            </div><!-- Col -->
                            <div class="col-sm-2">

                                <div class="form-group">

                                    <label class="control-label">Ürün Fiyat</label>
                                    <input type="text" class="form-control" autocomplete="off" name="urunfiyat" id="urunfiyat">
                                </div>

                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="form-group">

                                    <label class="control-label">Ürün Resmi Yükle</label>
                                    <input type="file" class="form-control" autocomplete="off" name="urunresim" id="urunresim">
                                </div>
                                <input type="hidden" name="resgiz" id="resgiz">
                                <div class="form-group">

                                    <img id="urunresimsrc" width="100%" height="100%">
                                </div>

                            </div><!-- Col -->
                            <div class="col-sm-12">
                                <div class="form-group">

                                    <label class="control-label">Ürün Açıklama</label>
                                    <textarea class="form-control" autocomplete="off" name="urunacikalama" id="urunacikalama"></textarea>
                                </div>

                            </div><!-- Col -->
                        </div><!-- Row -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" name="cron_update" class="btn btn-primary submit">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php init_tail(); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.8/js/dataTables.responsive.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>

    <script src="../../inc/lightgallery-all.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#kargoreport').DataTable({

            });

            //table.buttons().disable();

            $('#resimdiv').lightGallery({
                thumbnail: true,
                animateThumb: false,
                showThumbByDefault: false
            });


        });


        function urun_get(id) {
            $.ajax({
                url: '../../exec/ajaxgeturun.php',
                method: 'post',
                dataType: "json",

                data: {
                    'id': id

                },
                success: function(results) {
                    $('#gizliid').val(id);
                    $('#urunismi').val(results[0].urunismi);
                    $('#urunstok').val(results[0].urunstok);
                    $('#urunfiyat').val(results[0].urunfiyat);
                    $('#resgiz').val(results[0].urunresim);
                    $('#urunresimsrc').attr("src", "../../assets/images/kargo/urunler/" + results[0].urunresim);
                    $('#urunacikalama').val(results[0].urunaciklama);

                }
            });
        }

        function urun_delete(id) {

            $.ajax({
                url: '../../exec/ajaxdeleteurun.php',
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