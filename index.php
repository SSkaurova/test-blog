<?php
session_start();
require 'db_connection.php';
require 'commentManager.php';

ob_start();

$commentManager = new CommentManager($conn);

$comments = $commentManager->getComments();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $newComment = $POST['comment'];
    $commentManager->addComment($newComment);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$conn->close();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>My Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div id="comments" class="comments">
            <h2>Comments</h2>
            <?php if (isset($_SESSION['user_id'])): ?>
                <p>Welcome, <?php echo $_SESSION['username']; ?>! <a href="?logout">Logout</a></p>
            <?php else: ?>
                <p>You must be logged in to comment.</p>
                <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
            <?php endif; ?>
            <form action="" method="POST" id="comment-form">
                <label for="comment">Add a Comment:</label>
                <textarea id="comment" name="comment" required></textarea>
                <button type="submit">Submit</button>
            </form>
            <div id="comment-list" class="comment-list">
                <?php
                foreach ($comments as $c) {
                    echo "<p>" . htmlspecialchars($c) . "</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>