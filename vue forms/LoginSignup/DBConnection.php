<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class DBConnection
{
    
    private $host = "localhost";
    private $username = "postgres";
    private $password = "root";
    private $database = "restaurant";
    public $pdo;

    public function __construct()
    {

        try {
            $pdo = new PDO("pgsql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $this->pdo=$pdo;

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }

    }
    //called automatically when the object of the class in destroyed
    public function __destruct()
    {
        $this->pdo = null;
    }
}
