<?php
class Database
{
    private $conn;

    public function __construct($host, $username, $password, $database)
    {
        // Create a connection
        $this->conn = new mysqli($host, $username, $password, $database);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        // Close the connection
        $this->conn->close();
    }
}
?>
