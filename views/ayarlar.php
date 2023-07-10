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
                                                        <label class="control-label">Product Name</label>
                                                        <input type="text" class="form-control" autocomplete="off" id="proname" name="proname">
                                                    </div>


                                                </div><!-- Col -->
                                                <div class="col-sm-2">
                                                    <div class="form-group">

                                                        <label class="control-label">Ürün Stok</label>
                                                        <input type="text" class="form-control" autocomplete="off" name="urunstokmodal" id="urunstokmodal">
                                                    </div>


                                                </div><!-- Col -->
                                                <div class="col-sm-2">

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
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">

                                                        <label class="control-label">Product Explanation </label>
                                                        <textarea class="form-control" autocomplete="off" name="proexplanation" id="proexplanation"></textarea>
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

                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <table id="digiturktable" class="table dt-table">
                            <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>Ürün İsmi</th>
                                    <th>Ürün Açıklama</th>
                                    <th>Ürün Resim</th>
                                    <th>Ürün Stok</th>
                                    <th>Ürün Fiyat</th>
                                    <th>
                                        <?php
                                        if (has_permission('kargo', '', 'urunduzenle')) {
                                            echo "Güncelle ";
                                        }
                                        if (has_permission('kargo', '', 'urunsilme')) {
                                            echo "Sil";
                                        }
                                        ?>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = $db->prepare("SELECT * FROM tblkargolist");
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
                                            <p <?= $renk ?>><?= $result['urun_ismi'] ?></p>
                                        </th>
                                        <th>
                                            <p <?= $renk ?>><?= $result['urun_aciklama'] ?></p>
                                        </th>
                                        <th>
                                            <div id='resimdiv'>
                                                <a href="../../assets/images/kargo/urunler/<?= $result['urun_resim'] ?>">
                                                    <img src="../../assets/images/kargo/urunler/<?= $result['urun_resim'] ?>" width="50" height="50"></a>
                                            </div>
                                        </th>
                                        <th>
                                            <p <?= $renk ?>><?= $result['urun_stok'] ?></p>
                                        </th>
                                        <th>
                                            <p <?= $renk ?>><?= $result['urun_fiyat'] ?></p>
                                        </th>
                                        <th>
                                            <?php
                                            if (has_permission('kargo', '', 'urunduzenle')) {
                                            ?>
                                                <a href="javascript:void(0);" data-target="#Modal" data-toggle="modal" class="btn btn-primary" onclick="urun_get(<?= $result['id'] ?>)">
                                                    Düzenle
                                                </a>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            if (has_permission('kargo', '', 'urunsilme')) {
                                            ?>
                                                <a href="javascript:void(0);" onclick="urun_delete('<?= $result['id'] ?>')" class="btn btn-danger mb-1 mb-md-0">
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
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Product Name</label>
                                    <input type="text" class="form-control" autocomplete="off" id="productname" name="productname">
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
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select class="form-control" name="bayigun" id="bayigun">
                                        <option value="">Seçiniz</option>
                                        <?php
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

                                    <label class="control-label">Ürün Resmi Yükle</label>
                                    <input type="file" class="form-control" autocomplete="off" name="urunresim" id="urunresim">
                                </div>
                                <input type="hidden" name="resgiz" id="resgiz">
                                <div class="form-group">

                                    <img id="urunresimsrc" width="100%" height="100%">
                                </div>

                            </div><!-- Col -->
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">

                                    <label class="control-label">Ürün Açıklama</label>
                                    <textarea class="form-control" autocomplete="off" name="urunacikalama" id="urunacikalama"></textarea>
                                </div>

                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">

                                    <label class="control-label">Product Explanation</label>
                                    <textarea class="form-control" autocomplete="off" name="productexplanation" id="productexplanation"></textarea>
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
    <script src="../../inc/lightgallery-all.js"></script>
    <script>
        $(document).ready(function() {


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
                    $('#productname').val(results[0].productname);
                    $('#urunstok').val(results[0].urunstok);
                    $('#urunfiyat').val(results[0].urunfiyat);
                    $('#resgiz').val(results[0].urunresim);
                    $('#urunresimsrc').attr("src", "../../assets/images/kargo/urunler/" + results[0].urunresim);
                    $('#urunacikalama').val(results[0].urunaciklama);
                    $('#productexplanation').val(results[0].productexplanation);
                    $('#bayigun').val(results[0].bayi);
                    $('#bayigun').change();
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