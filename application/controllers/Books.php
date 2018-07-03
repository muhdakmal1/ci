<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Books extends CI_Controller
{

    public function __construct() {
        Parent::__construct();
        $this->load->model("books_model");
    }

     public function index()
     {
          $this->load->view("books/index.php", array());
     }

     public function books_page()
     {

          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $books = $this->books_model->get_books();

          $data = array();

          foreach($books->result() as $r) {

               $data[] = array(
                    $r->name,
                    $r->price,
                    $r->author,
                    $r->rating . "/10 Stars",
                    $r->publisher
               );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $books->num_rows(),
                 "recordsFiltered" => $books->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }

}
?>