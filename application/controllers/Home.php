<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'NovaPoshtaApi2.php';
class Home extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('pagination');
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $date = array(
            'firstdate' => $this->input->get('firstdate'),
            'lastdate' => $this->input->get('lastdate'),
            'count_list'=>$this->input->get('count_list')
        );
        $data = array(
            'firstdate' => $this->input->post('firstdate'),
            'lastdate' => $this->input->post('lastdate'),
            'count_list'=>$this->input->post('count_list')
        );
        if(isset($data['firstdate'])&&isset($data['lastdate']))
        {
            $firstdate = $data['firstdate'];
            $timestamp = strtotime($firstdate);
            $day = date('d', $timestamp);
            $month = date('m', $timestamp);
            $year = date('Y', $timestamp);
            $yesterday = $day.'.'.$month.'.'.$year;
            $findate = $data['lastdate'];
            $timestamp2 = strtotime($findate);
            $day2 = date('d', $timestamp2);
            $month2 = date('m', $timestamp2);
            $year2 = date('Y', $timestamp2);
            $findate = $day2.'.'.$month2.'.'.$year2;
            $firstdate = $data['firstdate'];
            $lastdate = $data['lastdate'];
        }
        elseif(isset($date['firstdate'])||isset($date['lastdate']))
        {
            $firstdate = $date['firstdate'];
            $lastdate = $date['lastdate'];
            $findate = $date['lastdate'];
            $yesterday =  $date['firstdate'];
        }
        else{
            $findate = date('d.m.Y');
            $yesterday =  date( "d.m.Y", strtotime($findate." -2 day" ) );

            $firstdate = $yesterday;
            $lastdate = $findate;
        }
        $count_list = $data['count_list'];
        $count_list2 =  $date['count_list'];
        #print_r($count_list);
        $data=array();
        $data['key'] = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
        if($data['key']==NULL){
            $data2 = array();
            $data2['view'] = 'key';
            $data2['stat'] = 'false';
            redirect('key/index',$data2);
        }
        else {
            $kk = strval($data['key']->user_key);
            $np = new NovaPoshtaApi2($kk);
            $result = $np
                ->model('InternetDocument')
                ->method('getDocumentList')
                ->params(array(
                    "DateTimeFrom" => $yesterday,
                    "DateTimeTo" => $findate,
                    "Page" => "1"
                ))
                ->execute();
            if(count($result['data'])==100)
            {
                $result['data'] = $this->select_result($data['key']->user_key,$yesterday,$findate);
            }
            if(isset($result)&& count($result)<0){
                redirect('/home/key', 'refresh');
            }
            $data['date'] = $result;
            $data['view'] = 'home';
            $data['base_url'] = base_url() . '/home/index';
            $data['total_rows'] = count($result['data']);
            $data['per_page'] = $count_list;
            if(isset($data["per_page"]))
            {
                $pp = $data["per_page"];
            }
            elseif(isset($count_list2)){
                $pp = $count_list2;
                $data['per_page'] = $pp;
            }
            else{
                $pp = 20;
                $data['per_page'] = $pp;
            }
            $choice = $data["total_rows"] / $pp;
            $data["num_links"] = round($choice);
            $this->pagination->initialize($data);
            $data['number'] = $this->uri->segment(3);
            $data["links"] = $this->pagination->create_links();
            $data["balance"] = $this->pages_model->get_user_balance($this->ion_auth->user()->row()->id);
            $data["price"] = $this->pages_model->get_sms_price();
            $data["user_name"] = $this->pages_model->user_name($this->ion_auth->user()->row()->id);
            $data['user_p'] = $this->pages_model->get_archive($this->ion_auth->user()->row()->id, $yesterday,$findate);
            if(isset($date['firstdate'])||isset($date['lastdate'])){
                $data['firstdate'] = $date['firstdate'];
                $data['lastdate'] = $date['lastdate'];
            }
            else{
                $data['firstdate'] = $firstdate;
                $data['lastdate'] = $lastdate;
            }
            $data['turbosms'] = $this->pages_model->get_turbo_sms($this->ion_auth->user()->row()->id);
            for($i = 0; $i < count($data['date']['data']); $i++)
            {
                for($b=0;$b<count($data['user_p']);$b++){

                    if(isset($data['date']['data'][$i]['RecipientContactPhone'])&& isset($data['user_p'][$b]['phone'])) {
                        if ($data['date']['data'][$i]['RecipientContactPhone'] == $data['user_p'][$b]['phone']) {
                            unset($data['date']['data'][$i]);

                        }
                    }

                }
            }
            $res = array_values($data['date']['data']);
            $data['date'] = $res;
            $this->load->view('template/template_view', $data);

        }
    }
    public function select_result($kk,$yesterday,$findate){
        $np = new NovaPoshtaApi2($kk);
        $array1 = array();
        for($i=1;$i<5;$i++) {
            $result = $np
                ->model('InternetDocument')
                ->method('getDocumentList')
                ->params(array(
                    "DateTimeFrom" => $yesterday,
                    "DateTimeTo" => $findate,
                    "Page" => "".$i.""
                ))
                ->execute();
            for($b=0;$b<count($result['data']);$b++)
            {
                array_push($array1,$result['data'][$b]);
            }
        }
        return $array1;

    }
    public function addtoarhive($phone,$date2,$ref2,$chanel,$region,$uname){
        $this->pages_model->addtoarhive($phone,$date2,$this->ion_auth->user()->row()->id,$ref2,$chanel,$region,$uname);
        $sms_getawey = $this->pages_model->get_getawey($this->ion_auth->user()->row()->id);
        if(!empty($sms_getawey->s_name)){
            echo "s_name available";
        }
        else{
            $this->pages_model->minu_balance($this->ion_auth->user()->row()->id);
        }


    }
    public function send_sms(){
        $data = array(
            'checkedList' => $this->input->post('checkedList'),
            'region' => $this->input->post('region'),
            'uname' => $this->input->post('uname'),
        );
        $region = $data['region'];
        $uname = $data['uname'];
        $data['sms_template'] = $this->pages_model->get_sms_template($this->ion_auth->user()->row()->id);
        $data['message'] = $this->pages_model->get_sms_template($this->ion_auth->user()->row()->id);
        if(count($data['sms_template'])==1){
            $text2 = $data['message'][0]->message;
        }
        else{
            $text2 = "Ваш заказ отправлен. ТТН: {ttn}";
        }
        for($i=0;$i<count($data['checkedList']);$i++)
        {

            $ttn = strstr($data['checkedList'][$i], '|',true);
            $number = strstr($data['checkedList'][$i], '|');
            $phone = ltrim($number, '|');
            $phone2 = strpos($phone, '#');
            $phone3 = substr($phone,0,$phone2);
            $date = strstr($data['checkedList'][$i], '#');
            $date3 = ltrim($date, '#');
            $date4 = strpos($date3, '??');
            $date2 = substr($date3,0,$date4);
            $ref = strstr($data['checkedList'][$i], '??');
            $ref3 = ltrim($ref, '??');
            $ref4 = strpos($ref3, '//');
            $ref2 = substr($ref3,0,$ref4);
            $price = strstr($data['checkedList'][$i], '//');
            $price2 = strstr($price, '//');
            $price3 = substr($price2,2);
            /*$ref = strstr($data['checkedList'][$i], '??');
            $ref3 = ltrim($ref, '//');
            $ref4 = strpos($ref3, '??');
            $ref2 = substr($ref3,0,$ref4);
            echo $ref2;*/
            try {
                $text = str_replace("{ttn}",$ttn,$text2);
                $text = str_replace("{count}",$ref2,$text);
                $text = str_replace("{price}",$price3,$text);
                $text3 = str_replace("\n"," ",$text);

                $sms_getawey = $this->pages_model->get_getawey($this->ion_auth->user()->row()->id);


                if(!empty($sms_getawey->s_name)){
                    $client = new SoapClient('http://turbosms.in.ua/api/wsdl.html');
                    $auth = array(
                        'login' => strval($sms_getawey->s_name),
                        'password' => strval($sms_getawey->u_pass)
                    );
                    $result = $client->Auth($auth);
                    $result = $client->GetCreditBalance();
                    echo $result->GetCreditBalanceResult . PHP_EOL;
                    if(!empty($sms_getawey->s_name)){
                        $this->pages_model->save_sms_bal($result->GetCreditBalanceResult, $this->ion_auth->user()->row()->id);
                        $sms = array(
                            'sender' => $sms_getawey->s_name,
                            'destination' => '+'.$phone3,
                            'text' => $text
                        );
                    }
                    $result = $client->SendSMS($sms);
                    // Conclusions The results sent.
                    $this->addtoarhive($phone3,$date2,$ttn,0,$region[$i],$uname[$i]);
                    echo "<pre>";
                    echo "</pre>";
                }else{
                    $username = 'Notify.ua';
                    $password = 'U618y!e4';
                    $a = base64_encode($username.':'.$password);

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "http://api.infobip.com/omni/1/scenarios",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "
                            {
                          \"name\":\"My VIBER-SMS scenario\",
                          \"flow\": [
                            {
                              \"from\": \"Notify\",
                              \"channel\": \"VIBER\"
                            },
                            {
                              \"from\": \"1_test_1\",
                              \"channel\": \"SMS\"
                            }    
                          ],
                          \"default\": true
                        }
                        ",
                        CURLOPT_HTTPHEADER => array(
                            "accept: application/json",
                            "authorization: Basic ".$a."==",
                            "content-type: application/json"
                        ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        $aaa = $this->pages_model->get_sending_type($this->ion_auth->user()->row()->id);

                        $phone = "380506238527";
                        if (empty($aaa)){
                            $ma = json_decode($response);
                            $aa = $ma->key;
                            $curl2 = curl_init();
                            curl_setopt_array($curl2, array(
                                CURLOPT_URL => "http://api.infobip.com/omni/1/advanced",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => "{ \"bulkId\":\"BULK-ID-123-xyz\", \"key\":\".$aa.\", \"destinations\":[ { \"messageId\":\"MESSAGE-ID-123-xyz\", \"to\":{ \"phoneNumber\":\"$phone3\"} } ], \"viber\":{ \"text\":\"$text3\" },\"sms\":{ \"text\":\"$text\" }}",
                                CURLOPT_HTTPHEADER => array(
                                    "accept: application/json",
                                    "authorization: Basic " . $a . "==",
                                    "content-type: application/json"
                                ),
                            ));
                            $response2 = curl_exec($curl2);
                            $err = curl_error($curl2);
                            curl_close($curl2);
                            if ($err) {
                                echo "<br/>";
                                echo "cURL Error #:" . $err;
                            } else {
                                echo $response2;

                            }
                        }
                        else{
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => "http://api.infobip.com/sms/1/text/single",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS => "{ \"from\":\"TTNnotify\", \"to\":\".$phone3.\", \"text\":\"Test SMS.\" }",
                                CURLOPT_HTTPHEADER => array(
                                    "accept: application/json",
                                    "authorization: Basic ".$a."==",
                                    "content-type: application/json"
                                ),
                            ));

                            $response = curl_exec($curl);
                            $err = curl_error($curl);

                            curl_close($curl);

                            if ($err) {
                                echo "cURL Error #:" . $err;
                            } else {
                                echo $response;
                            }
                        }

                        $curl3 = curl_init();
                        curl_setopt_array($curl3, array(
                            CURLOPT_URL => "http://api.infobip.com/omni/1/reports",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_POSTFIELDS => "",
                            CURLOPT_HTTPHEADER => array(
                                "accept: application/json",
                                "authorization: Basic ".$a."=="
                            ),
                        ));
                        $response = curl_exec($curl3);
                        $err = curl_error($curl3);

                        curl_close($curl3);

                        if ($err) {
                            echo "cURL Error #:" . $err;
                        } else {
                            $ress =json_decode($response);
                            $chanel = $ress->results[0]->channel;
                            print_r($chanel);
                            if($chanel=='SMS'){
                                $this->addtoarhive($phone3,$date2,$ttn,0,$region[$i],$uname[$i]);
                            }
                            else{
                                $this->addtoarhive($phone3,$date2,$ttn,1,$region[$i],$uname[$i]);
                            }
                        }
                    }



                }

            } catch(Exception $e) {
                echo 'Error: ' . $e->getMessage() . PHP_EOL;
            }
        }
        echo json_encode($data);


    }
    public function success(){
        $data2 = array(
            'data' => $this->input->post('data'),
            'signature' => $this->input->post('signature')
        );
        $private_key = 'GLIjhC6Ot98kMONd80zKOlp3MAxXQAFX1rM2gQyY';
        #print_r($data2);
        $data = base64_encode($data2['data']);
        #print_r($data);
        $json = base64_decode($data2['data']);
        $json2 = json_decode($json);
        #print_r($json2);
        if($json2->status=="success") {
            //echo $json2->status;
            $amount = $json2->amount;
            $date = date('Y-m-d');
            $sms_price = $this->pages_model->get_sms_price();
            $credit = $amount / $sms_price->price;
            $credit2 = number_format((float)$credit, 1, '.', '');
            $credit3 = round($credit2);
            $this->pages_model->payment($this->ion_auth->user()->row()->id, $date, $amount);
            $this->pages_model->update_balance($this->ion_auth->user()->row()->id, $credit);
            redirect('/home/index', 'refresh');
        }
        else{
            echo "Произошла ошибка, попробуйте еще раз!";
        }
    }
    public function save_star(){
        $data = array(
            'checkedArray' => $this->input->post('checkedArray')
        );
        $data['key'] = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
        $kk = strval($data['key']->user_key);
        $np = new NovaPoshtaApi2($kk);
        for($i=0;$i<count($data['checkedArray']);$i++) {
            $ttn = strstr($data['checkedArray'][$i], '|',true);
            $number = strstr($data['checkedArray'][$i], '|');
            $phone = ltrim($number, '|');
            $phone2 = strpos($phone, '#');
            $phone3 = substr($phone,0,$phone2);
            $result = $np
                ->model('InternetDocument')
                ->method('getDocumentList')
                ->params(array(
                    "IntDocNumber" => $ttn,
                ))
                ->execute();
            $u_name=$result['data'][0]['RecipientContactPerson'];
            echo $u_name;
            $this->pages_model->selected($this->ion_auth->user()->row()->id,$phone3,$ttn,$u_name);
        }
    }
    public function save_to_sended(){
        $data = array(
            'checkedList' => $this->input->post('checkedList')
        );
        print_r($data['checkedList']);
        $user = $this->ion_auth->user()->row()->id;
        for($i=0;$i<count($data['checkedList']);$i++){
            $this->pages_model->save_to_sended($user,$data['checkedList'][$i]);
        }
    }
    public function save_to_notsended(){
        $data = array(
            'checkedList' => $this->input->post('checkedList'),
            'region' => $this->input->post('region'),
            'uname' => $this->input->post('uname'),
        );
        print_r($data['checkedList']);
        $user = $this->ion_auth->user()->row()->id;
        for($i=0;$i<count($data['checkedList']);$i++){
            $this->pages_model->save_to_notsended($user,$data['checkedList'][$i],$data['region'][$i],$data['uname'][$i]);
        }
    }

}
