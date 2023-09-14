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
            <h1 class="text-2xl mb-4">Add New User</h1>

            <?php
            include 'db.php';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];
                $email = $_POST['email'];

                $sql = "INSERT INTO Users (Username, Password, FirstName, LastName, Email) VALUES ('$username', '$password', '$firstName', '$lastName', '$email')";
                if ($conn->query($sql) === TRUE) {
                    header("Location: users.php");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>

            <form method="POST" class="space-y-4">
                <input type="text" name="username" placeholder="Username" class="p-2 w-full border rounded">
                <input type="password" name="password" placeholder="Password" class="p-2 w-full border rounded">
                <input type="text" name="firstName" placeholder="First Name" class="p-2 w-full border rounded">
                <input type="text" name="lastName" placeholder="Last Name" class="p-2 w-full border rounded">
                <input type="text" name="email" placeholder="Email" class="p-2 w-full border rounded">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add User</button>
            </form>
        </div>
    </div>
    <script src="./js/main.js"></script>
</body>
</html>