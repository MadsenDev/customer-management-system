<?php
$sql = "SELECT * FROM Users";
$result = $conn->query($sql);
?>

<h1>User Management</h1>

<a href="add_user.php" class="add-button">Add New User</a>

<!-- User List -->
<div class="user-list">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="user-card">';
            echo 'ID: ' . $row['UserID'] . '<br>';
            echo 'Username: ' . $row['Username'] . '<br>';
            echo 'Name: ' . $row['FirstName'] . ' ' . $row['LastName'] . '<br>';
            echo 'Email: ' . $row['Email'] . '<br>';
            echo '<a href="edit_user.php?id=' . $row['UserID'] . '" class="edit-button">Edit</a> ';
            echo '<a href="delete_user.php?id=' . $row['UserID'] . '" class="delete-button">Delete</a>';
            echo '</div>';
        }
    } else {
        echo "No users found";
    }

    $conn->close();
    ?>
</div>

<style>
    .add-button {
        display: inline-block;
        margin-bottom: 20px;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        text-align: center;
        border-radius: 4px;
    }
    .user-list {
        margin-top: 20px;
    }
    .user-card {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .edit-button, .delete-button {
        display: inline-block;
        margin-top: 10px;
        padding: 5px;
        border-radius: 4px;
        text-align: center;
    }
    .edit-button {
        background-color: #007bff;
        color: white;
    }
    .delete-button {
        background-color: #dc3545;
        color: white;
    }
</style>