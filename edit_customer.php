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
            <h1 class="text-2xl mb-4">Edit Customer</h1>

            <?php
            include 'db.php';

            $id = $_GET['id'] ?? 0;
            $sql = "SELECT * FROM Customers WHERE CustomerID = $id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];
                $address = $_POST['address'];
                $phoneNumber = $_POST['phoneNumber'];
                $email = $_POST['email'];

                $sql = "UPDATE Customers SET FirstName='$firstName', LastName='$lastName', Address='$address', PhoneNumber='$phoneNumber', Email='$email' WHERE CustomerID=$id";
                if ($conn->query($sql) === TRUE) {
                    header("Location: customers.php");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>

            <form method="POST" class="space-y-4">
                <input type="text" name="firstName" value="<?php echo $row['FirstName']; ?>" placeholder="First Name" class="w-full p-2 border rounded">
                <input type="text" name="lastName" value="<?php echo $row['LastName']; ?>" placeholder="Last Name" class="w-full p-2 border rounded">
                <input type="text" name="address" value="<?php echo $row['Address']; ?>" placeholder="Address" class="w-full p-2 border rounded">
                <input type="text" name="phoneNumber" value="<?php echo $row['PhoneNumber']; ?>" placeholder="Phone Number" class="w-full p-2 border rounded">
                <input type="text" name="email" value="<?php echo $row['Email']; ?>" placeholder="Email" class="w-full p-2 border rounded">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Customer</button>
            </form>
        </div>
    </div>
    <script src="./js/main.js"></script>
</body>
</html>