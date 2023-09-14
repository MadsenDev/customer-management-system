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
            <h1 class="text-2xl mb-4">Edit User</h1>

            <?php
            include 'db.php';

            $id = $_GET['id'] ?? 0;
            $sql = "SELECT * FROM Users WHERE UserID = $id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];
                $email = $_POST['email'];

                $sql = "UPDATE Users SET Username='$username', Password='$password', FirstName='$firstName', LastName='$lastName', Email='$email' WHERE UserID=$id";
                if ($conn->query($sql) === TRUE) {
                    header("Location: users.php");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>

            <form method="POST" class="space-y-4">
                <input type="text" name="username" value="<?php echo $row['Username']; ?>" placeholder="Username" class="p-2 w-full border rounded">
                <input type="password" name="password" placeholder="Password" class="p-2 w-full border rounded">
                <input type="text" name="firstName" value="<?php echo $row['FirstName']; ?>" placeholder="First Name" class="p-2 w-full border rounded">
                <input type="text" name="lastName" value="<?php echo $row['LastName']; ?>" placeholder="Last Name" class="p-2 w-full border rounded">
                <input type="text" name="email" value="<?php echo $row['Email']; ?>" placeholder="Email" class="p-2 w-full border rounded">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update User</button>
            </form>
        </div>
    </div>
    <script src="./js/main.js"></script>
</body>
</html>