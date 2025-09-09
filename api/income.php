<?php
header('Content-Type: application/json');
include 'config.php';

// Handle POST to add income
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $desc = $data['description'] ?? '';
    $amt = $data['amount'] ?? 0;

    $sql = "INSERT INTO income (description, amount) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sd", $desc, $amt);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Income added']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add income']);
    }
    exit;
}

// Handle GET to fetch income
$result = $conn->query("SELECT * FROM income");
$income = [];
while ($row = $result->fetch_assoc()) {
    $income[] = ['description' => $row['description'], 'amount' => floatval($row['amount'])];

}
echo json_encode($income);
?>
