<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kargo extends AdminController
{
    public function __construct()
    {
        Parent::__construct();
        $this->load->model("kargo_model");
    }
    public function iade_kargolar()
    {
        $data['title'] = _l('İade Kargolar');
        $this->load->view('admin/kargo/iade_kargolar', array());
    }
    public function ayarlar()
    {
        $data['title'] = _l('Ayarlar');
        $this->load->view('admin/kargo/ayarlar', array());
    }
    public function detayliara()
    {
        $data['title'] = _l('Detaylı Ara');
        $this->load->view('admin/kargo/detayliara', array());
    }
    public function detayliarasonuc()
    {
        $data['title'] = _l('Detaylı Ara Sonuç');
        $this->load->view('admin/kargo/detayliarasonuc', array());
    }
    public function gonderilen_kargolar()
    {
        $data['title'] = _l('Gönderilen Kargolar');
        $this->load->view('admin/kargo/gonderilen_kargolar', array());
    }
    public function sent()
    {
        $data['title'] = _l('Sent');
        $this->load->view('admin/kargo/sent', array());
    }
    public function report()
    {
        $data['title'] = _l('Report');
        $this->load->view('admin/kargo/report', array());
    }
    public function gonderilmeyi_bekleyen_kargolar()
    {
        $data['title'] = _l('Gönderilmeyi Bekleyen Kargolar');
        $this->load->view('admin/kargo/gonderilmeyi_bekleyen_kargolar', array());
    }
    public function gonderilmeyi_bekleyen_kargolar2()
    {
        $data['title'] = _l('Gönderilmeyi Bekleyen Kargolar2');
        $this->load->view('admin/kargo/gonderilmeyi_bekleyen_kargolar2', array());
    }
    public function readytosend()
    {
        $data['title'] = _l('Ready To Send');
        $this->load->view('admin/kargo/readytosend', array());
    }
    public function teslim_edilen()
    {
        $data['title'] = _l('Teslim Edilen Kargolar');
        $this->load->view('admin/kargo/teslim_edilen', array());
    }
    public function rapor()
    {
        $data['title'] = _l('Rapor');
        $this->load->view('admin/kargo/rapor', array());
    }
    public function index()
    {

        if (!has_permission('customers', '', 'create')) {
            if ($id != '' && !is_customer_admin($id)) {
                access_denied('customers');
            }
        }

        $data['title'] = _l('Kargo List');
        $this->load->view('kargo/kargolist', array());
    }
}
