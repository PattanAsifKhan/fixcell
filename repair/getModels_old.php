<?php
$brand = $_GET['brand'];


start:
if (!file_exists('sessionid')) {
    include "login.php";
    goto start;
}
$sessionKey = file_get_contents("sessionid");

$url = "https://www.rollbase.com/rest/api/selectQuery?" .
    "sessionId=" . $sessionKey .
    "&query=select%20model%20from%20phone%20where%20brand%3D'" . $brand .
    "'&maxRows=1000000&output=json";

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
        "postman-token: 73c664a1-0fe4-a3e3-bc2d-5ad97a90caa5"
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

$response = str_replace('[', '', $response);
$response = str_replace(']', '', $response);
$response = '[' . $response . ']';
echo $response;

?>