<?php
require_once '../DB_lib/Database.php';
// Adjust path as needed
$db = new Database();

// If you're using sessions for authentication

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invoice_id'])) {
    $invoiceId = $_POST['invoice_id'];
    $result = $db->delete('tbcheckout', "id = $invoiceId"); 
    if ($result) {
        header("Location: invoice.php?delete=success");
        exit();
    } else {
        header("Location: invoice.php?delete=error&message=" . urlencode($result));
        exit();
    }
}

// Fetch invoices and totals
try {
    $invoices = $db->dbSelect('tbcheckout');
    
    // Calculate totals
    $totalAmount = array_sum(array_column($invoices, 'total_amount'));
    $totalInvoices = $db->count('tbcheckout');
} catch (Exception $e) {
    die("Query failed: " . $e->getMessage());
}

$title = "Invoices";
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php' ?>
<body class="bg-slate-50">
    
    <?php include 'include/adside.inc.php' ?>
    <?php include 'include/header.inc.php' ?>
    
    <main class="ml-70 p-6 pt-21">
      <div class="size-full py-5">
        <!-- Feedback Messages -->
        <?php
        if (isset($_GET['delete'])) {
            if ($_GET['delete'] === 'success') {
                echo '<div id="feedback-success" class="mb-4 p-4 bg-green-100 text-green-700 rounded">Invoice deleted successfully!</div>';
            } elseif ($_GET['delete'] === 'error') {
                echo '<div id = "feedback-error" class="mb-4 p-4 bg-red-100 text-red-700 rounded">Error deleting invoice: ' . htmlspecialchars($_GET['message']) . '</div>';
            }
        }
        ?>

        <div class="grid gap-4 md:grid-cols-2 pb-5">
            <!-- Search and Totals Section (unchanged) -->
            <div class="w-1/2 self-end">
                <div class="relative">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" name="email" id="topbar-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2.5" placeholder="Search"/>
                </div>
            </div>
            <div class="flex space-x-7 justify-self-end">
                <div class="w-fit px-6 py-2 min-w-44 rounded-sm bg-white shadow">
                    <div class="space-y-2">
                        <div class="text-xl">$<?=$totalAmount?></div>
                        <div class="text-sm font-medium text-gray-500"><span>Total of amount</span></div>
                    </div>
                </div>
                <div class="w-fit min-w-44 px-6 py-2 rounded-sm bg-white shadow">
                    <div class="space-y-2">  
                        <div class="text-xl"><?=$totalInvoices?></div>
                        <div class="text-sm font-medium text-gray-500"><span>Total invoices</span></div>
                    </div>
                </div>
            </div>
        </div>   

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="p-4 w-24">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 max-w-32">#</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Items</th>
                        <th scope="col" class="px-6 py-3">Total Amount</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Create Date</th>
                        <th scope="col" class="px-6 py-3">Address</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($invoices as $invoice): ?>
                        <?php 
                        $productItems = json_decode($invoice['product_items'], true);
                        $usersName = "Uncategorized";
                        $emails = "none";
                        if (isset($invoice['user_id'])) {
                            try {
                                $user = $db->read('tbusers', $invoice['user_id']);
                                if ($user) {
                                    $usersName = $user['username'];
                                    $emails = $user['email'];
                                }
                            } catch (Exception $e) {
                                error_log("User query failed: " . $e->getMessage());
                            }
                        }
                        ?>
                        <tr class="bg-white border-b border-gray-300 hover:bg-gray-50">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-table-search-<?php echo $invoice['id']; ?>" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                    <label for="checkbox-table-search-<?php echo $invoice['id']; ?>" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4">#<?php echo $invoice['id'] ?></th>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($usersName, ENT_QUOTES);?></td> 
                            <td><?php echo htmlspecialchars($emails, ENT_QUOTES); ?></td>
                            <td class="px-6 py-4">
                                <button id="btn-modal" onclick="openModal(<?php echo $invoice['id']; ?>)" class="font-medium cursor-pointer text-nowrap text-blue-600 hover:underline" type="button">View Items</button>
                                <!-- Modal code remains the same -->
                                <div id="modal-<?php echo $invoice['id']; ?>" class="fixed inset-0 z-50 hidden" tabindex="-1" aria-hidden="true">
                                    <!-- Modal content (unchanged) -->
                                    <div class="relative p-4 w-full h-full">
                                        <div class="absolute inset-0 bg-black/50" onclick="closeModal(<?php echo $invoice['id']; ?>)"></div>
                                        <div class="relative z-10 bg-white rounded-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 mx-auto mt-20">
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                                <h3 class="text-lg font-semibold text-gray-900">Invoice Items</h3>
                                                <button type="button" onclick="closeModal(<?php echo $invoice['id']; ?>)" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <div class="relative overflow-x-auto">
                                                <table class="w-full mt-2 text-sm text-left rtl:text-right text-gray-500">
                                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3">Product name</th>
                                                            <th scope="col" class="px-6 py-3">Qty</th>
                                                            <th scope="col" class="px-6 py-3">Price</th>
                                                            <th scope="col" class="px-6 py-3">total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($productItems) && is_array($productItems)): ?>
                                                            <?php foreach ($productItems as $item): ?>
                                                                <tr>
                                                                    <td class="px-4 py-2"><?php echo htmlspecialchars($item['pro_name']); ?></td>
                                                                    <td class="px-4 py-2"><?php echo htmlspecialchars($item['quantity']); ?></td>
                                                                    <td class="px-4 py-2">$<?php echo number_format($item['price'], 2); ?></td>
                                                                    <td class="px-4 py-2">$<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="4" class="px-4 py-2 text-center text-gray-500">No items found</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 ">$<?php echo $invoice['total_amount'] ?></td>
                            <td class="px-6 py-4"><?php echo $invoice['payment_status'] ?></td>
                            <td class="px-6 py-4"><?php echo $invoice['created_at'] ?></td>
                            <td class="px-6 py-4"><?php echo $invoice['address'] ?></td>
                            <td class="px-6 py-4">
                                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                                    <input type="hidden" name="invoice_id" value="<?php echo $invoice['id']; ?>">
                                    <button type="submit" class="cursor-pointer font-medium text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
      </div>
    </main>
    <script src="./js/events.js"></script>
    
</body>
</html>