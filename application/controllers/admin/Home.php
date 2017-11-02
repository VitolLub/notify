<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {

    function __construct(){
        //$this->load->library('ion_auth');
        parent::__construct();
        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/auth/login');
        }

    }

    public function index()
    {
        $date = array(
            'firstdate' => $this->input->get('firstdate'),
            'lastdate' => $this->input->get('lastdate')
        );
        $data['view'] = 'home';
        $this->load->view('admin/template/template_view', $data);
    }
    public function get_admin_analitics()
    {
        $data = array(
            'chanel' => $this->input->post('chanel')
        );
        $chanel = $data['chanel'];
        print_r($this->pages_model->get_admin_analitics($chanel));
    }



}
