<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Pisyek Kumar
 * @email pisyek@gmail.com
 * @link http://www.pisyek.com
 */
class Outsource_model extends CI_Model {
    // function readExcel()
    // {
    //     $this->load->library('csvreader');
    //     $result =   $this->csvreader->parse_file('Test.csv');//path to csv file

    //     $data['csvData'] =  $result;
    //     $this->load->view('view_csv', $data);  
    // }

    function select()
    {
    $this->db->order_by('id', 'DESC');
    $query = $this->db->get('tbl_user');
    return $query;
    }

    function insert($data)
    {
        // var_dump($this->load->dbforge());
        $this->db->insert_batch('tbl_user', $data);
    }
}