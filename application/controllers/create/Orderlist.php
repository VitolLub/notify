<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Orderlist extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login');
        }

    }
    public function index()
    {
        $key = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
        if($key!=NULL){
            $data['key'] = $key->user_key;
        }
        $data["balance"] = $this->pages_model->get_user_balance($this->ion_auth->user()->row()->id);
        $data["price"] = $this->pages_model->get_sms_price();
        $data["user_name"] = $this->pages_model->user_name($this->ion_auth->user()->row()->id);
        $data['view'] = 'create/orderlist';
        $this->load->view('template/template_view', $data);


    }

}
