<?php
ob_start(); // Start output buffering

$filename = 'comments.txt';

// Load existing comments into an array
$comments = [];
if (file_exists($filename)) {
    $comments = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newComment = htmlspecialchars(trim($_POST['comment']));

    // Save the new comment to the file
    file_put_contents($filename, $newComment . PHP_EOL, FILE_APPEND);

    // Redirect to the same page to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
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
    <div id="comments">
        <h2>Comments</h2>
        <form action="" method="POST" id="comment-form">
            <label for="comment">Add a Comment:</label>
            <textarea id="comment" name="comment" required></textarea>
            <button type="submit">Submit</button>
        </form>
        <div id="comment-list">
            <?php
            // Display all comments in the correct order
            foreach ($comments as $c) {
                echo "<p>" . htmlspecialchars($c) . "</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>