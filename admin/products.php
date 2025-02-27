<?php
require_once '../DB_lib/Database.php';
$db = new Database();
// Handle sorting
$categories = $db->readAll('tbcategory');
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$sortOrder = isset($_GET['order']) && strtoupper($_GET['order']) === 'ASC' ? 'ASC' : 'DESC';

// Handle category filtering
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

// Allowed columns for sorting
$allowedColumns = ['id', 'pro_name', 'price', 'create_date', 'description', 'prevPrice', 'CategoryID', 'imageUrl'];


// Prepare condition for filtering
$condition = !empty($categoryFilter) ? ['CategoryID' => $categoryFilter] : [];

// Fetch products with filtering and sorting
$products = $db->sort('tbproducts', $sortColumn, $sortOrder, $allowedColumns, $condition);
// Fetch products with filter
// Handle feedback messages
$successMessage = '';
$errorMessage = '';

if (isset($_GET['add'])) {
    if ($_GET['add'] === 'success') {
        $successMessage = "Product added successfully!";
    } elseif ($_GET['add'] === 'error' && isset($_GET['message'])) {
        $errorMessage = urldecode($_GET['message']);
    }
}

if (isset($_GET['edit'])) {
    if ($_GET['edit'] === 'success') {
        $successMessage = "Product updated successfully!";
    } elseif ($_GET['edit'] === 'error' && isset($_GET['message'])) {
        $errorMessage = urldecode($_GET['message']);
    }
}

if (isset($_GET['delete'])) {
    if ($_GET['delete'] === 'success') {
        $successMessage = "Product deleted successfully!";
    } elseif ($_GET['delete'] === 'error' && isset($_GET['message'])) {
        $errorMessage = urldecode($_GET['message']);
    }
}

// Handle Delete Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {
    $id = $_POST['delete_product_id'];
    $result = $db->delete('tbproducts', "id = $id");
    if ($result === true) {
        header("Location: products.php?delete=success");
        exit();
    } else {
        header("Location: products.php?delete=error&message=" . urlencode($result));
        exit();
    }
}

// Handle Edit Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product_id'])) {
    $id = $_POST['edit_product_id'];
    $productName = htmlspecialchars($_POST['productName']);
    $productDescription = htmlspecialchars($_POST['productDescription']);
    $productPrice = floatval($_POST['productPrice']);
    $productPrevPrice = floatval($_POST['productPrevPrice']);
    $categoryID = intval($_POST['categoryID']);

    $data = [
        'pro_name' => $productName,
        'description' => $productDescription,
        'price' => $productPrice,
        'prevPrice' => $productPrevPrice,
        'CategoryID' => $categoryID,
    ];

    // Handle image upload (optional for edit)
    if (isset($_FILES['productImage']) && $_FILES['productImage']['name']) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/LampStore/image/products/";
        $target_file = basename($_FILES["productImage"]["name"]);
        $target_move = $target_dir . $target_file;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // File Validation
        $check = getimagesize($_FILES["productImage"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["productImage"]["size"] > 500000) { // 500KB limit
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowed_types = array("jpg", "png", "jpeg", "gif");
        if (!in_array($imageFileType, $allowed_types)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            die("Sorry, your file was not uploaded.");
        } else {
            if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_move)) {
                $data['imageUrl'] = $target_file; // Update image URL in the data
            } else {
                die("Sorry, there was an error uploading your file.");
            }
        }
    }

    // Validate other inputs
    if (empty($productName) || empty($productPrice) || empty($categoryID)) {
        die("All fields except image are required.");
    }

    $result = $db->update('tbproducts', $data, "id = $id");
    if ($result === true) {
        header("Location: products.php?edit=success");
        exit();
    } else {
        header("Location: products.php?edit=error&message=" . urlencode($result));
        exit();
    }
}

// Handle Add Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $productName = htmlspecialchars($_POST['productName']);
    $productDescription = htmlspecialchars($_POST['productDescription']);
    $productPrice = floatval($_POST['productPrice']);
    $productPrevPrice = floatval($_POST['productPrevPrice']);
    $categoryID = intval($_POST['categoryID']);

    

    // Image Upload Handling (required for add)
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/LampStore/image/products/";
    $target_file = basename($_FILES["productImage"]["name"]);
    $target_move = $target_dir . $target_file;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // File Validation
    $check = getimagesize($_FILES["productImage"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["productImage"]["size"] > 500000) { // 500KB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_types = array("jpg", "png", "jpeg", "gif");
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        die("Sorry, your file was not uploaded.");
    } else {
        if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_move)) {
            $data['imageUrl'] = $target_file; // Add image URL to the data
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    }

    // Validate other inputs
    if (empty($productName) || empty($productPrice) || empty($categoryID)) {
        die("All fields except image are required.");
    }
    $data = [
        'pro_name' => $productName,
        'description' => $productDescription,
        'price' => $productPrice,
        'prevPrice' => $productPrevPrice,
        'CategoryID' => $categoryID,
        'imageUrl' => $target_file
    ];
    $result = $db->Insert('tbproducts', $data);
    if ($result !== false) {
        header("Location: products.php?add=success");
        exit();
    } else {
        header("Location: products.php?add=error&message=" . urlencode($result));
        exit();
    }
}
?>

<?php $title = "Products" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        console.log("bbbbb");
        function openModal() {
            console.log("open");
            document.getElementById('modals').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modals').classList.add('hidden');
        }

        function openEditModal(productId) {
            // Fetch product data (simplified; you might want to use AJAX or PHP to populate)
            const product = <?php echo json_encode($products); ?>.find(p => p.id === productId);
            if (product) {
                document.getElementById('edit_product_id').value = product.id;
                document.getElementById('edit_product_name').value = product.pro_name;
                document.getElementById('edit_product_description').value = product.description;
                document.getElementById('edit_product_price').value = product.price;
                document.getElementById('edit_product_prev_price').value = product.prevPrice || '';
                document.getElementById('edit_category_id').value = product.CategoryID;
                document.getElementById('edit_product_image').value = ''; // Reset file input
                document.getElementById('editModals').classList.remove('hidden');
            }
        }

        function closeEditModal() {
            document.getElementById('editModals').classList.add('hidden');
        }

        function toggleDropDown(contentID) {
            document.getElementById(contentID).classList.toggle('hidden');
        }
    </script>
    <?php include 'include/head.inc.php' ?>
</head>
<body class="bg-slate-50">
    <?php include 'include/header.inc.php' ?>
    <?php include 'include/adside.inc.php'?>
    <main class="ml-64 mr-3 p-6 pt-21">
        <!-- Display Success or Error Message -->
        <?php if ($successMessage): ?>
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                <?php echo htmlspecialchars($successMessage, ENT_QUOTES); ?>
            </div>
        <?php elseif ($errorMessage): ?>
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                <?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?>
            </div>
        <?php endif; ?>

        <div class="size-full py-5">
            <div class="bg-white shadow-sm rounded-lg p-6 mb-5">
                <div class="grid grid-cols-3 -mx-2 items-center">
                    <div class="w-full px-2 col-span-2">
                        <div class="flex -mx-2">
                            <div class="w-1/3 px-2 gap-2">
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="topbar-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2.5" placeholder="Search"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-2">
                                    <form method="GET" class="flex items-center">
                                        <select name="category" 
                                                class="px-4 py-2 border border-gray-300 rounded-md mr-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                                onchange="this.form.submit()">
                                                <option value="">
                                                    Filter
                                                </option>
                                            <?php foreach($categories as $category): ?>
                                                <option value="<?php echo htmlspecialchars($category['id']); ?>"
                                                        <?php echo $categoryFilter === $category['id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($category['CategoryName']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="sort" value="<?php echo $sortColumn; ?>">
                                        <input type="hidden" name="order" value="<?php echo $sortOrder; ?>">
                                    </form>
                                </div>
                                <div class="px-2">
                                    <div class="relative">
                                        <button onclick="toggleDropDown('sortDropdown')" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md bg-white hover:bg-gray-50" id="sortButton">
                                            Sort By
                                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div class="absolute hidden right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" id="sortDropdown">
                                            <div class="py-1">
                                                <a href="?sort=pro_name&order=ASC&category=<?=$categoryFilter?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Name (A-Z)</a>
                                                <a href="?sort=pro_name&order=DESC&category=<?=$categoryFilter?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Name (Z-A)</a>
                                                <a href="?sort=price&order=ASC&category=<?=$categoryFilter?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Price (Low to High)</a>
                                                <a href="?sort=price&order=DESC&category=<?=$categoryFilter?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Price (High to Low)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 ">
                                <a href="?" class=" ">Reset Filters</a>
                            </div>
                        </div>
                    </div>
                    <div class="w-full px-2 flex justify-end">
                        <button id="btn-model" onclick="openModal()" class="flex cursor-pointer items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                            </svg>
                            <span class="ml-2">Add Products</span>
                        </button>
                    </div>
                </div>
            </div>  

            <!-- Add Product Modal -->
            <div class="fixed inset-0 z-50 hidden" id="modals">
                <?php 
                $categories = $db->readAll('tbcategory');
                ?>
                <div class="absolute inset-0 bg-black/50" onclick="closeModal()"></div>
                <div class="relative z-10 bg-white rounded-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 mx-auto mt-20">
                    <div class="flex justify-between items-center pb-3">
                        <h3 class="text-lg font-semibold mb-1 border-b">Add New Products</h3>
                        <button type="button" class="cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeModal()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form class="w-full" action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="add_product" value="1">
                        <div class="mb-4">
                            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input type="text" name="productName" id="product_name" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div class="flex mb-4">
                            <div class="w-1/3 mr-2">
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="categoryID" id="category_id" class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                    <option value="">Select Category</option>
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                            <?php echo htmlspecialchars($category['CategoryName']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="w-2/3 flex">
                                <div class="w-full">
                                    <label for="product_price" class="block max-w-1/2 text-sm font-medium text-gray-700 mb-1">Price</label>
                                    <input type="number" name="productPrice" id="product_price" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                </div>
                                <div class="ml-2 w-full">
                                    <label for="product_prev_price" class="block text-sm font-medium text-gray-700 mb-1">PrevPrice</label>
                                    <input type="number" name="productPrevPrice" id="product_prev_price" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="product_description" class="block text-sm font-medium text-gray-700">Product Description</label>
                            <textarea name="productDescription" id="product_description" rows="3" class="mt-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                        </div>
                        <div class="w-full py-3 bg-gray-50 rounded-2xl border border-gray-300 gap-3 grid border-dashed">
                            <div class="grid gap-1">
                                <svg class="mx-auto" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="File">
                                        <path id="icon" d="M31.6497 10.6056L32.2476 10.0741L31.6497 10.6056ZM28.6559 7.23757L28.058 7.76907L28.058 7.76907L28.6559 7.23757ZM26.5356 5.29253L26.2079 6.02233L26.2079 6.02233L26.5356 5.29253ZM33.1161 12.5827L32.3683 12.867V12.867L33.1161 12.5827ZM31.8692 33.5355L32.4349 34.1012L31.8692 33.5355ZM24.231 11.4836L25.0157 11.3276L24.231 11.4836ZM26.85 14.1026L26.694 14.8872L26.85 14.1026ZM11.667 20.8667C11.2252 20.8667 10.867 21.2248 10.867 21.6667C10.867 22.1085 11.2252 22.4667 11.667 22.4667V20.8667ZM25.0003 22.4667C25.4422 22.4667 25.8003 22.1085 25.8003 21.6667C25.8003 21.2248 25.4422 20.8667 25.0003 20.8667V22.4667ZM11.667 25.8667C11.2252 25.8667 10.867 26.2248 10.867 26.6667C10.867 27.1085 11.2252 27.4667 11.667 27.4667V25.8667ZM20.0003 27.4667C20.4422 27.4667 20.8003 27.1085 20.8003 26.6667C20.8003 26.2248 20.4422 25.8667 20.0003 25.8667V27.4667ZM23.3337 34.2H16.667V35.8H23.3337V34.2ZM7.46699 25V15H5.86699V25H7.46699ZM32.5337 15.0347V25H34.1337V15.0347H32.5337ZM16.667 5.8H23.6732V4.2H16.667V5.8ZM23.6732 5.8C25.2185 5.8 25.7493 5.81639 26.2079 6.02233L26.8633 4.56274C26.0191 4.18361 25.0759 4.2 23.6732 4.2V5.8ZM29.2539 6.70608C28.322 5.65771 27.7076 4.94187 26.8633 4.56274L26.2079 6.02233C26.6665 6.22826 27.0314 6.6141 28.058 7.76907L29.2539 6.70608ZM34.1337 15.0347C34.1337 13.8411 34.1458 13.0399 33.8638 12.2984L32.3683 12.867C32.5216 13.2702 32.5337 13.7221 32.5337 15.0347H34.1337ZM31.0518 11.1371C31.9238 12.1181 32.215 12.4639 32.3683 12.867L33.8638 12.2984C33.5819 11.5569 33.0406 10.9662 32.2476 10.0741L31.0518 11.1371ZM16.667 34.2C14.2874 34.2 12.5831 34.1983 11.2872 34.0241C10.0144 33.8529 9.25596 33.5287 8.69714 32.9698L7.56577 34.1012C8.47142 35.0069 9.62375 35.4148 11.074 35.6098C12.5013 35.8017 14.3326 35.8 16.667 35.8V34.2ZM5.86699 25C5.86699 27.3344 5.86529 29.1657 6.05718 30.593C6.25217 32.0432 6.66012 33.1956 7.56577 34.1012L8.69714 32.9698C8.13833 32.411 7.81405 31.6526 7.64292 30.3798C7.46869 29.0839 7.46699 27.3796 7.46699 25H5.86699ZM23.3337 35.8C25.6681 35.8 27.4993 35.8017 28.9266 35.6098C30.3769 35.4148 31.5292 35.0069 32.4349 34.1012L31.3035 32.9698C30.7447 33.5287 29.9863 33.8529 28.7134 34.0241C27.4175 34.1983 25.7133 34.2 23.3337 34.2V35.8ZM32.5337 25C32.5337 27.3796 32.532 29.0839 32.3577 30.3798C32.1866 31.6526 31.8623 32.411 31.3035 32.9698L32.4349 34.1012C33.3405 33.1956 33.7485 32.0432 33.9435 30.593C34.1354 29.1657 34.1337 27.3344 34.1337 25H32.5337ZM7.46699 15C7.46699 12.6204 7.46869 10.9161 7.64292 9.62024C7.81405 8.34738 8.13833 7.58897 8.69714 7.03015L7.56577 5.89878C6.66012 6.80443 6.25217 7.95676 6.05718 9.40704C5.86529 10.8343 5.86699 12.6656 5.86699 15H7.46699ZM16.667 4.2C14.3326 4.2 12.5013 4.1983 11.074 4.39019C9.62375 4.58518 8.47142 4.99313 7.56577 5.89878L8.69714 7.03015C9.25596 6.47133 10.0144 6.14706 11.2872 5.97592C12.5831 5.8017 14.2874 5.8 16.667 5.8V4.2ZM23.367 5V10H24.967V5H23.367ZM28.3337 14.9667H33.3337V13.3667H28.3337V14.9667ZM23.367 10C23.367 10.7361 23.3631 11.221 23.4464 11.6397L25.0157 11.3276C24.9709 11.1023 24.967 10.8128 24.967 10H23.367ZM28.3337 13.3667C27.5209 13.3667 27.2313 13.3628 27.0061 13.318L26.694 14.8872C27.1127 14.9705 27.5976 14.9667 28.3337 14.9667V13.3667ZM23.4464 11.6397C23.7726 13.2794 25.0543 14.5611 26.694 14.8872L27.0061 13.318C26.0011 13.1181 25.2156 12.3325 25.0157 11.3276L23.4464 11.6397Z" fill="#4F46E5"/>
                                    </g>
                                </svg>
                                <h2 class="text-center text-gray-400 text-xs leading-4">PNG, JPG or PDF</h2>
                            </div>
                            <div class="grid gap-2">
                                <h4 class="text-center text-gray-900 text-sm font-medium leading-snug">Drag and Drop your file here or</h4>
                                <div class="flex items-center justify-center">
                                    <label>
                                        <input type="file" name="productImage" id="product_image" hidden />
                                        <div class="flex w-28 h-9 px-2 flex-col bg-indigo-600 rounded-full shadow text-white text-xs font-semibold leading-4 items-center justify-center cursor-pointer focus:outline-none">
                                            Choose File
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" value="Submit" class="mt-2 cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Insert Product</button>
                    </form>
                </div>
            </div>

            <!-- Edit Product Modal -->
            <div class="fixed inset-0 z-50 hidden" id="editModals">
                
                <div class="absolute inset-0 bg-black/50" onclick="closeEditModal()"></div>
                <div class="relative z-10 bg-white rounded-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 mx-auto mt-20">
                    <div class="flex justify-between items-center pb-3">
                        <h3 class="text-lg font-semibold mb-1 border-b">Edit Product</h3>
                        <button type="button" class="cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeEditModal()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form class="w-full" action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="edit_product_id" id="edit_product_id">
                        <div class="mb-4">
                            <label for="edit_product_name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input type="text" name="productName" id="edit_product_name" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        </div>
                        <div class="flex mb-4">
                            <div class="w-1/3 mr-2">
                                <label for="edit_category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="categoryID" id="edit_category_id" class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                    <option value="">Select Category</option>
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                            <?php echo htmlspecialchars($category['CategoryName']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="w-2/3 flex">
                                <div class="w-full">
                                    <label for="edit_product_price" class="block max-w-1/2 text-sm font-medium text-gray-700 mb-1">Price</label>
                                    <input type="number" name="productPrice" id="edit_product_price" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                </div>
                                <div class="ml-2 w-full">
                                    <label for="edit_product_prev_price" class="block text-sm font-medium text-gray-700 mb-1">PrevPrice</label>
                                    <input type="number" name="productPrevPrice" id="edit_product_prev_price" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="edit_product_description" class="block text-sm font-medium text-gray-700">Product Description</label>
                            <textarea name="productDescription" id="edit_product_description" rows="3" class="mt-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                        </div>
                        <div class="w-full py-3 bg-gray-50 rounded-2xl border border-gray-300 gap-3 grid border-dashed">
                            <div class="grid gap-1">
                                <svg class="mx-auto" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="File">
                                        <path id="icon" d="M31.6497 10.6056L32.2476 10.0741L31.6497 10.6056ZM28.6559 7.23757L28.058 7.76907L28.058 7.76907L28.6559 7.23757ZM26.5356 5.29253L26.2079 6.02233L26.2079 6.02233L26.5356 5.29253ZM33.1161 12.5827L32.3683 12.867V12.867L33.1161 12.5827ZM31.8692 33.5355L32.4349 34.1012L31.8692 33.5355ZM24.231 11.4836L25.0157 11.3276L24.231 11.4836ZM26.85 14.1026L26.694 14.8872L26.85 14.1026ZM11.667 20.8667C11.2252 20.8667 10.867 21.2248 10.867 21.6667C10.867 22.1085 11.2252 22.4667 11.667 22.4667V20.8667ZM25.0003 22.4667C25.4422 22.4667 25.8003 22.1085 25.8003 21.6667C25.8003 21.2248 25.4422 20.8667 25.0003 20.8667V22.4667ZM11.667 25.8667C11.2252 25.8667 10.867 26.2248 10.867 26.6667C10.867 27.1085 11.2252 27.4667 11.667 27.4667V25.8667ZM20.0003 27.4667C20.4422 27.4667 20.8003 27.1085 20.8003 26.6667C20.8003 26.2248 20.4422 25.8667 20.0003 25.8667V27.4667ZM23.3337 34.2H16.667V35.8H23.3337V34.2ZM7.46699 25V15H5.86699V25H7.46699ZM32.5337 15.0347V25H34.1337V15.0347H32.5337ZM16.667 5.8H23.6732V4.2H16.667V5.8ZM23.6732 5.8C25.2185 5.8 25.7493 5.81639 26.2079 6.02233L26.8633 4.56274C26.0191 4.18361 25.0759 4.2 23.6732 4.2V5.8ZM29.2539 6.70608C28.322 5.65771 27.7076 4.94187 26.8633 4.56274L26.2079 6.02233C26.6665 6.22826 27.0314 6.6141 28.058 7.76907L29.2539 6.70608ZM34.1337 15.0347C34.1337 13.8411 34.1458 13.0399 33.8638 12.2984L32.3683 12.867C32.5216 13.2702 32.5337 13.7221 32.5337 15.0347H34.1337ZM31.0518 11.1371C31.9238 12.1181 32.215 12.4639 32.3683 12.867L33.8638 12.2984C33.5819 11.5569 33.0406 10.9662 32.2476 10.0741L31.0518 11.1371ZM16.667 34.2C14.2874 34.2 12.5831 34.1983 11.2872 34.0241C10.0144 33.8529 9.25596 33.5287 8.69714 32.9698L7.56577 34.1012C8.47142 35.0069 9.62375 35.4148 11.074 35.6098C12.5013 35.8017 14.3326 35.8 16.667 35.8V34.2ZM5.86699 25C5.86699 27.3344 5.86529 29.1657 6.05718 30.593C6.25217 32.0432 6.66012 33.1956 7.56577 34.1012L8.69714 32.9698C8.13833 32.411 7.81405 31.6526 7.64292 30.3798C7.46869 29.0839 7.46699 27.3796 7.46699 25H5.86699ZM23.3337 35.8C25.6681 35.8 27.4993 35.8017 28.9266 35.6098C30.3769 35.4148 31.5292 35.0069 32.4349 34.1012L31.3035 32.9698C30.7447 33.5287 29.9863 33.8529 28.7134 34.0241C27.4175 34.1983 25.7133 34.2 23.3337 34.2V35.8ZM32.5337 25C32.5337 27.3796 32.532 29.0839 32.3577 30.3798C32.1866 31.6526 31.8623 32.411 31.3035 32.9698L32.4349 34.1012C33.3405 33.1956 33.7485 32.0432 33.9435 30.593C34.1354 29.1657 34.1337 27.3344 34.1337 25H32.5337ZM7.46699 15C7.46699 12.6204 7.46869 10.9161 7.64292 9.62024C7.81405 8.34738 8.13833 7.58897 8.69714 7.03015L7.56577 5.89878C6.66012 6.80443 6.25217 7.95676 6.05718 9.40704C5.86529 10.8343 5.86699 12.6656 5.86699 15H7.46699ZM16.667 4.2C14.3326 4.2 12.5013 4.1983 11.074 4.39019C9.62375 4.58518 8.47142 4.99313 7.56577 5.89878L8.69714 7.03015C9.25596 6.47133 10.0144 6.14706 11.2872 5.97592C12.5831 5.8017 14.2874 5.8 16.667 5.8V4.2ZM23.367 5V10H24.967V5H23.367ZM28.3337 14.9667H33.3337V13.3667H28.3337V14.9667ZM23.367 10C23.367 10.7361 23.3631 11.221 23.4464 11.6397L25.0157 11.3276C24.9709 11.1023 24.967 10.8128 24.967 10H23.367ZM28.3337 13.3667C27.5209 13.3667 27.2313 13.3628 27.0061 13.318L26.694 14.8872C27.1127 14.9705 27.5976 14.9667 28.3337 14.9667V13.3667ZM23.4464 11.6397C23.7726 13.2794 25.0543 14.5611 26.694 14.8872L27.0061 13.318C26.0011 13.1181 25.2156 12.3325 25.0157 11.3276L23.4464 11.6397Z" fill="#4F46E5"/>
                                    </g>
                                </svg>
                                <h2 class="text-center text-gray-400 text-xs leading-4">PNG, JPG or PDF</h2>
                            </div>
                            <div class="grid gap-2">
                                <h4 class="text-center text-gray-900 text-sm font-medium leading-snug">Drag and Drop your file here or</h4>
                                <div class="flex items-center justify-center">
                                    <label>
                                        <input type="file" name="productImage" id="edit_product_image" hidden />
                                        <div class="flex w-28 h-9 px-2 flex-col bg-indigo-600 rounded-full shadow text-white text-xs font-semibold leading-4 items-center justify-center cursor-pointer focus:outline-none">
                                            Choose File
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" value="Update" class="mt-2 cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update Product</button>
                    </form>
                </div>
            </div>

            <div class="shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="p-4"><input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2" /><label for="checkbox-all-search" class="sr-only">checkbox</label></th>
                            <th scope="col" class="px-4 py-3">Code</th>
                            <th scope="col" class="px-4 py-3">Product name</th>
                            <th scope="col" class="px-4 py-3">Category</th>
                            <th scope="col" class="px-4 py-3">Price</th>
                            <th scope="col" class="px-4 py-3 text-nowrap">Prev-price</th>
                            <th scope="col" class="px-4 py-3 max-w-xs">Description</th>
                            <th scope="col" class="px-4 py-3 text-nowrap">Create Date</th>
                            <th scope="col" class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="w-4 p-4"><input id="checkbox-table-search-<?php echo $product['id']; ?>" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2" /><label for="checkbox-table-search-<?php echo $product['id']; ?>" class="sr-only">checkbox</label></td>
                                <td class="px-4 py-4"><?php echo htmlspecialchars($product['id'], ENT_QUOTES); ?></td>
                                <th scope="row" class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="mr-3 w-[80px] h-[80px]">
                                            <img class="w-full h-full cover rounded" src="../image/products/<?php echo htmlspecialchars($product['imageUrl'], ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($product['pro_name'], ENT_QUOTES); ?>">
                                        </div>
                                        <span><?php echo htmlspecialchars($product['pro_name'], ENT_QUOTES); ?></span>
                                    </div>
                                </th>
                                <td class="px-4 py-4">
                                    <?php
                                    $categoryName = "Uncategorized";
                                    if (isset($product['CategoryID'])) {
                                        try {
                                            $category = $db->read('tbcategory', $product['CategoryID']); // Assuming a 'tbcategories' table
                                            if ($category && isset($category['CategoryName'])) {
                                                $categoryName = $category['CategoryName'];
                                            }
                                        } catch (PDOException $e) {
                                            error_log("Category query failed: " . $e->getMessage());
                                        }
                                    }
                                    echo htmlspecialchars($categoryName, ENT_QUOTES);
                                    ?>
                                </td>
                                <td class="px-4 py-4">$<?php echo htmlspecialchars($product['price'], ENT_QUOTES); ?></td>
                                <td class="px-4 py-4"><?php echo ($product['prevPrice'] > 0 ? "$" . htmlspecialchars($product['prevPrice'], ENT_QUOTES) : "Null"); ?></td>
                                <td class="px-4 py-4 max-w-xs line-clamp-1"><?php echo htmlspecialchars($product['description'], ENT_QUOTES); ?></td>
                                <td class="px-4 py-4 text-nowrap text-[13px]"><?php echo htmlspecialchars($product['create_date'], ENT_QUOTES); ?></td>
                                <td class="px-4 py-4 text-nowrap">
                                    <button onclick="openEditModal(<?php echo $product['id']; ?>)" class="font-medium mr-3 cursor-pointer text-blue-600 hover:underline">Edit</button>
                                    <form action="" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        <input type="hidden" name="delete_product_id" value="<?php echo $product['id']; ?>">
                                        <button type="submit" class="font-medium cursor-pointer text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>