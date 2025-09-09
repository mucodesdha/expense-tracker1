<?php
header('Content-Type: application/json'); // ensures proper JSON response

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    session_start();
$_SESSION['user_id'] = $row['id'];
echo json_encode(['success' => true, 'message' => 'Login successful', 'user' => ['id' => $row['id'], 'username' => $row['username']]]);

    exit;
}

include 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$sql = "SELECT * FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()) {
    if(password_verify($password, $row['password'])) {
        echo json_encode(['success' => true, 'message' => 'Login successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Wrong password']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}
?>
