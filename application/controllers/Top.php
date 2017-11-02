<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archive extends CI_Controller {

    public function index()
    {
        $data['view'] = 'template/top_view';
        $this->load->view('template/template_view', $data);
        echo "aaa";
    }
}
