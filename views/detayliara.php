<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php include "inc/db.php" ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php
                        $staffquery = $db->prepare("SELECT * FROM santrallogkisi");
                        $staffquery->execute();
                        $staff = $staffquery->fetchAll(PDO::FETCH_ASSOC);

                        $departmentsquery = $db->prepare("SELECT * FROM tblclients");
                        $departmentsquery->execute();
                        $departments = $departmentsquery->fetchAll(PDO::FETCH_ASSOC);

                        $staffquery = $db->prepare("SELECT * FROM tblstaff");
                        $staffquery->execute();
                        $staff = $staffquery->fetchAll(PDO::FETCH_ASSOC);


                        ?>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>

                        <!-- Modal -->

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detaylı Ara</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="clientid" class="control-label"> <small class="req text-danger">*
                                            </small>Müşteri</label>
                                        <div class="dropdown bootstrap-select ajax-search bs3 open" style="width: 100%;">
                                            <select id="clientid" name="musteri_id" data-live-search="true" data-width="100%" class="ajax-search" data-none-selected-text="Seçim yapılmadı" tabindex="-98" title="Seçin ve yazmaya başlayın">
                                                <option class="bs-title-option" value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group select-placeholder">
                                        <label for="gonderim" class="control-label">
                                            Gönderim
                                        </label>
                                        <select name="gonderim" id="gonderim" class="form-control selectpicker">
                                            <option value=""></option>
                                            <option value="Değişim">Değişim</option>
                                            <option value="Ücretsiz Gönderim">Ücretsiz Gönderim</option>
                                            <option value="Ücretli Gönderim">Ücretli Gönderim</option>
                                        </select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group select-placeholder">
                                        <label for="durum" class="control-label">
                                            Durum
                                        </label>
                                        <select name="durum" id="durum" class="form-control selectpicker">
                                            <option value=""></option>
                                            <option value="Göndermeye Hazır">Göndermeye Hazır</option>
                                            <option value="Gönderildi">Gönderildi</option>
                                            <option value="Teslim Edildi">Teslim Edildi</option>
                                        </select>
                                    </div>
                                </div><!-- Col -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Ürün İsmi</label>
                                        <select class="form-control selectpicker" required id="urun" name="urun_ismi">
                                            <option></option>
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
                                </div><!-- Col -->
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group select-placeholder">
                                        <label for="assigned" class="control-label">
                                            Personel Ara
                                        </label>
                                        <select required name="assigned" id="assigned" class="form-control selectpicker" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" data-width="100%">
                                            <option value=""><?php echo _l('ticket_settings_none_assigned'); ?>
                                            </option>
                                            <?php foreach ($staff as $member) { ?>
                                                <option value="<?php echo $member['staffid']; ?>" <?php if ($member['staffid'] == get_staff_user_id()) {
                                                                                                        echo 'selected';
                                                                                                    } ?>>
                                                    <?php echo $member['firstname'] . ' ' . $member['lastname']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Kapat</button>
                                <button type="button" class="btn btn-primary " onclick="ara()">
                                    Ara
                                </button>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php init_tail(); ?>
        <script>
            function ara() {
                var assigned = $('#assigned').val();
                var durum = $('#durum').val();
                var gonderim = $('#gonderim').val();
                var clientid = $('#clientid').val();
                var urun = $('#urun').val();
                window.location.href = 'detayliarasonuc?durum=' + durum + '&gonderim=' + gonderim + '&musteri=' + clientid + '&urun=' + urun + '&personel='+assigned;
            }
        </script>
        </body>

        </html>