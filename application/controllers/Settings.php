<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('pagination');
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login');
        }
    }
    public function index(){
        $data=array();
        $key = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
        if($key!=NULL){
            $data['key'] = $key->user_key;
        }
        $data["balance"] = $this->pages_model->get_user_balance($this->ion_auth->user()->row()->id);
        $data["price"] = $this->pages_model->get_sms_price();
        $data["user_name"] = $this->pages_model->user_name($this->ion_auth->user()->row()->id);
        $data["u_setting"] = $this->pages_model->get_settings($this->ion_auth->user()->row()->id);
        $data["auto_sms"] = $this->pages_model->get_auto_sending($this->ion_auth->user()->row()->id);
        $data["sending_type"] = $this->pages_model->get_sending_type($this->ion_auth->user()->row()->id);
        $data["sms_template2"] = $this->pages_model->get_sms_template($this->ion_auth->user()->row()->id);
        if($data["sms_template2"]==NULL)
        {
            $data["sms_template"] = "Ваш заказ отправлен. ТТН: {ttn}";
        }
        else
        {
            $data["sms_template"] = $data["sms_template2"][0]->message;
        }
        $data['view'] = 'settings';
        
        $this->load->view('template/template_view', $data);
    }
    public function save_settings(){
        $data = array(
            'u_name' => $this->input->post('u_name'),
            'u_surname' => $this->input->post('u_surname'),
            'phone_number' => $this->input->post('phone_number'),
            'email' => $this->input->post('email'),
            'sms_template'=>$this->input->post('sms_template')
        );
        $this->pages_model->save_settings($this->ion_auth->user()->row()->id,$data['u_name'],$data['u_surname'],$data['phone_number'],$data['email']);
        print_r($data['sms_template']);
        $this->pages_model->save_templates($this->ion_auth->user()->row()->id,$data['sms_template']);
        redirect('settings/index');
    }
    public function auto_sending(){
        $data = array(
            'a' => $this->input->post('a'),
        );
        print_r($data['a']);
        $this->pages_model->auto_sending($this->ion_auth->user()->row()->id,$data['a']);
    }
    public function save_sending_type(){
        $data = array(
            'a' => $this->input->post('a'),
        );
        print_r($data);
        $this->pages_model->save_sending_type($this->ion_auth->user()->row()->id,$data['a']);
    }
    

}
?>