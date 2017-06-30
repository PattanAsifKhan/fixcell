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

<div id="content-div" class="thumbnail center-block" style="margin-top: 5%">
    <div class="form-group">
        <label for="brand-list">Brand</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
            <select class="form-control" id="brand-list"> </select>
        </div>
        <br>
        <label for="brand-list">Model</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
            <select class="form-control" id="model-list"></select>
        </div>
    </div>
</div>

<script>
    $brandSelect2 = $("#brand-list");
    $modelSelect2 = $("#model-list");

    $.getJSON('getBrands.php', function (data) {
        $brandSelect2.select2({
            placeholder: "Select Brand",
            data: data
        });
        $brandSelect2.select2("val", "");
    });

    $modelSelect2.select2({
        placeholder: "Select a Brand"
    });

    $modelSelect2.prop("disabled", true);

    var brand = "";
    var model = "";
    $brandSelect2.on("select2:select", function (e) {
        brand = $(e.currentTarget).val();
        $modelSelect2.prop("disabled", true);
        $modelSelect2.select2({
            placeholder: "Loading..."
        });
        $modelSelect2.select2('val', '');
        $modelSelect2.empty();
        $.getJSON('getModels.php?brand=' + brand, function (data) {
            if (data.length > 0) {
                $modelSelect2.prop("disabled", false);
                $modelSelect2.select2({
                    placeholder: "Select Model",
                    data: data
                });
                $modelSelect2.select2('val', '');
            } else {
                $modelSelect2.select2({
                    placeholder: "No Model Available"
                });
            }
        });
    });

    $modelSelect2.on("select2:select", function (e) {
        model = $(e.currentTarget).val();
        window.open("/repair/repair.php?brand=" + brand + "&model=" + model, "_self");
    });
</script>


<!--footer-->
<div id="footer"></div>
<script>
    $(document).ready(function () {
        $("#footer").load("/footer.html");
        $("#brand-list").select2({
            placeholder: "Loading..."
        });
    });
</script>
</body>
</html>

<style>
    .select2-selection__arrow {
        display: none;
    }

    .select2-selection.select2-selection--single {
        padding: 5px;
        height: 40px;
    }

    .select2-container {
        width: 100% !important;
    }

    body {
        background-image: url('/images/back.jpg');
        background-size: cover;
        background-position: center center;
    }
</style>