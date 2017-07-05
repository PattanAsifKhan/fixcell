<?php
$name = $_POST['firstname'] . ' ' . $_POST['lastname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$feedback = $_POST['feedback'];

$conn = mysqli_connect('localhost', 'root', 'avi', 'fixcell');

$query = "INSERT INTO feedbacks values('$name','$email','$phone','$feedback')";

mysqli_query($conn, $query);

include "submit.html";
?>