<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
include 'db.php';

$id = $_GET['id'] ?? 0;
$sql = "DELETE FROM Customers WHERE CustomerID = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: customers.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>