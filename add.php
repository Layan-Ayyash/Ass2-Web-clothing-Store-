<?php
require_once 'dbconfig.in.php';

// Function to insert a new product into the database
function addProduct($productName, $category, $price, $quantity, $rating, $description, $photo) {
    global $dbHost, $dbName, $dbUser, $dbPass;
    $pdo = getPDOConnection($dbHost, $dbName, $dbUser, $dbPass);
    
    $sql = "INSERT INTO product (`Product Name`, Category, Price, Quantity, Rating, Description, Photo) 
            VALUES (:productName, :category, :price, :quantity, :rating, :description, :photo)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':productName', $productName);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':photo', $photo);
    
    $stmt->execute();
    
    return $pdo->lastInsertId();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if form data is set
    if (isset($_POST['productName'], $_POST['category'], $_POST['price'], $_POST['quantity'], $_POST['rating'], $_POST['description']) && isset($_FILES['photo'])) {
        $productName = $_POST['productName'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $rating = $_POST['rating'];
        $description = $_POST['description'];
        
        // Handle photo upload
        $photo = $_FILES['photo'];
        if ($photo['type'] === 'image/jpeg') {
            // Insert product into database to get product ID
            $photoName = ''; // Will be updated after we get the product ID
            $productId = addProduct($productName, $category, $price, $quantity, $rating, $description, $photoName);
            
            // Rename the file to be the same as the product ID
            $photoName = "images/$productId.jpeg";
            if (move_uploaded_file($photo['tmp_name'], $photoName)) {
                // Update product with correct photo name
                $pdo = getPDOConnection($dbHost, $dbName, $dbUser, $dbPass);
                $sql = "UPDATE product SET Photo = :photo WHERE `Product ID` = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':photo', $photoName);
                $stmt->bindParam(':id', $productId);
                $stmt->execute();
                
                echo "Product added successfully!";
            } else {
                echo "Failed to upload photo.";
            }
        } else {
            echo "Only JPEG images are allowed.";
        }
    } else {
        echo "All fields are required.";
    }
} else {
    // Display the form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
</head>
<body>
<header>
        <img src="LayanShop.jpg" alt="image" height="400" width="400">
        <h1>Welcome to "Layan's Shop"</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Home Page</a></li>
                <li><a href="./ass/ass1/index.html">Shope Page</a></li>
                <li><a href="./ass/ass1/contact.html">Contact Us</a></li>
                <li><a href="./ass/ass1/Reg.html">Register</a></li>
            </ul>
        </nav>
    </header>
    <h1>Add New Product</h1>
    <form method="POST" action="add.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Product Record</legend>
            <label for="productName">Product Name:</label>
            <input type="text" name="productName" id="productName" required><br><br>
            
            <label for="category">Category:</label>
            <input type="text" name="category" id="category" required><br><br>
            
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" required><br><br>
            
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" required><br><br>

            <label for="rating">Rating:</label>
            <input type="number" name="rating" id="rating" step="1" min="0" max="5" required><br><br>
            
            <label for="description">Description:</label><br>
            <textarea name="description" id="description" rows="4" cols="50" required></textarea><br><br>
            
            <label for="photo">Product Photo (JPEG only):</label>
            <input type="file" name="photo" id="photo" accept="image/jpeg" required><br><br>
            
            <button type="submit">Add Product</button>
        </fieldset>
    </form>
</body>
<footer>
    <br> <br>
    <div>Last Update: <?php echo date("Y-m-d"); ?></div>
    <div>Store Address: [Salfeet-Rafat]</div>
    <div>Customer Support: Phone: [0568246916] | Email: [layanayyash7@gmail.com] | <a href="./ass/ass1/contact.html">Contact Us</a></div>
</footer>
</html>
<?php
}
?>
