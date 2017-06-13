<?php
$brand = $_GET['brand'];

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.rollbase.com/rest/api/selectQuery?sessionId=751138c752d24350a9261dc9732a22a3%40352484058&query=select%20model%20from%20phone%20where%20brand%3D'".$brand."'&maxRows=1000000&output=json",
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

curl_close($curl);

header('Content-Type: application/json');

if ($err) {
    echo json_encode($err);
} else {
    echo $response;
}
?>