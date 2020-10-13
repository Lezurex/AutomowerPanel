<?php

include "config.php";

session_start();

if (!isset($_SESSION['ACCESS_TOKEN'])) {
    echo "401";
    exit();
}

$url = "https://api.amc.husqvarna.dev/v1/mowers/{$_POST['mowerID']}/actions";

$headers = array(
    "Authorization-Provider: husqvarna",
    "Authorization: Bearer {$_SESSION['ACCESS_TOKEN']}",
    "X-Api-Key:" . getAppKey(),
    "Content-Type: application/vnd.api+json"
);

$json = null;

if ($_POST['type'] == "plan") {
    $json = json_encode(array("data" => array("type" => "ParkUntilNextSchedule")));
} else if ($_POST['type'] == "time") {
    $json = json_encode(array("data" => array("type" => "Park", "attributes" => array("duration" => $_POST['duration']))));
} else if ($_POST['type'] == "ufn") {
    $json = json_encode(array("data" => array("type" => "ParkUntilFurtherNotice")));
} else {
    http_response_code(400);
    exit();
}

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