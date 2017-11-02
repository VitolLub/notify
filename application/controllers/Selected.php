<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Selected extends CI_Controller{
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
        //standart param
        $data=array();
        $uid = $this->ion_auth->user()->row()->id;
        $key = $this->pages_model->get_keys($uid);
        if($key!=NULL){
            $data['key'] = $key->user_key;
        }
        $data["balance"] = $this->pages_model->get_user_balance($uid);
        $data["price"] = $this->pages_model->get_sms_price();
        $data["user_name"] = $this->pages_model->user_name($uid);
        // end standart param
        $data['select'] = $this->pages_model->get_selected($uid);
        $data['view'] = 'selected';

        $this->load->view('template/template_view', $data);
    }
    public function remove_star(){
        $data = array(
            'checkedArray' => $this->input->post('checkedArray'),
        );
        for($i=0;$i<count($data['checkedArray']);$i++) {
            $this->pages_model->remove_star($data['checkedArray'][$i]);

        }
    }
    public function send_sms(){
        $data = array(
            'start' => $this->input->post('start'),
            'smsText' => $this->input->post('smsText'),
            'viberText' => $this->input->post('viberText'),
            'selected' => $this->input->post('selected'),
            'site_aress' => $this->input->post('site_aress'),
            'button_name' => $this->input->post('button_name'),
            'img_adress' => $this->input->post('img_adress'),
        );
            $smsText = $data['smsText'];
            $viberText = $data['viberText'];
            $site_aress = $data['site_aress'];
            $button_name = $data['button_name'];
            $img_adress = $data['img_adress'];
            $smsText2 = str_replace("\n"," ",$smsText);
            $get_selected = $this->pages_model->get_selected($this->ion_auth->user()->row()->id);
            $username = 'Notify.ua';
            $password = 'U618y!e4';
            $a = base64_encode($username.':'.$password);
            for($i=0;$i<count($get_selected);$i++){
                echo $get_selected[$i]->phone;
                echo "<br/>";
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
                    $phone = "380506238527";
                    $ma = json_decode($response);
                    $aa = $ma->key;
                    $curl2 = curl_init();

                    if($data['selected']==1) {
                        curl_setopt_array($curl2, array(
                            CURLOPT_URL => "http://api.infobip.com/omni/1/advanced",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => "{ \"bulkId\":\"BULK-ID-123-xyz\", \"key\":\".$aa.\", \"destinations\":[ { \"messageId\":\"MESSAGE-ID-123-xyz\", \"to\":{ \"phoneNumber\":\"$phone\"} } ], \"viber\":{ \"text\":\"$viberText\" },\"sms\":{ \"text\":\"$smsText2\" }}",
                            CURLOPT_HTTPHEADER => array(
                                "accept: application/json",
                                "authorization: Basic " . $a . "==",
                                "content-type: application/json"
                            ),
                        ));
                    }
                    else{
                        curl_setopt_array($curl2, array(
                            CURLOPT_URL => "http://api.infobip.com/omni/1/advanced",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => "{ 
                                  \"destinations\":[ 
                                    { 
                                      \"to\":{
                                        \"phoneNumber\": \"$phone\"
                                      }
                                    }
                                  ],
                                 \"viber\": {
                                    \"text\": \"$viberText\",
                                    \"imageURL\": \"$img_adress\",
                                    \"buttonText\": \"$button_name\",
                                    \"buttonURL\": \"$site_aress\",
                                    \"isPromotional\": true,
                                    \"validityPeriod\":1
                                  },
                                  \"sms\": {
                                    \"text\": \"$smsText2\",
                                    \"validityPeriod\":1
  }
}",
                            CURLOPT_HTTPHEADER => array(
                                "accept: application/json",
                                "authorization: Basic " . $a . "==",
                                "content-type: application/json"
                            ),
                        ));
                    }

                    $response2 = curl_exec($curl2);
                    $err = curl_error($curl2);
                    curl_close($curl2);
                    if ($err) {
                        echo "<br/>";
                        echo "cURL Error #:" . $err;
                    } else {
                        echo $response2;

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
                            "authorization: Basic " . $a . "=="
                        ),
                    ));
                    $response = curl_exec($curl3);
                    $err = curl_error($curl3);
                    curl_close($curl3);
                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        $ress = json_decode($response);
                        $chanel = $ress->results[0]->channel;
                        $this->pages_model->minu_balance($this->ion_auth->user()->row()->id);

                    }
                }
            }


    }
    public function addtoarhive($phone,$date2,$ref2,$chanel){
        $this->pages_model->addtoarhive($phone,$date2,$this->ion_auth->user()->row()->id,$ref2,$chanel);
        $sms_getawey = $this->pages_model->get_getawey($this->ion_auth->user()->row()->id);
        if(!empty($sms_getawey->s_name)){
            echo "s_name available";
        }
        else{
            $this->pages_model->minu_balance($this->ion_auth->user()->row()->id);
        }
    }
    public function exel_upload(){
        $data = array(
            'imgVal' => $this->input->post('imgVal'),
        );

        $date['phones'] = array();
        $fh = fopen($_FILES['file']['tmp_name'], 'r+');
        $lines = array();
        while( ($row = fgetcsv($fh, 8192)) !== FALSE ) {
            $lines[] = $row;
        }
        $aa = $lines;
        for($i=0;$i<count($lines);$i++){
            array_push($date['phones'],$aa[$i][0]);
        }
        print_r($date['phones']);
        return $date['phones'];
    }
    public function example(){
        // load download helder
        $filename = 'example.csv';
        $this->load->helper('download');
        // read file contents
        $data = file_get_contents("http://localhost/ciblog/example.csv");
        force_download($filename, $data);
    }
    public function send_phone_area_section(){
        $data = array(
            'res' => $this->input->post('res'),
            'smsText' => $this->input->post('smsText'),
            'viberText' => $this->input->post('viberText'),
            'selected' => $this->input->post('selected'),
            'site_aress' => $this->input->post('site_aress'),
            'button_name' => $this->input->post('button_name'),
            'img_adress' => $this->input->post('img_adress'),
        );
        $smsText = $data['smsText'];
        $viberText = $data['viberText'];
        $site_aress = $data['site_aress'];
        $button_name = $data['button_name'];
        $img_adress = $data['img_adress'];
        $smsText2 = str_replace("\n"," ",$smsText);
        print_r($data['res']);
        $username = 'Notify.ua';
        $password = 'U618y!e4';
        $a = base64_encode($username.':'.$password);
        for($i=0;$i<count($data['res']);$i++){
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
                $phone = $data['res'][$i];
                $ma = json_decode($response);
                $aa = $ma->key;
                $curl2 = curl_init();
                if($data['selected']==1) {
                    curl_setopt_array($curl2, array(
                        CURLOPT_URL => "http://api.infobip.com/omni/1/advanced",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "{ \"bulkId\":\"BULK-ID-123-xyz\", \"key\":\".$aa.\", \"destinations\":[ { \"messageId\":\"MESSAGE-ID-123-xyz\", \"to\":{ \"phoneNumber\":\"$phone\"} } ], \"viber\":{ \"text\":\"$viberText\" },\"sms\":{ \"text\":\"$smsText2\" }}",
                        CURLOPT_HTTPHEADER => array(
                            "accept: application/json",
                            "authorization: Basic " . $a . "==",
                            "content-type: application/json"
                        ),
                    ));
                }
                else{
                    curl_setopt_array($curl2, array(
                        CURLOPT_URL => "http://api.infobip.com/omni/1/advanced",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "{ 
                                  \"destinations\":[ 
                                    { 
                                      \"to\":{
                                        \"phoneNumber\": \"$phone\"
                                      }
                                    }
                                  ],
                                 \"viber\": {
                                    \"text\": \"$viberText\",
                                    \"imageURL\": \"$img_adress\",
                                    \"buttonText\": \"$button_name\",
                                    \"buttonURL\": \"$site_aress\",
                                    \"isPromotional\": true,
                                    \"validityPeriod\":1
                                  },
                                  \"sms\": {
                                    \"text\": \"$smsText2\",
                                    \"validityPeriod\":1
  }
}",
                        CURLOPT_HTTPHEADER => array(
                            "accept: application/json",
                            "authorization: Basic " . $a . "==",
                            "content-type: application/json"
                        ),
                    ));
                }

                $response2 = curl_exec($curl2);
                $err = curl_error($curl2);
                curl_close($curl2);
                if ($err) {
                    echo "<br/>";
                    echo "cURL Error #:" . $err;
                } else {
                    echo $response2;

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
                        "authorization: Basic " . $a . "=="
                    ),
                ));
                $response = curl_exec($curl3);
                $err = curl_error($curl3);
                curl_close($curl3);
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $ress = json_decode($response);
                    $chanel = $ress->results[0]->channel;
                    $this->pages_model->addtoarhive($phone,'0','0','0',$chanel,'0','0');
                    $this->pages_model->minu_balance($this->ion_auth->user()->row()->id);

                }
            }
        }
    }
    public function send_sms_excel(){
        $data = array(
            'start' => $this->input->post('start'),
            'smsText' => $this->input->post('smsText'),
            'roa' => $this->input->post('roa'),
            'viberText' => $this->input->post('viberText'),
            'selected' => $this->input->post('selected'),
            'site_aress' => $this->input->post('site_aress'),
            'button_name' => $this->input->post('button_name'),
            'img_adress' => $this->input->post('img_adress'),
        );
        $smsText = $data['smsText'];
        $viberText = $data['viberText'];
        $site_aress = $data['site_aress'];
        $button_name = $data['button_name'];
        $img_adress = $data['img_adress'];
        $smsText2 = str_replace("\n"," ",$smsText);
        $text3 = str_replace("\n"," ",$data['smsText']);
        $username = 'Notify.ua';
        $password = 'U618y!e4';
        $a = base64_encode($username.':'.$password);
        for($i=0;$i<count($data['roa']);$i++){
            $pos = strpos($text3, $data['roa'][$i]['TTN']);
            echo "pos";
            echo $pos;
            if($pos>0)
            {
                $text4 = str_replace("{ttn}",$data['roa'][$i]['TTN'],$data['smsText']);
            }
            else{
                $text4 = $text3;
            }
            $data['roa'][$i]['Phone'];
            echo "<br/>";
            $data['roa'][$i]['TTN'];
            echo "<br/>";
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
                //$phone = "380506238527";
                $phone = $data['roa'][$i]['Phone'];
                $ma = json_decode($response);
                $aa = $ma->key;
                $curl2 = curl_init();
                if($data['selected']==1) {
                    curl_setopt_array($curl2, array(
                        CURLOPT_URL => "http://api.infobip.com/omni/1/advanced",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "{ \"bulkId\":\"BULK-ID-123-xyz\", \"key\":\".$aa.\", \"destinations\":[ { \"messageId\":\"MESSAGE-ID-123-xyz\", \"to\":{ \"phoneNumber\":\"$phone\"} } ], \"viber\":{ \"text\":\"$viberText\" },\"sms\":{ \"text\":\"$smsText\" }}",
                        CURLOPT_HTTPHEADER => array(
                            "accept: application/json",
                            "authorization: Basic " . $a . "==",
                            "content-type: application/json"
                        ),
                    ));
                }
                else{
                    curl_setopt_array($curl2, array(
                        CURLOPT_URL => "http://api.infobip.com/omni/1/advanced",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "{ 
                                  \"destinations\":[ 
                                    { 
                                      \"to\":{
                                        \"phoneNumber\": \"$phone\"
                                      }
                                    }
                                  ],
                                 \"viber\": {
                                    \"text\": \"$viberText\",
                                    \"imageURL\": \"$img_adress\",
                                    \"buttonText\": \"$button_name\",
                                    \"buttonURL\": \"$site_aress\",
                                    \"isPromotional\": true,
                                    \"validityPeriod\":1
                                  },
                                  \"sms\": {
                                    \"text\": \"$smsText2\",
                                    \"validityPeriod\":1
  }
}",
                        CURLOPT_HTTPHEADER => array(
                            "accept: application/json",
                            "authorization: Basic " . $a . "==",
                            "content-type: application/json"
                        ),
                    ));
                }

                $response2 = curl_exec($curl2);
                $err = curl_error($curl2);
                curl_close($curl2);
                if ($err) {
                    echo "<br/>";
                    echo "cURL Error #:" . $err;
                } else {
                    echo $response2;

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
                        "authorization: Basic " . $a . "=="
                    ),
                ));
                $response = curl_exec($curl3);
                $err = curl_error($curl3);
                curl_close($curl3);
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $ress = json_decode($response);
                    $chanel = $ress->results[0]->channel;
                    $this->pages_model->minu_balance($this->ion_auth->user()->row()->id);

                }
            }
        }
    }
    public function add_to_selected(){
        $data = array(
            'res' => $this->input->post('res'),
        );
        $uid = $this->ion_auth->user()->row()->id;
        for($i=0;$i<count($data['res']);$i++){
            $this->pages_model->add_to_selected($uid,$data['res'][$i]);
        }

    }


}
?>