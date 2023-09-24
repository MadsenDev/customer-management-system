<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/head.php'; ?>
    <style>
        .ticket-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        /* Desktop-specific styling */
        @media (min-width: 1025px) {
            .ticket-card {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="flex">
        <?php include 'components/menu.php'; ?>
        <div class="w-5/6 p-5">
            <h1 class="text-2xl mb-4">Ticket Management</h1>

            <!-- Filtering Form -->
            <form method="GET" class="mb-4">
                <input type="text" name="filter" placeholder="Filter by Status">
                <button type="submit">Filter</button>
            </form>

            <?php
            include 'db.php';  // Include database connection

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

            if ($result->num_rows > 0) {
                echo '<div class="hidden md:block">';
                // Existing table layout
                include 'general_ticket_table.php';
                echo '</div>';

                // Rewind result set
                $result->data_seek(0);

                // Mobile version
                echo '<div class="md:hidden">';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="ticket-card">';
                    echo 'Ticket ID: ' . $row['TicketID'] . '<br>';
                    echo 'Customer: ' . $row['CFirstName'] . ' ' . $row['CLastName'] . '<br>';
                    echo 'Status: ' . $row['StatusName'] . '<br>';
                    echo 'Created By: ' . $row['UFirstName'] . ' ' . $row['ULastName'] . '<br>';
                    echo '<a href="view_ticket.php?id=' . $row['TicketID'] . '" class="text-blue-500 hover:text-blue-700">View</a> ';
                    echo '<a href="edit_ticket.php?id=' . $row['TicketID'] . '" class="text-blue-500 hover:text-blue-700">Edit</a> ';
                    echo '<a href="delete_ticket.php?id=' . $row['TicketID'] . '" class="text-red-500 hover:text-red-700">Delete</a>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo "No tickets found";
            }

            $conn->close();
            ?>
        </div>
    </div>
    <script src="./js/main.js"></script>
</body>
</html>