<?php

class Database {
    private $pdo;

    public function __construct() {
        $host = 'localhost';
        $dbname = 'lamps_store';
        $username = 'root'; 
        $password = '';    

        try {
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    //Insert
    public function Insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
            return $this->pdo->lastInsertId(); // Return the ID of the inserted record
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // READ
    public function readAll($table) {
        $sql = "SELECT * FROM $table";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    // READ
    public function read($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // UPDATE
    public function update($table, $id, $data) {
        $setClause = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = "UPDATE $table SET $setClause WHERE id = :id"; 
        try {
            $data['id'] = $id; 
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // DELETE
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM $table WHERE " . $where;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params); // Pass parameters to execute
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    // Count the number of records in a table (with optional condition)
    public function count($table, $condition = '') {
        try {
            $query = "SELECT COUNT(*) as total FROM $table";
            if (!empty($condition)) {
                $query .= " WHERE $condition";
            }
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['total'];
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function sort($table, $column, $order = 'ASC', $allowedColumns = [], $condition = []) {
        try {
            $column = in_array($column, $allowedColumns) ? $column : ($allowedColumns[0] ?? 'id');
            // Sanitize sort order to prevent injection
            $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';
            $query = "SELECT * FROM $table";
            $params = [];
            if (!empty($condition)) {
                $whereClauses = [];
                foreach ($condition as $key => $value) {
                    // Use named placeholders to avoid SQL injection
                    $whereClauses[] = "$key = :$key";
                    $params[":$key"] = $value;
                }
                $query .= " WHERE " . implode(' AND ', $whereClauses);
            }
            $query .= " ORDER BY $column $order";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}