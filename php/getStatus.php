<?php

include "config.php";

session_start();

if (!isset($_SESSION['ACCESS_TOKEN'])) {
    echo "401";
    exit();
}

$url = "https://api.amc.husqvarna.dev/v1/mowers/{$_POST['mowerID']}";

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

if ($code == 200) {

    $json = json_decode($response, true);
    $activity = $json['data']['attributes']['mower']['activity'];
    $state = $json['data']['attributes']['mower']['state'];
    $battery = $json['data']['attributes']['battery']['batteryPercent'];
    $battery_icon = "battery-empty";

    $activity_string = getActivityStrings()[$activity];
    $state_string = getStateStrings()[$state];
    $color = "bg-danger";
    $nextStart = "";

    switch ($activity) {
        case "UNKNOWN":
        case "NOT_APPLICABLE":
            $color = "bg-secondary";
            break;
        case "MOWING":
            $color = "bg-success";
            break;
        case "CHARGING":
        case "PARKED_IN_CS":
            if ($json['data']['attributes']['planner']['nextStartTimestamp'] != 0) {
                $unix = ($json['data']['attributes']['planner']['nextStartTimestamp'] / 1000) - 7200;
                $date = date("j.m.Y \u\m H:i", $unix);
                $weekday = getWeekdayStrings()[date("N", $unix)];
                $nextStart = "<br>Nächster Start: $weekday, $date";
            } else {
                if ($json['data']['attributes']['planner']['override']['action'] == "NO_SOURCE") {
                    $nextStart = "<br>Wartet bis auf Weiteres";
                }
            }
        case "LEAVING":
        case "GOING_HOME":
            $color = "bg-primary";
            break;
        case "STOPPED_IN_GARDEN":
            $color = "bg-danger";
            break;
    }

    if ($battery < 95) {
        if ($battery < 70) {
            if ($battery < 45) {
                if ($battery < 20) {
                    $battery_icon = "battery-empty";
                } else {
                    $battery_icon = "battery-quarter";
                }
            } else {
                $battery_icon = "battery-half";
            }
        } else {
            $battery_icon = "battery-three-quarters";
        }
    } else {
        $battery_icon = "battery-full";
    }

    echo '<div class="card ' . $color . ' text-white mb-4">
                                    <div class="card-body"><button id="status-refresh" class="btn btn-success"><i class="fas fa-sync-alt"></i></button>
                                    Aktivität: ' . $activity_string . '<br>
                                    Status: ' . $state_string . '
                                    ' . $nextStart . '<br>
                                    <div class="float-right"><i class="fas fa-' . $battery_icon . '"></i> ' . $battery . '%</div></div>
                                </div>';

} else {
    http_response_code($code);
    echo $response;
    exit();
}