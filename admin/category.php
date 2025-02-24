<?php
require_once '../DB_lib/Database.php';
$db = new Database();

// Handle Delete Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category_id'])) {
    $id = $_POST['delete_category_id'];
    $result = $db->delete('tbcategory', "id = $id");
    if ($result === true) {
        header("Location: category.php?delete=success");
        exit();
    } else {
        header("Location: category.php?delete=error&message=" . urlencode($result));
        exit();
    }
}

// Handle Edit Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_category_id'])) {
    $id = $_POST['edit_category_id'];
    $categoryName = $_POST['category_name'];
    $categoryDescription = $_POST['category_description'];

    $data = [
        'CategoryName' => $categoryName,
        'CategoryDescription' => $categoryDescription
    ];

    $result = $db->update('tbcategory', $data, "id = $id");
    if ($result === true) {
        header("Location: category.php?edit=success");
        exit();
    } else {
        header("Location: category.php?edit=error&message=" . urlencode($result));
        exit();
    }
}

// Handle Add Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $categoryName = $_POST['category_name'];
    $categoryDescription = $_POST['category_description'];

    $data = [
        'CategoryName' => $categoryName,
        'CategoryDescription' => $categoryDescription
    ];

    $result = $db->Insert('tbcategory', $data);
    if ($result === true) {
        header("Location: category.php?add=success");
        exit();
    } else {
        header("Location: category.php?add=error&message=" . urlencode($result));
        exit();
    }
}

// Fetch categories
$categorys = $db->readAll('tbcategory');
?>

<?php $title = "Category" ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php' ?>
<body class="bg-slate-50">
    <?php include 'include/header.inc.php' ?>
    <?php include 'include/adside.inc.php' ?>
    <main class="ml-70 p-6 pt-21">
        <div class="size-full py-5">
            <!-- Feedback Messages -->
            <?php
            if (isset($_GET['delete'])) {
                if ($_GET['delete'] === 'success') {
                    echo '<div id="feedback-success" class="mb-4 p-4 bg-green-100 text-green-700 rounded">Category deleted successfully!</div>';
                } elseif ($_GET['delete'] === 'error') {
                    echo '<div id="feedback-error" class="mb-4 p-4 bg-red-100 text-red-700 rounded">Error deleting category: ' . htmlspecialchars($_GET['message']) . '</div>';
                }
            }
            if (isset($_GET['edit'])) {
                if ($_GET['edit'] === 'success') {
                    echo '<div id="feedback-success" class="mb-4 p-4 bg-green-100 text-green-700 rounded">Category updated successfully!</div>';
                } elseif ($_GET['edit'] === 'error') {
                    echo '<div id="feedback-error" class="mb-4 p-4 bg-red-100 text-red-700 rounded">Error updating category: ' . htmlspecialchars($_GET['message']) . '</div>';
                }
            }
            if (isset($_GET['add'])) {
                if ($_GET['add'] === 'success') {
                    echo '<div id="feedback-success" class="mb-4 p-4 bg-green-100 text-green-700 rounded">Category added successfully!</div>';
                } elseif ($_GET['add'] === 'error') {
                    echo '<div id="feedback-error" class="mb-4 p-4 bg-red-100 text-red-700 rounded">Error adding category: ' . htmlspecialchars($_GET['message']) . '</div>';
                }
            }
            ?>

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
                            <button type="button" class="flex cursor-pointer items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="openAddModal()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                                </svg>
                                <span class="ml-2">Add New Category</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div> 

            <!-- Add Category Modal -->
            <div id="add-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
                <div class="relative p-4 w-full h-full">
                    <div class="absolute inset-0 bg-black/50" onclick="closeAddModal()"></div>
                    <div class="relative z-10 bg-white rounded-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 mx-auto mt-20">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Add Category</h3>
                            <button type="button" onclick="closeAddModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form action="" method="POST">
                            <input type="hidden" name="add_category" value="1">
                            <div class="p-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Category Name</label>
                                    <input type="text" name="category_name" value="" class="w-full p-2 border rounded" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="category_description" class="w-full p-2 border rounded"></textarea>
                                </div>
                                <button type="submit" class="cursor-pointer p-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Category</button>
                            </div>
                        </form>
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
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Description</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorys as $category): ?>
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-<?php echo $category['id']; ?>" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                        <label for="checkbox-table-search-<?php echo $category['id']; ?>" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <td class="px-6 py-4"><?php echo $category['id']; ?></td>
                                <td class="px-6 py-4"><?php echo htmlspecialchars($category['CategoryName']); ?></td>
                                <td class="px-6 py-4 max-w-xs"><?php echo htmlspecialchars($category['CategoryDescription']); ?></td>
                                <td class="px-6 py-4">
                                    <button onclick="openEditModal(<?php echo $category['id']; ?>)" class="font-medium mr-3 cursor-pointer text-blue-600 hover:underline">Edit</button>
                                    <form action="" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        <input type="hidden" name="delete_category_id" value="<?php echo $category['id']; ?>">
                                        <button type="submit" class="font-medium cursor-pointer text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div id="edit-modal-<?php echo $category['id']; ?>" class="fixed inset-0 z-50 hidden" tabindex="-1" aria-hidden="true">
                                <div class="relative p-4 w-full h-full">
                                    <div class="absolute inset-0 bg-black/50" onclick="closeEditModal(<?php echo $category['id']; ?>)"></div>
                                    <div class="relative z-10 bg-white rounded-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 mx-auto mt-20">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                            <h3 class="text-lg font-semibold text-gray-900">Edit Category #<?php echo $category['id']; ?></h3>
                                            <button type="button" onclick="closeEditModal(<?php echo $category['id']; ?>)" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <form action="" method="POST">
                                            <input type="hidden" name="edit_category_id" value="<?php echo $category['id']; ?>">
                                            <div class="p-4 space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Category Name</label>
                                                    <input type="text" name="category_name" value="<?php echo htmlspecialchars($category['CategoryName']); ?>" class="w-full p-2 border rounded" required>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                                    <textarea name="category_description" class="w-full p-2 border rounded"><?php echo htmlspecialchars($category['CategoryDescription']); ?></textarea>
                                                </div>
                                                <button type="submit" class="w-full cursor-pointer p-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function openEditModal(id) {
            document.getElementById(`edit-modal-${id}`).classList.remove("hidden");
        }

        function closeEditModal(id) {
            document.getElementById(`edit-modal-${id}`).classList.add("hidden");
        }

        function openAddModal() {
            document.getElementById('add-modal').classList.remove("hidden");
        }

        function closeAddModal() {
            document.getElementById('add-modal').classList.add("hidden");
        }

        function hideElement(elementId, timeout = 2000) {
            const element = document.getElementById(elementId);
            if (element) {
                setTimeout(() => {
                    element.style.display = 'none';
                }, timeout);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            hideElement('feedback-success');
            hideElement('feedback-error', 3000);
        });
    </script>
</body>
</html>