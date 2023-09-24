<div class="flex">
        <div class="w-5/6 p-5">
            <h1 class="text-2xl mb-4">Add New Customer</h1>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $firstName = $_POST['firstName'];
                $lastName = $_POST['lastName'];
                $address = $_POST['address'];
                $phoneNumber = $_POST['phoneNumber'];
                $email = $_POST['email'];

                $sql = "INSERT INTO Customers (FirstName, LastName, Address, PhoneNumber, Email) VALUES ('$firstName', '$lastName', '$address', '$phoneNumber', '$email')";
                if ($conn->query($sql) === TRUE) {
                    header("Location: ?page=customers");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>

            <form method="POST" class="space-y-4">
                <input type="text" name="firstName" placeholder="First Name" required class="w-full p-2 border rounded">
                <input type="text" name="lastName" placeholder="Last Name" required class="w-full p-2 border rounded">
                <input type="text" name="address" placeholder="Address" required class="w-full p-2 border rounded">
                <input type="text" name="phoneNumber" placeholder="Phone Number" required class="w-full p-2 border rounded">
                <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Customer</button>
            </form>
        </div>
    </div>