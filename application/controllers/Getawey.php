<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'NovaPoshtaApi2.php';
class Getawey extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login');
        }
    }
    public function index()
    {
        $data['view'] = 'getawey';
        $key = $this->pages_model->get_turbosms($this->ion_auth->user()->row()->id);
        if($key!=NULL){
            $data['pass'] = $key->u_pass;
            $data['name'] = $key->s_name;
        }
        $data["balance"] = $this->pages_model->get_user_balance($this->ion_auth->user()->row()->id);
        $data["price"] = $this->pages_model->get_sms_price();
        $data["user_name"] = $this->pages_model->user_name($this->ion_auth->user()->row()->id);
        $this->load->view('template/template_view', $data);
    }
    public function add_turbosms(){
        $data = array(
            'alpha_name' => $this->input->post('alpha_name'),
            'pass' => $this->input->post('pass'),
        );
        $res = $this->pages_model->add_turbosms($data,$this->ion_auth->user()->row()->id);
        redirect('/getawey/index', 'refresh');
    }
    public function of_getawey(){
        $data = array(
            'a' => $this->input->post('a')
        );
        $this->pages_model->of_getawey($this->ion_auth->user()->row()->id);
    }
}
