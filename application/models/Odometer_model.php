<?php

class Odometer_Model extends CI_Model
{

     public function get_odometer()
     {
          return $this->db->get("books");
     }

     public function reportShow($path) {
        error_reporting(0);   
        $this->load->library('PHPJasperXML');
        $server = "localhost:3307";   
        $user = "root";
        $pass = "";
        $db = "test";
        $PHPJasperXML = new PHPJasperXML();
        //$PHPJasperXML->debugsql=true;
        $PHPJasperXML->arrayParameter = array("parameter1" => 1);
        $PHPJasperXML->load_xml_file($path);
        $PHPJasperXML->transferDBtoArray($server, $user, $pass, $db);
        $PHPJasperXML->outpage("I");
     }

}

?>