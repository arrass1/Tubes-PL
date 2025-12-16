<?php
class PembayaranModel {
    private $conn;
    private $table = 'pembayaran';

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create pembayaran record
     */
    public function createPembayaran($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (pemesanan_id, metode_pembayaran, jumlah_bayar, status_pembayaran, kode_pembayaran) 
                  VALUES (:pemesanan_id, :metode_pembayaran, :jumlah_bayar, :status_pembayaran, :kode_pembayaran)";
        
        $stmt = $this->conn->prepare($query);
        
        // Generate kode pembayaran
        $kode_pembayaran = 'PAY' . strtoupper(substr(md5(time() . rand()), 0, 10));
        
        $status = 'Menunggu';
        $stmt->bindParam(':pemesanan_id', $data['pemesanan_id']);
        $stmt->bindParam(':metode_pembayaran', $data['metode_pembayaran']);
        $stmt->bindParam(':jumlah_bayar', $data['jumlah_bayar']);
        $stmt->bindParam(':status_pembayaran', $status);
        $stmt->bindParam(':kode_pembayaran', $kode_pembayaran);
        
        if ($stmt->execute()) {
            return $kode_pembayaran;
        }
        return false;
    }

    /**
     * Get pembayaran by pemesanan_id
     */
    public function getPembayaranByPemesananId($pemesanan_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE pemesanan_id = :pemesanan_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':pemesanan_id', $pemesanan_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get pembayaran by kode
     */
    public function getPembayaranByKode($kode_pembayaran) {
        $query = "SELECT p.*, pm.*, e.nama_event, e.tanggal_event, e.lokasi, t.nama_tiket, c.nama as customer_nama, c.email as customer_email
                  FROM " . $this->table . " p
                  LEFT JOIN pemesanan pm ON p.pemesanan_id = pm.id
                  LEFT JOIN tiket t ON pm.tiket_id = t.id
                  LEFT JOIN events e ON t.event_id = e.id
                  LEFT JOIN customers c ON pm.customer_id = c.id
                  WHERE p.kode_pembayaran = :kode_pembayaran";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':kode_pembayaran', $kode_pembayaran);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update status pembayaran
     */
    public function updateStatusPembayaran($kode_pembayaran, $status) {
        $query = "UPDATE " . $this->table . " 
                  SET status_pembayaran = :status, tanggal_bayar = NOW() 
                  WHERE kode_pembayaran = :kode_pembayaran";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':kode_pembayaran', $kode_pembayaran);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    /**
     * Get all pembayaran (for admin)
     */
    public function getAllPembayaran() {
        $query = "SELECT p.*, pm.kode_booking, pm.jumlah_tiket, c.nama as customer_nama, e.nama_event
                  FROM " . $this->table . " p
                  LEFT JOIN pemesanan pm ON p.pemesanan_id = pm.id
                  LEFT JOIN customers c ON pm.customer_id = c.id
                  LEFT JOIN tiket t ON pm.tiket_id = t.id
                  LEFT JOIN events e ON t.event_id = e.id
                  ORDER BY p.tanggal_pembayaran DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>