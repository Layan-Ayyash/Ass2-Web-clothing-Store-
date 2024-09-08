<?php
// Include the database configuration file
require_once 'dbconfig.in.php';

// Check if product ID is provided in the POST data
if(isset($_POST['id'])) {
    $productId = $_POST['id'];
    
    // Delete product from the database
    $pdo = getPDOConnection($dbHost, $dbName, $dbUser, $dbPass);
    $stmt = $pdo->prepare("DELETE FROM product WHERE `Product ID` = :id");
    $stmt->execute(['id' => $productId]);
}

// Redirect to product list after deletion
header("Location: products.php");
exit;

?>
<footer>
    <br> <br>
    <div>Last Update: <?php echo date("Y-m-d"); ?></div>
    <div>Store Address: [Salfeet-Rafat]</div>
    <div>Customer Support: Phone: [0568246916] | Email: [layanayyash7@gmail.com] | <a href="./ass/ass1/contact.html">Contact Us</a></div>
</footer>
