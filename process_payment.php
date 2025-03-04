<?php
session_start();
require_once 'DB_lib/Database.php'; 

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
$deliveryDetails = $data['delivery_details'];
$address = $deliveryDetails['country'] . ", " . $deliveryDetails['city'];

try {
    $db = new Database(); 

    // Insert payment 
    $checkoutData = [
        'user_id' => $userId,
        'payer_id' => $payerID,
        'order_id' => $orderID,
        'total_amount' => $totalAmount,
        'payment_status' => 'Paid',
        'product_items' => $productItems,
        'address' => $address
    ];

    $db->insert('tbcheckout', $checkoutData);

    
    $where = 'user_id = :user_id';
    $params = ['user_id' => $userId];
    $db->delete('tbcart', $where, $params);

    echo json_encode(['status' => 'success', 'message' => 'Payment recorded']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>