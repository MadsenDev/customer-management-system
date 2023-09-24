<?php
// Assuming $result is the result set from your SQL query
if ($result->num_rows > 0) {
    echo '<table class="min-w-full bg-white">';
    echo '<thead class="bg-gray-800 text-white">';
    echo '<tr>';
    echo '<th class="w-1/12 py-2 px-4 border-r">ID</th>';
    echo '<th class="w-1/5 py-2 px-4 border-r">First Name</th>';
    echo '<th class="w-1/5 py-2 px-4 border-r">Last Name</th>';
    echo '<th class="w-1/5 py-2 px-4 border-r">Address</th>';
    echo '<th class="w-1/5 py-2 px-4 border-r">Phone Number</th>';
    echo '<th class="w-1/5 py-2 px-4 border-r">Email</th>';
    echo '<th class="w-1/6 py-2 px-4">Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody class="text-gray-700">';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td class="w-1/12 py-2 px-4">' . $row['CustomerID'] . '</td>';
        echo '<td class="w-1/5 py-2 px-4"><a href="view_customer.php?id=' . $row['CustomerID'] . '" class="text-blue-500 hover:text-blue-700">' . $row['FirstName'] . '</a></td>';
        echo '<td class="w-1/5 py-2 px-4">' . $row['LastName'] . '</td>';
        echo '<td class="w-1/5 py-2 px-4">' . $row['Address'] . '</td>';
        echo '<td class="w-1/5 py-2 px-4">' . $row['PhoneNumber'] . '</td>';
        echo '<td class="w-1/5 py-2 px-4">' . $row['Email'] . '</td>';
        echo '<td class="w-1/6 py-2 px-4 text-center">';
        echo '<a href="edit_customer.php?id=' . $row['CustomerID'] . '" class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit fa-lg"></i></a> ';
        echo '<a href="delete_customer.php?id=' . $row['CustomerID'] . '" class="text-red-500 hover:text-red-700"><i class="fas fa-trash-alt fa-lg"></i></a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo "No customers found";
}