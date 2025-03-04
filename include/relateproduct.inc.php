<?php
require_once './DB_lib/Database.php';  // Updated path to match your previous examples

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = intval($_GET['id']);

    try {
        $db = new Database();

        $products = $db->dbSelect(
            'tbproducts',           
            '*',                   
            'id = :id',           
            '',                   
            [':id' => $productId] 
        );

        if (empty($products)) {
            die("Product not found.");
        }
        
        $relatedProducts = $db->dbSelect(
            'tbproducts',                           
            '*',                                   
            'CategoryID = :category AND id != :id', 
            'LIMIT 4',                           
            [                                     
                ':category' => $product['CategoryID'],
                ':id' => $productId
            ]
        );

    } catch (Exception $e) {  
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
                            <img class="w-full h-full cover" style="max-height: 700px;" src="image/products/<?php echo $product['imageUrl'];?>" alt="<?php echo htmlspecialchars($product['pro_name'], ENT_QUOTES); ?>">
                        </div>
                        <div class="pt-3">
                            <p class="text-14px text-slate-700">
                            <?php
                                $categoryNameDisplay = "Uncategorized";
                                if (isset($product['CategoryID']) && !empty($product['CategoryID'])) {
                                    try {
                                        $category = $db->dbSelect(
                                            'tbcategory',
                                            '*',
                                            'id = :id',
                                            '',
                                            [':id' => $product['CategoryID']]
                                        );
                                        if (!empty($category)) {
                                            $categoryNameDisplay = $category[0]['CategoryName'];
                                        }
                                    } catch (PDOException $e) {
                                        error_log("Category query failed: " . $e->getMessage());
                                    }
                                }
                                echo htmlspecialchars($categoryNameDisplay, ENT_QUOTES);
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
