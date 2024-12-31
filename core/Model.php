<?php

class Model extends Database
{
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
        $this->connection = $this->connect();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $result = $this->connection->query($sql);

        if (!$result) {
            die("Error pada query: " . $this->connection->error);
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function store($data)
    {
        if (empty($data) || !is_array($data)) {
            die("Invalid data provided for insertion.");
        }

        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_map(function ($value) {
            return "'" . $this->connection->real_escape_string($value) . "'";
        }, array_values($data)));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";

        if (!$this->connection->query($sql)) {
            die("Error executing query: " . $this->connection->error);
        }

        return $this->connection->insert_id;
    }
}
