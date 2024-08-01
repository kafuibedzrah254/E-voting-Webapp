<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Polls</title>
    <link rel="stylesheet" href="../css/pollsvoting.css">

</head>
<body>
    <div class="container">
        <?php
        session_start();
        include('../settings/connect.php');

        // Retrieve poll question and options from the database
        $sql = "SELECT question, first_option, second_option, third_option, fourth_option FROM polls";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Fetch the data
            $poll_data = mysqli_fetch_assoc($result);
            $question = $poll_data['question'];
            $options = array(
                $poll_data['first_option'],
                $poll_data['second_option'],
                $poll_data['third_option'],
                $poll_data['fourth_option']
            );
        ?>
            <h1>Poll Question:</h1>
            <p><?php echo $question; ?></p>

            <h2>Options:</h2>
            <form action="poll_results.php" method="POST">
                <?php foreach ($options as $index => $option) : ?>
                    <input type="radio" name="vote" value="<?php echo $index; ?>" id="option<?php echo $index; ?>">
                    <label for="option<?php echo $index; ?>"><?php echo $option; ?></label><br>
                <?php endforeach; ?>
                <button type="submit">Vote</button>
            </form>
        <?php
        } else {
            echo "No poll available.";
        }
        ?>
    </div>
</body>
</html>
