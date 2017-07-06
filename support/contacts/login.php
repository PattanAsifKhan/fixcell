<?php

$curl = curl_init();

$loginURL = "https://www.rollbase.com/rest/api/login?".
    "loginName=nehabandari".
    "&password=QWEasd123".
    "&output=json";

curl_setopt_array($curl, array(
    CURLOPT_URL => $loginURL,
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

$jsonLogin = json_decode($response, true);

$sessionKey = $jsonLogin['sessionId'];

$file = fopen("sessionid", "w");
fwrite($file, $sessionKey);
fclose($file);

?>