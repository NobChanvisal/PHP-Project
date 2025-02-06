<?php
session_start();
require_once 'include/dbh.inc.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in to view your cart.");
}

$userId = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT tbcart.id AS cart_id, tbproducts.pro_name, tbproducts.price, tbproducts.imageUrl, tbcart.quantity 
                           FROM tbcart 
                           JOIN tbproducts ON tbcart.product_id = tbproducts.id 
                           WHERE tbcart.user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php'; ?>
<body>
<?php include 'include/header.inc.php'; ?>
<section class="max-w-screen-lg pt-[120px] mx-auto p-6 bg-white">
    <h1 class="text-4xl font-bold mb-10 text-center underline underline-offset-8">Shopping Cart</h1>
    <table class="w-full border-collapse">
        <tr class="bg-gray-50 border-b">
            <th class="p-2 text-start">Product</th>
            <th class="p-2 text-start">Price</th>
            <th class="p-2 text-start">Quantity</th>
        </tr>
        <?php foreach ($cartItems as $item): ?>
        <tr class="border-b">
            <td class="p-2 pl-1">
                <div class=" flex">
                    <img src="image/products/<?php echo $item['imageUrl'];?>"alt="Product Image" class="w-16 border border-slate-400">
                    <p class=" pl-2"><?php echo $item['pro_name']; ?></p>
                </div>
            </td>
            <td class="p-2">$<?php echo $item['price']; ?></td>
            <td class="p-2"><?php echo $item['quantity']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>
<?php include 'include/footer.inc.php'; ?>
</body>
</html>
