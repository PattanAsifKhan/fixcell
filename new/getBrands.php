<?php
$conn = mysqli_connect("localhost", "root", "san", "fixcell");

$query = "SELECT DISTINCT (brand) FROM phones ORDER BY brand;";

$result = mysqli_query($conn, $query);

$arr = array();

foreach ($result as $r) {
    $arr[] = $r['brand'];
}

echo json_encode($arr);