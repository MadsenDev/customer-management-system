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
            <h1 class="text-2xl mb-4">User Management <a href="add_user.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Add New User</a></h1>

            <?php
            include 'db.php';

            $sql = "SELECT * FROM Users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table class="min-w-full bg-white">';
                echo '<thead class="bg-gray-800 text-white">';
                echo '<tr>';
                echo '<th class="w-1/12 py-2 px-4 border-r">ID</th>';
                echo '<th class="w-1/5 py-2 px-4 border-r">Username</th>';
                echo '<th class="w-1/5 py-2 px-4 border-r">First Name</th>';
                echo '<th class="w-1/5 py-2 px-4 border-r">Last Name</th>';
                echo '<th class="w-1/5 py-2 px-4 border-r">Email</th>';
                echo '<th class="w-1/6 py-2 px-4">Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody class="text-gray-700">';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td class="w-1/12 py-2 px-4">' . $row['UserID'] . '</td>';
                    echo '<td class="w-1/5 py-2 px-4">' . $row['Username'] . '</td>';
                    echo '<td class="w-1/5 py-2 px-4">' . $row['FirstName'] . '</td>';
                    echo '<td class="w-1/5 py-2 px-4">' . $row['LastName'] . '</td>';
                    echo '<td class="w-1/5 py-2 px-4">' . $row['Email'] . '</td>';
                    echo '<td class="w-1/6 py-2 px-4">';
                    echo '<a href="edit_user.php?id=' . $row['UserID'] . '" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Edit</a> ';
                    echo '<a href="delete_user.php?id=' . $row['UserID'] . '" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo "No users found";
            }

            $conn->close();
            ?>
        </div>
    </div>
    <script src="./js/main.js"></script>
</body>
</html>