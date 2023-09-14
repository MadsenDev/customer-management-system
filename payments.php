<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

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

// SQL for monthly data
$monthly_sql = "SELECT MONTH(PaymentDate) as month, SUM(Amount) as amount FROM Payments GROUP BY MONTH(PaymentDate)";
$monthly_result = $conn->query($monthly_sql);
$monthly_data = array_fill(0, 12, 0);
while ($monthly_row = $monthly_result->fetch_assoc()) {
    $monthly_data[$monthly_row['month'] - 1] = $monthly_row['amount'];
}
$monthly_data_json = json_encode($monthly_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'components/head.php'; ?>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
        }
        .left-panel, .right-panel {
            width: 48%;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            margin-bottom: 15px;
        }
        .card h3 {
            font-size: 18px;
        }
        .card p {
            font-size: 16px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="flex">
        <?php include 'components/menu.php'; ?>
        <div class="w-full p-5">
            <h1 class="text-2xl mb-4">Payments</h1>

            <div class="container">
                <!-- Left Panel -->
                <div class="left-panel">
                    <div class="card">
                        <h3>Total Amount</h3>
                        <p>NOK <?php echo $total_amount; ?></p>
                    </div>
                    <div class="card">
                        <h3>Total Amount This Month</h3>
                        <p>NOK <?php echo $total_month; ?></p>
                    </div>
                    <canvas id="myChart" width="400" height="200"></canvas>
                </div>

                <!-- Right Panel -->
                <div class="right-panel bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-2 px-4 w-1/12">Payment ID</th>
                                <th class="py-2 px-4 w-3/12">Customer</th>
                                <th class="py-2 px-4 w-2/12">Amount (NOK)</th>
                                <th class="py-2 px-4 w-2/12">Date</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td class="py-2 px-4">' . $row['PaymentID'] . '</td>';
                                    echo '<td class="py-2 px-4">' . $row['FirstName'] . ' ' . $row['LastName'] . '</td>';
                                    echo '<td class="py-2 px-4">NOK ' . $row['Amount'] . '</td>';
                                    echo '<td class="py-2 px-4">' . $row['PaymentDate'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4" class="py-2 px-4 text-center">No payments found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var monthlyData = <?php echo $monthly_data_json; ?>;
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Monthly Payments (NOK)',
                    data: monthlyData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>