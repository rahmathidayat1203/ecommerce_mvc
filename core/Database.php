<?php

class Database
{
    private $host = '127.0.0.1';
    private $dbname = 'ecommerce_mvc';
    private $username = 'root';
    private $password = '';
    private $connection;

    protected function connect()
    {
        if (!$this->connection) {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            if ($this->connection->connect_error) {
                die('Koneksi database gagal: ' . $this->connection->connect_error);
            }
        }

        return $this->connection;
    }
}
