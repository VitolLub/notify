<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'NovaPoshtaApi2.php';
class Leave extends CI_Controller {

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

        if(isset($date)){
            $date = array(
                'firstdate' => $this->input->post('firstdate'),
                'lastdate' => $this->input->post('lastdate'),
            );
        }
        else{
            $date = array(
                'firstdate' => date( "Y-m-d", strtotime(date('Y-m-d')." -2 day" )),
                'lastdate' => date('Y-m-d'),
            );
        }
        $data = array();
        $data['view'] = 'leave';
        $key = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
        $data["balance"] = $this->pages_model->get_user_balance($this->ion_auth->user()->row()->id);
        $data["price"] = $this->pages_model->get_sms_price();
        $data["user_name"] = $this->pages_model->user_name($this->ion_auth->user()->row()->id);
        $np = new NovaPoshtaApi2($key->user_key);
        $dd = array();
        $idd = array();
        array_push($idd,0);
        $date1 = date("d.m.Y",strtotime($date['firstdate']));
        $date2 = date("d.m.Y",strtotime($date['lastdate']));
        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);
        $seconds_diff = $ts2-$ts1;
        $a2 = floor($seconds_diff/(60 * 60 * 24));
        for($i=1;$i<$a2;$i++){
            $result = $np
                ->model('InternetDocument')
                ->method('getDocumentList')
                ->params(array(
                    "DateTimeFrom" => $date1,
                    "DateTimeTo" => $date2,
                    "Page" => $i
                ))
                ->execute();
            $aa = array_merge($dd, $result['data']);
            $dd += $aa;
        }
        $data['res'] = $dd;
        for($i=0;$i<count($dd);$i++){
            $yesterday =  date("Y-m-d", strtotime($dd[$i]['EstimatedDeliveryDate']." +2 day" ) );
            $Estimate =  date("Y-m-d", strtotime($dd[$i]['DateLastUpdatedStatus']));
            $date = date("Y-m-d");
            $ts1 = strtotime($yesterday);
            $ts2 = strtotime($Estimate);

            $seconds_diff = $ts1-$ts2;
            $a = floor($seconds_diff/(60 * 60 * 24));
            if($a>4&&$yesterday<$date)
            {
                array_push($idd,$dd[$i]['IntDocNumber']);
            }
        }

        $data['id'] = $idd;
        $a = array();
        for($f=0;$f>count($data['res']);$f++)
        {
            array_push($a,array_search($data['res']['IntDocNumber'], $data['id']));
        }
        $this->load->view('template/template_view', $data);
    }

}
