<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
include 'db.php';

// Determine which page to display based on the URL query parameter
$page = $_GET['page'] ?? 'dashboard';

// Function to set the 'active' class
function isActive($currentPage, $tabName) {
    return $currentPage === $tabName ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Content */
        #content {
            padding: 20px;
            margin-bottom: 80px;  /* Height of the bottom nav */
        }

        /* Bottom Navigation styles */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #333;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .bottom-nav a {
            flex: 1;
            color: white;  /* Same color for icons and text */
            text-align: center;
            padding: 12px;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .bottom-nav i {
            font-size: 18px;
        }
        .bottom-nav .label {
            font-size: 12px;
        }
        .bottom-nav a:hover,
        .bottom-nav a.active {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>

    <div id="content">
        <?php
            // Include the content based on the selected page
            if ($page === 'dashboard') {
                include 'pages/dashboard.php';
            } elseif ($page === 'customers') {
                include 'pages/customers.php';
            } elseif ($page === 'tickets') {
                include 'pages/tickets.php';
            } elseif ($page === 'payments') {
                include 'pages/payments.php';
            } elseif ($page === 'users') {
                include 'pages/users.php';
            } elseif ($page === 'view_ticket') {
                include 'pages/view_ticket.php';
            } elseif ($page === 'view_customer') {
                include 'pages/view_customer.php';
            } elseif ($page === 'add_customer') {
                include 'pages/add_customer.php';
            } elseif ($page === 'edit_customer') {
                include 'pages/edit_customer.php';
            } elseif ($page === 'delete_customer') {
                include 'pages/delete_customer.php';
            } elseif ($page === 'add_ticket') {
                include 'pages/add_ticket.php';
            } elseif ($page === 'edit_ticket') {
                include 'pages/edit_ticket.php';
            } elseif ($page === 'delete_ticket') {
                include 'pages/delete_ticket.php';
            } elseif ($page === 'add_user') {
                include 'pages/add_user.php';
            } elseif ($page === 'edit_user') {
                include 'pages/edit_user.php';
            } elseif ($page === 'delete_user') {
                include 'pages/delete_user.php';
            } elseif ($page === 'add_payment') {
                include 'pages/add_payment.php';
            } elseif ($page === 'edit_payment') {
                include 'pages/edit_payment.php';
            } elseif ($page === 'delete_payment') {
                include 'pages/delete_payment.php';
            }
        ?>
    </div>

    <!-- Bottom Navigation Menu -->
    <div class="bottom-nav">
        <a href="?page=dashboard" class="<?php echo isActive($page, 'dashboard'); ?>">
            <i class="fas fa-home"></i>
            <div class="label">Dashboard</div>
        </a>
        <a href="?page=customers" class="<?php echo isActive($page, 'customers'); ?>">
            <i class="fas fa-users"></i>
            <div class="label">Customers</div>
        </a>
        <a href="?page=tickets" class="<?php echo isActive($page, 'tickets'); ?>">
            <i class="fas fa-ticket-alt"></i>
            <div class="label">Tickets</div>
        </a>
        <a href="?page=payments" class="<?php echo isActive($page, 'payments'); ?>">
            <i class="fas fa-money-bill-wave"></i>
            <div class="label">Payments</div>
        </a>
        <a href="?page=users" class="<?php echo isActive($page, 'users'); ?>">
            <i class="fas fa-user"></i>
            <div class="label">Users</div>
        </a>
    </div>

</body>
</html>