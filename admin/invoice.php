<?php
require_once 'include/dbh.inc.php';

    try{
        $sql = "SELECT id, user_id, total_amount, payment_status, created_at, product_items, address FROM tbcheckout ORDER BY id DESC";
        $result = $pdo->query($sql);
        $invoices = $result->fetchAll(PDO::FETCH_ASSOC); 
        

         // Fetch total sum and invoice count
        $sqlTotal = "SELECT SUM(total_amount) AS total_sum, COUNT(id) AS total_invoices FROM tbcheckout";
        $resultTotal = $pdo->query($sqlTotal);
        $totals = $resultTotal->fetch(PDO::FETCH_ASSOC);

        // Assign values
        $totalAmount = $totals['total_sum'] ?? 0;
        $totalInvoices = $totals['total_invoices'] ?? 0;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
?>

<?php $title = "Invoices" ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php' ?>
<body class=" bg-slate-50">
    
    <?php include 'include/adside.inc.php' ?>
    <?php include 'include/header.inc.php' ?>
    <main class="ml-70 p-6 pt-21">
      <div class=" size-full py-5">
            
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
            <tr>
                <th scope="col" class="p-4 w-24">
                    <div class="flex items-center">
                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2 ">
                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 max-w-32">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Items
                </th>
                <th scope="col" class="px-6 py-3">
                    Total Amount
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Create Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Address
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($invoices as $invoice): ?>
                <?php $productItems = json_decode($invoice['product_items'], true);?>
                <?php $usersName = "Uncategorized";
                $emails = "none";
                if (isset($invoice['user_id'])) { // Now access $product['CategoryID']
                    try {
                        $stmt = $pdo->prepare("SELECT username, email  FROM tbusers WHERE id = ?");
                        $stmt->execute([$invoice['user_id']]);
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($user) {
                            $usersName = $user['username'];
                            $emails = $user['email'];
                        }
                    } catch (PDOException $e) {
                        error_log("Category query failed: " . $e->getMessage());
                    }
                }
                ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th scope="row" class="px-6 py-4">
                    #<?php echo $invoice['id'] ?>
                </th>
                <td class="px-6 py-4">
                    <?php echo htmlspecialchars($usersName, ENT_QUOTES);?>
                </td> 
                <td>             
                    <?php echo htmlspecialchars($emails, ENT_QUOTES); ?>               
                </td>
                <td class="px-6 py-4">
                    <button id="btn-modal"onclick="openModal(<?php echo $invoice['id']; ?>)"class="font-medium cursor-pointer text-blue-600 dark:text-blue-500 hover:underline"type="button">
                    View Items
                    </button>
                    <div id="modal-<?php echo $invoice['id']; ?>" class="fixed inset-0 z-50 hidden" tabindex="-1" aria-hidden="true">
                    <div class="relative p-4 w-full h-full">
                        <div class="absolute inset-0 bg-black/50" onclick="closeModal(<?php echo $invoice['id']; ?>)"></div>
                        <!-- Modal content -->
                        <div
                        class="relative z-10 bg-white rounded-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 mx-auto mt-20"
                        >
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200"
                        >
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Invoice Items
                            </h3>
                            <button
                            type="button"
                            onclick="closeModal(<?php echo $invoice['id']; ?>)"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="crud-modal"
                            >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 14"
                            >
                                <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                            <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->

                        <div class="relative overflow-x-auto">
                            <table
                            class="w-full mt-2 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                            >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
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
                <td class="px-6 py-4">
                    $ <?php echo $invoice['total_amount'] ?>
                </td>
                <td class="px-6 py-4">
                    <?php echo $invoice['payment_status'] ?>
                </td>
                <td class="px-6 py-4">
                    <?php echo $invoice['created_at'] ?>
                </td>
                <td class="px-6 py-4">
                    <?php echo $invoice['address'] ?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    
</div>

      </div>
    </main>

    <script>
   function openModal(id) {
    document.getElementById(`modal-${id}`).classList.remove("hidden");
}

function closeModal(id) {
    document.getElementById(`modal-${id}`).classList.add("hidden");
}

    </script>
</body>
</html>