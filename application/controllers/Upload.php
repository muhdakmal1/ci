<?php

class Upload extends CI_Controller {
 
        public function __construct()
        {
         parent::__construct();
         $this->load->model('outsource_model');
         $this->load->library('csvimport');
         $this->load->library('Excel/excel');
        }
       
        function index_csv()
        {
         $this->load->view('pages/outsource/csv_file');
        }
       
        function index_excel()
        {
        $this->load->view('pages/outsource/excel_file');
        }
        
        function load_data()
        {
         $result = $this->outsource_model->select();
         $output = '
          <h3 align="center">Imported User Details from CSV File</h3>
               <div class="table-responsive">
                <table class="table table-bordered table-striped">
                 <tr>
                  <th>Sr. No</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Phone</th>
                  <th>Email Address</th>
                 </tr>
         ';
         $count = 0;
         if($result->num_rows() > 0)
         {
          foreach($result->result() as $row)
          {
           $count = $count + 1;
           $output .= '
           <tr>
            <td>'.$count.'</td>
            <td>'.$row->first_name.'</td>
            <td>'.$row->last_name.'</td>
            <td>'.$row->phone.'</td>
            <td>'.$row->email.'</td>
           </tr>
           ';
          }
         }
         else
         {
          $output .= '
          <tr>
              <td colspan="5" align="center">Data not Available</td>
             </tr>
          ';
         }
         $output .= '</table></div>';
         echo $output;
        }
        
        function fetch()
 {
  $data = $this->excel_import_model->select();
  $output = '
  <h3 align="center">Total Data - '.$data->num_rows().'</h3>
  <table class="table table-striped table-bordered">
   <tr>
    <th>Customer Name</th>
    <th>Address</th>
    <th>City</th>
    <th>Postal Code</th>
    <th>Country</th>
   </tr>
  ';
  foreach($data->result() as $row)
  {
   $output .= '
   <tr>
    <td>'.$row->CustomerName.'</td>
    <td>'.$row->Address.'</td>
    <td>'.$row->City.'</td>
    <td>'.$row->PostalCode.'</td>
    <td>'.$row->Country.'</td>
   </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
 }

        function import_csv()
        {
         $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
         foreach($file_data as $row)
         {
          $data[] = array(
           'first_name' => $row["First Name"],
                 'last_name'  => $row["Last Name"],
                 'phone'   => $row["Phone"],
                 'email'   => $row["Email"]
          );
         }
         $this->outsource_model->insert($data);
        }

        function import_excel()
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
                                        $first_name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                                        $last_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                                        $phone = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                                        $email = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                                        $data[] = array(
                                        'first_name'  => $first_name,
                                        'last_name'   => $last_name,
                                        'phone'    => $phone,
                                        'email'   => $email
                                        );
                                }
                        }
                        $this->outsource_model->insert($data);
                        echo 'Data Imported successfully';
                } 
        }
        
         
 
}
?>