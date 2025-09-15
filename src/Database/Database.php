<?php 

namespace SuperMarket\Database;

use PDO;
use PDOException;

class Database{
	private $config;
    private static ?PDO $connection = null;


	public function __construct() {
		$this->config = require __DIR__ . '/../Config/database.php';
	}

    public function getConnection(): PDO {
        $dsn = "{$this->config['connection']}:host={$this->config['host']};dbname={$this->config['database']};port={$this->config['port']};charset={$this->config['charset']}";

        try{
        self::$connection = new PDO($dsn, $this->config['username'], $this->config['password']);             
        }
        catch(PDOException $e){
            throw new \Exception('Database connection failed: ' . $e->getMessage());
        }

        return self::$connection;
    }
}

?>