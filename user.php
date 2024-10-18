<?php

class User
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function register($username, $password): bool
    {
        $username = htmlspecialchars(trim($username));
        $hashedPassword = password_hash(trim($password), PASSWORD_DEFAULT);

        // Check if username already exists
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Insert new user
            $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashedPassword);
            $stmt->execute();
            return true;
        } else {
            return false; // Username already taken
        }
    }

    public function login($username, $password): ?array
    {
        $username = htmlspecialchars(trim($username));

        // Retrieve user from database
        $stmt = $this->conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            // Verify password
            if (password_verify(trim($password), $user['password'])) {
                return ['id' => $user['id'], 'username' => $username];
            }
        }
        return null; // Invalid username/password
    }
}