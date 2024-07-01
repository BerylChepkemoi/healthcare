<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <form action="feedback.php" method="post">
        <h2>Feedback</h2>
        <label for="rating">Rating:</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>
        <label for="comments">Comments:</label>
        <textarea id="comments" name="comments" required></textarea>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
