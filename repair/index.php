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
error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);
ini_set("html_errors", 1);

$request = new HttpRequest();
$request->setUrl('https://www.rollbase.com/rest/api/selectQuery');
$request->setMethod(HTTP_METH_POST);

$request->setQueryData(array(
    'sessionId' => '751138c752d24350a9261dc9732a22a3@352484058',
    'query' => 'select distinct(brand), count(model) from phone group by brand',
    'maxRows' => '1000000',
    'output' => 'json'
));

$request->setHeaders(array(
    'postman-token' => 'fe2df17e-1d18-6dcb-e789-3d052920c8ee',
    'cache-control' => 'no-cache'
));

try {
    $response = $request->send();

    echo $response->getBody();
} catch (HttpException $ex) {
    echo $ex;
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
    var brands = ["Apple", "Samsung"];

    $("#loader").hide();
    $("#content-div").show();
    $("#brand-list").autocomplete({
            source: brands,
            minLength: 0
        }
    ).focus(function () {
        $(this).search($(this).val());
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