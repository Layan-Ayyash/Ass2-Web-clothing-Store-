<?php
// Database configuration
$dbHost = 'localhost';
$dbName = 'clothingstore';
$dbUser = 'root';
$dbPass = '';

// Function to get a PDO connection
function getPDOConnection($dbHost, $dbName, $dbUser, $dbPass) {
    try {
        // Create the PDO object with the appropriate DSN (Data Source Name)
        $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
        $pdo = new PDO($dsn, $dbUser, $dbPass);

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Optional: Set default fetch mode to FETCH_ASSOC
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    } catch (PDOException $e) {
        // Display the error message and stop the script
        die('Database connection failed: ' . $e->getMessage());
    }
}
?>
