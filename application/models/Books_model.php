<?php

class Books_Model extends CI_Model
{

     public function get_books()
     {
          return $this->db->get("books");
     }

}

?>