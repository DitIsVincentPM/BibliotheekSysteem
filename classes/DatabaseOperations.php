<?php
require 'config/database.php';

class DatabaseOperations {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        if (!empty($params)) {
            $stmt->execute($params);
        } else {
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array_values($data));
    }

    public function update($table, $data, $where) {
        $columns = implode(" = ?, ", array_keys($data)) . " = ?";
        $sql = "UPDATE $table SET $columns WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array_values($data));
    }

    public function delete($table, $where) {
        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    public function addColumn($table, $column, $type) {
        $sql = "ALTER TABLE $table ADD $column $type";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }
}