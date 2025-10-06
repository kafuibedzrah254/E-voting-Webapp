<?php
session_start();
include('../settings/connect.php');

// Check if user is logged in and authorized
// Ensure your authorization logic here

// Determine which section to load based on the request
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admindashboard.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>
    <nav>
        <ul>
            <li><a href="./adminactions.php" class="nav-link" data-section="database_analytics">Admin Dashboard</a></li>
            <li><a href="./adminactions.php" class="nav-link" data-section="voters">Voters</a></li>
            <li><a href="./adminactions.php" class="nav-link" data-section="candidates">Candidates</a></li>
            <li><a href="../partials/logout.php">Logout</a></li>
        </ul>
    </nav>
    <section id="dashboard-content">
        <!-- Initial content or a welcome message -->
        <div class="section">
            <h2>Welcome to the Admin Dashboard</h2>
            <p>Select a section from the navigation menu to view the details.</p>
        </div>
    </section>
</body>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const links = document.querySelectorAll(".nav-link");
    const content = document.getElementById("dashboard-content");

    links.forEach(link => {
        link.addEventListener("click", function(e) {
            e.preventDefault();
            const section = this.getAttribute("data-section");

            fetch(`adminactions.php?section=${section}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    let html = '';
                    if (data.error) {
                        html = `<div class="section"><p>${data.error}</p></div>`;
                    } else if (section === 'database_analytics') {
                        html = `
                            <div class="section">
                                <h2>Database Analytics</h2>
                                <p>Number of Users: ${data.userdata}</p>
                                <p>Number of Candidates: ${data.candidates}</p>
                                <p>Number of Polls: ${data.polls}</p>
                            </div>
                        `;
                    } else if (section === 'candidates') {
                        if (data.length === 0) {
                            html = '<div class="section"><h2>Candidates and Their Total Votes</h2><p>No candidates found.</p></div>';
                        } else {
                            html = '<div class="section"><h2>Candidates and Their Total Votes</h2><table><tr><th>Username</th><th>Photo</th><th>Total Votes</th></tr>';
                            data.forEach(row => {
                                html += `<tr>
                                        <td>${row.username}</td>
                                        <td><img src="data:image/jpeg;base64,${row.photo}" alt="Candidate Photo" style="width: 50px; height: 50px;"></td>
                                        <td>${row.total_votes}</td> <!-- FIXED THIS LINE -->
                                        </tr>`;
                            });
                            html += '</table></div>';
                        }
                    } else if (section === 'polls') {
                        if (data.length === 0) {
                            html = '<div class="section"><h2>Poll Results</h2><p>No polls found.</p></div>';
                        } else {
                            html = '<div class="section"><h2>Poll Results</h2><table><tr><th>Poll Question</th><th>Options</th></tr>';
                            data.forEach(row => {
                                html += `<tr><td>${row.question}</td><td>1. ${row.first_option}<br>2. ${row.second_option}<br>3. ${row.third_option}<br>4. ${row.fourth_option}</td></tr>`;
                            });
                            html += '</table></div>';
                        }
                    } else if (section === 'voters') {
                        if (data.length === 0) {
                            html = '<div class="section"><h2>Voters</h2><p>No voters found.</p></div>';
                        } else {
                            html = '<div class="section"><h2>Voters</h2><table><tr><th>Username</th><th>Email</th><th>Status</th><th>Photo</th><th>Actions</th></tr>';
                            data.forEach(row => {
                                html += `<tr><td>${row.username}</td><td>${row.email}</td><td>${row.status}</td><td><img src="data:image/jpeg;base64,${row.photo}" alt="Voter Photo" style="width: 50px; height: 50px;"></td><td><button class="delete-button" data-username="${row.username}">Delete</button></td></tr>`;
                            });
                            html += '</table></div>';
                        }
                    }
                    content.innerHTML = html;

                    // Add event listeners to delete buttons
                    const deleteButtons = document.querySelectorAll(".delete-button");
                    deleteButtons.forEach(button => {
                        button.addEventListener("click", function() {
                            const username = this.getAttribute("data-username");
                            if (confirm(`Are you sure you want to delete voter ${username}?`)) {
                                fetch(`adminactions.php?section=delete_voter&username=${username}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert(data.success);
                                            // Reload the voters section
                                            document.querySelector('[data-section="voters"]').click();
                                        } else {
                                            alert(data.error);
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error deleting voter:', error);
                                    });
                            }
                        });
                    });
                })
                .catch(error => {
                    console.error('Error loading content:', error);
                    content.innerHTML = `<div class="section"><p>Error loading content: ${error.message}</p></div>`;
                });
        });
    });
});
</script>
</html>