<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/pollresults.css">

    <title>Poll Results</title>
</head>
<body>
    <div class="container">
        <?php
        session_start();
        include('../settings/connect.php');

        // Retrieve vote counts for each option from the "polls" table
        $sql = "SELECT first_option, second_option, third_option, fourth_option FROM polls";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Initialize variables to track max count and option
            $max_count = 0;
            $max_option = '';
            $option_statistics = array();

            // Fetch the poll data
            $poll_data = mysqli_fetch_assoc($result);

            // Loop through the options and count votes
            foreach ($poll_data as $option => $count) {
                // Calculate the count for each option
                $option_count = (int)$count;

                // Update statistics for the option
                $option_statistics[$poll_data[$option]] = $option_count;

                // Update max count and option if the current count is higher
                if ($option_count > $max_count) {
                    $max_count = $option_count;
                    $max_option = $poll_data[$option];
                }
            }

            // Display the statistics for each option
            echo "<h1>Poll Results</h1>";
            echo "<ul>";
            foreach ($option_statistics as $option => $count) {
                $class = ($option === $max_option) ? 'highlight' : '';
                echo "<li class='option $class'>$option: $count votes</li>";
            }
            echo "</ul>";

            // Display the option with the highest count
            if (!empty($max_option)) {
                echo "<p>The option with the highest selection count is: <span class='highlight'>$max_option</span> with $max_count votes.</p>";
            } else {
                echo "<p>No votes recorded yet.</p>";
            }
        } else {
            echo "No votes recorded yet.";
        }
        ?>
    </div>
</body>
</html>
