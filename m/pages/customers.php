<!-- customers.php -->
<div class="p-5">
    <h1 class="text-2xl mb-4">
        Customer Management 
        <a href="?page=add_customer" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
            Add New Customer
        </a>
    </h1>

    <div id="customer-list">
        <?php

        $sql = "SELECT * FROM Customers";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="customer-card">';
                echo 'ID: ' . $row['CustomerID'] . '<br>';
                echo 'Name: <a href="?page=view_customer&id=' . $row['CustomerID'] . '" class="text-blue-500 hover:text-blue-700">' . $row['FirstName'] . ' ' . $row['LastName'] . '</a><br>';
                echo 'Address: ' . $row['Address'] . '<br>';
                echo 'Phone: ' . $row['PhoneNumber'] . '<br>';
                echo 'Email: ' . $row['Email'] . '<br>';
                echo '<a href="edit_customer.php?id=' . $row['CustomerID'] . '" class="text-blue-500 hover:text-blue-700">Edit</a> ';
                echo '<a href="delete_customer.php?id=' . $row['CustomerID'] . '" class="text-red-500 hover:text-red-700">Delete</a>';
                echo '</div>';
            }
        } else {
            echo "No customers found";
        }

        $conn->close();
        ?>
    </div>
</div>

<style>
    .customer-card {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
</style>