<?php
require_once 'include/dbh.inc.php';

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    try {
        // Fetch current product details
        $stmt = $pdo->prepare("SELECT * FROM tbproducts WHERE id = :id");
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            die("Product not found.");
        }

        // Fetch related products by category
        $stmt = $pdo->prepare("SELECT * FROM tbproducts WHERE CategoryID = :category AND id != :id LIMIT 4");
        $stmt->bindParam(':category', $product['CategoryID'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $relatedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    die("Invalid product ID.");
}
?>

<section>
    <div class="mt-10">
        <h1 class="px-20 pb-2 text-[30px]">Related Products</h1>
        <div class="px-20 py-5 grid grid-cols-4 gap-5">
        <?php foreach ($relatedProducts as $product): ?>  <div class="relative">
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
