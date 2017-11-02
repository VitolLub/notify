<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Payment extends CI_Controller{
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
        $sms_price = $this->pages_model->get_sms_price();
        print_r($sms_price);
        $data['view'] = 'payment';
        $this->load->view('template/template_view', $data);
    }
    public function buy_coffee_form(){
         $post  = array(
             'pay' => $this->input->post('pay'),
         );

        $order_id = 'coffee_'.rand(10000, 99999);
        require("LiqPay.php");

        $liqpay = new LiqPay("i66714015989", "GLIjhC6Ot98kMONd80zKOlp3MAxXQAFX1rM2gQyY");
        $data['form'] = $liqpay->cnb_form(array(
            'version'        => '3',
            'amount'         => $post['pay'],
            'currency'       => 'UAH',
            'description'    => 'notify.com.ua',
            'order_id'       => $order_id,
            'language'      => 'ru',
            'type'          => 'donate',
            'result_url'    => base_url().'home/success'
        ));
        echo json_encode($data['form']);


    }
    public function success_coffee(){
        $private_key = "GLIjhC6Ot98kMONd80zKOlp3MAxXQAFX1rM2gQyY";
        $data = "eyJhY3Rpb24iOiJwYXkiLCJwYXltZW50X2lkIjozMjg3NTU5NTgsInN0YXR1cyI6ImZhaWx1cmUiLCJlcnJfY29kZSI6ImxpbWl0IiwiZXJyX2Rlc2NyaXB0aW9uIjoi0J/RgNC10LLRi9GI0LXQvSDQu9C40LzQuNGCIiwidmVyc2lvbiI6MywidHlwZSI6ImRvbmF0ZSIsInBheXR5cGUiOiJjYXJkIiwicHVibGljX2tleSI6Imk2NjcxNDAxNTk4OSIsImFjcV9pZCI6NDE0OTYzLCJvcmRlcl9pZCI6ImNvZmZlXzk1NzA5IiwibGlxcGF5X29yZGVyX2lkIjoiMFExS0UyNEsxNDg0NzQ5MTgwNzkxMDE3IiwiZGVzY3JpcHRpb24iOiJub3RpZnkuY29tLnVhIiwic2VuZGVyX2NhcmRfbWFzazIiOiI1MTY4NzUqNTgiLCJzZW5kZXJfY2FyZF9iYW5rIjoicGIiLCJzZW5kZXJfY2FyZF90eXBlIjoibWMiLCJzZW5kZXJfY2FyZF9jb3VudHJ5Ijo4MDQsImlwIjoiMTkzLjE2OS44MS4zMSIsImFtb3VudCI6MS4wLCJjdXJyZW5jeSI6IlVBSCIsInNlbmRlcl9jb21taXNzaW9uIjowLjAsInJlY2VpdmVyX2NvbW1pc3Npb24iOjAuMDMsImFnZW50X2NvbW1pc3Npb24iOjAuMCwiYW1vdW50X2RlYml0IjoxLjAsImFtb3VudF9jcmVkaXQiOjEuMCwiY29tbWlzc2lvbl9kZWJpdCI6MC4wLCJjb21taXNzaW9uX2NyZWRpdCI6MC4wMywiY3VycmVuY3lfZGViaXQiOiJVQUgiLCJjdXJyZW5jeV9jcmVkaXQiOiJVQUgiLCJzZW5kZXJfYm9udXMiOjAuMCwiYW1vdW50X2JvbnVzIjowLjAsIm1waV9lY2kiOiI3IiwiaXNfM2RzIjpmYWxzZSwiY3JlYXRlX2RhdGUiOjE0ODQ3NDkxNjU5NzQsImVuZF9kYXRlIjoxNDg0NzQ5MTkwOTUyLCJ0cmFuc2FjdGlvbl9pZCI6MzI4NzU1OTU4LCJjb2RlIjoibGltaXQifQ== ";
        $signature = "rcB8XAUHVLcYU42DaotFCsRgB6M= ) rKrAYNSNRF9NgZDq/6gmsBQjVeE=rKrAYNSNRF9NgZDq/6gmsBQjVeE=";

        $signature = base64_encode(sha1($private_key."eyJhY3Rpb24iOiJwYXkiLCJwYXltZW50X2lkIjozMjg3NTU5NTgsInN0YXR1cyI6ImZhaWx1cmUiLCJlcnJfY29kZSI6ImxpbWl0IiwiZXJyX2Rlc2NyaXB0aW9uIjoi0J/RgNC10LLRi9GI0LXQvSDQu9C40LzQuNGCIiwidmVyc2lvbiI6MywidHlwZSI6ImRvbmF0ZSIsInBheXR5cGUiOiJjYXJkIiwicHVibGljX2tleSI6Imk2NjcxNDAxNTk4OSIsImFjcV9pZCI6NDE0OTYzLCJvcmRlcl9pZCI6ImNvZmZlXzk1NzA5IiwibGlxcGF5X29yZGVyX2lkIjoiMFExS0UyNEsxNDg0NzQ5MTgwNzkxMDE3IiwiZGVzY3JpcHRpb24iOiJub3RpZnkuY29tLnVhIiwic2VuZGVyX2NhcmRfbWFzazIiOiI1MTY4NzUqNTgiLCJzZW5kZXJfY2FyZF9iYW5rIjoicGIiLCJzZW5kZXJfY2FyZF90eXBlIjoibWMiLCJzZW5kZXJfY2FyZF9jb3VudHJ5Ijo4MDQsImlwIjoiMTkzLjE2OS44MS4zMSIsImFtb3VudCI6MS4wLCJjdXJyZW5jeSI6IlVBSCIsInNlbmRlcl9jb21taXNzaW9uIjowLjAsInJlY2VpdmVyX2NvbW1pc3Npb24iOjAuMDMsImFnZW50X2NvbW1pc3Npb24iOjAuMCwiYW1vdW50X2RlYml0IjoxLjAsImFtb3VudF9jcmVkaXQiOjEuMCwiY29tbWlzc2lvbl9kZWJpdCI6MC4wLCJjb21taXNzaW9uX2NyZWRpdCI6MC4wMywiY3VycmVuY3lfZGViaXQiOiJVQUgiLCJjdXJyZW5jeV9jcmVkaXQiOiJVQUgiLCJzZW5kZXJfYm9udXMiOjAuMCwiYW1vdW50X2JvbnVzIjowLjAsIm1waV9lY2kiOiI3IiwiaXNfM2RzIjpmYWxzZSwiY3JlYXRlX2RhdGUiOjE0ODQ3NDkxNjU5NzQsImVuZF9kYXRlIjoxNDg0NzQ5MTkwOTUyLCJ0cmFuc2FjdGlvbl9pZCI6MzI4NzU1OTU4LCJjb2RlIjoibGltaXQifQ==".$private_key,1));
        print_r($signature);
    }
    public function success2(){

        //echo $json2->status;
        print_r($this->ion_auth->user()->row()->id);

        $amount = 3;
        $date = date('Y-m-d');
        $sms_price = $this->pages_model->get_sms_price();
        $credit = $amount / $sms_price->price;
        $credit2 = number_format((float)$credit, 1, '.', '');
        $credit3 = round($credit2);
        $this->pages_model->payment($this->ion_auth->user()->row()->id, $date, $amount);
        $this->pages_model->update_balance($this->ion_auth->user()->row()->id, $credit);
        #redirect('/home/index', 'refresh');
    }
}
?>