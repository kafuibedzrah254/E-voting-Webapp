<?php
include('../settings/connect.php');

// Fetch the existing password from the database
$query = "SELECT id, password FROM `userdata` WHERE standard = 'admin'";
$result = $con->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userId = $row['id'];
        $existingPassword = $row['password'];

        // Hash the existing password
        $hashedPassword = password_hash($existingPassword, PASSWORD_DEFAULT);

        // Update the database with the hashed password
        $updateQuery = $con->prepare("UPDATE `userdata` SET password = ? WHERE id = ?");
        $updateQuery->bind_param("si", $hashedPassword, $userId);

        if ($updateQuery->execute()) {
            echo "Password hashed and updated successfully for user ID: " . $userId . "<br>";
        } else {
            echo "Error updating password for user ID: " . $userId . ": " . $updateQuery->error . "<br>";
        }
    }
} else {
    echo "Admin user not found.";
}

$con->close();
?>
