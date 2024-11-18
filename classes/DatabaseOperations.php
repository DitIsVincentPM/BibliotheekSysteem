<?php
require __DIR__ . '/../config/database.php';

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
        if (!is_array($data)) {
            throw new InvalidArgumentException("Data must be an associative array");
        }

        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array_values($data));
            return true;
        } catch (PDOException $e) {
            error_log("Database Insert Error: " . $e->getMessage());
            die("Database Insert Error: " . $e->getMessage());
        }
    }

    public function update($table, $data, $where) {
        if (!is_array($data) || !is_array($where)) {
            throw new InvalidArgumentException("Data and where conditions must be associative arrays");
        }

        $columns = implode(" = ?, ", array_keys($data)) . " = ?";
        $whereClause = implode(" = ? AND ", array_keys($where)) . " = ?";
        $sql = "UPDATE $table SET $columns WHERE $whereClause";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array_merge(array_values($data), array_values($where)));
            return true;
        } catch (PDOException $e) {
            error_log("Database Update Error: " . $e->getMessage());
            die("Database Update Error: " . $e->getMessage());
        }
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