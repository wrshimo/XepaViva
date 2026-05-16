<?php
// api/config/Database.php

/**
 * Classe para gerenciamento da conexão com o banco de dados utilizando PDO.
 * 
 * Esta classe segue o padrão Singleton para garantir uma única instância de conexão
 * durante o ciclo de vida da aplicação, otimizando recursos.
 */
class Database {
    
    // Propriedades da conexão
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;

    // Instância da conexão PDO
    private $conn;

    // Instância única da classe (Singleton)
    private static $instance = null;

    /**
     * Construtor privado para impedir a criação de múltiplas instâncias.
     * Carrega as configurações do banco de dados e inicia a conexão.
     */
    private function __construct() {
        // Inclui o arquivo de configuração
        require_once 'config.php';

        $this->host = DB_HOST;
        $this->db_name = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;
        $this->charset = DB_CHARSET;

        // Tenta estabelecer a conexão
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Configura o PDO para lançar exceções em caso de erro
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Garante que os dados sejam retornados como arrays associativos
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Em caso de falha na conexão, encerra a execução e exibe o erro
            // Em um ambiente de produção, o erro deveria ser logado em vez de exibido
            die("Erro de conexão com o banco de dados: " . $e->getMessage());
        }
    }

    /**
     * Método estático para obter a instância única da classe (Singleton).
     *
     * @return Database A instância única da classe Database.
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Método para obter o objeto de conexão PDO.
     *
     * @return PDO O objeto de conexão PDO.
     */
    public function getConnection() {
        return $this->conn;
    }

    /**
     * Previne a clonagem da instância (parte do padrão Singleton).
     */
    private function __clone() { }

    /**
     * Previne a desserialização da instância (parte do padrão Singleton).
     */
    public function __wakeup() { }
}
?>
