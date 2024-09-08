<?php

class Product {
    private $productId;
    private $productName;
    private $category;
    private $description;
    private $price;
    private $rating;
    private $productImage;

    // Constructor
    public function __construct($productId, $productName, $category, $description, $price, $rating, $productImage) {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->category = $category;
        $this->description = $description;
        $this->price = $price;
        $this->rating = $rating;
        $this->productImage = $productImage;
    }

    // Setters and getters
    public function getProductId() {
        return $this->productId;
    }

    public function getProductName() {
        return $this->productName;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getRating() {
        return $this->rating;
    }

    public function getProductImage() {
        return $this->productImage;
    }

    public function setProductId($productId) {
        $this->productId = $productId;
    }

    public function setProductName($productName) {
        $this->productName = $productName;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function setProductImage($productImage) {
        $this->productImage = $productImage;
    }

    // Method to display product details in a table row
    public function displayInTable() {
        return "
        <tr>
            <td><a href='view.php?id={$this->productId}'>{$this->productId}</a></td>
            <td>{$this->productName}</td>
            <td>{$this->category}</td>
            <td>{$this->description}</td>
            <td>\${$this->price}</td>
            <td><img src='{$this->productImage}' alt='{$this->productName}' width='100'></td>
        </tr>
        ";
    }

    // Method to display product page
    public function displayProductPage() {
        return "
        <main>
            <h1>{$this->productName}</h1>
            <img src='{$this->productImage}' alt='{$this->productName}' width='300'>
            <p><strong>Category:</strong> {$this->category}</p>
            <p><strong>Description:</strong> {$this->description}</p>
            <p><strong>Price:</strong> \${$this->price}</p>
            <p><strong>Rating:</strong> {$this->rating} / 5</p>
        </main>
        ";
    }
}

?>
