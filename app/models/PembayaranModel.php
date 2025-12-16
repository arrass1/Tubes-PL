<?php
require_once __DIR__ . '/../core/QueryBuilder.php';

class PembayaranModel {
    private $conn;
    private $builder;
    private $table = 'pembayaran';

    public function __construct($db) {
        $this->conn = $db;
        $this->builder = new QueryBuilder($db);
    }

    /**
     * Create pembayaran record
     */
    public function createPembayaran($data) {
        // Generate kode pembayaran
        $kode_pembayaran = 'PAY' . strtoupper(substr(md5(time() . rand()), 0, 10));

        $insertData = [
            'pemesanan_id' => $data['pemesanan_id'],
            'metode_pembayaran' => $data['metode_pembayaran'],
            'jumlah_bayar' => $data['jumlah_bayar'],
            'status_pembayaran' => 'Menunggu',
            'kode_pembayaran' => $kode_pembayaran
        ];

        $ok = $this->builder
            ->table($this->table)
            ->insert($insertData);

        return $ok ? $kode_pembayaran : false;
    }

    /**
     * Get pembayaran by pemesanan_id
     */
    public function getPembayaranByPemesananId($pemesanan_id) {
        return $this->builder
            ->table($this->table)
            ->where('pemesanan_id', '=', $pemesanan_id)
            ->first();
    }

    /**
     * Get pembayaran by kode
     */
    public function getPembayaranByKode($kode_pembayaran) {
        return $this->builder
            ->table($this->table . ' p')
            ->select(['p.*', 'pm.*', 'e.nama_event', 'e.tanggal_event', 'e.lokasi', 't.nama_tiket', 'c.nama as customer_nama', 'c.email as customer_email'])
            ->leftJoin('pemesanan pm', 'p.pemesanan_id = pm.id')
            ->leftJoin('tiket t', 'pm.tiket_id = t.id')
            ->leftJoin('events e', 't.event_id = e.id')
            ->leftJoin('customers c', 'pm.customer_id = c.id')
            ->where('p.kode_pembayaran', '=', $kode_pembayaran)
            ->first();
    }

    /**
     * Update status pembayaran
     */
    public function updateStatusPembayaran($kode_pembayaran, $status) {
        // Update status via builder then set timestamp via a small raw query
        $ok = $this->builder
            ->table($this->table)
            ->where('kode_pembayaran', '=', $kode_pembayaran)
            ->update(['status_pembayaran' => $status]);

        if ($ok) {
            // set tanggal_bayar to NOW()
            $quoted = $this->conn->quote($kode_pembayaran);
            $this->conn->exec("UPDATE {$this->table} SET tanggal_bayar = NOW() WHERE kode_pembayaran = {$quoted}");
        }

        return (bool) $ok;
    }

    /**
     * Get all pembayaran (for admin)
     */
    public function getAllPembayaran() {
        return $this->builder
            ->table($this->table . ' p')
            ->select(['p.*', 'pm.kode_booking', 'pm.jumlah_tiket', 'c.nama as customer_nama', 'e.nama_event'])
            ->leftJoin('pemesanan pm', 'p.pemesanan_id = pm.id')
            ->leftJoin('customers c', 'pm.customer_id = c.id')
            ->leftJoin('tiket t', 'pm.tiket_id = t.id')
            ->leftJoin('events e', 't.event_id = e.id')
            ->orderBy('p.tanggal_pembayaran', 'DESC')
            ->get();
    }
}
?>