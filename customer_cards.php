<!-- Full Name -->
<div class="card">
    <i class="fas fa-user"></i>
    <h3>Name</h3>
    <p><?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></p>
</div>

<!-- Address -->
<div class="card">
    <i class="fas fa-map-marker-alt"></i>
    <h3>Address</h3>
    <p><?php echo $row['Address']; ?></p>
</div>

<!-- Phone Number -->
<div class="card">
    <i class="fas fa-phone"></i>
    <h3>Phone Number</h3>
    <p><?php echo $row['PhoneNumber']; ?></p>
</div>

<!-- Email -->
<div class="card">
    <i class="fas fa-envelope"></i>
    <h3>Email</h3>
    <p><?php echo $row['Email']; ?></p>
</div>