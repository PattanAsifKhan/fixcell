<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fixcell</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/bootstrap.min.css"
          rel="stylesheet"><!-- Optional theme -->
    <link href="/css/bootstrap-theme.min.css"
          rel="stylesheet"><!-- Latest compiled and minified JavaScript -->
    <link href="/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">
    <script src="/jquery-3.1.1.js"></script>
    <script src="/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <link href="/style.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
</head>
<body>

<div class="navbar navbar-inverse"
     style="-webkit-border-radius: 0;-moz-border-radius: 0;border-radius: 0; margin-bottom: 0px;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar"
                    style="vertical-align: middle; margin-top: 15px">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/" style="height: auto;">
                <img src="/images/fixcell.png" alt="fixcell" style="display: inherit;"/>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav nav-pills nav-justified navbar-right" style="margin-top: 10px;">
                <li><a href="/">Home</a></li>
                <li class="active"><a href="/repair/">Repair</a></li>
                <li><a href="/services">Service</a></li>
                <li><a href="/faq/">FAQ</a></li>
            </ul>
        </div>
    </div>
</div>

<?php


error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);
ini_set("html_errors", 1);

if (isset($_GET['brand']) and isset($_GET['model'])) {
    $brand = $_GET['brand'];
    $model = $_GET['model'];
    echo $brand . " " . $model;

    start:
    if (!file_exists('sessionid')) {
        include "login.php";
        goto start;
    }
    $sessionKey = file_get_contents("sessionid");
    $id = 0;

    $url1 = "https://www.rollbase.com/rest/api/selectQuery?" .
        "sessionId=" . $sessionKey .
        "&query=select%20id%20from%20phone%20where%20name%3D'" . $brand . "%20" . $model .
        "'&maxRows=1000000&output=json";

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    if ($httpcode == 403 or $httpcode != 200) {
        include 'login.php';
        goto start;
    }
    echo $brand.$model.$response;

/*
    $url = "https://www.rollbase.com/rest/api/getRelationships?" .
        "sessionId=" . $sessionKey .
        "&objName=Phone&id=" . $id .
        "&relName=R353377550";

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "postman-token: 097e4f50-9b61-5e24-7ff9-690ea91731eb"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);*/
} else {
    header("location: /repair/");
}
?>


<!--footer-->
<div id="footer"></div>
<script>
    $(document).ready(function () {
        $("#footer").load("/footer.html");
    });
</script>
</body>
</html>