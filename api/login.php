<?php
// Start the session at the very top of the script
session_start();

header('Content-Type: application/json');
include 'config.php';

// Only proceed if the request is a POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Username and password are required.']);
        exit;
    }

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // ✅ This is the correct place for success logic
            $_SESSION['user_id'] = $row['id']; // Set the session variable
            echo json_encode(['success' => true, 'message' => 'Login successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }

} else {
    // Handle cases where the request is not POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>