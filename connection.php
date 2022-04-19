<?php

class Connection
{
    private $connection;

    public function __construct()
    {
        $config = require_once('config.php');
        $this->connectToDatabase($config);
    }

    private function connectToDatabase($config)
    {
        if (isset($config['connection'])) {
            $conn = $config['connection'];
        }

        $host = $conn['host'];
        $database = $conn['database'];
        $username = $conn['username'];
        $password = $conn['password'];

        $dsn = "mysql:host=$host;dbname=$database;";

        try {
            $pdo = new PDO($dsn, $username, $password);

            if ($pdo) {
                $this->connection = $pdo;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit(404);
        }
    }


    public function get($table, $id = null)
    {
        if ($id) {
            $sql = "SELECT * FROM `$table` WHERE `id` = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT * FROM $table";
            $stmt = $this->connection->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }

    public function create($table, $data)
    {
        unset($data['_METHOD']);

        $columns = $values = '';
        $count = count($data);
        $i = 0;

        foreach ($data as $key) {
            $i++;
            $columns .= "`$key`";
            $values .= ":$key";
            if ($i < $count) {
                $columns .=  ', ';
                $values .= ', ';
            }
        }

        $sql = "INSERT INTO $table
    ($columns)
    VALUES 
    ($values)";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
    }

    public function update($table, $data)
    {
        unset($data['_METHOD']);

        $values = '';
        $count = count($data);
        $i = 0;

        foreach ($data as $key => $d) {
            $i++;

            if ($key === 'id') {
                continue;
            }

            $values .= "`$key`=:$key";
            if ($i < $count) {
                $values .= ', ';
            }
        }
        
        $sql = "UPDATE $table SET $values WHERE id= :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
    }

    public function delete($table, $id)
    {
        unset($data['_METHOD']);

        $sql = "DELETE FROM `$table` WHERE `id` = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
    }
}
