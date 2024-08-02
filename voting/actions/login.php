<?php
session_start();
include('../settings/connect.php');

$username = $_POST['username'];
$mobile = $_POST['mobile'];
$password = $_POST['password'];

// Use prepared statements to prevent SQL injection for userdata table
$stmt = $con->prepare("SELECT * FROM `userdata` WHERE username = ? AND mobile = ?");
$stmt->bind_param("ss", $username, $mobile);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    $hashed_password = $data['password']; // Hashed password

    // Verify the password for userdata
    if (password_verify($password, $hashed_password)) {
        $_SESSION['id'] = $data['id'];
        $_SESSION['status'] = $data['status'];
        $_SESSION['data'] = $data;
        $_SESSION['standard'] = $data['standard'];

        // Check if the user is an admin
        if ($data['standard'] == "admin") {
            header("Location: ../admin/admindashboard.php");
            exit;
        } elseif ($data['standard'] == "poll creator") {
            header("Location: ../partials/createpolldashboard.php");
            exit;
        } elseif ($data['standard'] == "single voter") {
            // Display modal and options
            echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Engage Dialog</title>
                <style>
                    /* Modal styles */
                    .modal {
                        display: none;
                        position: fixed;
                        z-index: 1000;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0, 0, 0, 0.5);
                    }
                    .modal-content {
                        background-color: white;
                        margin: 25% auto;
                        padding: 20px;
                        border: 1px solid #888;
                        width: 50%;
                        text-align: center;
                    }
                    .button {
                        margin: 10px;
                        padding: 10px 20px;
                        cursor: pointer;
                    }
                </style>
            </head>
            <body>
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <p>Do you want to engage in Elections or Polls?</p>
                        <button class="button" id="electionsButton">Elections</button>
                        <button class="button" id="pollsButton">Polls</button>
                    </div>
                </div>

                <script>
                    // Get the modal
                    var modal = document.getElementById("modal");

                    // Get the buttons
                    var electionsButton = document.getElementById("electionsButton");
                    var pollsButton = document.getElementById("pollsButton");

                    // When the user clicks the Elections button, redirect to dashboard.php
                    electionsButton.onclick = function() {
                        window.location = "../partials/dashboard.php";
                    }

                    // When the user clicks the Polls button, redirect to pollsvoting.php
                    pollsButton.onclick = function() {
                        window.location = "pollsvoting.php";
                    }

                    // Display the modal
                    modal.style.display = "block";
                </script>
            </body>
            </html>';
            exit;
        }
    } else {
        echo '<script>alert("Invalid credentials 1"); window.location = "../";</script>';
    }
} else {
    echo '<script>alert("Invalid credentials 2"); window.location = "../";</script>';
}
?>
