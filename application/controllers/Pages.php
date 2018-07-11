<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
    class Pages extends CI_Controller{
        public function __construct() {
            Parent::__construct();
            $this->load->model("odometer_model");
            $this->load->model('outsource_model');
            $this->load->library('csvimport');
            $this->load->library('Excel/excel');
        }

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

        public function odometer($page = 'index')
        {
            // if ( ! file_exists(APPPATH.'views/pages/test/'.$page.'.php'))
            // {
            //         // Whoops, we don't have a page for that!
            //         show_404();
            // }
            $query = $this->db->get('company_vehicle');

            $data['error'] = array('error' => ' ' );
            $data['query'] = $query;
            
            $this->load->view('templates/header');
            $this->load->view('pages/odometer/'.$page, $data);
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

        public function transaction_odometer()
        {      
            $this->load->view('templates/header');
            $this->load->view('pages/odometer/transaction_odometer',array(''));
            $this->load->view('templates/footer');
        }

        public function data_transaction_odometer()
        {

          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $trans = $this->odometer_model->get_transaction_odometer();

          $data = array();
          
          $variance = intval($trans->row("odometer"));

          $countIndex = 1;
        
          foreach($trans->result() as $r) {
            $data[] = array(
                $countIndex,
                $r->odo_vehicle_number,
                $r->odo_transaction_type,
                $r->odo_date,
                $r->odometer,
                $variance
            );
            $countIndex=$countIndex+1;
            // $test=intval($r->odo_date);
            $variance=$variance-172308;
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $trans->num_rows(),
                 "recordsFiltered" => $trans->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
        }
        
        function import_data_csv()
        {
         $file_data = $this->csvimport->get_array($_FILES["file"]["tmp_name"]);
         foreach($file_data as $row)
         {
            $data[] = array(
                'odo_date'  => $row['Date Time'],
                'odo_transaction_type'   => $row['Transaction Type'],
                'odo_card_number'    => $row['Card Number'],
                'odo_vehicle_number'   => $row['Vehicle Number'],
                'driver_card_number'  => $row['Driver Card Number'],
                'product_type'   => $row['Product Type'],
                'billing_type'    => $row['Billing Type'],
                'transaction_volume'   => $row['Transaction Volume (Litres)'],
                'transaction_amount'  => $row['Transaction Amount (RM)'],
                'station_name'   => $row['Station Name'],
                'odometer'   => $row['Odometer'],
                'card_type'   => $row['Card Type'],
                'cost_centre'   => $row['Cost Centre'],
                'cost_centre_name'   => $row['Cost Centre Name'],
                'statement_month'   => $row['Statement Month']
                // 'odo_variance'    => $odometer,
                // 'odo_average'   => $vehicle_number,
                // 'odo_company_code'  => $driver_car,
                // 'odo_section_code'   => $product_type,
                // 'odo_region_code'    => $billing_type,
                // 'odo_unit_code'   => $transaction_volume,\
                // 'odo_type_code'   => $product_type,
                // 'odo_remark_code'    => $billing_type,
                // 'created_date'   => $transaction_volume,
                // 'created_by'   => $transaction_volume,
            );
         }
         $this->odometer_model->insert_transaction_odometer($data);
        }

        function import_data_excel()
        {
            if(isset($_FILES["file"]["name"]))
            {
                $path = $_FILES["file"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach($object->getWorksheetIterator() as $worksheet)
                {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for($row=2; $row<=$highestRow; $row++)
                    {
                        $date_time = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $transaction = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $card_number = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $vehicle_number = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $driver_car = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $product_type = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $billing_type = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $transaction_volume = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                        $transaction_amount = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                        $station_name = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                        $odometer = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                        $card_type = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                        $cost_centre = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                        $cost_centre_name = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                        $statement_month = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                        
                        $data[] = array(
                            'odo_date'  => $date_time,
                            'odo_transaction_type'   => $transaction,
                            'odo_card_number'    => $card_number,
                            'odo_vehicle_number'   => $vehicle_number,
                            'driver_card_number'  => $driver_car,
                            'product_type'   => $product_type,
                            'billing_type'    => $billing_type,
                            'transaction_volume'   => $transaction_volume,
                            'transaction_amount'  => $transaction_amount,
                            'station_name'   => $station_name,
                            'odometer'   => $odometer,
                            'card_type'   => $card_type,
                            'cost_centre'   => $cost_centre,
                            'cost_centre_name'   => $cost_centre_name,
                            'statement_month'   => $statement_month
                            // 'odo_variance'    => $odometer,
                            // 'odo_average'   => $vehicle_number,
                            // 'odo_company_code'  => $driver_car,
                            // 'odo_section_code'   => $product_type,
                            // 'odo_region_code'    => $billing_type,
                            // 'odo_unit_code'   => $transaction_volume,\
                            // 'odo_type_code'   => $product_type,
                            // 'odo_remark_code'    => $billing_type,
                            // 'created_date'   => $transaction_volume,
                            // 'created_by'   => $transaction_volume,
                        );
                    }
                }
                $this->odometer_model->insert_transaction_odometer($data);
                echo 'Data Imported successfully';
            } 
        }
    }