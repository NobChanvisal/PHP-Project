<?php
require_once 'include/dbh.inc.php';

try {
    $categoryName = "All Products"; // Default category name

    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $category = $_GET['category'];

        // Fetch the category name
        $stmt = $pdo->prepare("SELECT CategoryName FROM tbcategory WHERE CategoryID = ?");
        $stmt->execute([$category]);
        $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($categoryData) {
            $categoryName = $categoryData['CategoryName'];
        }

        // Fetch products by category
        $sql = "SELECT * FROM tbproducts WHERE CategoryID = :category ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['category' => $category]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Fetch all products if no category is selected
        $sql = "SELECT * FROM tbproducts ORDER BY id DESC"; 
        $products = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>


<section>
  <div class="category-name relative pt-[88px]">
    <div class="absolute inset-0 flex justify-center items-center">
        <h1 class="uppercase text-4xl tracking-widest pt-1">
            <?= htmlspecialchars($categoryName, ENT_QUOTES) ?>
        </h1>
    </div>
    <img
      class="w-full h-[50vh] object-cover border-b "
      src="https://i.pinimg.com/736x/85/0a/5c/850a5c9d0f73a5f570094640eb5802ea.jpg"
      alt=""
    />
  </div>
</section>

<main>
    <img src="" alt="">
  <div class="px-5 sm:px-10 sm:px-20 py-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
  <?php foreach ($products as $product): ?>  <div class="relative">
                    <a href="productPage.php?id=<?php echo $product['id']; ?>">
                        <?php if ($product['prevPrice'] > 0): ?>
                            <div class="absolute top-0 left-0 rounded-full flex items-center bg-red-100 m-3 py-0.5 px-2.5 border border-transparent text-sm text-red-800 transition-all shadow-sm">
                                -<?php echo round(($product['prevPrice'] - $product['price']) / $product['prevPrice'] * 100, 0); ?>%
                            </div>
                        <?php endif; ?>

                        <div>
                            <img class="w-full cover" src="image/products/<?php echo $product['imageUrl'];?>" alt="<?php echo htmlspecialchars($product['pro_name'], ENT_QUOTES); ?>">
                        </div>
                        <div class="pt-3">
                            <p class="text-14px text-slate-700">
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
                            </p>
                            <p class="text-[17px] font-semibold"><?php echo htmlspecialchars($product['pro_name'], ENT_QUOTES); ?></p>
                            <p>$<?php echo $product['price']; ?><span class="pl-3 text-slate-600 line-through"><?php echo ($product['prevPrice'] > 0 ? "$" . $product['prevPrice'] : ""); ?></span></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
  </div>
</main>
