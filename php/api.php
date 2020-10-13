<?php

function listMowers($getFirstID = false) {

    $url = "https://api.amc.husqvarna.dev/v1/mowers";

    $headers = array(
        "Authorization-Provider: husqvarna",
        "Authorization: Bearer {$_SESSION['ACCESS_TOKEN']}",
        "X-Api-Key:" . getAppKey()
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

    $response = curl_exec($curl);
    $code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    curl_close($curl);

    $json = json_decode($response, true);
    $return = "";

    if (!$getFirstID) {
        foreach ($json['data'] as $mower) {
            $return .= "<option value='{$mower['id']}'>{$mower['attributes']['system']['name']}</option>";
        }
    } else {
        $return = $json['data'][0]['id'];
    }

    return $return;
}