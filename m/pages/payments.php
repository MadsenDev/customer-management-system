<?php

// Placeholder: Calculate the total amount and total amount for this month
$total_amount = 0;
$total_month = 0;

// SQL queries for payment details
$sql = "SELECT Payments.*, Customers.FirstName, Customers.LastName 
        FROM Payments 
        LEFT JOIN Customers ON Payments.CustomerID = Customers.CustomerID";
$result = $conn->query($sql);

// SQL for total amount
$total_sql = "SELECT SUM(Amount) as total_amount FROM Payments";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_amount = $total_row['total_amount'];

// SQL for total amount this month
$month_sql = "SELECT SUM(Amount) as total_month FROM Payments WHERE MONTH(PaymentDate) = MONTH(CURRENT_DATE)";
$month_result = $conn->query($month_sql);
$month_row = $month_result->fetch_assoc();
$total_month = $month_row['total_month'];

?>

<h1>Payments</h1>

<!-- Summary Cards -->
<div class="summary-cards">
    <div class="card">
        <h3>Total Amount</h3>
        <p>NOK <?php echo $total_amount; ?></p>
    </div>
    <div class="card">
        <h3>Total This Month</h3>
        <p>NOK <?php echo $total_month; ?></p>
    </div>
</div>

<!-- Payment List -->
<h2>Recent Payments</h2>
<div class="payment-list">
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="payment-card">';
            echo 'Payment ID: ' . $row['PaymentID'] . '<br>';
            echo 'Customer: ' . $row['FirstName'] . ' ' . $row['LastName'] . '<br>';
            echo 'Amount: NOK ' . $row['Amount'] . '<br>';
            echo 'Date: ' . $row['PaymentDate'];
            echo '</div>';
        }
    } else {
        echo "No payments found";
    }

    $conn->close();
    ?>
</div>

<style>
    .summary-cards {
        display: flex;
        justify-content: space-between;
    }
    .card {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 15px;
        width: 48%;
        text-align: center;
    }
    .payment-list {
        margin-top: 20px;
    }
    .payment-card {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
</style>