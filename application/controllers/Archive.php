<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'NovaPoshtaApi2.php';
class Archive extends CI_Controller {
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
        if(isset($data['firstdate'])&&isset($data['lastdate'])||isset($data['firstdate2'])&&isset($data['lastdate2']))
        {
            $findate = date( "d.m.Y", strtotime($data['lastdate']));
            $yesterday =  date( "d.m.Y", strtotime($data['firstdate']." -7 day" ));
            $findate2 = date( "d.m.Y", strtotime($data['lastdate2']));
            $yesterday2 =  date( "d.m.Y", strtotime($data['firstdate2']." -7 day" ));
        }
        else{
            $findate = date('d.m.Y');
            $yesterday =  date( "d.m.Y", strtotime($findate." -7 day" ) );
            $findate2 = date('d.m.Y');
            $yesterday2 =  date( "d.m.Y", strtotime($findate." -7 day" ) );
        }

        $data['view'] = 'archive';
        $key = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
        if($key!=NULL){
            $data['key'] = $key->user_key;
        }

        $data["balance"] = $this->pages_model->get_user_balance($this->ion_auth->user()->row()->id);
        $data["price"] = $this->pages_model->get_sms_price();
        $data["user_name"] = $this->pages_model->user_name($this->ion_auth->user()->row()->id);
        $data['archiv'] = $this->pages_model->get_archive_data($this->ion_auth->user()->row()->id);
        $data['listDate'] = $this->pages_model->get_to_sended_date($this->ion_auth->user()->row()->id);
        $data['firstdate'] = $yesterday;
        $data['lastdate'] = $findate;
        $data['firstdate2'] = $yesterday2;
        $data['lastdate2'] = $findate2;
        //print_r(count($data['archiv']));
        $this->load->view('template/template_view', $data);
    }
    public function get_arhive_date(){
        $data = array(
            'date' => $this->input->post('date')
        );
        $data['archiv'] = $this->pages_model->get_archive_ttn3($this->ion_auth->user()->row()->id,$data['date']);
        //print_r($data['archiv']);
        $key = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
        if($key!=NULL){
            $data['key'] = $key->user_key;
        }
        $date['arh_d'] = array();
        $np = new NovaPoshtaApi2($key->user_key);
        for($i=0;$i<count($data['archiv']);$i++){
            $result = $np
                ->model('InternetDocument')
                ->method('getDocumentList')
                ->params(array(
                    "IntDocNumber" => $data['archiv'][$i]->ref,
                ))
                ->execute();
            $date['arh_d'][$i]=$result;
        }
        echo json_encode($date['arh_d']);
    }
    public function get_to_sended(){
        $data = array(
            'date' => $this->input->post('date')
        );
        $date['list'] = $this->pages_model->get_to_sended2($this->ion_auth->user()->row()->id,$data['date'],$data['date']);
        echo json_encode($date);

    }
    public function get_to_notsended(){
        $data = array(
            'a' => $this->input->post('a')
        );
        $data2 = array(
            'firstdate2' => $this->input->post('firstdate2'),
            'lastdate2' => $this->input->post('lastdate2')
        );
        if(isset($data2['firstdate2'])&&isset($data2['lastdate2'])){
            $firstdate = $data2['firstdate2'];
            $lastdate = $data2['lastdate2'];
        }
        else{
            $lastdate = date('Y-m-d');
            $firstdate =  date( "Y-m-d", strtotime($lastdate." -7 day" ) );
        }
        $a = array();
        $b = array();
        $aa = array();
        $aa2 = array();
        $aa3 = array();
        $aa4 = array();
        $date['list'] = $this->pages_model->get_to_notsended($this->ion_auth->user()->row()->id,$firstdate,$lastdate);
        for($i=0;$i<count($date['list']);$i++){
            $a[] = $date['list'][$i]['uname'];
            $aa[] = $date['list'][$i]['users'];
            $aa2[] = $date['list'][$i]['phone'];
            $aa3[] = $date['list'][$i]['price'];
            $aa4[] = $date['list'][$i]['u_date'];

        }
        array_push($b,$a);
        array_push($b,$aa);
        array_push($b,$aa2);
        array_push($b,$aa3);
        array_push($b,$aa4);
        echo json_encode($b);

    }
    public function save_to_sended(){
        $data = array(
            'checkedList' => $this->input->post('checkedList'),
            'uname' => $this->input->post('uname'),
            'phone' => $this->input->post('phone'),
            'price' => $this->input->post('price')
        );
        for($i=0;$i<count($data['checkedList']);$i++) {
            $this->pages_model->save_to_sended2($this->ion_auth->user()->row()->id, $data['checkedList'][$i], $data['uname'][$i], $data['phone'][$i], $data['price'][$i]);
        }
    }
    public function download(){
        $data = array(
            'date' => $this->input->get('date')
        );
        $data['archiv'] = $this->pages_model->get_archive_ttn($this->ion_auth->user()->row()->id,$data['date']);
        $str2 = array();
        for($i=0;$i<count($data['archiv']);$i++){
            $aa = $data['archiv'][$i]->uname."|".$data['archiv'][$i]->users."|".$data['archiv'][$i]->u_date."|".$data['archiv'][$i]->cost."|".$data['archiv'][$i]->phone."\r\n";

            array_push($str2,$aa);

        }
        $str = implode("\r\n", $str2);
        //print_r($str);
        header('Content-Disposition: attachment; filename="archiv.txt"');
        header('Content-Type: text/plain'); # Don't use application/force-download - it's not a real MIME type, and the Content-Disposition header is sufficient
        header('Content-Length: ' . strlen($str));
        header('Connection: close');


        echo $str;
    }
    public function get_delivery_stat(){
        $data = array(
            'users' => $this->input->post('users')
        );
        $key = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
        if($key!=NULL){
            $data['key'] = $key->user_key;
        }
        $date['arh_d'] = array();
        $np = new NovaPoshtaApi2($key->user_key);
        $result = $np
            ->model('InternetDocument')
            ->method('getDocumentList')
            ->params(array(
                "IntDocNumber" => $data['users'],
            ))
            ->execute();
        $firstdate =  date( "Y-m-d", strtotime($result['data'][0]['DateTime']) );
        $dd = date("Y-m-d");
        if($result['data'][0]['DateLastUpdatedStatus']==$result['data'][0]['DateTime']){
            echo 1;
        }
        elseif ($firstdate==$dd){
            echo 2;
        }
        else{
            echo 0;
        }

    }
}
