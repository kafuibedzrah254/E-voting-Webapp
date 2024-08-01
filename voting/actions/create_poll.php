<?php
session_start();
include('../settings/connect.php');

// Check if the user is logged in and authorized as a poll creator
//if (!isset($_SESSION['id']) || $_SESSION['standard'] !== 'poll creator') {
    //echo 'Unauthorized access';
   // exit;
//}

// Retrieve form data
$question = $_POST['question'];
$options = array(); // Initialize an array to store options
for ($i = 1; $i <= 4; $i++) {
    if (isset($_POST['option' . $i])) {
        $options[] = $_POST['option' . $i];
    }
}

// Insert poll question and options into polls table using parameterized query
$insert_poll_query = "INSERT INTO `polls` (question, first_option, second_option, third_option, fourth_option) VALUES (?, ?, ?, ?, ?)";
$stmt_poll = mysqli_prepare($con, $insert_poll_query);
mysqli_stmt_bind_param($stmt_poll, "sssss", $question, $options[0], $options[1], $options[2], $options[3]);

// Execute the prepared statement for the poll question and options
if (mysqli_stmt_execute($stmt_poll)) {
    echo '<script>alert("Poll Created Successfully!"); window.location.href="../partials/createpolldashboard.php";</script>';
} else {
    echo 'Error: ' . mysqli_error($con);
}
?>
