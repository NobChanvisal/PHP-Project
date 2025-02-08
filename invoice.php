<?php
session_start();
require_once 'include/dbh.inc.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in to view the invoice.");
}

// Get the order ID from the query parameter
if (!isset($_GET['order_id'])) {
    die("Invalid request. Order ID is missing.");
}
$orderID = $_GET['order_id'];

// Fetch payment details from the database
try {
    $stmt = $pdo->prepare("SELECT * FROM tbcheckout WHERE order_id = :order_id AND user_id = :user_id");
    $stmt->execute([
        'order_id' => $orderID,
        'user_id' => $_SESSION['user_id']
    ]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        die("Order not found.");
    }

    // Decode product items
    $productItems = json_decode($order['product_items'], true);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php'; ?>
<body>
<?php include 'include/header.inc.php'; ?>
<main class=" pt-[120px]">
    
    <div class="bg-white rounded-lg shadow-lg px-8 py-10 max-w-xl mx-auto">
      <div class="flex items-center justify-between mb-8">
          <div class="pl-10 flex items-center">
                <div class="flex lg:flex-1">
                <a href="index.php" class="-m-1.5 p-1.5 border-2 border-black rounded-full">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-lamp"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 20h6" /><path d="M12 20v-8" /><path d="M5 12h14l-4 -8h-6z" /></svg>
                </a>
                </div>
          </div>
          <div class="text-gray-700">
              <div class="font-bold text-xl mb-2">INVOICE</div>
              <div class="text-sm flex items-center">
                    <p class=" w-16">Date</p> 
                    <span>: <?php echo htmlspecialchars($order['created_at']); ?></span>
              </div>
     
              <div class="text-sm flex items-center">
                <p class=" w-16">Invoice </p>
                <span>: # <?php echo htmlspecialchars($order['id']); ?></span> 
              </div>
          </div>
      </div>
      <div class="border-b-2 border-gray-300 pb-8 mb-8">
          <h2 class="text-2xl font-bold mb-4">Bill To:</h2>
          <div class="text-gray-700 capitalize mb-2"><?= $_SESSION['username'] ?></div>
          <div class="text-gray-700 mb-2"><?php echo htmlspecialchars($order['address']); ?></div>
          <div class="text-gray-700"><?= $_SESSION['email']?></div>
      </div>
      <table class="w-full border-collapse">
        <thead class=" text-sm font-medium text-gray-900 bg-gray-100 border-t border-b border-gray-200">
            <tr class="">
                <th class="p-3 text-left">Product</th>
                <th class="p-3 text-left">Quantity</th>
                <th class="p-3 text-left">Price</th>
                <th class="p-3 text-left">Total</th>
            </tr>
        </thead>
        <tbody>
                <?php foreach ($productItems as $item): ?>
                    <tr class="border-b border-gray-200">
                        <td class="p-3"><?php echo htmlspecialchars($item['pro_name']); ?></td>
                        <td class="p-3"><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td class="p-3">$<?php echo number_format($item['price'], 2); ?></td>
                        <td class="p-3">$<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
          </tbody>
      </table>
      <div class="flex justify-end mt-8 mb-2">
          <div class="text-gray-700 mr-2">Store Pickup:</div>
          <div class="text-gray-700">$10</div>
      </div>
      <div class="flex justify-end mb-2">
          <div class="text-gray-700 mr-2">Tax:</div>
          <div class="text-gray-700">5%</div>
      </div>
      <div class="flex justify-end mb-2">
          <div class="text-gray-700 mr-2">Total:</div>
          <div class="text-gray-700 font-bold">$<?php echo number_format($order['total_amount'], 2);?></div>
      </div>
  </div>
  <div class=" text-center mt-10">
    <a href="Shop.php" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
    back to shopping
    </a>
  </div>
</main>
<?php include 'include/footer.inc.php'; ?>
</body>
</html>