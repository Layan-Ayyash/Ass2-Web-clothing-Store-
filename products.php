<?php
require_once 'dbconfig.in.php';

// Function to fetch all products from the database
function getAllProducts() {
    global $dbHost, $dbName, $dbUser, $dbPass;

    // Get the PDO connection
    $pdo = getPDOConnection($dbHost, $dbName, $dbUser, $dbPass);
    
    $sql = "SELECT * FROM product";
    
    // Prepare and execute the statement
    $stmt = $pdo->query($sql);
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $products;
}

// Function to fetch products by category from the database
function getProductsByCategory($category) {
    global $dbHost, $dbName, $dbUser, $dbPass;

    $pdo = getPDOConnection($dbHost, $dbName, $dbUser, $dbPass);
    
    $sql = "SELECT * FROM product WHERE Category = :category";
    
    // Prepare and execute the statement
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':category', $category);
    $stmt->execute();
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $products;
}

// Function to fetch products by name from the database
function getProductsByName($name) {
    global $dbHost, $dbName, $dbUser, $dbPass;

    $pdo = getPDOConnection($dbHost, $dbName, $dbUser, $dbPass);
    
    $sql = "SELECT * FROM product WHERE `Product Name` LIKE :name";
    
    // Prepare and execute the statement
    $stmt = $pdo->prepare($sql);
    $name = "%$name%";
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $products;
}

// Function to fetch products by price from the database
function getProductsByPrice($price) {
    global $dbHost, $dbName, $dbUser, $dbPass;

    $pdo = getPDOConnection($dbHost, $dbName, $dbUser, $dbPass);
    
    $sql = "SELECT * FROM product WHERE Price >= :price";
    
    // Prepare and execute the statement
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':price', $price);
    $stmt->execute();
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $products;
}





if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    if ($filter === 'name' && isset($_POST['search'])) {
        $name = $_POST['search'];
        // Fetch products by name
        $products = getProductsByName($name);
    } elseif ($filter === 'price' && isset($_POST['search'])) {
        $price = $_POST['search'];
        // Fetch products by price
        $products = getProductsByPrice($price);
    } elseif (isset($_POST['category_filter'])) {
        $category_filter = $_POST['category_filter'];
        // Fetch products by selected category
        $products = getProductsByCategory($category_filter);
    } else {
        // If filter is not set or invalid, fetch all products
        $products = getAllProducts();
    }
} elseif (isset($_POST['category_filter'])) {
    $category_filter = $_POST['category_filter'];
    // Fetch products by selected category
    $products = getProductsByCategory($category_filter);
} else {
    // If filter is not set, fetch all products
    $products = getAllProducts();
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

$categories = getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
</head>
<body>
<header>
        <img src="LayanShop.jpg" alt="image" height="400" width="400">
        <h1>Welcome to "Layan's Shop"</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Home Page</a></li>
                <li><a href="./ass/ass1/index.html">Shope page</a></li>
                <li><a href="./ass/ass1/contact.html">Contact Us</a></li>
                <li><a href="./ass/ass1/Reg.html">Register</a></li>
            </ul>
        </nav>
    </header>
    <!-- Link to insert a new product -->
    to Add a new product click on the following link <a href="add.php">Add New Product</a>
</br>
</br>
    or use the action below to edit or delete a products record
    <form method="POST" action="products.php">
        <label for="search">Search:</label>
        <input type="text" name="search" id="search" placeholder="Search...">
        
        <input type="radio" name="filter" id="name" value="name">
        <label for="name">Name</label>
        
        <input type="radio" name="filter" id="price" value="price">
        <label for="price">Price</label>
        
        <select name="category_filter">
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category ?>"><?= $category ?></option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit">Filter</button>
            </br>
            </br>
    </form>
    <fieldset>
    <legend>Advanced Product Search</legend>
        <table border="1">
        <caption>Products Table Result </caption>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product['Product ID'] ?></td>
            <td><?= $product['Product Name'] ?></td>
            <td><?= $product['Category'] ?></td>
            <td><?= $product['Price'] ?></td>
            <td><?= $product['Quantity'] ?></td>
            <td><img src="<?= $product['Photo'] ?>" alt="<?= $product['Product Name'] ?>" width="100"></td>
            <td>
                <a href="edit.php?id=<?= $product['Product ID'] ?>"><img src="./images/edit.jpg" alt="Edit" width="50" height="50"></a>
                <form method="POST" action="./delete.php">
                    <input type="hidden" name="id" value="<?= $product['Product ID'] ?>">
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')">
                    <img src="images/delete.jpg" alt="Delete" width="50" height="50">
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
        </fieldset>
</body>
<footer>
    <br> <br>
    <div>Last Update: <?php echo date("Y-m-d"); ?></div>
    <div>Store Address: [Salfeet-Rafat]</div>
    <div>Customer Support: Phone: [0568246916] | Email: [layanayyash7@gmail.com] | <a href="./ass/ass1/contact.html">Contact Us</a></div>
</footer>
</html>
