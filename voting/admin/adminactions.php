<?php
include('../settings/connect.php');

// Function to get candidates data
function getCandidatesData($con) {
    $voters_query = "SELECT username, photo, votes FROM candidates2";
    $voters_result = mysqli_query($con, $voters_query);
    
    if (!$voters_result) {
        return ['error' => 'Failed to fetch voters data: ' . mysqli_error($con)];
    }
    
    $data = [];
    while ($row = mysqli_fetch_assoc($voters_result)) {
        // Ensure the photo data is base64 encoded
        $row['photo'] = base64_encode($row['photo']);
        $data[] = $row;
    }
    
    return $data;
}

// Function to get polls data
function getPollsData($con) {
    $polls_query = "SELECT question, first_option, second_option, third_option, fourth_option FROM polls";
    $polls_result = mysqli_query($con, $polls_query);
    
    if (!$polls_result) {
        return ['error' => 'Failed to fetch polls data: ' . mysqli_error($con)];
    }
    
    $data = [];
    while ($row = mysqli_fetch_assoc($polls_result)) {
        $data[] = $row;
    }
    
    return $data;
}

// Function to get database analytics data
function getDatabaseAnalytics($con) {
    $userdata_count = mysqli_query($con, "SELECT COUNT(*) as count FROM userdata");
    $candidates2_count = mysqli_query($con, "SELECT COUNT(*) as count FROM candidates2");
    $polls_count = mysqli_query($con, "SELECT COUNT(*) as count FROM polls");

    if (!$userdata_count || !$candidates2_count || !$polls_count) {
        return ['error' => 'Failed to fetch database analytics data: ' . mysqli_error($con)];
    }

    return [
        'userdata' => mysqli_fetch_assoc($userdata_count)['count'],
        'candidates2' => mysqli_fetch_assoc($candidates2_count)['count'],
        'polls' => mysqli_fetch_assoc($polls_count)['count']
    ];
}

// Function to get voters data
function getVotersData($con) {
    $voters_query = "SELECT username, email, status, photo FROM userdata";
    $voters_result = mysqli_query($con, $voters_query);
    
    if (!$voters_result) {
        error_log('Query Error: ' . mysqli_error($con)); // Log query error
        return ['error' => 'Failed to fetch voters data: ' . mysqli_error($con)];
    }
    
    $data = [];
    while ($row = mysqli_fetch_assoc($voters_result)) {
        // Ensure the photo data is base64 encoded
        $row['photo'] = base64_encode($row['photo']);
        error_log('Fetched Row: ' . print_r($row, true)); // Log fetched row
        $data[] = $row;
    }
    
    return $data;
}

// Function to delete a voter by username
function deleteVoter($con, $username) {
    $query = "DELETE FROM userdata WHERE username = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $username);
    return $stmt->execute();
}

header('Content-Type: application/json');
$response = [];

if (isset($_GET['section'])) {
    $section = $_GET['section'];
    switch ($section) {
        case 'candidates':
            $response = getCandidatesData($con);
            break;
        case 'polls':
            $response = getPollsData($con);
            break;
        case 'database_analytics':
            $response = getDatabaseAnalytics($con);
            break;
        case 'voters':
            $response = getVotersData($con);
            break;
        case 'delete_voter':
            if (isset($_GET['username'])) {
                $username = $_GET['username'];
                if (deleteVoter($con, $username)) {
                    $response = ['success' => 'Voter deleted successfully'];
                } else {
                    $response = ['error' => 'Failed to delete voter'];
                }
            } else {
                $response = ['error' => 'Username not specified'];
            }
            break;
        default:
            $response = ['error' => 'Invalid section'];
            break;
    }
} else {
    $response = ['error' => 'No section specified'];
}

echo json_encode($response);
exit;
?>
