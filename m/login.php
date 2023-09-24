<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE Username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            // Indicate that the user is logged in
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['userID'] = $row['UserID'];  // Store the user ID in the session

            header("Location: admin.php");
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }
} else {
    header("Location: index.html");
    exit;
}
?>