<?php

class Database
{
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    public $conn;


    public function dbSet()
    {
        $this->conn = null;

        $this->host = getenv('DB_HOST') ?: '127.0.0.1';
        $this->port = getenv('DB_PORT') ?: '3306';
        $this->db_name = getenv('DB_DATABASE') ?: 'clinica_odontologica';
        $this->username = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASSWORD') ?: 'rootpassword';

        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'");
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $exception) {
              echo "Erro na conexão com o banco de dados: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public static function prepare($sql){
        $db = new Database();
        return $db->dbSet()->prepare($sql);
    }
}

?>
