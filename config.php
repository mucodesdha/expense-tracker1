<?php
$servername = "localhost";
$dbname = "expense_tracker"; // your database name
$username = "root"; // usually 'root' in XAMPP
$password = "";     // leave empty if no password

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
