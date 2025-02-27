<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../../DB_lib/Database.php';
    $db = new Database();

    $productName = htmlspecialchars($_POST['productName']);
    $productDescription = htmlspecialchars($_POST['productDescription']);
    $productPrice = floatval($_POST['productPrice']);
    $productPrevPrice = floatval($_POST['productPrevPrice']);
    $categoryID = intval($_POST['categoryID']);

    // Image Upload Handling (CRITICAL)
    
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/LampStore/image/products/";
 // Directory to store uploaded images (make sure it exists and has correct permissions)
    $target_file = basename($_FILES["productImage"]["name"]); // Use $_FILES["productImage"]
    $target_move = $target_dir . basename($_FILES["productImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // File Validation (Add more robust checks here)
    $check = getimagesize($_FILES["productImage"]["tmp_name"]); // Use $_FILES["productImage"]
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
    if ($_FILES["productImage"]["size"] > 500000) {
     // Example: 500KB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_types = array("jpg", "png", "jpeg", "gif");
    if(!in_array($imageFileType, $allowed_types)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }


    if ($uploadOk == 0) {
        die("Sorry, your file was not uploaded."); // Stop here if upload failed
    } else {
        if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_move)) {  // Use $_FILES["productImage"]
            // Image uploaded successfully, now insert into database

            // Validate other inputs (as before)
            if (empty($productName) || empty($productPrice) || empty($categoryID)) {
                die("All fields except image are required."); // Improved message
            }

            // try {
            //     $sql = "INSERT INTO tbproducts (pro_name, description, price, prevPrice, CategoryID, imageUrl) 
            //             VALUES (:productName, :productDescription, :productPrice, :productPrevPrice, :categoryID, :productImage)";
            //     $stmt = $pdo->prepare($sql);

            //     $stmt->bindParam(':productName', $productName);
            //     $stmt->bindParam(':productDescription', $productDescription);
            //     $stmt->bindParam(':productPrice', $productPrice);
            //     $stmt->bindParam(':productPrevPrice', $productPrevPrice);
            //     $stmt->bindParam(':categoryID', $categoryID);
            //     $stmt->bindParam(':productImage', $target_file); // Store the path!

            //     $stmt->execute();

            //     echo "Product inserted successfully!";
            // } catch (PDOException $e) {
            //     die("Error inserting product: " . $e->getMessage());
            // }
            $data = [
                'productName' => $productName,
                'productDescription' =>$productDescription,
                'productPrice' => $productPrice,
                'productPrevPrice' => $productPrevPrice,
                'categoryID' => $categoryID,
                'productImage' =>$target_file
            ];
            $result = $db->Insert('tbproducts', $data);
            
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    }


} else {
    die("Invalid request method.");
}

?>
