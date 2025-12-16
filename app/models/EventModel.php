<?php
require_once __DIR__ . '/../core/QueryBuilder.php';

class EventModel {
    private $db;
    private $builder;
    private $table = 'events';

    public function __construct($db) {
        $this->db = $db;
        $this->builder = new QueryBuilder($db);
    }

    /**
     * Get all events
     */
    public function getAllEvents() {
        return $this->builder
            ->table($this->table)
            ->orderBy('tanggal_event', 'DESC')
            ->get();
    }

    /**
     * Get event by ID
     */
    public function getEventById($id) {
        return $this->builder
            ->table($this->table)
            ->where('id', '=', $id)
            ->first();
    }

    /**
     * Get active events ordered by date
     */
    public function getActiveEvents() {
        return $this->builder
            ->table($this->table)
            ->where('status', '=', 'Aktif')
            ->orderBy('tanggal_event', 'ASC')
            ->get();
    }

    /**
     * Get upcoming events
     */
    public function getUpcomingEvents($limit = 10) {
        return $this->builder
            ->table($this->table)
            ->where('status', '=', 'Aktif')
            ->where('tanggal_event', '>=', date('Y-m-d'))
            ->orderBy('tanggal_event', 'ASC')
            ->limit($limit)
            ->get();
    }

    /**
     * Create event
     */
    public function createEvent($data) {
        try {
            return $this->builder
                ->table($this->table)
                ->insert($data);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Update event
     */
    public function updateEvent($id, $data) {
        try {
            return $this->builder
                ->table($this->table)
                ->where('id', '=', $id)
                ->update($data);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Delete event
     */
    public function deleteEvent($id) {
        try {
            return $this->builder
                ->table($this->table)
                ->where('id', '=', $id)
                ->delete();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Search events by keyword
     */
    public function searchEvents($keyword) {
        return $this->builder
            ->table($this->table)
            ->where('nama_event', 'LIKE', $keyword)
            ->orWhere('lokasi', 'LIKE', $keyword)
            ->orWhere('kategori', 'LIKE', $keyword)
            ->orderBy('tanggal_event', 'DESC')
            ->get();
    }

    /**
     * Get events by category
     */
    public function getEventsByCategory($category) {
        return $this->builder
            ->table($this->table)
            ->where('kategori', '=', $category)
            ->where('status', '=', 'Aktif')
            ->orderBy('tanggal_event', 'ASC')
            ->get();
    }

    /**
     * Get all unique categories
     */
    public function getAllCategories() {
        // only categories for active events
        $query = "SELECT DISTINCT kategori FROM " . $this->table . " WHERE kategori IS NOT NULL AND kategori != '' AND status = 'Aktif' ORDER BY kategori ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Get statistics
     */
    public function getStatistics() {
        $stats = [];

        // Total events
        $stats['total_events'] = $this->builder
            ->table($this->table)
            ->count();

        // Upcoming events
        $stats['upcoming_events'] = $this->builder
            ->table($this->table)
            ->where('status', '=', 'Aktif')
            ->where('tanggal_event', '>=', date('Y-m-d'))
            ->count();

        // Total sold tickets
        $ticketStats = $this->db
            ->query("SELECT COALESCE(SUM(jumlah_tiket), 0) as total FROM pemesanan")
            ->fetch(PDO::FETCH_ASSOC);
        $stats['total_tickets'] = $ticketStats['total'] ?? 0;

        return $stats;
    }

    /**
     * Get events with ticket info
     */
    public function getEventsWithTickets() {
        return $this->builder
            ->table($this->table)
            ->select(['events.*', 'COUNT(tiket.id) as tiket_count', 'SUM(tiket.stok) as total_stok'])
            ->leftJoin('tiket', 'tiket.event_id = events.id')
            ->orderBy('events.tanggal_event', 'DESC')
            ->get();
    }

    /**
     * Count all events
     */
    public function countAll() {
        return $this->builder
            ->table($this->table)
            ->count();
    }

    /**
     * Get paginated events
     */
    public function getPaginated($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        return $this->builder
            ->table($this->table)
            ->orderBy('tanggal_event', 'DESC')
            ->limit($perPage)
            ->offset($offset)
            ->get();
    }

    /**
     * Handle file upload
     */
    public function uploadImage($file) {
        if (!isset($file) || $file['error'] != 0) {
            return null;
        }

        // Validasi tipe file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        // Validasi ukuran file (max 5MB)
        $maxSize = 5 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            return false;
        }

        // Buat folder jika belum ada
        $uploadDir = __DIR__ . '/../../assets/uploads/events/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate nama file unik
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'event_' . time() . '_' . uniqid() . '.' . $ext;
        $filepath = $uploadDir . $filename;

        // Pindahkan file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return 'assets/uploads/events/' . $filename;
        }

        return false;
    }

    /**
     * Delete image file
     */
    public function deleteImage($imagePath) {
        if (!$imagePath) return true;

        $filepath = __DIR__ . '/../../' . $imagePath;
        if (file_exists($filepath)) {
            return unlink($filepath);
        }
        return true;
    }
}
?>