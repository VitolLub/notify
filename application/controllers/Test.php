<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'NovaPoshtaApi2.php';
include_once 'simple_html_dom.php';
include_once('Googl.class.php');
class Test extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('pagination');

    }
    public function index()
    {
        $arr = ['https://allegro.pl/kategoria/naczepy-wywrotki-18537?price_to=70000&order=m', 'https://www.otomoto.pl/przyczepy/maczepy_wywrotki/?search%5Bfilter_float_price%3Ato%5D=70000&search%5Bcountry%5D=', 'https://www.olx.pl/motoryzacja/dostawcze-ciezarowe/naczepy/q-wywrotka/?search%5Bfilter_float_price%3Ato%5D=70000'];
        $urlTypeAtt = ['allegro.pl','otomoto.pl','olx.pl'];
        for($i=0;$i<count($arr);$i++){
            $url = $arr[$i];
            if($i==0){
                $html = file_get_html($url);
                $bb = $html->find('div[class="layout__right"]',0)->innertext;
                $html2 = str_get_html($bb);
                foreach($html2->find('h2') as $element) { //выборка всех тегов img на странице
                    $html3 = str_get_html( $element->innertext ); // построчный вывод содержания всех найденных атрибутов src
                    foreach($html3->find('a') as $elsem){
                        $uu = $elsem->href."<br>";
                        $uu2 = strlen(trim($uu));
                        $pos = strpos($uu, ".html");
                        if ($pos >0){
                            $uu3 = substr($uu, 0, $pos+5);
                            if($uu2>10){
                                $this->addtofile($uu3);
                            }
                        }
                    }
                }
            }
            if ($i==1){
                $html = file_get_html($url);
                $bb = $html->find('div[class="om-list-container"]',0)->innertext;
                $html2 = str_get_html($bb);
                foreach($html2->find('h2') as $element) { //выборка всех тегов img на странице
                    $html3 = str_get_html( $element->innertext ); // построчный вывод содержания всех найденных атрибутов src
                    foreach($html3->find('a') as $elsem){
                        $uu = $elsem->href;
                        $uu2 = strlen(trim($uu));
                        $pos = strpos($uu, ".html");
                        if ($pos >0){
                            $uu3 = substr($uu, 0, $pos+5);
                            if($uu2>10){
                                $this->addtofile($uu3);
                            }
                        }
                    }
                }
            }
            if($i==2){
                $html = file_get_html($url);
                //base url
                $base = $url;

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_URL, $base);
                curl_setopt($curl, CURLOPT_REFERER, $base);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                $str = curl_exec($curl);
                curl_close($curl);

                // Create a DOM object
                $html_base = new simple_html_dom();
                // Load HTML from a string
                $aa = $html_base->load($str);
                foreach($aa->find('h3') as $element) { //выборка всех тегов img на странице
                    $html3 = str_get_html( $element->innertext ); // построчный вывод содержания всех найденных атрибутов src
                    foreach($html3->find('a') as $elsem){
                        $uu = $elsem->href;
                        $uu2 = strlen(trim($uu));
                        $pos = strpos($uu, ".html");
                        if ($pos >0){
                            $uu3 = substr($uu, 0, $pos+5);
                            if($uu2>10){
                                $this->addtofile($uu3);
                            }
                        }
                    }
                }

                $html_base->clear();
                unset($html_base);
            }
        }
        echo file_get_contents("people.txt");


    }
    public function addtofile($uu) {
        $searchfor = trim($uu);
        //echo $searchfor."\n";
        $uu2 = $this->clean($uu);
        $a = $this->pages_model->get_savetodbb(''.$uu2.'');
        print_r(count($a));

        if(count($a)==0){
                $this->savetodbb($uu2);

                $googl = new Googl('AIzaSyBaxn_gk-hrKevNfXvUxm6pKReSWeV_ifI');
                $urlg = $googl->shorten($searchfor);
                if(strlen($urlg)>5){
                    $get_user_balance = $this->pages_model->get_user_balance(27);
                    if(intval($get_user_balance->user_balance)>0){
                        $this->sendSms($urlg);
                        $this->pages_model->minu_balance(27);
                    }
                }
                unset($googl);
        }


    }
    public function savetodbb($uu) {
        $uu2 = $this->clean($uu);
        $this->pages_model->savetodbb($uu2);
    }
    public function remove_http($url) {
        $disallowed = array('http://', 'https://');
        foreach($disallowed as $d) {
            if(strpos($url, $d) === 0) {
                return str_replace($d, '', $url);
            }
        }
        return $url;
    }
    public function clean($string) {
        $string = str_replace('-', '', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
    public function sendSms($urlg){
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
            $phone = "380964353465";
            $ma = json_decode($response);
            $aa = $ma->key;
            $viberText = $urlg;
            $smsText = $urlg;
            $curl2 = curl_init();
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


            $response2 = curl_exec($curl2);
            $err = curl_error($curl2);
            curl_close($curl2);
            if ($err) {
                echo "<br/>";
                echo "cURL Error #:" . $err;
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
            }
        }
    }
}
