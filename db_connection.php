<?php
$host = 'db'; // Use 'localhost' if you're not using Docker
$username = 'root';
$password = 'example';
$dbname = 'my_database'; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>