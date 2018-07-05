<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller
{
     public function index()
     {
        $this->odometer_model->reportShow("application/views/report/sample1.jrxml");
        // $this->load->view("report/sample1.php");
     }

}
?>