<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'finalproject');

if ($db->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $db->connect_error]);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'], $_POST['quantity'])) {
    $userId = $_SESSION['user_id'] ?? 0; // Use 0 for guests
    $productId = intval($_POST['productId']);
    $quantity = intval($_POST['quantity']);

    $stmt = $db->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
    $stmt->bind_param("iii", $userId, $productId, $quantity);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product added to cart successfully."]);
    } else {
        echo json_encode(["success" => false, "error" => "Error adding product to cart: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
}

$db->close();
?>
