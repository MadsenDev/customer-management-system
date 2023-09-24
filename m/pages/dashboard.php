<?php

// Fetch statistics from database (replace with your own queries)
$total_tickets = $conn->query("SELECT COUNT(*) FROM Tickets")->fetch_row()[0];
$total_open_tickets = $conn->query("SELECT COUNT(*) FROM Tickets WHERE StatusID = 1")->fetch_row()[0]; // assuming 1 is the StatusID for 'Open'
$total_inprogress_tickets = $conn->query("SELECT COUNT(*) FROM Tickets WHERE StatusID = 2")->fetch_row()[0]; // assuming 2 is the StatusID for 'In Progress'
$total_closed_tickets = $conn->query("SELECT COUNT(*) FROM Tickets WHERE StatusID = 3")->fetch_row()[0]; // assuming 2 is the StatusID for 'Closed'
$total_payments = $conn->query("SELECT SUM(Amount) FROM Payments")->fetch_row()[0];
$total_customers = $conn->query("SELECT COUNT(*) FROM Customers")->fetch_row()[0];
$total_users = $conn->query("SELECT COUNT(*) FROM Users")->fetch_row()[0];
?>
    <style>
        /* Common styles */
        .card {
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .card h3 {
            font-size: 1.5rem;
            margin-bottom: 12px;
        }
        .card p {
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        /* Desktop styles */
        @media (min-width: 768px) {
            .card {
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
            .card:hover {
                box-shadow: 0 6px 12px rgba(0,0,0,0.2);
                transform: translateY(-4px);
            }
        }

        /* Mobile styles */
        @media (max-width: 767px) {
            .card {
                background: none;
                box-shadow: none;
            }
            .card h3 {
                font-size: 1.2rem;
            }
            .card p {
                font-size: 1rem;
            }
            /* Add any additional mobile-specific styles here */
        }
    </style>
    <div class="flex">
        <?php include 'components/menu.php'; ?>
        <div class="content w-full p-5">
            <h1 class="text-2xl mb-4">Dashboard</h1>
            
            <!-- Statistics -->
            <div class="grid grid-cols-4 gap-4">
                <div class="card">
                    <h3>Total Tickets</h3>
                    <p><?php echo $total_tickets; ?></p>
                </div>
                <div class="card">
                    <h3>Open Tickets</h3>
                    <p><?php echo $total_open_tickets; ?></p>
                </div>
                <div class="card">
                    <h3>In Progress Tickets</h3>
                    <p><?php echo $total_inprogress_tickets; ?></p>
                </div>
                <div class="card">
                    <h3>Closed Tickets</h3>
                    <p><?php echo $total_closed_tickets; ?></p>
                </div>
                <div class="card">
                    <h3>Total Payments (NOK)</h3>
                    <p><?php echo $total_payments; ?></p>
                </div>
                <div class="card">
                    <h3>Total Customers</h3>
                    <p><?php echo $total_customers; ?></p>
                </div>
                <div class="card">
                    <h3>Total Users</h3>
                    <p><?php echo $total_users; ?></p>
                </div>
            </div>
        </div>
    </div>