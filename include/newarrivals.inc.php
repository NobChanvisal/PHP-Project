<?php
require_once 'include/dbh.inc.php';

try {
    $sql = "SELECT id, pro_name, imageUrl, price, prevPrice, CategoryID FROM tbproducts ORDER BY id DESC LIMIT 4";
    $result = $pdo->query($sql);
    $products = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>    

<section>
    <div class="mt-10">
        <div class=" text-center">
          <h1 class=" text-4xl mb-4">New Arrivals</h1>
          <p class="px-5 max-w-lg mx-auto">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
        <div class="px-5 sm:px-10 md:px-20 py-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
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
    </div>
</section>