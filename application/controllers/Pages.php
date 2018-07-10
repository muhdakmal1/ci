<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
    class Pages extends CI_Controller{
        public function view($page = 'home')
        {
            if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
            {
                    // Whoops, we don't have a page for that!
                    show_404();
            }

            $data['title'] = ucfirst($page); // Capitalize the first letter

            $this->load->view('templates/header', $data);
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer', $data);
        }

        public function dashboard($page = 'dash2')
        {
            // if ( ! file_exists(APPPATH.'views/pages/test/'.$page.'.php'))
            // {
            //         // Whoops, we don't have a page for that!
            //         show_404();
            // }

            $data['title'] = ucfirst($page); // Capitalize the first letter

            $this->load->view('templates/header', $data);
            $this->load->view('pages/dashboard/'.$page, $data);
            $this->load->view('templates/footer', $data);
        }
        
        public function __construct() {
            Parent::__construct();
            $this->load->model("odometer_model");
        }

        public function odometer($page = 'index')
        {
            // if ( ! file_exists(APPPATH.'views/pages/test/'.$page.'.php'))
            // {
            //         // Whoops, we don't have a page for that!
            //         show_404();
            // }

            $this->load->view('templates/header');
            $this->load->view('pages/odometer/'.$page, array('error' => ' ' ));
            $this->load->view('templates/footer');
        }

        public function odometer_page()
     {

          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $books = $this->odometer_model->get_odometer();

          $data = array();
          
          $countIndex = 1;

          foreach($books->result() as $r) {

               $data[] = array(
                    $r->$countIndex=$countIndex,
                    $r->company,
                    $r->section,
                    $r->vehicle_no,
                    $r->vehicle_model 
               );
               $countIndex=$countIndex+1;
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