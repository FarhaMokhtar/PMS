<?php
require_once 'config.php';

class Order {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Create a new order
    public function createOrder($productId, $quantity, $total, $userId, $phone, $address) {
        $stmt = $this->conn->prepare("INSERT INTO orders (product_id, quantity, total, user_id, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iidsis", $productId, $quantity, $total, $userId, $phone, $address);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }
    // Read an order by order ID
    public function getOrderById($orderId) {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    // Update an order
    public function updateOrder($orderId, $productId, $quantity, $total, $userId, $phone, $address) {
        $stmt = $this->conn->prepare("UPDATE orders SET product_id = ?, quantity = ?, total = ?, user_id = ?, phone = ?, address = ? WHERE id = ?");
        $stmt->bind_param("iidsisi", $productId, $quantity, $total, $userId, $phone, $address, $orderId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    // Delete an order
    public function deleteOrder($orderId) {
        $stmt = $this->conn->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    // Get all orders
    public function getAllOrders() {
        $result = $this->conn->query("SELECT * FROM orders");

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

$order = new Order($conn);
?>
