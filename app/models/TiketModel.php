<?php
require_once __DIR__ . '/../core/QueryBuilder.php';

class TiketModel {
    private $conn;
    private $builder;
    private $table = 'tiket';

    public function __construct($db) {
        $this->conn = $db;
        $this->builder = new QueryBuilder($db);
    }

    // Get all tickets with event info
    public function getAllTiket() {
        return $this->builder
            ->table($this->table . ' t')
            ->select(['t.id', 't.event_id', 'e.nama_event', 't.nama_tiket', 't.harga', 't.stok', 't.created_at'])
            ->leftJoin('events e', 't.event_id = e.id')
            ->orderBy('t.created_at', 'DESC')
            ->get();
    }

    public function getTiketById($id) {
        return $this->builder
            ->table($this->table)
            ->where('id', '=', $id)
            ->first();
    }

    public function createTiket($data) {
        return $this->builder
            ->table($this->table)
            ->insert([
                'event_id' => $data['event_id'],
                'nama_tiket' => $data['nama_tiket'],
                'harga' => $data['harga'],
                'stok' => $data['stok']
            ]);
    }

    public function updateTiket($id, $data) {
        return $this->builder
            ->table($this->table)
            ->where('id', '=', $id)
            ->update([
                'event_id' => $data['event_id'],
                'nama_tiket' => $data['nama_tiket'],
                'harga' => $data['harga'],
                'stok' => $data['stok']
            ]);
    }

    public function deleteTiket($id) {
        return $this->builder
            ->table($this->table)
            ->where('id', '=', $id)
            ->delete();
    }

    public function getTiketByEventId($event_id) {
        return $this->builder
            ->table($this->table)
            ->where('event_id', '=', $event_id)
            ->get();
    }

    // Reduce ticket stock
    public function reduceStok($tiket_id, $jumlah) {
        // This operation requires atomic decrement with condition; perform with raw query to preserve behavior
        $query = "UPDATE " . $this->table . " SET stok = stok - :jumlah WHERE id = :tiket_id AND stok >= :jumlah";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tiket_id', $tiket_id);
        $stmt->bindParam(':jumlah', $jumlah);

        if ($stmt->execute()) {
            return $stmt->rowCount() > 0;
        }
        return false;
    }

    // Check if ticket stock is sufficient
    public function hasEnoughStock($tiket_id, $jumlah) {
        $tiket = $this->getTiketById($tiket_id);
        return $tiket && $tiket['stok'] >= $jumlah;
    }
}
?>