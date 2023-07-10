<?php
use app\services\utilities\Arr;

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
        $this->load->view('kargo/iade_kargolar', array());
    }
    public function ayarlar()
    {
        $data['title'] = _l('Ayarlar');
        $this->load->view('kargo/ayarlar', array());
    }
    public function detayliara()
    {
        $data['title'] = _l('Detaylı Ara');
        $this->load->view('kargo/detayliara', array());
    }
    public function detayliarasonuc()
    {
        $data['title'] = _l('Detaylı Ara Sonuç');
        $this->load->view('kargo/detayliarasonuc', array());
    }
    public function gonderilen_kargolar()
    {
        $data['title'] = _l('Gönderilen Kargolar');
        $this->load->view('kargo/gonderilen_kargolar', array());
    }
    public function sent()
    {
        $data['title'] = _l('Sent');
        $this->load->view('kargo/sent', array());
    }
    public function report()
    {
        $data['title'] = _l('Report');
        $this->load->view('kargo/report', array());
    }
    public function print(){
        $data['jquery_js'] = base_url('assets/plugins/jquery/jquery.js');
        $data['print_js'] = base_url('modules/kargo/assets/plugins/print/printThis.js');

        $data['bootstrap_css'] = base_url('assets/plugins/bootstrap/css/bootstrap.css');

        $this->load->view("kargo/print",$data);
    }

    public function kargolist_all_table(){


        $this->app->get_table_data('kargolist_all');

    }
    public function gonderilmeyi_bekleyen_kargolar()
    {
        $data['title'] = _l('Gönderilmeyi Bekleyen Kargolar');
        $this->load->view('kargo/gonderilmeyi_bekleyen_kargolar', array());
    }
    public function gonderilmeyi_bekleyen_kargolar2()
    {
        $data['title'] = _l('Gönderilmeyi Bekleyen Kargolar2');
        $this->load->view('kargo/gonderilmeyi_bekleyen_kargolar2', array());
    }
    public function readytosend()
    {
        $data['title'] = _l('Ready To Send');
        $this->load->view('kargo/readytosend', array());
    }
    public function teslim_edilen()
    {
        $data['title'] = _l('Teslim Edilen Kargolar');
        $this->load->view('kargo/teslim_edilen', array());
    }
    public function rapor()
    {
        $data['title'] = _l('Rapor');
        $this->load->view('kargo/rapor', array());
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
    
    public function urun_ekle()
    {
        $this->load->library('urunekle');

        // AJAX isteğine yanıt olarak HTML kodunu alın
        $html = $this->urunekle->getHTMLResponse();

        // HTML kodunu JSON formatına dönüştürerek döndürün
        $response = array('html' => $html);
        echo json_encode($response);
    }






    //------------------- kargo_update ------------------------------------
    public function kargo_report()
    {
        $contents = "";
        if (file_exists(dirname(__FILE__) . "/update_report.txt"))
            $contents = file_get_contents(dirname(__FILE__) . "/update_report.txt");
        $data = [
            "logs" => $contents
        ];
        $this->flsuhJson($data);
        die;
    }

    public function kargo_update()
    {
        if (!has_permission('kargo', '', 'kargo_update')) {
            access_denied('kargo');
        }
        $this->load->library(KARGO_MODULE_NAME . '/' . 'update_module');
        $this->update_module->update();
        $data['title'] = _l('kargo_update');
        $this->load->view('kargo_update', $data);
    }

    public function flsuhJson($data)
    {
        header('Content-Type: application/json', true);
        echo(json_encode($data));

        // This is what you need
        ob_flush();
        flush();
    }

//\------------------- kargo_update ------------------------------------
}
