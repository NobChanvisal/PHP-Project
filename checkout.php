<?php
session_start();
require_once './DB_lib/Database.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in to checkout.");
}

$userId = $_SESSION['user_id'];

try {
    $db = new Database();

    // Get total amount for PayPal payment using dbSelect
    $totalResult = $db->dbSelect(
        'tbcart JOIN tbproducts ON tbcart.product_id = tbproducts.id', // Table with JOIN
        'SUM(quantity * price) AS total_amount',                       // Columns
        'tbcart.user_id = :user_id',                                   // Criteria
        '',                                                           // Clause
        ['user_id' => $userId]                                        // Parameters
    );
    
    $totalAmount = $totalResult[0]['total_amount'] ?? 0;

    if ($totalAmount <= 0) {
        echo "Your cart is empty. <a href='Shop.php' class='bg-blue-500 text-white px-6 py-2 rounded'>Continue Shopping</a>";
        exit();
    }

    // Fetch product items from tbcart using dbSelect
    $productItems = $db->dbSelect(
        'tbcart JOIN tbproducts ON tbcart.product_id = tbproducts.id', // Table with JOIN
        'tbcart.product_id, tbproducts.pro_name, tbcart.quantity, tbproducts.price', // Columns
        'tbcart.user_id = :user_id',                                   // Criteria
        '',                                                           // Clause
        ['user_id' => $userId]                                        // Parameters
    );

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
<?php 
    $storePickup = 10; 
    $taxAmount = $totalAmount * 0.05;
    $totalWithTax = $totalAmount + $storePickup + $taxAmount;
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php'; ?>
<body>
<?php include 'include/header.inc.php'; ?>
<main>
    <section class="bg-white antialiased">
      <form id="checkoutForm" action="#" class="px-5 sm:px-10 max-w-6xl mx-auto pt-[140px]">
        <h1 class="text-4xl font-bold mb-26 text-center underline underline-offset-8">Checkout</h1>
        <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12 xl:gap-16">
          <div class="min-w-0 flex-1 space-y-8">
            <div class="space-y-4">
              <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Delivery Details</h2>
              <div class="flex items-center justify-center">
                <div class="mx-auto w-full bg-white">
                    <div class="mb-5">
                      <div class="mb-2 flex items-center gap-2">
                        <label for="name" class="block text-sm font-medium text-gray-900"> Full Name<span class=" text-red-500">*</span> </label>
                      </div>
                      <input
                        required
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Full Name"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                      />
                    </div>
                    <div class="mb-5">
                      <div class="mb-2 flex items-center gap-2">
                        <label for="phone" class="block text-sm font-medium text-gray-900"> Phone number <span class=" text-red-500">*</span> </label>
                      </div>
                      <input
                      required
                        type="text"
                        name="phone"
                        id="phone"
                        placeholder="123-456-7890"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                      />
                    </div>
                    <div class="mb-5">
                      <div class="mb-2 flex items-center gap-2">
                        <label for="email" class="block text-sm font-medium text-gray-900"> Email <span class=" text-red-500">*</span> </label>
                      </div>
                      <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Name@example.com"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                      />
                    </div>
                    <div class="-mx-3 flex flex-wrap">
                      <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                          <div class="mb-2 flex items-center gap-2">
                            <label for="Country" class="block text-sm font-medium text-gray-900"> Country <span class=" text-red-500">*</span> </label>
                          </div>
                          <input
                            type="text"
                            name="country"
                            id="country"
                            placeholder="Cambodia"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                          />
                        </div>
                      </div>
                      <div class="w-full px-3 sm:w-1/2">
                        <div class="mb-5">
                          <div class="mb-2 flex items-center gap-2">
                            <label for="city" class="block text-sm font-medium text-gray-900"> City <span class=" text-red-500">*</span> </label>
                          </div>
                          <input
                            type="text"
                            name="city"
                            id="city"
                            placeholder="Phnom Penh"
                            class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                          />
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-6 w-full space-y-6 sm:mt-8 lg:mt-0 lg:max-w-xs xl:max-w-md">
            <div class="flow-root">
              <div class="-my-3 divide-y divide-gray-200 dark:divide-gray-800">
                <dl class="flex items-center justify-between gap-4 py-3">
                  <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Subtotal</dt>
                  <dd class="text-base font-medium text-gray-900 dark:text-white">$<?php echo number_format($totalAmount, 2); ?></dd>
                </dl>
                <dl class="flex items-center justify-between gap-4 py-3">
                  <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Savings</dt>
                  <dd class="text-base font-medium text-green-500">0</dd>
                </dl>
                <dl class="flex items-center justify-between gap-4 py-3">
                  <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Store Pickup</dt>
                  <dd class="text-base font-medium text-gray-900 dark:text-white">$<?php echo number_format($storePickup, 2); ?></dd>
                </dl>
                <dl class="flex items-center justify-between gap-4 py-3">
                  <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Tax (5%)</dt>
                  <dd class="text-base font-medium text-gray-900 dark:text-white">$<?php echo number_format($taxAmount, 2); ?></dd>
                </dl>
                <dl class="flex items-center justify-between gap-4 py-3">
                  <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                  <dd class="text-base font-bold text-gray-900 dark:text-white">$<?php echo number_format($totalWithTax, 2); ?></dd>
                </dl>
              </div>
            </div>
            <p class="text-sm font-normal text-gray-500">You need to fill delivery info to proceed with payment.</p>
            <div class="space-y-3">
                <div id="paypal-button-container" class="pointer-events-none opacity-50"></div>
            </div>
          </div>
        </div>
      </form>
    </section>

    <script src="https://www.paypal.com/sdk/js?client-id=ATzlLb_R9Ub3MshTOLuUFbMKQpHL37PU4YiEr1708LJFnFdeg2gQy0ohZe4b6WxTFM_ThEr2UR8uVy-_&currency=USD"></script>
    <script>
    function validateForm() {
        const requiredFields = ['name', 'phone', 'email', 'country', 'city'];
        let isValid = true;

        requiredFields.forEach(id => {
            const field = document.getElementById(id);
            if (!field.value.trim()) {
                isValid = false;
            }
        });

        const paypalButton = document.getElementById('paypal-button-container');
        if (isValid) {
            paypalButton.classList.remove('pointer-events-none', 'opacity-50');
        } else {
            paypalButton.classList.add('pointer-events-none', 'opacity-50');
        }
    }

    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', validateForm);
    });

    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: { value: '<?php echo number_format($totalWithTax, 2, '.', ''); ?>' }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                const formData = new FormData(document.getElementById('checkoutForm'));
                const deliveryDetails = {};
                formData.forEach((value, key) => deliveryDetails[key] = value);
                
                fetch('process_payment.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        user_id: <?php echo $userId; ?>,
                        payerID: details.payer.payer_id,
                        orderID: details.id,
                        total_amount: '<?php echo number_format($totalWithTax, 2, '.', ''); ?>',
                        product_items: <?php echo json_encode($productItems); ?>,
                        delivery_details: deliveryDetails
                    })
                }).then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert("Payment Successful!");
                        window.location.href = `invoice.php?order_id=${details.id}`; // Fixed orderid to order_id
                    } else {
                        alert("Payment processing failed: " + data.message);
                        console.error("Payment processing error:", data.message);
                    }
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                    alert("An error occurred while processing payment.");
                });
            });
        }
    }).render('#paypal-button-container');
    </script>
</main>
<?php include 'include/footer.inc.php'; ?>
</body>
</html>