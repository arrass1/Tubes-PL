<?php
class PemesananModel {
    private $conn;
    private $table = 'pemesanan';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all orders
    public function getAllPemesanan() {
        $query = "SELECT p.*, e.nama_event, c.nama as customer_nama, c.email as customer_email 
                  FROM " . $this->table . " p
                  LEFT JOIN events e ON p.event_id = e.id
                  LEFT JOIN customers c ON p.customer_id = c.id
                  ORDER BY p.tanggal_pemesanan DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get order by ID
    public function getPemesananById($id) {
        $query = "SELECT p.*, e.nama_event, c.nama as customer_nama, c.email as customer_email 
                  FROM " . $this->table . " p
                  LEFT JOIN events e ON p.event_id = e.id
                  LEFT JOIN customers c ON p.customer_id = c.id
                  WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get orders by customer
    public function getPemesananByCustomer($customer_id) {
        $query = "SELECT p.*, e.nama_event, e.tanggal_event, e.lokasi 
                  FROM " . $this->table . " p
                  LEFT JOIN events e ON p.event_id = e.id
                  WHERE p.customer_id = :customer_id
                  ORDER BY p.tanggal_pemesanan DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create order
    public function createPemesanan($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (customer_id, event_id, jumlah_tiket, total_harga, status, kode_booking) 
                  VALUES (:customer_id, :event_id, :jumlah_tiket, :total_harga, :status, :kode_booking)";
        
        $stmt = $this->conn->prepare($query);
        
        // Generate booking code
        $kode_booking = 'BK' . strtoupper(substr(md5(time()), 0, 8));
        
        $status = 'Pending';
        $stmt->bindParam(':customer_id', $data['customer_id']);
        $stmt->bindParam(':event_id', $data['event_id']);
        $stmt->bindParam(':jumlah_tiket', $data['jumlah_tiket']);
        $stmt->bindParam(':total_harga', $data['total_harga']);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':kode_booking', $kode_booking);
        
        return $stmt->execute();
    }

    // Update order status
    public function updateStatusPemesanan($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    // Delete order
    public function deletePemesanan($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Get pending orders count
    public function getPendingCount() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE status = 'Pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    // Get orders statistics
    public function getStatistics() {
        $stats = [];

        // Total orders
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['total_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Pending orders
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE status = 'Pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['pending_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Approved orders
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE status = 'Disetujui'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['approved_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Rejected orders
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE status = 'Ditolak'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['rejected_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total revenue from approved orders
        $query = "SELECT SUM(total_harga) as total FROM " . $this->table . " WHERE status = 'Disetujui'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['total_revenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        return $stats;
    }
}
?>
