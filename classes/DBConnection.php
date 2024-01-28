<?php
if (!defined('DB_SERVER')) {
    require_once("../initialize.php");
}

class DBConnection
{
    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    public function query($sql)
    {
        $result = $this->conn->query($sql);

        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }

        return $result;
    }

    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    public function escapeString($value)
    {
        return $this->conn->real_escape_string($value);
    }
}
?>
