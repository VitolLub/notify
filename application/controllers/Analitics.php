<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'NovaPoshtaApi2.php';
class Analitics extends CI_Controller {
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
        $ana = array();
        $datee = array();
        $data = array(
            'firstdate' => $this->input->post('firstdate'),
            'lastdate' => $this->input->post('lastdate')
        );
        if(isset($data['firstdate'])&&isset($data['lastdate'])){
            $firstdate = $data['firstdate'];
            $lastdate = $data['lastdate'];
        }
        else{
            $lastdate = date("Y-m-d");
            $firstdate =  date("Y-m-d", strtotime($lastdate." -7 day" ) );
        }
        $date1 = date("d.m.Y",strtotime($firstdate));
        $date2 = date("d.m.Y",strtotime($lastdate));
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);
        $seconds_diff = $ts2-$ts1;
        $a2 = floor($seconds_diff/(60 * 60 * 24));
        $data['view'] = 'analitics';
        $key = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
        if($key!=NULL){
            $data['key'] = $key->user_key;
        }
        $data["balance"] = $this->pages_model->get_user_balance($this->ion_auth->user()->row()->id);
        $data["price"] = $this->pages_model->get_sms_price();
        $data["user_name"] = $this->pages_model->user_name($this->ion_auth->user()->row()->id);
        $yesterday =  date("Y-m-d", strtotime($firstdate." -1 day" ) );
        for($i=0;$i<$a2;$i++)
        {
            $yesterday =  date("Y-m-d", strtotime($firstdate." +".$i." day" ) );
            $data['analit'] = $this->pages_model->get_analitics($this->ion_auth->user()->row()->id,$yesterday);

            array_push($ana,intval($data['analit'][0]->total));
            if(empty($data['analit'][0]->u_date)){
                array_push($datee,$yesterday);
            }
            else{
                array_push($datee,$data['analit'][0]->u_date);
            }

        }
        $data['analitiscs'] = $ana;
        $data['andate'] = $datee;
        
        //get analitics data
        $data['res_analit'] = $this->pages_model->get_analitics_data($this->ion_auth->user()->row()->id,$lastdate,$firstdate);
        $this->load->view('template/template_view', $data);
    }

}
