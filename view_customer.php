<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/head.php'; ?>
    <style>
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
        }
        .card i {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .card h3 {
            font-size: 18px;
        }
        .card p {
            font-size: 16px;
        }
        .ticket-row:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="flex">
        <?php include 'components/menu.php'; ?>
        <div class="w-5/6 p-5">
            <h1 class="text-2xl mb-4">View Customer</h1>
            
            <?php
            include 'db.php';
            $id = $_GET['id'] ?? 0;
            $sql = "SELECT * FROM Customers WHERE CustomerID = $id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            ?>

            <div class="grid grid-cols-2 gap-4">
                <!-- Full Name -->
                <div class="card">
                    <i class="fas fa-user"></i>
                    <h3>Name</h3>
                    <p><?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></p>
                </div>

                <!-- Address -->
                <div class="card">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Address</h3>
                    <p><?php echo $row['Address']; ?></p>
                </div>

                <!-- Phone Number -->
                <div class="card">
                    <i class="fas fa-phone"></i>
                    <h3>Phone Number</h3>
                    <p><?php echo $row['PhoneNumber']; ?></p>
                </div>

                <!-- Email -->
                <div class="card">
                    <i class="fas fa-envelope"></i>
                    <h3>Email</h3>
                    <p><?php echo $row['Email']; ?></p>
                </div>
            </div>

            <h2 class="text-xl mt-4 mb-2">Related Tickets</h2>
            <a href="add_ticket.php?customer=<?php echo $id; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Create New Ticket</a>
            
            <?php
            $sql_tickets = "SELECT Tickets.*, StatusOptions.StatusName FROM Tickets LEFT JOIN StatusOptions ON Tickets.StatusID = StatusOptions.StatusID WHERE CustomerID = $id";
            $result_tickets = $conn->query($sql_tickets);
            if ($result_tickets->num_rows > 0) {
                echo '<table class="min-w-full bg-white mt-4">';
                echo '<thead class="bg-gray-800 text-white">';
                echo '<tr>';
                echo '<th class="py-2 px-4 border-r">Ticket ID</th>';
                echo '<th class="py-2 px-4 border-r">Status</th>';
                echo '<th class="py-2 px-4">Description</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody class="text-gray-700">';
                while ($row_tickets = $result_tickets->fetch_assoc()) {
                    echo '<tr class="ticket-row" onclick="location.href=\'view_ticket.php?id=' . $row_tickets['TicketID'] . '\'">';
                    echo '<td class="py-2 px-4">' . $row_tickets['TicketID'] . '</td>';
                    echo '<td class="py-2 px-4">' . $row_tickets['StatusName'] . '</td>';
                    echo '<td class="py-2 px-4">' . $row_tickets['Description'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo "<p>No related tickets found.</p>";
            }            
            ?>

        </div>
    </div>
    <script src="./js/main.js"></script>
</body>
</html>