<?php
require_once __DIR__ . '/../core/QueryBuilder.php';

class CustomerModel {
    private $db;
    private $builder;
    private $table = 'customers';

    public function __construct($db) {
        $this->db = $db;
        $this->builder = new QueryBuilder($db);
    }

    /**
     * Get all customers
     */
    public function getAllCustomers() {
        return $this->builder
            ->table($this->table)
            ->select(['id AS user_id', 'nama', 'email', 'no_telepon', 'tanggal_daftar'])
            ->orderBy('tanggal_daftar', 'DESC')
            ->get();
    }

    /**
     * Get customer by ID
     */
    public function getCustomerById($id) {
        return $this->builder
            ->table($this->table)
            ->select(['id AS user_id', 'nama', 'email', 'no_telepon', 'tanggal_daftar'])
            ->where('id', '=', $id)
            ->first();
    }

    /**
     * Get customer by email
     */
    public function getCustomerByEmail($email) {
        return $this->builder
            ->table($this->table)
            ->where('email', '=', $email)
            ->first();
    }

    /**
     * Create customer
     */
    public function createCustomer($data) {
        try {
            return $this->builder
                ->table($this->table)
                ->insert($data);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Update customer
     */
    public function updateCustomer($id, $data) {
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
     * Delete customer
     */
    public function deleteCustomer($id) {
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
     * Search customers by name or email
     */
    public function searchCustomers($keyword) {
        return $this->builder
            ->table($this->table)
            ->where('nama', 'LIKE', $keyword)
            ->orWhere('email', 'LIKE', $keyword)
            ->orderBy('tanggal_daftar', 'DESC')
            ->get();
    }

    /**
     * Count total customers
     */
    public function countAll() {
        return $this->builder
            ->table($this->table)
            ->count();
    }

    /**
     * Get paginated customers
     */
    public function getPaginated($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        
        return $this->builder
            ->table($this->table)
            ->orderBy('tanggal_daftar', 'DESC')
            ->limit($perPage)
            ->offset($offset)
            ->get();
    }
}
?>