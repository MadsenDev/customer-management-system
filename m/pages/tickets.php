<?php

$order = $_GET['order'] ?? 'TicketID';  // Default sort by TicketID
$filter = $_GET['filter'] ?? '';  // Default no filter

$sql = "SELECT Tickets.*, Customers.FirstName AS CFirstName, Customers.LastName AS CLastName, Users.FirstName AS UFirstName, Users.LastName AS ULastName, StatusOptions.StatusName 
FROM Tickets 
JOIN Customers ON Tickets.CustomerID = Customers.CustomerID 
JOIN Users ON Tickets.CreatedBy = Users.UserID 
JOIN StatusOptions ON Tickets.StatusID = StatusOptions.StatusID 
WHERE StatusOptions.StatusName LIKE '%$filter%' 
ORDER BY $order";
$result = $conn->query($sql);
?>

<h1 class="text-2xl mb-4">Ticket Management</h1>

<!-- Filtering Form -->
<form method="GET" class="mb-4">
    <input type="text" name="filter" placeholder="Filter by Status">
    <button type="submit">Filter</button>
</form>

<div class="ticket-list">
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="ticket-card" onclick="redirectToTicket(' . $row['TicketID'] . ')">';
            echo 'Ticket ID: ' . $row['TicketID'] . '<br>';
            echo 'Customer: ' . $row['CFirstName'] . ' ' . $row['CLastName'] . '<br>';
            echo 'Status: ' . $row['StatusName'] . '<br>';
            echo 'Created By: ' . $row['UFirstName'] . ' ' . $row['ULastName'] . '<br>';
            echo '</div>';
        }
    } else {
        echo "No tickets found";
    }

    $conn->close();
    ?>
</div>

<style>
    .ticket-card {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
</style>
<script>
    function redirectToTicket(ticketId) {
        window.location.href = "?page=view_ticket&id=" + ticketId;
    }
</script>