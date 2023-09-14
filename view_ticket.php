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
        /* Custom styles */
        .container {
            display: flex;
            justify-content: space-between;
        }
        .section-wrapper {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .section-header {
            background-color: #f1f1f1;
            padding: 10px;
            font-size: 18px;
            border-bottom: 1px solid #ccc;
        }
        .section-content {
            padding: 15px;
        }

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

    .work-description-list {
    max-height: 300px;
    overflow-y: auto;
}

.work-description-item {
    background-color: #f9f9f9;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 5px;
}

.work-description-item p {
    margin: 0;
    padding: 0;
}

.work-description-item span {
    font-size: 0.8em;
    color: #888;
}

.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 1;
}

.overlay-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    z-index: 2;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}
    </style>
</head>
<body>
    <div class="flex">
        <?php include 'components/menu.php'; ?>
        <div class="w-5/6 p-5">
            <h1 class="text-2xl mb-4">View Ticket</h1>

            <?php
            include 'db.php';

            // Add Work Description
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $work_description = $_POST['work_description'];
                $created_by = $_SESSION['userID'];
                $ticket_id = $_GET['id'];

                $stmt = $conn->prepare("INSERT INTO WorkDescription (TicketID, CreatedBy, Comment) VALUES (?, ?, ?)");
                $stmt->bind_param("iis", $ticket_id, $created_by, $work_description);
                $stmt->execute();
            }

            $id = $_GET['id'] ?? 0;
            $sql = "SELECT Tickets.*, Customers.*, StatusOptions.StatusName, Users.FirstName as UFirstName, Users.LastName as ULastName 
                    FROM Tickets 
                    LEFT JOIN Customers ON Tickets.CustomerID = Customers.CustomerID 
                    LEFT JOIN StatusOptions ON Tickets.StatusID = StatusOptions.StatusID 
                    LEFT JOIN Users ON Tickets.CreatedBy = Users.UserID 
                    WHERE TicketID = $id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            // Update Status
            if (isset($_POST['update_status'])) {
                $new_status = $_POST['new_status'];
                $stmt = $conn->prepare("UPDATE Tickets SET StatusID = ? WHERE TicketID = ?");
                $stmt->bind_param("ii", $new_status, $id);
                $stmt->execute();
            }
            ?>

            <div class="container">
                <!-- Ticket Info -->
                <div class="section-wrapper">
    <div class="section-header">Ticket Details</div>
    <div class="section-content">
        <div class="grid grid-cols-2 gap-4">
            <!-- Ticket ID -->
            <div class="card">
                <i class="fas fa-ticket-alt"></i>
                <h3>Ticket ID</h3>
                <p><?php echo $row['TicketID']; ?></p>
            </div>

            <!-- Status -->
            <div class="card">
                <i class="fas fa-exclamation-circle"></i>
                <h3>Status</h3>
                <form method="POST" action="">
                    <select name="new_status" id="new_status">
                        <option value="1" <?php echo ($row['StatusName'] == 'Open') ? 'selected' : ''; ?>>Open</option>
                        <option value="2" <?php echo ($row['StatusName'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                        <option value="3" <?php echo ($row['StatusName'] == 'Closed') ? 'selected' : ''; ?>>Closed</option>
                    </select>
                    <button type="submit" name="update_status" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Update Status</button>
                </form>
            </div>

            <!-- Created By -->
            <div class="card">
                <i class="fas fa-user"></i>
                <h3>Created By</h3>
                <p><?php echo $row['UFirstName'] . ' ' . $row['ULastName']; ?></p>
            </div>

            <!-- Description -->
            <div class="card">
                <i class="fas fa-sticky-note"></i>
                <h3>Description</h3>
                <p><?php echo $row['Description']; ?></p>
            </div>

            <!-- Created At -->
            <div class="card">
                <i class="fas fa-calendar"></i>
                <h3>Created At</h3>
                <p><?php echo $row['CreatedAt']; ?></p>
            </div>

            <!-- Updated At -->
            <div class="card">
                <i class="fas fa-clock"></i>
                <h3>Updated At</h3>
                <p><?php echo $row['UpdatedAt']; ?></p>
            </div>
        </div>
    </div>
</div>
                <!-- Customer Info -->
<div class="section-wrapper">
    <div class="section-header">Customer Details <i class="fas fa-edit"></i></div>
    <div class="section-content">
        <div class="grid grid-cols-2 gap-4">
        <div class="card">
                        <i class="fas fa-user"></i>
                        <h3>Customer</h3>
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
    </div>
</div>

            
    </div>


    <div class="container">
    <<!-- Work Descriptions -->
<div class="section-wrapper">
    <div class="section-header">Work Descriptions</div>
    <div class="section-content">
        <div class="grid grid-cols-1 gap-4"> <!-- Changed from grid-cols-2 to grid-cols-1 -->
            <form method="POST" class="mb-4">
                <textarea name="work_description" rows="4" class="w-full border rounded p-2"></textarea><br>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Add Work Description</button>
            </form>

            <!-- Display Work Descriptions -->
            <?php
            $sql = "SELECT WorkDescription.*, Users.FirstName, Users.LastName 
                    FROM WorkDescription 
                    LEFT JOIN Users ON WorkDescription.CreatedBy = Users.UserID 
                    WHERE TicketID = $id 
                    ORDER BY TimeStamp DESC";
            $work_result = $conn->query($sql);
            if ($work_result->num_rows > 0) {
                echo "<div class='work-description-list'>";
                while ($work_row = $work_result->fetch_assoc()) {
                    echo "<div class='work-description-item border-b p-2'>";
                    echo "<p>" . $work_row['Comment'] . "</p>";
                    echo "<span class='text-sm text-gray-600'>" . $work_row['FirstName'] . " " . $work_row['LastName'] . " (" . $work_row['TimeStamp'] . ")</span>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p class='text-gray-600'>No work descriptions added yet.</p>";
            }
            ?>
        </div>
    </div>
</div>

<!-- Payment Info -->
<div class="section-wrapper">
    <div class="section-header">Payment Details</div>
    <div class="section-content">
        <?php
        $payment_sql = "SELECT * FROM Payments WHERE TicketID = $id";
        $payment_result = $conn->query($payment_sql);
        if ($payment_result->num_rows > 0) {
            $payment_row = $payment_result->fetch_assoc();
        ?>
            <div class="grid grid-cols-2 gap-4">
                <!-- Amount -->
                <div class="card">
                    <i class="fas fa-dollar-sign"></i>
                    <h3>Amount</h3>
                    <p><?php echo $payment_row['Amount']; ?></p>
                </div>

                <!-- Payment Date -->
                <div class="card">
                    <i class="fas fa-calendar-alt"></i>
                    <h3>Payment Date</h3>
                    <p><?php echo $payment_row['PaymentDate']; ?></p>
                </div>
            </div>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="openEditPaymentOverlay()">Edit Payment</button>
        <?php
        } else {
        ?>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="openAddPaymentOverlay()">Add Payment</button>
        <?php
        }
        ?>
    </div>
</div>

<!-- Add Payment Overlay -->
<div id="addPaymentOverlay" class="overlay">
    <div class="overlay-content">
        <span class="close-btn" onclick="closeAddPaymentOverlay()">&times;</span>
        <h2>Add Payment</h2>
        <form method="POST" action="add_payment.php">
            <input type="hidden" name="TicketID" value="<?php echo $id; ?>">
            <input type="hidden" name="CustomerID" value="<?php echo $row['CustomerID']; ?>">  <!-- Add this line -->
            Amount: <input type="number" name="Amount" step="0.01"><br>
            Payment Date: <input type="date" name="PaymentDate"><br>
            <button type="submit">Add Payment</button>
        </form>
    </div>
</div>

<!-- Edit Payment Overlay -->
<div id="editPaymentOverlay" class="overlay">
    <div class="overlay-content">
        <span class="close-btn" onclick="closeEditPaymentOverlay()">&times;</span>
        <h2>Edit Payment</h2>
        <form method="POST" action="edit_payment.php">
            <input type="hidden" name="PaymentID" value="<?php echo $payment_row['PaymentID']; ?>">
            Amount: <input type="number" name="Amount" step="0.01" value="<?php echo $payment_row['Amount']; ?>"><br>
            Payment Date: <input type="date" name="PaymentDate" value="<?php echo $payment_row['PaymentDate']; ?>"><br>
            <button type="submit">Edit Payment</button>
        </form>
    </div>
</div>
    </div>

    <script src="./js/main.js"></script>
    <script>
        function openAddPaymentOverlay() {
    document.getElementById('addPaymentOverlay').style.display = 'block';
}

function closeAddPaymentOverlay() {
    document.getElementById('addPaymentOverlay').style.display = 'none';
}

function openEditPaymentOverlay() {
    document.getElementById('editPaymentOverlay').style.display = 'block';
}

function closeEditPaymentOverlay() {
    document.getElementById('editPaymentOverlay').style.display = 'none';
}
    </script>
</body>
</html>