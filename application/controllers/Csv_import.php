<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv_import extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('csv_import_model');
		$this->load->library('csvimport');
	}

	function index_csv()
	{
		$this->load->view('pages/outsource/csv_file');
	}

	function load_data()
	{
		$result = $this->csv_import_model->select();
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
					<th>Variance</th>
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
					<td>'.$row->odo_date.'</td>
					<td>'.$row->odo_transaction_type.'</td>
					<td>'.$row->odo_vehicle_number.'</td>
					<td>'.$row->odometer.'</td>
					<td>'.$row->odo_variance.'</td>
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

	function import()
	{
		$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
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
                'statement_month'   => $row['Statement Month'],
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

		$this->csv_import_model->insert($data);
		// $result = $this->csv_import_model->select();
	}
	
		
}
