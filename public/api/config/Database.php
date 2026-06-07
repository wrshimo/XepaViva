<?php
// api/config/Database.php

class Database {
    
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;
    private $conn;

    private static $instance = null;

    private function __construct() {
        require_once __DIR__ . '/config.php';

        $this->host = DB_HOST;
        $this->db_name = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;
        $this->charset = DB_CHARSET;

        // A conexão PDO é iniciada mas a exceção não é capturada aqui de propósito.
        // Deixamos a exceção "borbulhar" para ser capturada no momento da chamada (ex: no roteiro da API).
        // No entanto, para o problema imediato, vamos adicionar um manipulador que retorna JSON.
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // **ESTA É A CORREÇÃO**
            // Em vez de die(), que retorna HTML e quebra o frontend, nós retornamos um JSON válido com o erro.
            header("Content-Type: application/json; charset=UTF-8");
            http_response_code(503); // 503 Service Unavailable - indica um problema no servidor
            echo json_encode([
                "status" => "error",
                "message" => "Falha crítica: Não foi possível conectar ao banco de dados.",
                "error_details" => $e->getMessage() // Importante para depuração
            ]);
            exit; // Interrompe a execução para não continuar com um PDO nulo.
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    private function __clone() { }

    public function __wakeup() { }
}
?>
