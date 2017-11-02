<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Index extends CI_Controller {
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
        $confirmation = $this->pages_model->get_api_keys_confirmation($this->ion_auth->user()->row()->id);
        //check if user first titme or not
        if(intval($confirmation[0]->confirmation)==1){
            header("Location:  ".$_SERVER['SERVER_NAME']."/create/orderlist/index");
        }else{
            $api_keys = $this->pages_model->check_api_keys($this->ion_auth->user()->row()->id);

            if(count($api_keys)==0){ $this->save_api_key(); }

            $key = $this->pages_model->get_keys($this->ion_auth->user()->row()->id);
            if($key!=NULL){
                $data['key'] = $key->user_key;
            }
            $data["balance"] = $this->pages_model->get_user_balance($this->ion_auth->user()->row()->id);
            $data["price"] = $this->pages_model->get_sms_price();
            $data["user_name"] = $this->pages_model->user_name($this->ion_auth->user()->row()->id);
            $data['site_url'] = $this->get_website();
            $data['view'] = 'create/index';
            $this->load->view('template/template_view', $data);
        }

    }
    public function get_website() {
        $site_url = $this->pages_model->get_website($this->ion_auth->user()->row()->id);
        return $site_url[0]->site_url;
    }
    public function bridge_request() {

        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, 'http://okiem.ch/notify_bridge.php');
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curlSession);
        $jsonData = json_decode(curl_exec($curlSession));
        curl_close($curlSession);
        print_r($jsonData);
    }

    public function check_bridge_request() {
        $user_key = $this->pages_model->get_website($this->ion_auth->user()->row()->id);
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, strval($user_key[0]->site_url).'/notify_bridge'.strval($this->ion_auth->user()->row()->id).'.php');
        curl_setopt($curlSession, CURLOPT_POST, 1);
        curl_setopt($curlSession, CURLOPT_POSTFIELDS, http_build_query(array('postvar1'=>strval($user_key[0]->user_key))));
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curlSession);
        $jsonData = json_decode(curl_exec($curlSession));
        curl_close($curlSession);
        if(intval(count($jsonData))>=0){
            echo "OK";
            $this->api_keys_confirmation();
        }
        //print_r($jsonData);
    }
    public function save_api_key() {
        //generate hesh for bridge
        $data = $this->pages_model->user_name($this->ion_auth->user()->row()->id);
        //for hash take 2 arguments
        $randNum = rand(5, 15);
        $random = intval($randNum)*intval($this->ion_auth->user()->row()->id)/100;
        $hasres = $data->username."".$data->email."".strval($random);
        //use ripemd160 coding
        $hash = hash('ripemd160',$hasres);

        //save new hash in DB
        $this->pages_model->save_hash($this->ion_auth->user()->row()->id,$hash);
    }
    public function download_file() {

        $platform = $_SESSION['platform'];
        $userId = $this->ion_auth->user()->row()->id;

        $url = '/home/fallen/notify.com.ua/www/application/controllers/create/'.strval($platform).'/';
        $file_url = $url."notify_bridge".strval($userId).".php";
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
        readfile($file_url); // do the double-download-dance (dirty but worky)
        unlink($file_url);

    }
    public function copy_file() {
        $data = array(
            'platform' => $this->input->post('platform')
        );


        $platform = $data['platform'];
        $_SESSION['platform']=$platform;
        $userId = $this->ion_auth->user()->row()->id;
        $url = '/home/fallen/notify.com.ua/www/application/controllers/create/'.strval($platform).'/notify_bridge.php';
        $newfile = '/home/fallen/notify.com.ua/www/application/controllers/create/'.strval($platform).'/notify_bridge'.strval($userId).'.php';
        copy($url, $newfile);
        $this->replace_key($platform,$userId);

    }
    public function save_url() {
        //save url for bridge
        $data = array('site_url' => $this->input->post('site_url'));
        $this->pages_model->save_url($this->ion_auth->user()->row()->id,$data['site_url']);


    }
    public function replace_key($platform,$userId) {
        $user_key = $this->pages_model->get_website($this->ion_auth->user()->row()->id);
        $file = '/home/fallen/notify.com.ua/www/application/controllers/create/'.strval($platform).'/notify_bridge'.strval($userId).'.php';
        $path_to_file = $file;
        $file_contents = file_get_contents($path_to_file);
        $file_contents = str_replace("key",strval($user_key[0]->user_key),$file_contents);
        $file_contents2 = htmlspecialchars_decode($file_contents);
        file_put_contents($path_to_file,$file_contents2);

    }
    public function api_keys_confirmation() {
        $this->pages_model->api_keys_confirmation($this->ion_auth->user()->row()->id,1);
    }

}
