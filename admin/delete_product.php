<?php
require_once 'include/dbh.inc.php';

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    try {
        // Get the image filename from the database
        $stmt = $pdo->prepare("SELECT imageUrl FROM tbproducts WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $imagePath = "../image/products/" . $product['imageUrl']; // Path to the image

            // Delete the image file if it exists
            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath);
            }

            // Delete the product from the database
            $stmt = $pdo->prepare("DELETE FROM tbproducts WHERE id = ?");
            $stmt->execute([$productId]);

            header("Location: products.php");
            
        } else {
            echo "Product not found.";
        }
    } catch (PDOException $e) {
        echo "Error deleting product: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
