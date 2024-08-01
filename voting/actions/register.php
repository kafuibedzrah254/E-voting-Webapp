<?php
include('../settings/connect.php');

$username= $_POST['username'];
$mobile= $_POST['mobile'];
$email=$_POST['email'];
$password= $_POST['password'];
$cpassword= $_POST['cpassword'];
$image= $_FILES['photo']['name'];
$tmp_name= $_FILES['photo']['tmp_name'];
$std= $_POST['std'];

if($password != $cpassword){
    echo '<script>
    alert ("Passwords do not match");
    window.location = "../partials/registration.php";
    </script>';
    exit;
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Move uploaded file to destination folder
move_uploaded_file($tmp_name, "../uploads/$image");

// Insert user data into database
$sql = "INSERT INTO `userdata` (username,email, mobile, password, photo, standard, status)  
        VALUES ('$username','$email','$mobile', '$hashed_password', '$image', '$std', 0)";

$result = mysqli_query($con, $sql);

if($result){
    echo '<script>
    alert ("Registration successful");
    window.location = "../";
    </script>';
} else {
    die("Connection failed: " . mysqli_error($con));
}

mysqli_close($con);
?>
