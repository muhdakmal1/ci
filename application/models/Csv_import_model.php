<?php
class Csv_import_model extends CI_Model
{
	function select()
	{
		$query = $this->db->query("SELECT 
										id,
										odo_vehicle_number,
										odo_transaction_type,
										odo_date,
										odometer,
										odo_variance
									FROM table9
									ORDER BY odo_vehicle_number ASC, str_to_date( odo_date, '%d/%m/%Y' ) DESC");
		return $query;
	}

	function insert($data)
	{
		$this->db->insert_batch('table9', $data);

		$query = $this->db->query("SELECT 
										id,
										odo_vehicle_number,
										odo_transaction_type,
										odo_date,
										odometer
										
									FROM table9
									ORDER BY odo_vehicle_number ASC, str_to_date( odo_date, '%d/%m/%Y' ) DESC");

		$test = $query->result();
		if($query->num_rows() > 0)
		{
			$x = 0;
			$remark = "01";
			foreach($test as $row)
			{
				if($x==0){
					$variance = intval($test[$x]->odometer)-intval($test[$x+1]->odometer);
					$this->db->set('odo_variance',$variance);
					$this->db->set('odo_remark_code',$remark);
					$this->db->where('id', $test[$x]->id);
					$this->db->update('table9');
				}
				else if($x==count($test)-1){
					$variance = intval($test[$x]->odometer)-intval($test[$x]->odometer);
					$this->db->set('odo_variance',$variance);
					$this->db->set('odo_remark_code',$remark);
					$this->db->where('id', $test[$x]->id);
					$this->db->update('table9');
				}
				else if($test[$x]->odo_vehicle_number != $test[$x+1]->odo_vehicle_number){
					$this->db->set('odo_variance',0);
					$this->db->set('odo_remark_code',$remark);
					$this->db->where('id', $test[$x]->id);
					$this->db->update('table9');
				}
				else{
					$variance = intval($test[$x]->odometer)-intval($test[$x+1]->odometer);
					$this->db->set('odo_variance',$variance);
					if($variance == 0 && $test[$x]->odometer != ""){
						$this->db->set('odo_remark_code',"02");
					}
					else if($variance < 0 && $test[$x]->odometer != ""){
						$this->db->set('odo_remark_code',"02");
					}
					else if($test[$x]->odometer == ""){
						$this->db->set('odo_remark_code',"03");
					}
					else{
						$this->db->set('odo_remark_code',$remark);
					}
					$this->db->where('id', $test[$x]->id);
					$this->db->update('table9');
				}

				$x=$x+1;
				
			}
		}
	}
}
