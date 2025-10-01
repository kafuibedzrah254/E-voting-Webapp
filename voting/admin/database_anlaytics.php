<?php
session_start();
include('../settings/connect.php');

// Check if user is logged in and authorized
// Ensure your authorization logic here

// Fetch the number of rows in userdata table
$userdata_query = "SELECT COUNT(*) as count FROM userdata";
$userdata_result = mysqli_query($con, $userdata_query);
$userdata_count = mysqli_fetch_assoc($userdata_result)['count'];

// Fetch the number of rows in candidates table
$candidates_query = "SELECT COUNT(*) as count FROM candidates";
$candidates_result = mysqli_query($con, $candidates_query);
$candidates_count = mysqli_fetch_assoc($candidates_result)['count'];

// Fetch the number of rows in polls table
$polls_query = "SELECT COUNT(*) as count FROM polls";
$polls_result = mysqli_query($con, $polls_query);
$polls_count = mysqli_fetch_assoc($polls_result)['count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/database_anlaytics.css">
</head>
<body>
    <header>
        <!-- The Admin Dashboard text has been removed -->
    </header>
    <nav>
        <ul>
            <li><a href="#">Voters</a></li>
            <li><a href="#">Candidates</a></li>
            <li><a href="#">View Results</a></li>
            <li><a href="#">Positions</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <section id="dashboard-content">
        <!-- Displaying the counts -->
        <div class="section">
            <h2>Database Analytics</h2>
            <table>
                <tr>
                    <th>Table Name</th>
                    <th>Number of Records</th>
                </tr>
                <tr>
                    <td>Users</td>
                    <td><?php echo $userdata_count; ?></td>
                </tr>
                <tr>
                    <td>Candidates</td>
                    <td><?php echo $candidates_count; ?></td>
                </tr>
                <tr>
                    <td>Polls</td>
                    <td><?php echo $polls_count; ?></td>
                </tr>
            </table>
        </div>
        <!-- Candidates and their total votes -->
        <div class="section">
            <h2>Candidates and Their Total Votes</h2>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Photo</th>
                    <th>Total Votes</th>
                </tr>
                <?php
                $candidates_data_query = "SELECT username, photo, votes FROM candidates";
                $candidates_data_result = mysqli_query($con, $candidates_data_query);
                while ($row = mysqli_fetch_assoc($candidates_data_result)) { ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['photo']); ?>" alt="Candidate Photo"></td>
                    <td><?php echo $row['votes']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <!-- Poll results -->
        <div class="section">
            <h2>Poll Results</h2>
            <table>
                <tr>
                    <th>Poll Question</th>
                    <th>Options</th>
                </tr>
                <?php
                $polls_data_query = "SELECT question, first_option, second_option, third_option, fourth_option FROM polls";
                $polls_data_result = mysqli_query($con, $polls_data_query);
                while ($row = mysqli_fetch_assoc($polls_data_result)) { ?>
                <tr>
                    <td><?php echo $row['question']; ?></td>
                    <td>
                        <?php
                        echo "1. " . $row['first_option'] . "<br>";
                        echo "2. " . $row['second_option'] . "<br>";
                        echo "3. " . $row['third_option'] . "<br>";
                        echo "4. " . $row['fourth_option'];
                        ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </section>
</body>
</html>
