<?php

class Odometer_Model extends CI_Model
{
    function allposts_count()
    {   
        $query = $this
                ->db
                ->get('vehicle_list');
    
        return $query->num_rows();  

    }
    
    function allposts($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('vehicle_list');
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function posts_search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->like('vehicle_no',$search)
                // ->or_like('title',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('vehicle_list');
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function posts_search_count($search)
    {
        $query = $this
                ->db
                ->like('vehicle_no',$search)
                // ->or_like('title',$search)
                ->get('vehicle_list');
    
        return $query->num_rows();
    } 

    #####################################################

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

     //Data Transaction Odometer List//
     public function get_transaction_odometer()
     {
         $query_transaction_list = "SELECT 
                                        odo_vehicle_number,
                                        odo_transaction_type,
                                        odo_date,
                                        odometer
                                    FROM table8
                                    ORDER BY odo_vehicle_number ASC, str_to_date( odo_date, '%d/%m/%Y' ) DESC";

        //   return $this->db->get("vehicle_list");
        $transaction_qry = $this->db->query($query_transaction_list);

        return $transaction_qry->num_rows(); 
     }

     function get_alltransaction_odometer($limit,$start,$col,$dir)
    {   
        
        $query_transaction_list = "SELECT 
                                        id,
                                        odo_vehicle_number,
                                        odo_transaction_type,
                                        odo_date,
                                        odometer
                                    FROM table8
                                    ORDER BY odo_vehicle_number ASC, str_to_date( odo_date, '%d/%m/%Y' ) DESC";

        $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->query($query_transaction_list);
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }

     function insert_transaction_odometer($data)
    {
        // var_dump($this->load->dbforge());
        $this->db->insert_batch('table8', $data);
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