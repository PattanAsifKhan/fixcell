<?php
foreach ($_POST as $key => $value)
    echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
start:
if (!file_exists('sessionid')) {
    include "login.php";
    goto start;
}
$sessionKey = file_get_contents("sessionid");

$curl = curl_init();

$url = "https://www.rollbase.com/rest/api/createRecord?" .
    "sessionId=" . $sessionKey .
    "&objName=order&useIds=false&" .
    "Customer_Name=" . $_POST['first-name'] . "%20" . $_POST['last-name'] .
    "&Brand=" . $_COOKIE['brand'] .
    "&Model=" . $_COOKIE['model'] .
    "&Phone=" . $_POST['phone'] .
    "&Email=" . $_POST['email'] .
    "&Landmark=" . $_POST['landmark'] .
    "&Address=" . $_POST['address'] .
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
        "cache-control: no-cache",
        "postman-token: 3126eb0e-adb1-4190-434b-bd3f319e8bc0"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}