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
    $status = '<b class="text-warning">Not Voted</b>'; // Added status for non-voted users
}

// Connect to the database
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "votingsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, username, photo FROM candidates WHERE standard = 'candidate' ";
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
  <title>Voting System – Dashboard</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0d6efd, #6610f2);
      min-height: 100vh;
      color: #fff;
    }
    .navbar {
      background: rgba(0,0,0,0.3);
      backdrop-filter: blur(6px);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    /* Main container */
    .dashboard-container {
      padding: 20px;
      margin-top: 80px; /* Space for fixed navbar */
    }

    /* Voter profile */
    .profile-card {
      background: rgba(255,255,255,0.95);
      color: #000;
      border-radius: 0.5rem;
      padding: 0.75rem;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
      width: 100%;
      max-width: 250px;
      margin: 0 auto 20px;
    }
    .profile-card img {
      width: 55px;
      height: 55px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #fff;
      margin-bottom: 0.25rem;
    }
    .profile-card h5 {
      font-size: 0.85rem;
      margin-bottom: 0.15rem;
    }
    .profile-card p {
      font-size: 0.7rem;
      margin-bottom: 0.25rem;
    }
    .profile-card .badge {
      font-size: 0.7rem;
    }

    /* Candidate cards */
    .candidate-card {
      transition: transform 0.2s ease;
      margin-bottom: 20px;
      display: flex;
      flex-direction: row;
      align-items: center;
      max-width: 600px;
    }
    .candidate-card img {
      width: 120px;
      height: 120px;
      object-fit: contain; /* ✅ Prevents cropping */
      object-position: center top; /* ✅ Align top to keep heads visible */
      border-radius: 0.5rem;
      background: #f8f9fa;
      margin-right: 15px;
    }
    .candidate-card:hover {
      transform: translateY(-4px);
    }
    .vote-btn {
      background: #e63946;
      border: none;
      width: 100%;
    }
    .vote-btn:hover {
      background: #d62828;
    }

    .candidate-info {
      flex: 1;
    }

    /* === Responsive behavior === */
    /* On small screens: profile above candidates */
    @media (max-width: 991px) {
      .profile-card {
        margin: 0 auto 20px;
      }
      .candidate-card {
        flex-direction: column;
        text-align: center;
      }
      .candidate-card img {
        margin-right: 0;
        margin-bottom: 15px;
        width: 100%;
        max-width: 200px;
        height: 150px;
      }
    }

    /* On large screens: profile to the far right */
    @media (min-width: 992px) {
      .dashboard-container {
        display: flex;
        gap: 30px;
        align-items: flex-start;
      }
      .candidates-section {
        flex: 2;
      }
      .profile-section {
        flex: 1;
        max-width: 280px;
        position: sticky;
        top: 100px; /* Below navbar */
      }
      .profile-card {
        margin: 0;
      }
      .candidate-card {
        flex-direction: row;
      }
      .candidate-card img {
        margin-right: 15px;
        margin-bottom: 0;
      }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark px-4">
    <a class="navbar-brand fw-bold" href="#">E-Voting</a>
    <div class="ms-auto">
      <a href="../" class="btn btn-outline-light me-2">
        <i class="fa fa-arrow-left"></i> Back
      </a>
      <a href="logout.php" class="btn btn-light text-dark">
        <i class="fa fa-sign-out-alt"></i> Logout
      </a>
    </div>
  </nav>

  <!-- Main content -->
  <div class="dashboard-container">
    <!-- Candidates section -->
    <div class="candidates-section">
      <div class="container py-3">
        <h2 class="mb-4 text-center">Welcome to the E-Voting System</h2>

        <!-- Voter profile (appears above candidates on small screens) -->
        <div class="d-lg-none">
          <div class="card profile-card">
            <img src="../uploads/<?php echo htmlspecialchars($data['photo']); ?>" alt="User Image">
            <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($data['username']); ?></h5>
            <p class="text-muted mb-1"><?php echo htmlspecialchars($data['mobile']); ?></p>
            <span class="badge bg-success px-2 py-1">
              <?php echo $status; ?>
            </span>
          </div>
        </div>

        <div class="col-lg-12">
          <h4 class="mb-3">Candidates</h4>
          <?php if (!empty($candidates)): ?>
            <div class="candidates-list">
              <?php foreach ($candidates as $candidate): ?>
                <div class="card candidate-card shadow-sm">
                  <!-- Candidate image from BLOB -->
                  <img src="data:image/jpeg;base64,<?php echo base64_encode($candidate['photo']); ?>" alt="Candidate Photo">
                  <div class="candidate-info">
                    <h5 class="card-title text-dark mb-3">
                      <i class="fa fa-user-circle text-primary me-2"></i>
                      <?php echo htmlspecialchars($candidate['username']); ?>
                    </h5>
                    <form action="../actions/voting.php" method="POST">
                      <input type="hidden" name="candidate_id" value="<?php echo $candidate['id']; ?>">
                      <button type="submit" class="btn vote-btn text-white">
                        <i class="fa fa-check-circle me-1"></i> Vote
                      </button>
                    </form>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <div class="alert alert-light text-dark mt-3">
              No candidates to display.
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Voter profile (appears on the right on large screens) -->
    <div class="profile-section d-none d-lg-block">
      <div class="card profile-card">
        <img src="../uploads/<?php echo htmlspecialchars($data['photo']); ?>" alt="User Image">
        <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($data['username']); ?></h5>
        <p class="text-muted mb-1"><?php echo htmlspecialchars($data['mobile']); ?></p>
        <span class="badge bg-success px-2 py-1">
          <?php echo $status; ?>
        </span>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
