<?php
require_once './DB_lib/Database.php';

try {
    $db = new Database();
    $categoryName = "All Products"; // Default category name

    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $category = $_GET['category'];

        // Fetch the category name
        $categoryResult = $db->dbSelect(
            'tbcategory',
            '*',
            'id = :category',
            '',
            [':category' => $category]
        );
        
        if (!empty($categoryResult)) {
            $categoryName = $categoryResult[0]['CategoryName'];
        }

        // Fetch products by category
        $products = $db->dbSelect(
            'tbproducts',
            '*',
            'CategoryID = :category',
            'ORDER BY id DESC',
            [':category' => $category]
        );
    } else {
        // Fetch all products
        $products = $db->dbSelect(
            'tbproducts',
            '*',
            '',
            'ORDER BY id DESC'
        );
    }

} catch (Exception $e) {  // Changed from PDOException to Exception since constructor throws Exception
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
            class="w-full h-[50vh] object-cover border-b"
            src="https://i.pinimg.com/736x/85/0a/5c/850a5c9d0f73a5f570094640eb5802ea.jpg"
            alt="Category banner"
        />
    </div>
</section>

<main>
    <div class="px-5 sm:px-10 lg:px-20 py-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="relative">
                    <a href="productPage.php?id=<?= htmlspecialchars($product['id'], ENT_QUOTES) ?>">
                        <?php if ($product['prevPrice'] > 0): ?>
                            <div class="absolute top-0 left-0 rounded-full flex items-center bg-red-100 m-3 py-0.5 px-2.5 border border-transparent text-sm text-red-800 transition-all shadow-sm">
                                -<?= round(($product['prevPrice'] - $product['price']) / $product['prevPrice'] * 100, 0) ?>%
                            </div>
                        <?php endif; ?>

                        <div>
                            <img 
                                class="w-full cover" style="max-height: 700px;"
                                src="image/products/<?= htmlspecialchars($product['imageUrl'], ENT_QUOTES) ?>" 
                                alt="<?= htmlspecialchars($product['pro_name'], ENT_QUOTES) ?>"
                            >
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
                            <p class="text-[17px] font-semibold"><?= htmlspecialchars($product['pro_name'], ENT_QUOTES) ?></p>
                            <p>
                                $<?= htmlspecialchars($product['price'], ENT_QUOTES) ?>
                                <span class="pl-3 text-slate-600 line-through">
                                    <?= ($product['prevPrice'] > 0 ? "$" . htmlspecialchars($product['prevPrice'], ENT_QUOTES) : "") ?>
                                </span>
                            </p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</main>