<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $TicketID = $_POST['TicketID'];
    $CustomerID = $_POST['CustomerID'];  // Add this line
    $Amount = $_POST['Amount'];
    $PaymentDate = $_POST['PaymentDate'];

    $sql = "INSERT INTO Payments (TicketID, CustomerID, Amount, PaymentDate) VALUES (?, ?, ?, ?)";  // Update this line
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iids", $TicketID, $CustomerID, $Amount, $PaymentDate);  // Update this line
    $stmt->execute();
    
    header("Location: ?page=view_ticket.php&id=$TicketID");
}
?>