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
$url = "https://www.rollbase.com/rest/api/selectQuery?" .
    "sessionId=" .
    $sessionKey .
    "&query=select%20distinct(brand)%20from%20phone" .
    "&maxRows=1000000" .
    "&output=json";

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
//echo $httpcode;
if ($httpcode == 403 or $httpcode != 200) {
    include "login.php";
    goto start;
}

$response = str_replace('[', '', $response);
$response = str_replace(']', '', $response);
$response = '[' . $response . ']';

echo $response;
?>
