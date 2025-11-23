<?php
class EventModel {
    private $conn;
    private $table = 'events';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all events
    public function getAllEvents() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY tanggal_event DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get event by ID
    public function getEventById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create event
    public function createEvent($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (nama_event, deskripsi, tanggal_event, lokasi, harga_tiket, kapasitas, kategori, status) 
                  VALUES (:nama_event, :deskripsi, :tanggal_event, :lokasi, :harga_tiket, :kapasitas, :kategori, :status)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nama_event', $data['nama_event']);
        $stmt->bindParam(':deskripsi', $data['deskripsi']);
        $stmt->bindParam(':tanggal_event', $data['tanggal_event']);
        $stmt->bindParam(':lokasi', $data['lokasi']);
        $stmt->bindParam(':harga_tiket', $data['harga_tiket']);
        $stmt->bindParam(':kapasitas', $data['kapasitas']);
        $stmt->bindParam(':kategori', $data['kategori']);
        $stmt->bindParam(':status', $data['status']);
        
        return $stmt->execute();
    }

    // Update event
    public function updateEvent($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET nama_event = :nama_event, 
                      deskripsi = :deskripsi, 
                      tanggal_event = :tanggal_event, 
                      lokasi = :lokasi, 
                      harga_tiket = :harga_tiket, 
                      kapasitas = :kapasitas, 
                      kategori = :kategori, 
                      status = :status 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama_event', $data['nama_event']);
        $stmt->bindParam(':deskripsi', $data['deskripsi']);
        $stmt->bindParam(':tanggal_event', $data['tanggal_event']);
        $stmt->bindParam(':lokasi', $data['lokasi']);
        $stmt->bindParam(':harga_tiket', $data['harga_tiket']);
        $stmt->bindParam(':kapasitas', $data['kapasitas']);
        $stmt->bindParam(':kategori', $data['kategori']);
        $stmt->bindParam(':status', $data['status']);
        
        return $stmt->execute();
    }

    // Delete event
    public function deleteEvent($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Get statistics
    public function getStatistics() {
        $stats = [];
        
        // Total events
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['total_events'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Upcoming events
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE tanggal_event >= CURDATE() AND status = 'Aktif'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['upcoming_events'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Total sold tickets
        $query = "SELECT COALESCE(SUM(jumlah_tiket), 0) as total FROM pemesanan";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stats['total_tickets'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return $stats;
    }

    // Search events
    public function searchEvents($keyword) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE nama_event LIKE :keyword 
                  OR lokasi LIKE :keyword 
                  OR kategori LIKE :keyword 
                  ORDER BY tanggal_event DESC";
        
        $stmt = $this->conn->prepare($query);
        $searchTerm = "%{$keyword}%";
        $stmt->bindParam(':keyword', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>