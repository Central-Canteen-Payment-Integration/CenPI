<?php

class Database
{
    private $host = DB_HOST;
    private $port = '1521';
    private $sid = 'xe';
    private $username = DB_USER;
    private $password = DB_PASS;

    private $pdo;
    private $stmt;

    public function __construct()
    {
        $dsn = "oci:dbname=//{$this->host}:{$this->port}/{$this->sid}";
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function query($sql)
    {
        $this->stmt = $this->pdo->prepare($sql);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function bindObject($param, $value, $type = null)
{
    // Check for object or array values and handle them appropriately
    if (is_object($value) || is_array($value)) {
        // Log or throw an error to make sure you handle this case
        error_log("Warning: Binding an object or array is not supported. Value: " . var_export($value, true));
        // Optionally, you can convert the object/array to a string or handle it differently
        $value = json_encode($value);  // Example: converting object/array to a JSON string
        $type = PDO::PARAM_STR;  // Set to string if converted to JSON
    }

    if (is_null($type)) {
        switch (true) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
    }
    
    $this->stmt->bindValue($param, $value, $type);
}

    public function execute()
    {
        return $this->stmt->execute();
    }

    // Fetch all results as objects or arrays
    public function resultSet($fetchMode = PDO::FETCH_ASSOC)
    {
        $this->execute();
        return $this->stmt->fetchAll($fetchMode);
    }

    // Fetch single result as object or array
    public function single($fetchMode = PDO::FETCH_ASSOC)
    {
        $this->execute();
        return $this->stmt->fetch($fetchMode);
    }


    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    public function commit()
    {
        return $this->pdo->commit();
    }

    public function rollBack()
    {
        return $this->pdo->rollBack();
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}
