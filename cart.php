<?php
session_start();
require_once './DB_lib/Database.php';

$db = new Database();

if (!isset($_SESSION['user_id'])) {
    die("Please log in to view your cart.");
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pro_id'])) {
    $proId = $_POST['pro_id']; 
    $result = $db->delete("tbcart", "product_id = :id AND user_id = :userid ", [':id'=>$proId, ':userid'=>$userId]); 
    if ($result) {
        echo "Item successfully removed from cart.";
    } else {
        echo "Failed to remove item from cart.";
    }

    header("Location: cart.php"); 
    exit(); 
}

// Fetch cart items
$cartItems = $db->query(
    "SELECT tbcart.id AS cart_id,tbproducts.id, tbproducts.pro_name, tbproducts.price, tbproducts.imageUrl, tbcart.quantity 
     FROM tbcart 
     JOIN tbproducts ON tbcart.product_id = tbproducts.id 
     WHERE tbcart.user_id = :user_id",
    ['user_id' => $userId]
);

if (is_string($cartItems)) {
    die("Query failed: " . $cartItems);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php'; ?>
<body>
<?php include 'include/header.inc.php'; ?>
<?php if (!empty($cartItems)) :  ?>
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
                    <div class=" pl-2">
                        <p><?php echo $item['pro_name']; ?></p>
                    </div>
                </div>
            </td>
            <td class="p-2">$<?php echo $item['price']; ?></td>
            <td class="p-2"><?php echo $item['quantity']; ?></td>
            <td>
                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                    <input type="hidden" name="pro_id" value="<?php echo $item['id']; ?>">
                    <button type="submit" class="font-medium cursor-pointer text-red-600 hover:underline">Remove</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <form action="checkout.php" method="POST" class="text-center mt-6">
        <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded">Proceed to Checkout</button>
    </form>
    </section>
    <?php else : ?>
        <section class="max-w-screen-lg pt-[120px] mx-auto p-6 bg-white text-center">
            <p class="text-2xl text-gray-600">Your cart is empty!</p>
        </section>
    <?php endif; ?>
<?php include 'include/footer.inc.php'; ?>
</body>
</html>
