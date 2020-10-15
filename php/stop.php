<?php

include "config.php";
require "SpamProtection.php";

session_start();

if (!isset($_SESSION['ACCESS_TOKEN'])) {
    echo "401";
    exit();
}

if (SpamProtection::isSpam($_SERVER['REMOTE_ADDR'])) {
    http_response_code(429);
    echo "Webserver Spam Protection";
    exit();
}

$url = "https://api.amc.husqvarna.dev/v1/mowers/{$_POST['mowerID']}/actions";

$headers = array(
    "Authorization-Provider: husqvarna",
    "Authorization: Bearer {$_SESSION['ACCESS_TOKEN']}",
    "X-Api-Key:" . getAppKey(),
    "Content-Type: application/vnd.api+json"
);

$json = json_encode(array("data" => array("type" => "Pause")));

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

$response = curl_exec($curl);
$code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
curl_close($curl);

if ($code == 202) {
    http_response_code(202);
} else {
    http_response_code($code);
    echo $response;
}