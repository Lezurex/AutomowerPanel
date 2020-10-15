<?php

include "php/config.php";
header("Access-Control-Allow-Origin: *");

session_start();

if (isset($_GET['code'])) {
    $_SESSION['AUTH_CODE'] = $_GET['code'];
    $_SESSION['STATE'] = $_GET['state'];
    $_SESSION['authorized'] = true;
    echo "Loginvorgang...";

    $url = "https://api.authentication.husqvarnagroup.dev/v1/oauth2/token";
    $params = array(
        "grant_type" => "authorization_code",
        "client_id" => getAppKey(),
        "client_secret" => getAppSecret(),
        "code" => $_SESSION['AUTH_CODE'],
        "redirect_uri" => "https://automower.test/",
        "state" => $_SESSION["STATE"]
    );

    $headers = array(
            "content-type: application/x-www-form-urlencoded"
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

    $response = curl_exec($curl);
    $code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    curl_close($curl);

    if ($code == 200) {
        $response = json_decode($response, true);

        $_SESSION['ACCESS_TOKEN'] = $response['access_token'];
        $_SESSION['REFRESH_TOKEN'] = $response['refresh_token'];

        echo $_SESSION['ACCESS_TOKEN'];

        header("Location: /dashboard");
    } else {
        echo "<br>Es ist ein Fehler aufgetreten: " . $code . "<br>Response:<br><pre><code>" . $response . "</code></pre>";
    }
}

if (!$_SESSION['authorized']) {
    header("Location: https://api.authentication.husqvarnagroup.dev/v1/oauth2/authorize?client_id=" . getAppKey() . "&redirect_uri=https://automower.test/");
} else {
    header("Location: /dashboard");
}

?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Automower | Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head>
<body>



</body>
</html>
