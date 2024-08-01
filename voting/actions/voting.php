<?php
session_start();
include('../settings/connect.php');

// Check if user has already voted
if ($_SESSION['status'] == 1) {
    echo '<script>
    alert("You have already voted. You cannot vote again.");
    window.location="../partials/dashboard.php";
    </script>';
    exit; // Exit the script to prevent further execution
}



$votes = $_POST['candidate_id'];
$totalvotes = $votes + 1;

$cid = $_POST['candidate_id'];
$uid = $_SESSION['id'];

// Update the votes for the selected candidate
$updatevotes = mysqli_query($con, "UPDATE `candidates2` SET votes='$totalvotes' WHERE id='$cid' ");

// Update the status of the user to indicate that they have voted
$updatestatus = mysqli_query($con, "UPDATE `userdata` SET status=1 WHERE id='$uid' ");

if ($updatevotes && $updatestatus) {
    // Fetch updated candidate data
    $getcandidate = mysqli_query($con, "SELECT username,photo,votes,id FROM `candidates2` WHERE standard='candidate'");
    $candidates = mysqli_fetch_all($getcandidate, MYSQLI_ASSOC);
    $_SESSION['candidates'] = $candidates;
    $_SESSION['status'] = 1; // Update user's status to indicate they have voted

    echo '<script>
    alert("Voting Successful");
    window.location="../partials/dashboard.php";
    </script>';
} else {
    echo '<script>
    alert("Technical error!! Vote after sometime");
    window.location="../partials/dashboard.php";
    </script>';
}

?>
