<?php
require_once __DIR__ . '/../core/QueryBuilder.php';

class PemesananModel {
    private $conn;
    private $builder;
    private $table = 'pemesanan';

    public function __construct($db) {
        $this->conn = $db;
        $this->builder = new QueryBuilder($db);
    }

    // Get all orders
    public function getAllPemesanan() {
        return $this->builder
            ->table($this->table . ' p')
            ->select(['p.*', 't.nama_tiket', 't.harga AS tiket_harga', 'e.nama_event', 'e.tanggal_event', 'c.nama as customer_nama', 'c.email as customer_email'])
            ->leftJoin('tiket t', 'p.tiket_id = t.id')
            ->leftJoin('events e', 't.event_id = e.id')
            ->leftJoin('customers c', 'p.customer_id = c.id')
            ->orderBy('p.tanggal_pemesanan', 'DESC')
            ->get();
    }

    // Get order by ID
    public function getPemesananById($id) {
        return $this->builder
            ->table($this->table . ' p')
            ->select(['p.*', 't.nama_tiket', 't.harga AS tiket_harga', 'e.nama_event', 'c.nama as customer_nama', 'c.email as customer_email'])
            ->leftJoin('tiket t', 'p.tiket_id = t.id')
            ->leftJoin('events e', 't.event_id = e.id')
            ->leftJoin('customers c', 'p.customer_id = c.id')
            ->where('p.id', '=', $id)
            ->first();
    }

    // Get orders by customer
    public function getPemesananByCustomer($customer_id) {
        return $this->builder
            ->table($this->table . ' p')
            ->select(['p.*', 't.nama_tiket', 't.harga AS tiket_harga', 'e.nama_event', 'e.tanggal_event', 'e.lokasi'])
            ->leftJoin('tiket t', 'p.tiket_id = t.id')
            ->leftJoin('events e', 't.event_id = e.id')
            ->where('p.customer_id', '=', $customer_id)
            ->orderBy('p.tanggal_pemesanan', 'DESC')
            ->get();
    }

    // Create order
    public function createPemesanan($data) {
        // Generate booking code
        $kode_booking = 'BK' . strtoupper(substr(md5(time()), 0, 8));

        $insertData = [
            'customer_id' => $data['customer_id'],
            'tiket_id' => $data['tiket_id'],
            'jumlah_tiket' => $data['jumlah_tiket'],
            'total_harga' => $data['total_harga'],
            'status' => 'Pending',
            'kode_booking' => $kode_booking
        ];

        return $this->builder
            ->table($this->table)
            ->insert($insertData);
    }

    // Update order status
    public function updateStatusPemesanan($id, $status) {
        return $this->builder
            ->table($this->table)
            ->where('id', '=', $id)
            ->update(['status' => $status]);
    }

    // Delete order
    public function deletePemesanan($id) {
        return $this->builder
            ->table($this->table)
            ->where('id', '=', $id)
            ->delete();
    }

    // Get pending orders count
    public function getPendingCount() {
        return $this->builder
            ->table($this->table)
            ->where('status', '=', 'Pending')
            ->count();
    }

    // Get orders statistics
    public function getStatistics() {
        $stats = [];

        // Total orders
        $stats['total_orders'] = $this->builder->table($this->table)->count();

        // Pending orders
        $stats['pending_orders'] = $this->builder->table($this->table)->where('status', '=', 'Pending')->count();

        // Approved orders
        $stats['approved_orders'] = $this->builder->table($this->table)->where('status', '=', 'Disetujui')->count();

        // Rejected orders
        $stats['rejected_orders'] = $this->builder->table($this->table)->where('status', '=', 'Ditolak')->count();

        // Total revenue from approved orders
        $res = $this->builder->table($this->table)
            ->select('SUM(total_harga) as total')
            ->where('status', '=', 'Disetujui')
            ->first();

        $stats['total_revenue'] = $res['total'] ?? 0;

        return $stats;
    }

    /**
     * Check if there are any pemesanan for a given tiket id
     */
    public function hasOrdersForTiket($tiket_id) {
        return $this->builder
            ->table($this->table)
            ->where('tiket_id', '=', $tiket_id)
            ->count() > 0;
    }

    /**
     * Check if there are any pemesanan for a given event id (via tiket)
     */
    public function hasOrdersForEvent($event_id) {
        // join tiket to pemesanan and count
        return $this->builder
            ->table($this->table . ' p')
            ->leftJoin('tiket t', 'p.tiket_id = t.id')
            ->where('t.event_id', '=', $event_id)
            ->count() > 0;
    }

    /**
     * Delete pemesanan (and related pembayaran) for a given tiket id
     */
    public function deleteByTiketId($tiket_id) {
        // find pemesanan ids for this tiket
        $stmt = $this->conn->prepare("SELECT id FROM pemesanan WHERE tiket_id = :tiket_id");
        $stmt->bindParam(':tiket_id', $tiket_id);
        $stmt->execute();
        $pemesananIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($pemesananIds)) {
            // delete related pembayaran
            $placeholders = implode(',', array_fill(0, count($pemesananIds), '?'));
            $delPemb = $this->conn->prepare("DELETE FROM pembayaran WHERE pemesanan_id IN ({$placeholders})");
            $delPemb->execute($pemesananIds);

            // delete pemesanan rows
            $delPem = $this->conn->prepare("DELETE FROM pemesanan WHERE tiket_id = :tiket_id");
            $delPem->bindParam(':tiket_id', $tiket_id);
            return $delPem->execute();
        }

        return true;
    }

    /**
     * Delete pemesanan (and related pembayaran) for all tickets of an event
     */
    public function deleteByEventId($event_id) {
        // find tiket ids for this event
        $stmt = $this->conn->prepare("SELECT id FROM tiket WHERE event_id = :event_id");
        $stmt->bindParam(':event_id', $event_id);
        $stmt->execute();
        $tiketIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($tiketIds)) return true;

        // find pemesanan ids for these tiket ids
        $placeholders = implode(',', array_fill(0, count($tiketIds), '?'));
        $selPem = $this->conn->prepare("SELECT id FROM pemesanan WHERE tiket_id IN ({$placeholders})");
        $selPem->execute($tiketIds);
        $pemesananIds = $selPem->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($pemesananIds)) {
            // delete related pembayaran
            $ph2 = implode(',', array_fill(0, count($pemesananIds), '?'));
            $delPemb = $this->conn->prepare("DELETE FROM pembayaran WHERE pemesanan_id IN ({$ph2})");
            $delPemb->execute($pemesananIds);

            // delete pemesanan rows
            $delPem = $this->conn->prepare("DELETE FROM pemesanan WHERE tiket_id IN ({$placeholders})");
            $delPem->execute($tiketIds);
            return true;
        }

        return true;
    }
}
?>