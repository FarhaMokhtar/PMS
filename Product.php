<?php
require_once 'config.php';

class Product {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
     // Create a new product
     public function createProduct($categoryId, $name, $price, $description, $stock) {
        $stmt = $this->conn->prepare("INSERT INTO products (category_id, name, price, description, stock) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issdi", $categoryId, $name, $price, $description, $stock);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }
    // Read a product by product ID
    public function getProductById($productId) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
    // Update a product
    public function updateProduct($productId, $categoryId, $name, $price, $description, $stock) {
        $stmt = $this->conn->prepare("UPDATE products SET category_id = ?, name = ?, price = ?, description = ?, stock = ? WHERE id = ?");
        $stmt->bind_param("issdii", $categoryId, $name, $price, $description, $stock, $productId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    // Delete a product
    public function deleteProduct($productId) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    // Get all products
    public function getAllProducts() {
        $result = $this->conn->query("SELECT * FROM products");

        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
$product = new Product($conn);
