<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kargo_model extends App_Model
{
   public function __construct(){
        parent::__construct();
        $this->load->database();
   }
   public function getKargo(){
       return $this->db->get('tblkargolist');       
   }

}
