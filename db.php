<?php
$host = "localhost";
$user = "cat2user";
$pass = "Cat2Pass@123";
$dbname = "CAT2";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>