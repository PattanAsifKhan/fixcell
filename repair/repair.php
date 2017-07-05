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

<div class="navbar navbar-default"
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
                <img src="/images/fixcell.png" alt="fixcell"
                     style="display: inline;"/><span><strong>ixcell</strong></span>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav nav-pills nav-justified navbar-right nav-over-video" style="margin-top: 10px;">
                <li><a href="/">Home</a></li>
                <li class="active"><a href="/repair/">Repair</a></li>
                <li><a href="/services">Service</a></li>
                <li class="dropdown">
                    <a>
                        <div class="dropbtn">Support</div>
                    </a>
                    <div class="dropdown-content">
                        <a href="/support/faq/">FAQ</a>
                        <a href="/support/contacts/">Contact us</a>
                        <a href="/support/feedback/">Feedback</a>
                        <a href="/support/careers/">Career</a>
                    </div>
                </li>
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

    setcookie("cart", '', time() - 1000);
    setcookie("cart", '', time() - 1000, '/');

    start:
    if (!file_exists('sessionid')) {
        include "login.php";
        goto start;
    }
    $sessionKey = file_get_contents("sessionid");
    $sessionKey = str_replace("@", "%40", $sessionKey);

    $url1 = "https://www.rollbase.com/rest/api/selectQuery?" .
        "sessionId=" . $sessionKey .
        "&query=select%20id%20from%20phone%20where%20name%3D'" .
        $brand . " " . $model .
        "'" .
        "&maxRows=1000000" .
        "&output=json";

    $url1 = str_replace(" ", "%20", $url1);
//    echo $url1;

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
            "cache-control: no-cache",
            "postman-token: 2dfe9adb-4d5c-ddc0-c2b2-4be226a9e852"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

//    echo $response;

    curl_close($curl);

    if ($httpcode == 403 or $httpcode != 200) {
        include 'login.php';
        goto start;
    }
//    echo $response;
    $response = preg_replace("/[\[\] ]+/", '', $response);
//    echo $response;


    $url = "https://www.rollbase.com/rest/api/getRelationships?" .
        "sessionId=" . $sessionKey .
        "&objName=Phone&id=" . $response .
        "&relName=R353377550&output=json";
//    echo $url;

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

    curl_close($curl);
    $response = str_replace("[", "(", $response);
    $response = str_replace("]", ")", $response);


    $response = urlencode($response);
    $url = "https://www.rollbase.com/rest/api/selectQuery?" .
        "sessionId=" . $sessionKey .
        "&query=" .
        "select%20type_%2Cprice%20from%20service%20where%20id%20in%20" .
        $response .
        "&maxRows=1000000&output=json";

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "postman-token: 9e7b25f9-7a1e-784e-d492-daaecbe1f83c"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    if ($httpcode == 403) {
        include 'login.php';
        goto start;
    }

    echo "<script>";
    echo "var services=" . $response . ";";
    echo "</script>";

} else {
    header("location: /repair/");
}
?>
<div class="container">
    <div class="page-header" style="border: none;">
        <h1 style="display: inline;">
            <?php
            echo $brand;
            setcookie("brand", $brand);
            ?>
        </h1>
        <h2 style="display: inline;">
            <?php
            echo $model;
            setcookie("model", $model);
            ?>
        </h2>
        <div style="float: right;">
            <a href="checkout.php" onclick="checkout()">
                <div style="float: right; display: block;" class="btn btn-primary"><span
                            class="glyphicon glyphicon-shopping-cart"></span>
                    Checkout
                </div>
            </a>
            <div>Current&nbsp;Cart&nbsp;Value:&nbsp;₹&nbsp;<span id="cart-price"></span>
            </div>
        </div>
    </div>
    <div id="services-div" class="row">
    </div>
</div>

<!--footer-->
<div id="footer"></div>
<script>
    $(document).ready(function () {
        $("#footer").load("/footer.html");
    });

    var selected_services = [];


    function updatePrice() {
        var price = 0;
        for (var i = 0; i < selected_services.length; i++) {
            price += services[selected_services[i]][1];
        }
        $("#cart-price").html(price.toFixed(2));
    }
    updatePrice();

    $container = $("#services-div");
    $.each(services, function (i) {
        var col = $("<div/>")
            .addClass("col-md-4 col-sm-6")
            .appendTo($container);
        var panel = $("<div/>")
            .addClass("panel")
            .addClass("panel-default")
            .attr('id', 'service-' + i)
            .appendTo(col);
        var panel_body = $("<div/>")
            .addClass("panel-body")
            .appendTo(panel);
        var service_name = $("<h4/>")
            .addClass("text-primary")
            .html(services[i][0])
            .appendTo(panel_body);
        var service_price = $("<h5/>")
            .addClass("text-primary")
            .addClass("badge")
            .html("₹ " + services[i][1] + "/-")
            .appendTo(panel_body);

    });

    $(".panel").on("click", function () {
        $(this).toggleClass("panel-default").toggleClass("panel-primary");
        $val = $(this).attr('id');
        console.log($val);
        $val = $val.split("-")[1];
        if ($.inArray($val, selected_services) >= 0) {
            var i = selected_services.indexOf($val);
            selected_services.splice(i, 1);
        } else {
            selected_services.push($val);
        }
        updatePrice();
    });

    function checkout() {
        var cart = [];
        for (var i = 0; i < selected_services.length; i++) {
            cart.push(services[selected_services[i]]);
        }
        document.cookie = "cart=" + cart;
    }
</script>
</body>
</html>

<style>
    .panel {
        cursor: pointer;
        margin: 10px;
    }
</style>