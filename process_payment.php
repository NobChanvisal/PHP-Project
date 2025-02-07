<?php
session_start();
require_once 'include/dbh.inc.php';

$data = json_decode(file_get_contents("php://input"), true);

error_log("Received data: " . print_r($data, true));
if (!$data || !isset($data['user_id'], $data['payerID'], $data['orderID'], $data['total_amount'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$userId = $data['user_id'];
$payerID = $data['payerID'];
$totalAmount = $data['total_amount'];
$orderID = $data['orderID'];
$productItems = json_encode($data['product_items']);

try {
    // Insert order into tbcheckout
    $stmt = $pdo->prepare("INSERT INTO tbcheckout (user_id, payer_id, order_id, total_amount, payment_status, product_items) 
                           VALUES (:user_id, :payerID, :orderID, :total_amount, 'Paid', :product_items)");
    $stmt->execute([
        'user_id' => $userId,
        'payerID' => $payerID,
        'orderID' => $orderID,
        'total_amount' => $totalAmount,
        'product_items' => $productItems // Store product items
    ]);

    // Remove items from tbcart
    $stmt = $pdo->prepare("DELETE FROM tbcart WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);

    echo json_encode(['status' => 'success', 'message' => 'Payment recorded']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
