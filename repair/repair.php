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
                <li class="active"><a href="/repair">Repair</a></li>
                <li><a href="/services">Service</a></li>
                <li class="dropdown">
                    <a>
                        <div class="dropbtn">Support</div>
                    </a>
                    <div class="dropdown-content">
                        <a href="/support/faq">FAQ</a>
                        <a href="/support/contacts">Contact us</a>
                        <a href="/support/feedback">Feedback</a>
                        <a href="/support/careers">Career</a>
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

    $conn = mysqli_connect("localhost", "root", "avi", "fixcell");

    $query = "SELECT type,price FROM services WHERE phone='$brand $model'";

    $result = mysqli_query($conn, $query);

    $arr = array();

    while ($r = $result->fetch_array()) {
        $arr[] = $r;
    }

    mysqli_close($conn);

    echo "<script>";
    echo "var services=" . json_encode($arr) . ";";
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
            price += parseFloat(services[selected_services[i]][1]);
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
            cart.push(["" + services[selected_services[i]][0], services[selected_services[i]][1]]);
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