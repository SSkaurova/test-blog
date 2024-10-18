<?php
session_start();
require 'db_connection.php';
require 'User.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userManager = new User($conn);
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $userManager->login($username, $password);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['message'] = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="cont">
        <div id="login" class="login">
            <h2>Login</h2>
            <form method="POST" action="">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                <br>
                <button type="submit" class="login-button">Login</button>
            </form>
            <a href="register.php" class="register-link">Register</a>
            <?php if (isset($_SESSION['message'])): ?>
                <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>