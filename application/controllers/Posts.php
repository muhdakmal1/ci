<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends CI_Controller
{
     public function index()
     {
        $data['title'] = 'Latest Posts';

        $data['posts'] = $this->post_model->get_posts();
        print_r($data['posts']);
          $this->load->view("posts/index.php", $data);
     }

}
?>