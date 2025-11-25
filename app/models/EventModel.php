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
            ->where('tanggal_event', '>=', date('Y-m-d'))
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
}
?>