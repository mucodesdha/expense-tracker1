<?php
header('Content-Type: application/json');
include 'config.php';

// Handle POST to add expense
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $desc = $data['description'] ?? '';
    $amt = $data['amount'] ?? 0;

    $sql = "INSERT INTO expenses (description, amount) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sd", $desc, $amt);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Expense added']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add expense']);
    }
    exit;
}

// Handle GET to fetch expenses
$result = $conn->query("SELECT * FROM expenses");
$expenses = [];
while ($row = $result->fetch_assoc()) {
    $expenses[] = ['description' => $row['description'], 'amount' => floatval($row['amount'])];

}
echo json_encode($expenses);
?>
