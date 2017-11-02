<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'NovaPoshtaApi2.php';
class Notify_Admin extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');

    }
    public function index()
    {

    }

}
