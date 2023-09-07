<?php
require_once 'config.php';
class Category{
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    // Create a new category
    public function createCategory($name) {
        $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }
    // Read a category by category ID
    public function getCategoryById($categoryId) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
     // Update a category
     public function updateCategory($categoryId, $name) {
        $stmt = $this->conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $categoryId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }
    // Delete a category
    public function deleteCategory($categoryId) {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }
     // Get all categories
     public function getAllCategories() {
        $result = $this->conn->query("SELECT * FROM categories");

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
$category = new Category($conn);
