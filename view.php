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

// Check if product ID is provided in the query string
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $product = getProductById($productId); // Retrieve product details from the database
    
    if ($product) {
        // Display product details
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Product Details</title>
        </head>
        <body>
        <header>
        <img src="LayanShop.jpg" alt="image" height="400" width="400">
        <h1>Welcome to "Layan's Shop"</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Home Page</a></li>
                <li><a href="./ass/ass2/products.php">Shope Page</a></li>
                <li><a href="./ass/ass1/contact.html">Contact Us</a></li>
                <li><a href="./ass/ass1/Reg.html">Register</a></li>
            </ul>
        </nav>
    </header>
            <h1>Product Details</h1>
            <table border="1">
                <tr>
                    <th>Product ID</th>
                    <td><?= $product['Product ID'] ?></td>
                </tr>
                <tr>
                    <th>Product Name</th>
                    <td><?= $product['Product Name'] ?></td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td><?= $product['Category'] ?></td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td><?= $product['Price'] ?></td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td><?= $product['Quantity'] ?></td>
                </tr>
                <tr>
                    <th>Rating</th>
                    <td><?= $product['Rating'] ?></td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td><?= $product['Description'] ?></td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td><img src="<?= $product['Photo'] ?>" alt="<?= $product['Product Name'] ?>" width="100"></td>
                </tr>
            </table>
        </body>
        </html>
        <?php
    } else {
        // Product not found, display error message
        echo "Product not found.";
    }
} else {
    // No product ID provided, display error message
    echo "Invalid product ID.";
}
?>
