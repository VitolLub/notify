<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'NovaPoshtaApi2.php';
class Key extends CI_Controller {

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
        $data['view'] = 'key';
        $key = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
        if($key!=NULL){
            $data['key'] = $key->user_key;
        }
        $data["balance"] = $this->pages_model->get_user_balance($this->ion_auth->user()->row()->id);
        $data["price"] = $this->pages_model->get_sms_price();
        $data["user_name"] = $this->pages_model->user_name($this->ion_auth->user()->row()->id);
        $this->load->view('template/template_view', $data);
    }
    public function addkey(){
        $data = array(
            'key' => $this->input->post('key')
        );
        $this->pages_model->addkeys($data['key'],$this->ion_auth->user()->row()->id);
        $data['key'] = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
        $np = new NovaPoshtaApi2($data['key']->user_key);
        $findate = date('d.m.Y');
        $yesterday =  date( "d.m.Y", strtotime($findate." -2 day" ) );
        $result = $np
            ->model('InternetDocument')
            ->method('getDocumentList')
            ->params(array(
                "DateTimeFrom" => $yesterday,
                "DateTimeTo" => $findate,
                "Page" => "1"
            ))
            ->execute();
        if($result['success']==1){
                $data["balance"] = $this->pages_model->get_user_balance($this->ion_auth->user()->row()->id);
                $data["price"] = $this->pages_model->get_sms_price();
                $data["user_name"] = $this->pages_model->user_name($this->ion_auth->user()->row()->id);
                redirect('/home/index', 'refresh',$data);
        }
        else{
            $key = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
            if($key!=NULL){
                $data['key'] = $key->user_key;
            }
            $data['view'] = 'key';
            $data['cor'] = 0;
            $data["balance"] = $this->pages_model->get_user_balance($this->ion_auth->user()->row()->id);
            $data["price"] = $this->pages_model->get_sms_price();
            $data["user_name"] = $this->pages_model->user_name($this->ion_auth->user()->row()->id);
            $this->load->view('template/template_view', $data);
        }
    }

}
