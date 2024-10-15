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

            $filename = 'comments.txt';

            $comments = [];
            if (file_exists($filename)) {
                $comments = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $newComment = htmlspecialchars(trim($_POST['comment']));

                file_put_contents($filename, $newComment . PHP_EOL, FILE_APPEND);

                echo "<p>" . htmlspecialchars($newComment) . "</p>";
            }

            foreach ($comments as $c) {
                echo "<p>" . htmlspecialchars($c) . "</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>