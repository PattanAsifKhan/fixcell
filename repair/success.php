<?php

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);
ini_set("html_errors", 1);
start:
if (!file_exists('sessionid')) {
    include "login.php";
    goto start;
}
$sessionKey = file_get_contents("sessionid");

$curl = curl_init();

$url = "https://www.rollbase.com/rest/api/createRecord?" .
    "sessionId=" . urlencode($sessionKey) .
    "&output=json" .
    "&objName=order&useIds=false&" .
    "Customer_Name=" . urlencode($_POST['first-name'] . " " . $_POST['last-name']) .
    "&Brand=" . urlencode($_COOKIE['brand']) .
    "&Model=" . urlencode($_COOKIE['model']) .
    "&Phone=" . urlencode($_POST['phone']) .
    "&Email=" . urlencode($_POST['email']) .
    "&Landmark=" . urlencode($_POST['landmark']) .
    "&Address=" . urlencode($_POST['address']);
echo $url;

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
        "postman-token: 46294f3b-23b6-e336-d851-3aca56ed94b1"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);
echo $err;

if ($httpcode == 403 or $httpcode != 200) {
    include 'login.php';
    goto start;
}

$id = json_decode($response, true)['id'];

$cart = explode(",", $_COOKIE['cart']);
print_r($cart);
echo sizeof($cart);
die();
$curl = curl_init();
//while (sizeof($cart) > 0) {
step:
if (!file_exists('sessionid')) {
    include "login.php";
    goto step;
}
$sessionKey = file_get_contents("sessionid");
$url = "https://www.rollbase.com/rest/api/createRecord?" .
    "sessionId=" . $sessionKey .
    "&objName=order_service" .
    "&useIds=false" .
    "&Type_=" . urlencode($cart[0]) .
    "&Cost=" . urlencode($cart[1]) .
    "&R354713501=" . $id .
    "&output=json";
echo $url;

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
        "postman-token: 21764e5a-3266-6f59-954f-a958da5cfae3"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

if ($httpcode == 403 or $httpcode != 200) {
    include "login.php";
    goto step;
}

array_splice($array, 0, 2);
print_r($cart);
//}