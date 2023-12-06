<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance";

/*
$servername = "sql109.byetcluster.com";
$username = "if0_35566113"; // Replace with your database username
$password = "ZHj0U9sY8zCb1tb"; // Replace with your database password
$dbname = "if0_35566113_attendance";
*/

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>

