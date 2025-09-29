<?php
session_start();
include('../settings/connect.php');

// Check if user has already voted
if ($_SESSION['status'] == 1) {
    echo '<script>
    alert("You have already voted. You cannot vote again.");
    window.location="../partials/dashboard.php";
    </script>';
    exit;
}

$cid = (int)$_POST['candidate_id']; // Candidate ID from form
$uid = (int)$_SESSION['id'];        // User ID from session

// --- 1. Update the candidate's votes ---
$stmt = $con->prepare("UPDATE candidates SET total_votes = total_votes + 1 WHERE id = ?");
$stmt->bind_param("i", $cid);
$updatevotes = $stmt->execute();
$stmt->close();

// --- 2. Update the user's voting status ---
$stmt = $con->prepare("UPDATE userdata SET status = 1 WHERE id = ?");
$stmt->bind_param("i", $uid);
$updatestatus = $stmt->execute();
$stmt->close();

if ($updatevotes && $updatestatus) {
    // --- 3. Fetch updated candidates ---
    $stmt = $con->prepare("SELECT username, photo, total_votes, id FROM candidates WHERE standard = 'candidate'");
    $stmt->execute();
    $result = $stmt->get_result();
    $candidates = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Store in session
    $_SESSION['candidates'] = $candidates;
    $_SESSION['status'] = 1;

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
