<?php
$brand = $_GET['brand'];

$conn = mysqli_connect("localhost", "root", "avi", "fixcell");

$query = "SELECT DISTINCT(model) FROM phones WHERE brand='$brand' ORDER BY model;";

$result = mysqli_query($conn, $query);

$arr = array();

foreach ($result as $r) {
    $arr[] = $r['model'];
}
mysqli_close($conn);

echo json_encode($arr);