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
        .customer-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        /* Desktop-specific styling */
        @media (min-width: 1025px) {
            .customer-card {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="flex">
        <?php include 'components/menu.php'; ?>
        <div class="w-5/6 p-5">
            <h1 class="text-2xl mb-4">Customer Management <a href="add_customer.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Add New Customer</a></h1>

            <?php
            include 'db.php';

            $sql = "SELECT * FROM Customers";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Desktop version
                echo '<div class="hidden md:block">';
                include 'customer_table.php';  // Your existing table layout
                echo '</div>';

                // Rewind result set
                $result->data_seek(0);

                // Mobile version
                echo '<div class="md:hidden">';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="customer-card">';
                    echo 'ID: ' . $row['CustomerID'] . '<br>';
                    echo 'Name: <a href="view_customer.php?id=' . $row['CustomerID'] . '" class="text-blue-500 hover:text-blue-700">' . $row['FirstName'] . ' ' . $row['LastName'] . '</a><br>';
                    echo 'Address: ' . $row['Address'] . '<br>';
                    echo 'Phone: ' . $row['PhoneNumber'] . '<br>';
                    echo 'Email: ' . $row['Email'] . '<br>';
                    echo '<a href="edit_customer.php?id=' . $row['CustomerID'] . '" class="text-blue-500 hover:text-blue-700">Edit</a> ';
                    echo '<a href="delete_customer.php?id=' . $row['CustomerID'] . '" class="text-red-500 hover:text-red-700">Delete</a>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo "No customers found";
            }

            $conn->close();
            ?>
        </div>
    </div>
    <script src="./js/main.js"></script>
</body>
</html>