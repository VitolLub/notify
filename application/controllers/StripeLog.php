<?php

use \Stripe\Stripe;
use  \Stripe\Charge;
use \Stripe\Customer;

class StripeLog extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $this->load->view('stripelog');
    }
    public function checkout(){

        $token = $_POST['stripeToken'];
        try{
            require_once('vendor/autoload.php');
            Stripe::setApiKey('sk_test_LPne2KVy9oJvvIyiiwf9YcFR');
            $charge = Charge::create(
                array(
                    "amount" => 1000, // Amount in cents
                    "currency" => "cad",
                    "source" => $token,
                    "description" => "Example charge"
                )
            );
            echo "Thanks! Payment was good";

        }
        catch (\Stripe\Error\Card $e){
            $error = $e->getMessage();
            echo $error;
        }

    }
}