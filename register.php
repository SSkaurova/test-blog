<?php

session_start();
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        $_SESSION['message'] = "Registration successful! You can now log in.";
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
            <a href="login.php" class="login-link">Login</a></p>
            <?php if (isset($_SESSION['message'])): ?>
                <p><?php echo $_SESSION['message'];
                unset($_SESSION['message']); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>