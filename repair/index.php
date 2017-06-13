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
</head>
<body>

<?php
//phpinfo();
error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);
ini_set("html_errors", 1);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.rollbase.com/rest/api/selectQuery?sessionId=751138c752d24350a9261dc9732a22a3%40352484058&query=select%20distinct(brand)%20from%20phone&maxRows=1000000&output=json",
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

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    //echo $response;
    echo '<script>var brands = ' . $response . ';</script>';
}
?>

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

<div>
    <div id="loader"></div>
</div>

<div id="content-div" class="thumbnail center-block" hidden style="margin-top: 5%">
    <div class="form-group">
        <label for="brand-list">Brand</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
            <input class="form-control" id="brand-list" placeholder="Select Brand (Start Typing name of brand)">
        </div>
        <br>
        <label for="brand-list">Model</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
            <input class="form-control" id="model-list"
                   placeholder="Select Model (Start Typing first few letters model)">
        </div>
    </div>
</div>

<script>
    $("#model-list").val("");
    $("#brand-list").val("");

    var models = [];

    for (var i = 0; i < brands.length; i++) {
        brands.push(brands[0][0]);
        brands.splice(0, 1);
    }

    $("#loader").hide();
    $("#content-div").show();
    $("#brand-list").autocomplete({
            source: brands,
            minLength: 0
        }
    );

    $("#model-list").autocomplete({
            source: models,
            minLength: 0
        }
    );

    if (models.length === 0) {
        $("#model-list").prop("disabled",true);
    }

    $("#brand-list").bind('input change keyup click', function () {
        var b = $(this).val()
        $("#model-list").prop("disabled",true);
        if (brands.indexOf(b) !== -1) {
            $.getJSON('getModels.php?brand=' + b, function (data) {
                models.splice(0);
                for (var i = 0; i < data.length; i++) {
                    models.push(data[i][0]);
                }
                if (models.length > 0)
                    $("#model-list").prop("disabled",false);
            })
        }
    });
</script>


<!--footer-->
<div id="footer"></div>
<script>
    $(document).ready(function () {
        $("#footer").load("/footer.html");
    });
</script>
</body>
</html>