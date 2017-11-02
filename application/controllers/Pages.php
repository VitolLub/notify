<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pages extends CI_Controller{
    function __construct(){
        parent::__construct();

    }
    public function view(){
        redirect('/index', 'refresh');
    }
}
?>