<?php
require_once 'include/dbh.inc.php';

try {
    $sql = "SELECT id, pro_name, imageUrl, price, prevPrice,description,create_date, CategoryID FROM tbproducts ORDER BY id DESC";
    $result = $pdo->query($sql);
    $products = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?> 

<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.inc.php' ?>
<body class=" bg-slate-50">
    <img src="" alt="">
    <?php include 'include/adside.inc.php' ?>
    <?php include 'include/header.inc.php' ?>
    <main class="ml-64 mr-3 p-6 pt-21">
      <div class=" py-5">
        <div class="bg-white shadow-sm rounded-lg p-6">
          <div class="grid grid-cols-2 -mx-2 items-center">
            <div class="w-full px-2">
              <div class="flex flex-wrap -mx-2">
                <div class="w-1/2 px-2">
                  <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search product..">
                </div>
                <div class="w-1/4 px-2">
                  <button class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md bg-white hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                      <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                    </svg>
                    <span class="ml-2">Filter</span>
                  </button>
                </div>
                <div class="w-1/4 px-2">
                  <div class="relative">
                    <button class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md bg-white hover:bg-gray-50">
                      Sort By
                      <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                      </svg>
                    </button>
                    <div class="absolute hidden right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                      <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Price</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Name</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Category</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="w-full px-2">
              <div class="flex justify-end">
                <button type="button" class="flex cursor-pointer items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="openModal()">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                  </svg>
                  <span class="ml-2">Add Products</span>
                </button>
              </div>
            </div>
          </div>
        </div>  

    <!-- Modal -->
        <div class="fixed inset-0 z-50 hidden" id="modal">
          <!-- Overlay -->
          <div class="absolute inset-0 bg-black/50" onclick="closeModal()"></div>

          <!-- Modal Content -->
          <div class="relative z-10 bg-white rounded-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 mx-auto mt-20">
            <div class="flex justify-between items-center pb-3">
              <h3 class="text-lg font-semibold mb-1">Add New Products</h3>
              <button type="button" class="cursor-pointer text-gray-500 hover:text-gray-700" onclick="closeModal()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
            <?php include 'include/productForm.inc.php' ?>
            
          </div>
        </div>
    </div>


      <div class="shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
          <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
              <th scope="col" class="p-4">
                <div class="flex items-center">
                  <input
                    id="checkbox-all-search"
                    type="checkbox"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2"
                  />
                  <label for="checkbox-all-search" class="sr-only"
                    >checkbox</label
                  >
                </div>
              </th>
              <th scope="col" class="px-4 py-3">Code</th>
              <th scope="col" class="px-4 py-3">Product name</th>
              <th scope="col" class="px-4 py-3">Category</th>
              <th scope="col" class="px-4 py-3">Price</th>
              <th scope="col" class="px-4 py-3 text-nowrap">Prev-price</th>
              <th scope="col" class="px-4 py-3">Description</th>
              <th scope="col" class="px-4 py-3 text-nowrap">Create Date</th>
              <th scope="col" class="px-4 py-3">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product): ?> 
              <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                <td class="w-4 p-4">
                  <div class="flex items-center">
                    <input
                      id="checkbox-table-search-1"
                      type="checkbox"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2"
                    />
                    <label for="checkbox-table-search-1" class="sr-only"
                      >checkbox</label
                    >
                  </div>
                </td>
                <td class="px-4 py-4"><?php echo $product['id'] ?></td>
                <th
                  scope="row"
                  class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap"
                >
                  <div class="flex items-center">
                    <div class="mr-3 w-[80px] h-[80px]">
                      <img
                        class=" w-full h-full cover rounded"
                        src="../image/products/<?php echo $product['imageUrl'];?>" alt="<?php echo htmlspecialchars($product['pro_name'], ENT_QUOTES); ?>">
                    </div>
                    <span ><?php echo htmlspecialchars($product['pro_name'], ENT_QUOTES); ?></span>
                  </div>
                </th>
                <td class="px-4 py-4">
                  <?php
                      $categoryName = "Uncategorized";
                      if (isset($product['CategoryID'])) { // Now access $product['CategoryID']
                        try {
                            $stmt = $pdo->prepare("SELECT CategoryName FROM tbcategory WHERE CategoryID = ?");
                            $stmt->execute([$product['CategoryID']]);
                            $category = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($category) {
                              $categoryName = $category['CategoryName']; // or $category['CategoryName'] if that's the actual column name
                            }
                            } catch (PDOException $e) {
                              error_log("Category query failed: " . $e->getMessage());
                            }
                      }
                      echo htmlspecialchars($categoryName, ENT_QUOTES);
                  ?>                                
                </td>
                <td class="px-4 py-4">$<?php echo $product['price'] ?></td>
                <td class="px-4 py-4"><?php echo ($product['prevPrice'] > 0 ? "$" . $product['prevPrice'] : "Null"); ?></td>
                <td class="px-4 py-4 line-clamp-1"><?php echo $product['description'] ?></td>
                <td class="px-4 py-4 text-nowrap text-[13px]"><?php echo $product['create_date'] ?></td>
                <td class="px-4 py-4">
                  <div class="flex items-center">
                    <a href="#" class="font-medium text-blue-600 hover:underline"
                      >Edit</a
                    >
                    <a
                      href="#"
                      class="font-medium text-red-600 hover:underline ms-3"
                      >Remove</a
                    >
                  </div>
                </td>
              </tr>  
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </main>

    <script>
  function openModal() {
    document.getElementById('modal').classList.remove('hidden');
  }

  function closeModal() {
    document.getElementById('modal').classList.add('hidden');
  }
</script>
</body>
</html>