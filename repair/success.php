
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
//echo $url . "<br>";

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
echo $httpcode;
if ($httpcode == 403) {
    include 'login.php';
    goto start;
}

$id = json_decode($response, true)['id'];


$cart = explode(",", $_COOKIE['cart']);
print_r($cart);
echo sizeof($cart);

for ($i = 0; $i < sizeof($cart); $i = $i + 2) {
    $curl = curl_init();
    if (!file_exists('sessionid')) {
        include "login.php";
        $i -= 2;
        continue;
    }
    $sessionKey = file_get_contents("sessionid");
    $url = "https://www.rollbase.com/rest/api/createRecord?" .
        "sessionId=" . $sessionKey .
        "&objName=order_service" .
        "&useIds=false" .
        "&Type_=" . urlencode($cart[$i]) .
        "&Cost=" . urlencode($cart[$i + 1]) .
        "&R354713501=" . $id .
        "&output=json";
    echo "<br><br>".$cart[$i] . "<br>" . $url . "<br>";

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

    echo $response . "<br>" . $httpcode . "<br>";

    curl_close($curl);

    if ($httpcode == 403) {
        die();
        include "login.php";
        $i -= 2;
        continue;
    }
}