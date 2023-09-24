<?php
$preFilledCustomerID = $_GET['customer'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customerID = $_POST['customerID'];
    $statusID = $_POST['statusID'];
    $description = $_POST['description'];
    $createdBy = $_SESSION['userID'];

    $sql = "INSERT INTO Tickets (CustomerID, StatusID, CreatedBy, Description) VALUES ('$customerID', '$statusID', '$createdBy', '$description')";

    if ($conn->query($sql) === TRUE) {
        header("Location: tickets.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        echo "<br>Session UserID: " . $_SESSION['userID'];  // Debug line to print the session UserID
    }
}
?>
    <div class="flex">
        <div class="w-5/6 p-5 flex">
            <!-- Ticket Form Section -->
            <div class="w-1/2 pr-4">
                <h1 class="text-2xl mb-4">Add New Ticket</h1>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="customerID" value="<?php echo $preFilledCustomerID; ?>">
                    <select name="statusID">
                        <option value="1">Open</option>
                        <option value="2">In Progress</option>
                        <option value="3">Closed</option>
                    </select>
                    <textarea name="description" rows="4" placeholder="Ticket Description" class="w-full p-2 border rounded"></textarea>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Ticket</button>
                </form>
            </div>

            <!-- Customer Information Section -->
            <div class="w-1/2 pl-4 border-l">
                <h1 class="text-2xl mb-4">Customer Information</h1>
                
                <?php
                if (!empty($preFilledCustomerID)) {
                    $sql = "SELECT * FROM Customers WHERE CustomerID = '$preFilledCustomerID'";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "First Name: " . $row['FirstName'] . "<br>";
                        echo "Last Name: " . $row['LastName'] . "<br>";
                        echo "Address: " . $row['Address'] . "<br>";
                        echo "Phone Number: " . $row['PhoneNumber'] . "<br>";
                        echo "Email: " . $row['Email'] . "<br>";
                    } else {
                        echo "Customer not found.";
                    }
                } else {
                    echo "No customer selected.";
                }
                ?>
            </div>
        </div>
    </div>
    <style>
    /* Mobile-friendly styles */
    @media (max-width: 768px) {
        /* Make flex containers stack vertically */
        .flex {
            flex-direction: column;
        }

        /* Full width for flex children */
        .w-5/6 {
            width: 100%;
        }

        /* Full width for form and customer information sections */
        .w-1/2 {
            width: 100%;
        }

        /* Remove padding and border */
        .pr-4, .pl-4, .border-l {
            padding-right: 0;
            padding-left: 0;
            border: none;
        }

        /* Adjust form elements and text */
        select, textarea, button {
            width: 100%;
            margin-bottom: 20px;
        }
    }
</style>