<?php
require_once("vendor2/autoload.php");
use Viber\Client;
$apiKey = '456e34ab9b31d960-2505831776551566-449fd14e29f117ce'; // <- PLACE-YOU-API-KEY-HERE
$webhookUrl = 'https://viber.hcbogdan.com/bot.php'; // <- PLACE-YOU-HTTPS-URL
try {
    $client = new Client([ 'token' => $apiKey ]);
    $result = $client->setWebhook($webhookUrl);
    echo "Success!\n";
} catch (Exception $e) {
    echo "Error: ". $e->getError() ."\n";
}