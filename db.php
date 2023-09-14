<?php
$servername = "localhost";
$username = "madsyrnh_chris";
$password = "data2023";
$dbname = "madsyrnh_cms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>