<?php
session_start();
require_once 'include/dbh.inc.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please log in to add items to your cart.']);
    exit;
}

$userId = $_SESSION['user_id'];
$productId = intval($_POST['product_id']);
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

try {
    // Check if the product already exists in the cart
    $stmt = $pdo->prepare("SELECT * FROM tbcart WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cartItem) {
        // Update quantity if item already exists in the cart
        $stmt = $pdo->prepare("UPDATE tbcart SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['quantity' => $quantity, 'user_id' => $userId, 'product_id' => $productId]);
    } else {
        // Insert new item into the cart
        $stmt = $pdo->prepare("INSERT INTO tbcart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    echo json_encode(['status' => 'success', 'message' => 'Product added to cart.']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error adding to cart: ' . $e->getMessage()]);
}
?>
