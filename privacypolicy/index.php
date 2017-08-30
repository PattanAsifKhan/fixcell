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
    <script src="/jquery-3.1.1.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <link href="/style.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
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
                     style="display: inline;"/><span></span>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav nav-justified navbar-right nav-over-video" style="margin-top: 10px;">
                <li></li>
                <li><a href="/repair/"><strong>Repair</strong></a></li>
                <li><a href="/services"><strong>Service</strong></a></li>
                <li class="dropdown">
                    <a href="/support/about/">
                        <div class="dropbtn"><strong>Support</strong></div>
                    </a>
                    <div class="dropdown-content">
                        <a href="/support/faq">FAQ</a>
                        <a href="/support/contacts/index.html">Contact us</a>
                        <a href="/support/feedback/">Feedback</a>
                        <a href="/support/careers/">Career</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container" style="margin-top: 20px">
<?php
    include "privacypolicy.html";
?>
</div>
<div id="footer"></div>
<script>
    $(document).ready(function () {
        $("#footer").load("/footer.html?version=2");
    });
    $(function () {
        $(document).scroll(function () {
            var $nav = $(".navbar-fixed-top");
            $nav.toggleClass('navbar-default', $(this).scrollTop() > $nav.height());
            $(".nav").toggleClass("nav-over-video", $(this).scrollTop() < $nav.height());
            if ($(this).scrollTop() > $nav.height()) {
                $(".icon-bar").css({'background-color': '#888 !important'});
                console.log($(".icon-bar"));
            }
        });
    });

</script>
</body>
</html>