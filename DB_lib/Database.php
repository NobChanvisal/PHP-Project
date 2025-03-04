<?php

class Database {
    private $pdo;

    // Constructor to initialize PDO connection
    public function __construct() {
        try {
            $this->pdo = $this->dbConn();
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    // Private method for database connection
    private function dbConn() {
        $host = 'localhost';
        $dbname = 'lamps_store';
        $username = 'root'; 
        $password = '';
        
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    }
    // Select 
    public function dbSelect($table, $column = "*", $where = "", $clause = "", $params = []) {
        if (empty($table)) {
            return false;
        }
        
        try {
            $sql = "SELECT " . $column . " FROM " . $table;
            if (!empty($where)) {
                $sql .= " WHERE " . $where;
            }
            if (!empty($clause)) {
                $sql .= " " . $clause;
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new PDOException("Select failed: " . $e->getMessage());
        }
    }
    // Insert
    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("Insert failed: " . $e->getMessage());
        }
    }

    // Update
    public function update($table, $id, $data) {
        $setClause = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = "UPDATE $table SET $setClause WHERE id = :id";
        try {
            $data['id'] = $id;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
            return $stmt->rowCount(); // Return number of affected rows
        } catch (PDOException $e) {
            throw new PDOException("Update failed: " . $e->getMessage());
        }
    }

    // Delete
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM $table WHERE $where";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount(); // Return number of deleted rows
        } catch (PDOException $e) {
            throw new PDOException("Delete failed: " . $e->getMessage());
        }
    }

    // Custom query
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new PDOException("Query failed: " . $e->getMessage());
        }
    }

    // Count records
    public function count($table, $where = '', $params = []) {
        try {
            $query = "SELECT COUNT(*) as total FROM $table";
            if (!empty($where)) {
                $query .= " WHERE $where";
            }
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetch();
            return (int) $result['total'];
        } catch (PDOException $e) {
            throw new PDOException("Count failed: " . $e->getMessage());
        }
    }

    
}
