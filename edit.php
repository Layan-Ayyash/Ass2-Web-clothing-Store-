<?php
require_once 'dbconfig.in.php';

// Function to get product details by ID from the database
function getProductById($productId) {
    global $dbHost, $dbName, $dbUser, $dbPass;
    $pdo = getPDOConnection($dbHost, $dbName, $dbUser, $dbPass);
    
    $sql = "SELECT * FROM product WHERE `Product ID` = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to get all categories
function getAllCategories() {
    global $dbHost, $dbName, $dbUser, $dbPass;
    $pdo = getPDOConnection($dbHost, $dbName, $dbUser, $dbPass);
    $sql = "SELECT DISTINCT Category FROM product";
    $stmt = $pdo->query($sql);
    $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
    return $categories;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Retrieve product details from the database based on the product ID
    $productId = $_GET['id'];
    $product = getProductById($productId); // Implement getProductById function to fetch product details by ID
    
    if ($product) {
        // Get all categories
        $categories = getAllCategories();
        
        // Display the HTML form pre-filled with the product details
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Product</title>
        </head>
        <body>
        <header>
        <img src="LayanShop.jpg" alt="image" height="400" width="400">
        <h1>Welcome to "Layan's Shop"</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Home Page</a></li>
                <li><a href="/ass/ass1/index.html">Ahope page</a></li>
                <li><a href="/ass/ass1/contact.html">Contact Us</a></li>
                <li><a href="/ass/ass1/Reg.html">Register</a></li>
            </ul>
        </nav>
    </header>
            <h1>Edit Product</h1>
            <form method="POST" action="edit.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $productId ?>">
                <fieldset>
                    <legend>Product Record</legend>
                    <label for="productID">Product ID:</label>
                    <input type="text" name="productID" id="productID" value="<?= $product['Product ID'] ?>" readonly><br><br>
                    
                    <label for="productName">Product Name:</label>
                    <input type="text" name="productName" id="productName" value="<?= $product['Product Name'] ?>" required><br><br>
                    
                    <label for="category">Category:</label>
                    <select name="category" id="category" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category ?>" <?= $category === $product['Category'] ? 'selected' : '' ?>><?= $category ?></option>
                        <?php endforeach; ?>
                    </select><br><br>
                    
                    <label for="price">Price:</label>
                    <input type="number" name="price" id="price" value="<?= $product['Price'] ?>" required><br><br>
                    
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" value="<?= $product['Quantity'] ?>" required><br><br>
                    
                    <label for="rating">Rating:</label>
                    <input type="number" name="rating" id="rating" value="<?= $product['Rating'] ?>" step="1" min="0" max="5" required><br><br>
                    
                    <label for="description">Description:</label><br>
                    <textarea name="description" id="description" rows="4" cols="50" required><?= $product['Description'] ?></textarea><br><br>
                    
                    <label for="photo">Product Photo (JPEG only):</label>
                    <input type="file" name="photo" id="photo" accept="image/jpeg"><br><br>
                    
                    <button type="submit">Update Product</button>
                </fieldset>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Product not found.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Update product details in the database
    $productId = $_POST['id'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    
    // Handle photo upload if provided
    $photo = $_FILES['photo'];
    if ($photo['type'] === 'image/jpeg') {
        $photoName = "images/$productId.jpeg";
        move_uploaded_file($photo['tmp_name'], $photoName);
    }
    
    // Update product details in the database
    updateProduct($productId, $price, $quantity, $description, $photoName); // Implement updateProduct function to update product details
    
    // Redirect to the same edit page with a success message or display a confirmation message here
    header("Location: edit.php?id=$productId&success=true");
    exit();
} else {
    echo "Invalid request.";
}
?>
<footer>
    <br> <br>
    <div>Last Update: <?php echo date("Y-m-d"); ?></div>
    <div>Store Address: [Salfeet-Rafat]</div>
    <div>Customer Support: Phone: [0568246916] | Email: [layanayyash7@gmail.com] | <a href="./ass/ass1/contact.html">Contact Us</a></div>
</footer>