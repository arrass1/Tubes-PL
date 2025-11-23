<?php
class CustomerModel {
    private $conn;
    private $table = 'customers';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all customers
    public function getAllCustomers() {
        $query = "SELECT id AS user_id, nama, email, no_telepon, role, tanggal_daftar FROM " . $this->table . " ORDER BY tanggal_daftar DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get customer by id
    public function getCustomerById($id) {
        $query = "SELECT id AS user_id, nama, email, no_telepon, role, tanggal_daftar FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create customer
    public function createCustomer($data) {
        $query = "INSERT INTO " . $this->table . " (nama, email, password, no_telepon, role) VALUES (:nama, :email, :password, :no_telepon, :role)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':no_telepon', $data['no_telepon']);
        $stmt->bindParam(':role', $data['role']);
        return $stmt->execute();
    }

    // Update customer
    public function updateCustomer($id, $data) {
        $query = "UPDATE " . $this->table . " SET nama = :nama, email = :email, no_telepon = :no_telepon, role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $data['nama']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':no_telepon', $data['no_telepon']);
        $stmt->bindParam(':role', $data['role']);
        return $stmt->execute();
    }

    // Delete customer
    public function deleteCustomer($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
