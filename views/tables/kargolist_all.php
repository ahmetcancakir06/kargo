<?php

defined('BASEPATH') or exit('No direct script access allowed');


$aColumns = [
    'tblmusteri_talepler.id',
    '(SELECT CONCAT_WS(" ",userid,firstname,lastname) FROM ' . db_prefix() . 'contacts WHERE ' . db_prefix() . 'contacts.userid = ' . db_prefix() . 'musteri_talepler.userid ORDER by userid ASC) as user',
    '(SELECT CONCAT_WS("<br>",phonenumber,secondphone,thirdphone) FROM ' . db_prefix() . 'contacts WHERE ' . db_prefix() . 'contacts.userid = ' . db_prefix() . 'musteri_talepler.userid ORDER by userid ASC) as phonenumbers',

    '(SELECT isim FROM ' . db_prefix() . 'musteri_talep_tur WHERE ' . db_prefix() . 'musteri_talep_tur.id = ' . db_prefix() . 'musteri_talepler.tur ORDER by id ASC) as turs',
    'konu',
    'tarih',
    '(SELECT CONCAT_WS(",",staffid,firstname,lastname) FROM ' . db_prefix() . 'staff WHERE ' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'musteri_talepler.kim_ilgileniyor ORDER by staffid ASC) as kim_ilgileniyor',
    '(SELECT CONCAT_WS(",",staffid,firstname,lastname) FROM ' . db_prefix() . 'staff WHERE ' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'musteri_talepler.kim_ekledi ORDER by staffid ASC) as kim_ekledi',
    '(SELECT CONCAT_WS(",",id,isim,gorunum) FROM ' . db_prefix() . 'musteri_talep_durum WHERE ' . db_prefix() . 'musteri_talep_durum.id = ' . db_prefix() . 'musteri_talepler.durum ORDER by id ASC) as durum',
    '(SELECT CONCAT_WS(",",id,isim,gorunum) FROM ' . db_prefix() . 'musteri_talep_alt_kategori WHERE ' . db_prefix() . 'musteri_talep_alt_kategori.id = ' . db_prefix() . 'musteri_talepler.alt_kategori ORDER by id ASC) as alt_kategori',

];

$sIndexColumn = 'id';
$sTable = db_prefix() . 'musteri_talepler';
$where = [];
$ci = &get_instance();
$ci->load->model('musteri_listesi_model');
$getAllStaff = $ci->musteri_listesi_model->getAllStaff();
$join = [
    'LEFT JOIN ' . db_prefix() . 'contacts ON ' . db_prefix() . 'musteri_talepler.userid=' . db_prefix() . 'contacts.userid '
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [], '', 'tblmusteri_talepler.id');

$output = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $aRow) {
    $row = [];
    $kim_ilgileniyor_ex = explode(",", $aRow['kim_ilgileniyor']);
    $rowName = '<a href="' . admin_url() . '/staff/member/' . $kim_ilgileniyor_ex[0] . '" target="_blank" ><img src="' . staff_profile_image_url($kim_ilgileniyor_ex[0]) . '" class="client-profile-image-small mright5"></a>' .
        '<select class="form-control" onchange="kisiDegistir(' . $aRow['tblmusteri_talepler.id'] . ',this,\'kim_ilgileniyor\')">';
    foreach ($getAllStaff as $staff) {
        $selected = "";
        if ($staff['staffid'] == $kim_ilgileniyor_ex[0]) {
            $selected = "selected";
        }
        $rowName .= '<option value="' . $staff['staffid'] . '" ' . $selected . '>' . $staff['firstname'] . " " . $staff['lastname'] . '</option>';
    }
    $rowName .= '</select>';
    $rowName .= '<div class="row-options">';

    $rowName .= '</div>';

    $kim_ekledi_ex = explode(",", $aRow['kim_ekledi']);
    $rowName2 = "";
    if ($_SESSION['staff_user_id'] == "1") {
        $rowName2 = '<a target="_blank" href="' . admin_url() . '/staff/member/' . $kim_ekledi_ex[0] . '" ><img src="' . staff_profile_image_url($kim_ekledi_ex[0]) . '" class="client-profile-image-small mright5"></a>' .
            '<select class="form-control" onchange="kisiDegistir(' . $aRow['tblmusteri_talepler.id'] . ',this,\'kim_ekledi\')">';
        foreach ($getAllStaff as $staff) {
            $selected = "";
            if ($staff['staffid'] == $kim_ekledi_ex[0]) {
                $selected = "selected";
            }
            $rowName2 .= '<option value="' . $staff['staffid'] . '" ' . $selected . '>' . $staff['firstname'] . " " . $staff['lastname'] . '</option>';
        }
        $rowName2 .= '</select>';


        $rowName2 .= '<div class="row-options">';

        $rowName2 .= '</div>';
    } else {
        $rowName2 = $kim_ekledi_ex[1] . ' ' . $kim_ekledi_ex[2];
    }
    $row[] = $aRow['tblmusteri_talepler.id'];
    $explode_user=explode(" ",$aRow['user']);
    $explode_user=removeEmptyValues($explode_user);

    if(count($explode_user) > 0){
        $row[]='<a href="' . admin_url() . 'musteri_listesi/client/' . $explode_user[0] . '?group=talepler" target="_blank" >'.$explode_user[1]." ".$explode_user[2].'</a>';
    }

    $row_phone = "";
    $rowexp_phone = explode("<br>", $aRow['phonenumbers']);
    foreach ($rowexp_phone as $phone) {
        $row_phone .= '<a href="tel:' . $phone . '">' . $phone . '</a><br>';
    }
    $row[] = $row_phone;
    if (has_permission('musteri_listesi', '', 'musteri_listesi_talep_updateTur')) {
        $row[] = '<a href="#" data-toggle="modal" data-target="#updateTur" onclick="changeTur(' . $aRow['tblmusteri_talepler.id'] . ')">' . $aRow['turs'] . '</a>';
    } else {
        $row[] = $aRow['turs'];
    }
    $row[] = $aRow['konu'];
    $row[] = '<button class="btn btn-primary" onclick="yorumekleIstek(\'' . $aRow['tblmusteri_talepler.id'] . '\')">Yorumları Göster</button>';

    $row[] = $aRow['tarih'];

    $row[] = $rowName;
    $row[] = $rowName2;
    $rowexp_durum = explode(",", $aRow['durum']);

    if (has_permission('musteri_listesi', '', 'musteri_listesi_talep_updateDurum')) {
        if ($aRow['durum'] == '') {
            $row[] = '<a href="#" data-toggle="modal" data-target="#updateDurum" onclick="changeDurum(' . $aRow['tblmusteri_talepler.id'] . ')"><span class="label label-danger">Durum Boş</span></a>';
        } else {
            $row[] = '<a href="#" data-toggle="modal" data-target="#updateDurum" onclick="changeDurum(' . $aRow['tblmusteri_talepler.id'] . ')"><span class="label label-' . $rowexp_durum[2] . '">' . $rowexp_durum[1] . '</span></a>';
        }
    } else {
        if($aRow['durum'] == ''){
            $row[] = '<span class="label label-danger">Durum Boş</span>';

        }else {
            $row[] = '<span class="label label-' . $rowexp_durum[2] . '">' . $rowexp_durum[1] . '</span>';
        }
    }
    if(!empty($aRow['alt_kategori'])) {
        $rowexp_alt_kategori = explode(",", $aRow['alt_kategori']);
        $row[] = '<a href="#" data-toggle="modal" data-target="#updateAltKategori" onclick="changeAltKategori(' . $aRow['tblmusteri_talepler.id'] . ',\'' . $rowexp_alt_kategori[0] . '\')"><span class="label label-' . $rowexp_alt_kategori[2] . '">' . $rowexp_alt_kategori[1] . '</span></a>';
    }else{
        $row[] = '<a href="#" data-toggle="modal" data-target="#updateAltKategori" onclick="changeAltKategori(' . $aRow['tblmusteri_talepler.id'] . ')"><span class="label label-danger">Alt Kategorisi Yok</span></a>';
    }
    if (has_permission('musteri_listesi', '', 'musteri_listesi_talep_sil')) {
        $row[] = '<button class="btn btn-danger" onclick="delettalep(' . $aRow['tblmusteri_talepler.id'] . ')" title="' . _l('record_delete') . '"><i class="fa fa-trash"></i></button>';
    }

    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
function removeEmptyValues($array) {
    // Boş değerleri sil
    $array = array_values(array_filter($array, function($value) {
        return !empty($value);
    }));

    // Yeni diziyi döndür
    return $array;
}