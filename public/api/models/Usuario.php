<?php
// /public/api/models/Usuario.php

require_once __DIR__ . '/../config/Database.php';

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    // Propriedades do Objeto (alinhadas com schema.sql)
    public $id;
    public $nome;
    public $email;
    public $senha;
    public $tipo;
    public $telefone;
    public $cpf_cnpj;
    public $localidade;

    public function __construct() {
        // CORREÇÃO CRÍTICA: Usa o método estático getInstance() para obter a conexão Singleton
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    /**
     * Busca um usuário pelo seu endereço de email.
     *
     * @param string $email O email a ser buscado.
     * @return array|null Retorna um array associativo com os dados do usuário ou null se não for encontrado.
     */
    public function buscarPorEmail($email) {
        $query = "SELECT id, nome, email, senha, tipo FROM " . $this->table_name . " WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return null;
    }

    /**
     * Cria um novo usuário no banco de dados.
     *
     * @return bool Retorna true se a criação for bem-sucedida, false caso contrário.
     */
    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome, email=:email, senha=:senha, tipo=:tipo, telefone=:telefone";

        $stmt = $this->conn->prepare($query);

        // Sanitiza os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        
        // A senha já deve vir hasheada para o modelo

        // Associa os dados
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":senha", $this->senha);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":telefone", $this->telefone);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }
}
?>