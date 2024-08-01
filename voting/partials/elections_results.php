<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Voting system - Election Results</title>
    <!-- Bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">

</head>
<body class="bg-primary text-light">
<div class="container my-5">
    <a href="../"><button class="btn btn-dark text-light px-4">Back</button></a>
    <a href="logout.php"><button class="btn btn-dark text-light px-4">Logout</button></a>

    <h1 class="my-3">E-Voting System - Election Results</h1>

    <div class="row my-5">
        <div class="col-md-7">

            <?php
            if (isset($_SESSION['groups'])) {
                $groups = $_SESSION['groups'];
                for ($i = 0; $i < count($groups); $i++) {
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="../uploads/<?php echo $groups[$i]['photo']; ?>" alt="Group image">
                        </div>
                        <div class="col-md-8">
                            <strong class="text-dark h5">Group name:</strong>
                            <?php echo $groups[$i]['username']; ?>
                            <br>
                            <strong class="text-dark h5">Votes:</strong>
                            <?php echo $groups[$i]['votes']; ?>
                            <br>
                        </div>
                    </div>
                    <hr>
                    <?php
                }
            } else {
                ?>
                <div class="container">
                    <p>No groups to display</p>
                </div>
                <?php
            }
            ?>

            <hr>
        </div>

        <div class="col-md-5">
            <!-- Winning Group -->
            <h3 class="text-center">Winning Group</h3>
            <?php
            if (!empty($winning_group)) {
                echo "<p>The group with the highest votes is: <span class='text-success'>$winning_group</span> with $max_votes votes.</p>";
            } else {
                echo "<p>No votes recorded yet.</p>";
            }
            ?>
        </div>

    </div>
</div>
</body>
</html>
