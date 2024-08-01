<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Poll</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Create a Poll</h2>
        <form action="../actions/create_poll.php" id="pollForm" method="POST">
            <div class="mb-3">
                <label for="question" class="form-label">Poll Question:</label>
                <input type="text" class="form-control" id="question" name="question" required>
            </div>
            <div class="mb-3">
                <label for="options" class="form-label">Options:</label>
                <input type="text" class="form-control mb-2" name="option1" required>
                <input type="text" class="form-control mb-2" name="option2" required>
                <input type="text" class="form-control mb-2" name="option3" required>
                <input type="text" class="form-control mb-2" name="option4" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Poll</button>
        </form>
    </div>
</body>
</html>
