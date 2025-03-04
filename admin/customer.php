<?php
require_once '../DB_lib/Database.php';
$db = new Database();

$customers = $db->dbSelect('tbusers'); 

// Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) { 
    $id = $_POST['delete_user_id'];
    $result = $db->delete('tbusers', "id = $id");
    if ($result) {
        header("Location: customer.php?delete=success");
        exit();
    } else {
        header("Location: customer.php?delete=error&message=" . urlencode($result));
        exit();
    }
}

$successMessage = '';
$errorMessage = '';
if (isset($_GET['add'])) {
    if ($_GET['add'] === 'success') {
        $successMessage = "Customer added successfully!";
    } elseif ($_GET['add'] === 'error' && isset($_GET['message'])) {
        $errorMessage = urldecode($_GET['message']);
    }
}

if (isset($_GET['edit'])) {
    if ($_GET['edit'] === 'success') {
        $successMessage = "Customer updated successfully!";
    } elseif ($_GET['edit'] === 'error' && isset($_GET['message'])) {
        $errorMessage = urldecode($_GET['message']);
    }
}

if (isset($_GET['delete'])) {
    if ($_GET['delete'] === 'success') {
        $successMessage = "Customer deleted successfully!";
    } elseif ($_GET['delete'] === 'error' && isset($_GET['message'])) {
        $errorMessage = urldecode($_GET['message']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_customer'])) {
    $customerName = $_POST['customer_name'];
    $customerEmail = $_POST['customer_email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    $data = [
        'username' => $customerName,
        'email' => $customerEmail,
        'password' => $password 
    ];

    $result = $db->insert('tbusers', $data);
    if ($result) {
        header("Location: customer.php?add=success");
        exit();
    } else {
        header("Location: customer.php?add=error&message=" . urlencode($result));
        exit();
    }
}

// Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $id = $_POST['user_id'];
    $customerName = $_POST['customer_name']; 
    $customerEmail = $_POST['customer_email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null; // Only update password if provided

    $data = [
        'username' => $customerName,
        'email' => $customerEmail
    ];

    
    if ($password) {
        $data['password'] = $password; 
    }

    $result = $db->update('tbusers', $id, $data);
    if ($result) {
        header("Location: customer.php?edit=success");
        exit();
    } else {
        header("Location: customer.php?edit=error&message=" . urlencode($result));
        exit();
    }
}
?>

<?php $title = "Customers" ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php' ?>
<body class="bg-slate-50">
    
    <?php include 'include/adside.inc.php' ?>
    <?php include 'include/header.inc.php' ?>
    <main class="ml-70 p-6 pt-21">
        <div class="size-full py-5">
            <?php if ($successMessage): ?>
                <div id="feedback-success" class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    <?php echo htmlspecialchars($successMessage, ENT_QUOTES); ?>
                </div>
            <?php elseif ($errorMessage): ?>
                <div id="feedback-error" class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                    <?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?>
                </div>
            <?php endif; ?>
            <div class="grid gap-4 md:grid-cols-2 pb-5">
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
                    <div class="w-fit px-6 py-2 min-w-44">
                        <div class="flex justify-end">
                            <button type="button" class="flex cursor-pointer items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="openModal('adds')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                                </svg>
                                <span class="ml-2">Add Customer</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Create Date</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($customers as $user): ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-<?=$user['id'] ?>" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-<?= $user['id'] ?>" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="ps-3">
                                        <div class="text-base font-semibold"><?= htmlspecialchars($user['username']) ?></div>
                                    </div>  
                                </th>
                                <td class="px-6 py-4"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> Online
                                    </div>
                                </td>
                                <td class="px-6 py-4"><?php echo $user['created_date']; ?></td>
                                <td class="px-6 py-4">
                                    <button onclick="openEditModal(<?=$user['id']?>)" class="font-medium mr-3 cursor-pointer text-blue-600 hover:underline">Edit</button>
                                    <form action="" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                        <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="font-medium cursor-pointer text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>

            <!-- Add Customer Modal -->
            <div id="modal-adds" class="fixed inset-0 z-50 hidden" aria-hidden="true">
                <div class="relative p-4 w-full h-full">
                    <div class="absolute inset-0 bg-black/50" onclick="closeModal('adds')"></div>
                    <div class="relative z-10 bg-white rounded-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 mx-auto mt-20">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Add Customer</h3>
                            <button type="button" onclick="closeModal('adds')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <input type="hidden" name="add_customer" value="1">
                            <div class="p-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                                    <input type="text" name="customer_name" value="" class="w-full p-2 border rounded" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="customer_email" class="w-full p-2 border rounded" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Password</label>
                                    <input type="password" name="password" class="w-full p-2 border rounded" required>
                                </div>
                                <button type="submit" class="cursor-pointer p-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Customer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Customer Modal -->
            <div id="editUserModal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
                <div class="relative p-4 w-full h-full">
                    <div class="absolute inset-0 bg-black/50" onclick="closeEditModal()"></div>
                    <div class="relative z-10 bg-white rounded-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 mx-auto mt-20">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Edit Customer</h3>
                            <button type="button" onclick="closeEditModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <input type="hidden" name="user_id" id="edit_customer_id" value="">
                            <div class="p-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                                    <input type="text" name="customer_name" id="edit_username" class="w-full p-2 border rounded" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="customer_email" id="edit_email" class="w-full p-2 border rounded" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">New Password (optional)</label>
                                    <input type="password" name="password" id="edit_password" class="w-full p-2 border rounded" placeholder="Set new password">
                                </div>
                                <button type="submit" class="cursor-pointer p-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Customer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="js/events.js"></script>                
    <script>
        function openEditModal(customerId) {
            const customers = <?php echo json_encode($customers); ?>.find(c => c.id === customerId);
            if (customers) {
                document.getElementById('edit_customer_id').value = customers.id;
                document.getElementById('edit_username').value = customers.username;
                document.getElementById('edit_email').value = customers.email;
                document.getElementById('edit_password').value = ''; // Do not pre-fill password for security
                document.getElementById('editUserModal').classList.remove('hidden');
            }
        }
        function closeEditModal() {
            document.getElementById('editUserModal').classList.add('hidden');
        }
        
    </script>
</body>
</html>