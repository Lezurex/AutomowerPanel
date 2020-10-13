<?php

include "config.php";

session_start();

if (!isset($_SESSION['ACCESS_TOKEN'])) {
    header("Location: ../dashboard/401.php");
    exit();
}

$url = "https://api.authentication.husqvarnagroup.dev/v1/token/{$_SESSION['ACCESS_TOKEN']}";

$headers = array(
    "Authorization-Provider: husqvarna",
    "Authorization: Bearer {$_SESSION['ACCESS_TOKEN']}",
    "X-Api-Key:" . getAppKey(),
);

$json = null;

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

$response = curl_exec($curl);
$code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
curl_close($curl);

if ($code == 204) {
    session_destroy();
    header("Location: ../dashboard/204.php");
} else {
    http_response_code($code);
    echo $response;
}