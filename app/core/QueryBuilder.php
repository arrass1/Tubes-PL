<?php
class QueryBuilder {
    private $db;
    private $table;
    private $select = '*';
    private $wheres = [];
    private $bindings = [];
    private $joins = [];
    private $orderBy = [];
    private $limit_val = null;
    private $offset_val = null;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Set the table to query
     */
    public function table($table) {
        $this->table = $table;
        $this->reset();
        return $this;
    }

    /**
     * Reset query builder state
     */
    private function reset() {
        $this->select = '*';
        $this->wheres = [];
        $this->bindings = [];
        $this->joins = [];
        $this->orderBy = [];
        $this->limit_val = null;
        $this->offset_val = null;
    }

    /**
     * Select specific columns
     */
    public function select($columns = '*') {
        if (is_array($columns)) {
            $this->select = implode(', ', $columns);
        } else {
            $this->select = $columns;
        }
        return $this;
    }

    /**
     * Add where clause
     */
    public function where($column, $operator = '=', $value = null) {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        // If there are existing where clauses, join with AND
        if (count($this->wheres) > 0) {
            $this->wheres[] = "AND {$column} {$operator} ?";
        } else {
            $this->wheres[] = "{$column} {$operator} ?";
        }
        $this->bindings[] = $value;
        return $this;
    }

    /**
     * Add OR where clause
     */
    public function orWhere($column, $operator = '=', $value = null) {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        // OR only makes sense when there's an existing where; otherwise behave like where
        if (count($this->wheres) > 0) {
            $this->wheres[] = "OR {$column} {$operator} ?";
        } else {
            $this->wheres[] = "{$column} {$operator} ?";
        }
        $this->bindings[] = $value;
        return $this;
    }

    /**
     * Add AND where clause
     */
    public function andWhere($column, $operator = '=', $value = null) {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        // behave like where(): add AND only if there's a previous clause
        if (count($this->wheres) > 0) {
            $this->wheres[] = "AND {$column} {$operator} ?";
        } else {
            $this->wheres[] = "{$column} {$operator} ?";
        }
        $this->bindings[] = $value;
        return $this;
    }

    /**
     * Where IN clause
     */
    public function whereIn($column, $values) {
        if (is_array($values) && count($values) > 0) {
            $placeholders = implode(',', array_fill(0, count($values), '?'));
            // prepend AND if there's already a where clause
            if (count($this->wheres) > 0) {
                $this->wheres[] = "AND {$column} IN ({$placeholders})";
            } else {
                $this->wheres[] = "{$column} IN ({$placeholders})";
            }
            foreach ($values as $value) {
                $this->bindings[] = $value;
            }
        }
        return $this;
    }

    /**
     * Where NOT IN clause
     */
    public function whereNotIn($column, $values) {
        if (is_array($values) && count($values) > 0) {
            $placeholders = implode(',', array_fill(0, count($values), '?'));
            if (count($this->wheres) > 0) {
                $this->wheres[] = "AND {$column} NOT IN ({$placeholders})";
            } else {
                $this->wheres[] = "{$column} NOT IN ({$placeholders})";
            }
            foreach ($values as $value) {
                $this->bindings[] = $value;
            }
        }
        return $this;
    }

    /**
     * Where LIKE clause
     */
    public function whereLike($column, $value) {
        if (count($this->wheres) > 0) {
            $this->wheres[] = "AND {$column} LIKE ?";
        } else {
            $this->wheres[] = "{$column} LIKE ?";
        }
        $this->bindings[] = "%{$value}%";
        return $this;
    }

    /**
     * Join tables
     */
    public function join($table, $on, $type = 'INNER') {
        $this->joins[] = "{$type} JOIN {$table} ON {$on}";
        return $this;
    }

    /**
     * Left join
     */
    public function leftJoin($table, $on) {
        return $this->join($table, $on, 'LEFT');
    }

    /**
     * Right join
     */
    public function rightJoin($table, $on) {
        return $this->join($table, $on, 'RIGHT');
    }

    /**
     * Order by
     */
    public function orderBy($column, $direction = 'ASC') {
        $this->orderBy[] = "{$column} {$direction}";
        return $this;
    }

    /**
     * Limit results
     */
    public function limit($limit) {
        $this->limit_val = $limit;
        return $this;
    }

    /**
     * Offset results
     */
    public function offset($offset) {
        $this->offset_val = $offset;
        return $this;
    }

    /**
     * Build the query
     */
    private function buildQuery() {
        $query = "SELECT {$this->select} FROM {$this->table}";

        // Add joins
        if (count($this->joins) > 0) {
            $query .= ' ' . implode(' ', $this->joins);
        }

        // Add where clauses
        if (count($this->wheres) > 0) {
            $query .= " WHERE " . implode(' ', $this->wheres);
        }

        // Add order by
        if (count($this->orderBy) > 0) {
            $query .= " ORDER BY " . implode(', ', $this->orderBy);
        }

        // Add limit
        if ($this->limit_val !== null) {
            $query .= " LIMIT {$this->limit_val}";
        }

        // Add offset
        if ($this->offset_val !== null) {
            $query .= " OFFSET {$this->offset_val}";
        }

        return $query;
    }

    /**
     * Execute the query and get all results
     */
    public function get() {
        $query = $this->buildQuery();
        $stmt = $this->db->prepare($query);
        $stmt->execute($this->bindings);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Execute the query and get first result
     */
    public function first() {
        $query = $this->buildQuery();
        $stmt = $this->db->prepare($query);
        $stmt->execute($this->bindings);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Count results
     */
    public function count() {
        $this->select = 'COUNT(*) as count';
        $query = $this->buildQuery();
        $stmt = $this->db->prepare($query);
        $stmt->execute($this->bindings);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    /**
     * Insert data
     */
    public function insert($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute(array_values($data));
    }

    /**
     * Update data
     */
    public function update($data) {
        $sets = [];
        $bindings = array_values($data);
        
        foreach (array_keys($data) as $column) {
            $sets[] = "{$column} = ?";
        }
        
        $query = "UPDATE {$this->table} SET " . implode(', ', $sets);
        
        if (count($this->wheres) > 0) {
            $query .= " WHERE " . implode(' ', $this->wheres);
            $bindings = array_merge($bindings, $this->bindings);
        }
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($bindings);
    }

    /**
     * Delete data
     */
    public function delete() {
        $query = "DELETE FROM {$this->table}";
        
        if (count($this->wheres) > 0) {
            $query .= " WHERE " . implode(' ', $this->wheres);
        }
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($this->bindings);
    }

    /**
     * Get the built query as string (for debugging)
     */
    public function toSql() {
        return $this->buildQuery();
    }
}
?>