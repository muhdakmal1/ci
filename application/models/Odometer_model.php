<?php

class Odometer_Model extends CI_Model
{

     public function get_odometer()
     {
          return $this->db->get("books");
     }

}

?>