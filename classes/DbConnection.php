<?php

class DbConnection
{
    
    private $hostname = "localhost";
    private $db_name = "my_reminders";
    private $db_user = "root";
    private $db_pass = "";
    public $conn;
    
    public function dbConnection()
    {
        $this->conn = null;
        
        try {
            $this->conn = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->db_name, $this->db_user, $this->db_pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}
?>