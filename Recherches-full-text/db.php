<?php

    class DB {
        const HOST = '127.0.0.1';
        const DB   = 'geo';
        const USR = 'root';
        const PWD = '';
        const PORT = "3306";
        const CHARSET = 'utf8mb4';

        private $pdo;

        function __construct() {
            $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DB . ";charset=" . self::CHARSET . ";port=" . self::PORT;
            try {
                $this->pdo = new PDO($dsn, self::USR, self::PWD);
            } 
            catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        
        public function prepare($sql) {
            $query = $this->pdo->prepare($sql);
            return $query;            
        }
        
    }


?>