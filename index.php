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
            // File to store comments
            $filename = 'comments.txt';

            // Load existing comments into an array
            $comments = [];
            if (file_exists($filename)) {
                $comments = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            }

            // Handle form submission
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get the comment from the POST request
                $newComment = htmlspecialchars($_POST['comment']); // Sanitize input

                // Check if the comment is not a duplicate
                if (!in_array($newComment, $comments)) {
                    // Save the comment to the file
                    file_put_contents($filename, $newComment . PHP_EOL, FILE_APPEND);
                    // Add to the array to avoid duplication on page reload
                    $comments[] = $newComment;
                }
            }

            // Display comments
            foreach ($comments as $c) {
                echo "<p>" . htmlspecialchars($c) . "</p>"; // Display each comment
            }
            ?>
        </div>
    </div>
</body>

</html>