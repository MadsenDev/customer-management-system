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
                echo '<table class="min-w-full bg-white">';
                echo '<thead>';
                echo '<tr>';
                echo '<th class="py-2 px-4 border"><a href="?order=TicketID">Ticket ID</a></th>';
                echo '<th class="py-2 px-4 border"><a href="?order=CustomerID">Customer</a></th>';
                echo '<th class="py-2 px-4 border"><a href="?order=StatusID">Status</a></th>';
                echo '<th class="py-2 px-4 border"><a href="?order=CreatedBy">Created By</a></th>';
                echo '<th class="py-2 px-4 border"><a href="?order=Description">Description</a></th>';
                echo '<th class="py-2 px-4 border"><a href="?order=CreatedAt">Created At</a></th>';
                echo '<th class="py-2 px-4 border"><a href="?order=UpdatedAt">Updated At</a></th>';
                echo '<th class="py-2 px-4 border">Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td class="py-2 px-4 border">' . $row["TicketID"] . '</td>';
                    echo '<td class="py-2 px-4 border">' . $row["CFirstName"] . ' ' . $row["CLastName"] . '</td>';
                    echo '<td class="py-2 px-4 border">' . $row["StatusName"] . '</td>';
                    echo '<td class="py-2 px-4 border">' . $row["UFirstName"] . ' ' . $row["ULastName"] . '</td>';
                    echo '<td class="py-2 px-4 border">' . $row["Description"] . '</td>';
                    echo '<td class="py-2 px-4 border">' . $row["CreatedAt"] . '</td>';
                    echo '<td class="py-2 px-4 border">' . $row["UpdatedAt"] . '</td>';
                    echo '<td class="py-2 px-4 border">';
                    echo '<a href="view_ticket.php?id=' . $row['TicketID'] . '">View</a> | ';
                    echo '<a href="edit_ticket.php?id=' . $row['TicketID'] . '">Edit</a> | ';
                    echo '<a href="delete_ticket.php?id=' . $row['TicketID'] . '">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
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