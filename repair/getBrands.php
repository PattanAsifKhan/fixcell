<?php
$conn = mysqli_connect("localhost", "root", "avi", "fixcell");

$query = "SELECT DISTINCT (brand) FROM phones ORDER BY brand;";

$result = mysqli_query($conn, $query);

$arr = array();

foreach ($result as $r) {
    $arr[] = $r['brand'];
}
mysqli_close($conn);

echo json_encode($arr);