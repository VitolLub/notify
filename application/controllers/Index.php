<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');
        $this->load->library('pagination');
        if ($this->ion_auth->logged_in())
        {
            redirect('home');
        }
    }
    public function index()
    {
        $data['view'] = 'index';
        $this->load->view('template/template_view', $data);
    }


}
