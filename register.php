<?php
session_start();
require 'db_connection.php';
require 'User.php'; // Include the User class

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userManager = new User($conn);
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($userManager->register($username, $password)) {
        $_SESSION['message'] = "Registration successful!";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['message'] = "Username already taken.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="cont2">
        <div id="comments" class="comments">
            <h2>Register</h2>
            <form method="POST" action="">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                <br>
                <button type="submit" class="login-button">Register</button>
            </form>
            <a href="login.php" class="login-link">Login</a>
            <?php if (isset($_SESSION['message'])): ?>
                <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>