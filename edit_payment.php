<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $PaymentID = $_POST['PaymentID'];
    $Amount = $_POST['Amount'];
    $PaymentDate = $_POST['PaymentDate'];

    $sql = "UPDATE Payments SET Amount = ?, PaymentDate = ? WHERE PaymentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dsi", $Amount, $PaymentDate, $PaymentID);
    $stmt->execute();
    
    header("Location: view_ticket.php?id=$TicketID");  // Assuming TicketID is available
}
?>