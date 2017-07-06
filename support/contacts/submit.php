<?php
$name = $_POST['firstname'] . ' ' . $_POST['lastname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

start:
if (!file_exists('sessionid')) {
    include "login.php";
    goto start;
}
$sessionKey = file_get_contents("sessionid");

$curl = curl_init();

$url = "https://www.rollbase.com/rest/api/createRecord?" .
    "sessionId=" . urlencode($sessionKey) .
    "&objName=contactform" .
    "&useIds=false" .
    "&name_=" . urlencode($name) .
    "&email=" . urlencode($email) .
    "&phone=" . $phone .
    "&message=" . urlencode($message);

curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
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

if ($httpcode == 403) {
    include 'login.php';
    goto start;
}
include "submit.html";
?>