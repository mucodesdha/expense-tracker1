<?php
require_once 'config.php';

echo "<h2>Database Connection Test</h2>";

if ($conn) {
    echo "<p style='color: green;'>✅ Database connected successfully!</p>";
    
    // Test if we can see our tables
    $result = $conn->query("SHOW TABLES");
    echo "<h3>Tables in database:</h3>";
    echo "<ul>";
    while ($row = $result->fetch_array()) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
    
    // Test if we can see our test user
    $result = $conn->query("SELECT username FROM users");
    echo "<h3>Users in database:</h3>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['username'] . "</li>";
    }
    echo "</ul>";
    
} else {
    echo "<p style='color: red;'>❌ Database connection failed!</p>";
}
?>