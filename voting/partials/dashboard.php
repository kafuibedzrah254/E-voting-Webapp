<?php
session_start();
if(!isset($_SESSION['id'])){
    header('location:../');
}

$data = $_SESSION['data'];
$loggedInId = $data['id'];

if($_SESSION['status'] == 1){
    $status = '<b class="text-success">Voted</b>';
}else{
    $status = ''; // Initialize $status variable if $_SESSION['status'] is not 1
}

// Connect to the database
$servername = "localhost:3308";
$username = "root";
$password = "";
$dbname = "votingsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, username, photo FROM candidates2 WHERE standard = 'candidate' AND id != $loggedInId";
$result = $conn->query($sql);

$candidates = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $candidates[] = $row;
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Voting system- Dashboard</title>
    <!-- Bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"  rel="stylesheet">
    <link rel="stylesheet" href="../style.css">

</head>
<body class="bg-primary text-light">
<div class="container my-5">
<a href="../"><button class="btn btn-dark text-light px-4">Back</button></a>
<a href="logout.php"><button class="btn btn-dark text-light px-4">Logout</button></a>

<h1 class="my-3">E-Voting System</h1>

<div class="row my-5">
    <div class="col-md-7">

        <?php
        if(!empty($candidates)){
           foreach($candidates as $candidate){
        ?>  
            <div class="row">
            <div class="col-md-4">
                <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($candidate['photo']).'" alt="Candidate photo">'; ?>
            </div>
            <div class="col-md-8">
                <strong class="text-dark h5">Candidate Name:</strong>
                <?php echo $candidate['username']; ?>
                <br>
                <form action="../actions/voting.php" method="POST">
                    <input type="hidden" name="candidate_id" value="<?php echo $candidate['id']; ?>">
                    <button type="submit" class="btn btn-primary" style="background-color: red;">Vote</button>                
                </form>
                <br>
            </div>
            </div>
            <?php
           }

        }

        else{
            ?>

            <div class="container">
                <p>No candidates to display</p>
            </div>
        <?php
        }
        ?>
        <!--candidates-->
    </div>

    <div class="col-md-5">
                <!--user profile-->
                <img src="../uploads/<?php echo $data['photo']; ?>" alt="User image">
                <br>
                <br>
                <strong class="text-dark h5"> Name:</strong>
                <?php echo $data['username']; ?>

                <br><br>
                <strong class="text-dark h5"> Mobile:</strong>
                <?php echo $data['mobile']; ?>

                
                <br><br>
                <strong class="text-dark h5"> Status:</strong>
                <?php echo $status; ?>

                
                <br><br>




    </div>

</div>
</div>
</body>
</html>
