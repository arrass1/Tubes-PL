<?php
class TiketModel {
    private $conn;
    private $table = 'tiket';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all tickets with event info
    public function getAllTiket() {
        $query = "SELECT t.id, t.event_id, e.nama_event, t.nama_tiket, t.harga, t.stok, t.created_at FROM " . $this->table . " t LEFT JOIN events e ON t.event_id = e.id ORDER BY t.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTiketById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createTiket($data) {
        $query = "INSERT INTO " . $this->table . " (event_id, nama_tiket, harga, stok) VALUES (:event_id, :nama_tiket, :harga, :stok)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $data['event_id']);
        $stmt->bindParam(':nama_tiket', $data['nama_tiket']);
        $stmt->bindParam(':harga', $data['harga']);
        $stmt->bindParam(':stok', $data['stok']);
        return $stmt->execute();
    }

    public function updateTiket($id, $data) {
        $query = "UPDATE " . $this->table . " SET event_id = :event_id, nama_tiket = :nama_tiket, harga = :harga, stok = :stok WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':event_id', $data['event_id']);
        $stmt->bindParam(':nama_tiket', $data['nama_tiket']);
        $stmt->bindParam(':harga', $data['harga']);
        $stmt->bindParam(':stok', $data['stok']);
        return $stmt->execute();
    }

    public function deleteTiket($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getTiketByEventId($event_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE event_id = :event_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
