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

<div class="container">
    <div class="page-header">
        <h1 class="text-primary">Checkout</h1>
    </div>
</div>
<div class="container">
    <div id="checkout-div">
        <div class="row">
            <div class="col-md-8">
                <form id="checkout-form" action="success.php">
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label for="first-name">First Name: <span style="color: red;">*</span></label>
                            <input class="form-control" id="first-name" required type="text" placeholder="First Name">
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="last-name">Last Name: <span style="color: red;">*</span></label>
                            <input class="form-control" id="last-name" required type="text" placeholder="Last Name">
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="first-name">Email: <span style="color: red;">*</span></label>
                            <input class="form-control" id="first-name" required type="email" placeholder="Email">
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="last-name">Phone: <span style="color: red;">*</span></label>
                            <input class="form-control" id="last-name" required type="text" pattern="/[0-9]{10}/"
                                   placeholder="Phone">
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="last-name">Nearest Landmark: </label>
                            <input class="form-control" id="landmark" type="text"
                                   placeholder="Landmark">
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="last-name">Address: <span style="color: red;">*</span></label>
                            <textarea class="form-control" id="address" required type="text"
                                      placeholder="Address"></textarea>
                        </div>
                        <div class="form-group col-xs-6">
                            <span style="color: red;">*</span> Fields are mandatory
                        </div>
                        <div class="form-group col-xs-6">
                            <input type="submit" value="Submit" style="float: right;" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
            <div id="cart" class="col-md-4">
                <h3 id="phone" class="text-primary"></h3>
            </div>
        </div>
    </div>
</div>

<!--footer-->
<div id="footer"></div>
<script>
    $("#checkout-form")[0].reset();
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    $(document).ready(function () {
        $("#footer").load("/footer.html");
    });

    $temp = getCookie('cart').split(",");
    $brand = getCookie('brand');
    $model = getCookie('model');
    $brand = $brand.replace("+", " ");
    $model = $model.replace("+", " ");
    $("#phone").html("Your Order: " + $brand + " " + $model);
    var cart = [];
    for (var i = 0; i < $temp.length; i += 2) {
        cart.push([$temp[i], $temp[i + 1]]);
    }
    var total = 0;

    var cart_table = $("<table/>")
        .addClass("table")
        .addClass("table-hover")
        .appendTo($("#cart"));
    var head = $("<thead/>")
        .appendTo(cart_table);
    var row = $("<tr/>")
        .appendTo(head);
    $("<th/>").html("Service")
        .appendTo(row);
    $("<th/>").html("Cost")
        .addClass("text-right")
        .appendTo(row);
    var body = $("<tbody/>")
        .appendTo(cart_table);
    $.each(cart, function (i) {
        var row = $("<tr/>")
            .appendTo(body);
        $("<td/>").html(cart[i][0])
            .appendTo(row);
        $("<td/>").html("₹ " + parseFloat(cart[i][1]).toFixed(2))
            .addClass("text-right")
            .appendTo(row);
        total += parseFloat(cart[i][1]);
    });
    var foot = $("<tfoot/>")
        .appendTo(cart_table);
    var row = $("<tr/>")
        .appendTo(foot);
    $("<th/>").html("Total")
        .appendTo(row);
    $("<th/>").html("₹ " + total.toFixed(2))
        .addClass("text-right")
        .appendTo(row);
</script>
</body>
</html>