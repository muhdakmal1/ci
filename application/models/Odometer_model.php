<?php

class Odometer_Model extends CI_Model
{

     public function get_odometer()
     {
         $query_vehicle_list = "SELECT 
                                    t1.`vehicle_model`,t1.`vehicle_no`,t2.`description` AS section,t3.`description` AS company
                                FROM 
                                    vehicle_list t1 
                                JOIN section_vehicle t2 ON t2.code = t1.section_code
                                JOIN company_vehicle t3 ON t3.code = t1.company_code";

        //   return $this->db->get("vehicle_list");
        return $this->db->query($query_vehicle_list);
     }

     public function reportShow($path) {
        error_reporting(0);   
        $this->load->library('PHPJasperXML');
        $server = "localhost:3307";   
        $user = "root";
        $pass = "";
        $db = "test";
        $PHPJasperXML = new PHPJasperXML();
        $PHPJasperXML->debugsql=false;
        $PHPJasperXML->arrayParameter=array("parameter1"=>1);
        $xml =  simplexml_load_file($path);
        $PHPJasperXML->load_xml_string($xml); //load xml string instead of file

        $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
        $PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file
     }

    //  public function reportShow_sub($path) {
    //     error_reporting(0);   
    //     $this->load->library('PHPJasperXML');
    //     $server = "localhost:3307";   
    //     $user = "root";
    //     $pass = "";
    //     $db = "test";
    //     $PHPJasperXML = new PHPJasperXML("en");
    //     //$PHPJasperXML->debugsql=false;
    //     $PHPJasperXML->arrayParameter=array("parameter1"=>1);
    //     $PHPJasperXML->load_xml_file($path);

    //     $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
    //     $PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file
    //  }

     public function odometer_report($path) {
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