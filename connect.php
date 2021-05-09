<?php
class DB{
    private $severname = '127.0.0.1';
    private $username = 'root';
    private $password = '';
    private $dbname = 'quanlybanhang';
    public $conn;

    public function __construct()
    {
        if (!$this->conn){
            $this->connect();
        }

    }

    public function __destruct()
    {
        if ($this->conn){
            $this->disconnect();
        }
    }

    public function connect(){
        $this->conn = new PDO("mysql:host=$this->severname;dbname=$this->dbname",$this->username,$this->password);
        $this->conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

    public function disconnect(){
        $this->conn = NULL;
    }
}