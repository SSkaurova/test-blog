<?php
session_start();
require 'db_connection.php'; // Your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);

    // Retrieve user from database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            header("Location: index.php"); // Redirect to main page
            exit();
        } else {
            $_SESSION['message'] = "Invalid password.";
        }
    } else {
        $_SESSION['message'] = "User not found.";
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
        <a href="register.php" class="register-link">Register</a></p>
    </div>
</div>
    <?php if (isset($_SESSION['message'])): ?>
        <p><?php echo $_SESSION['message'];
        unset($_SESSION['message']); ?></p>
    <?php endif; ?>
</body>

</html>