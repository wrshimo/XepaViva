<?php
// api/models/Usuario.php

require_once __DIR__ . '/../config/Database.php';

class Usuario {

    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nome;
    public $email;
    public $senha;
    public $cpf_cnpj;
    public $tipo;
    public $localidade;
    public $data_cadastro;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getTodos() {
        $query = "SELECT id, nome, email, cpf_cnpj, tipo, localidade, data_cadastro FROM " . $this->table_name . " ORDER BY nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getUm() {
        $query = "SELECT id, nome, email, cpf_cnpj, tipo, localidade, data_cadastro FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nome = $row['nome'];
            $this->email = $row['email'];
            $this->cpf_cnpj = $row['cpf_cnpj'];
            $this->tipo = $row['tipo'];
            $this->localidade = $row['localidade'];
            $this->data_cadastro = $row['data_cadastro'];
            return true;
        }
        return false;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome, email=:email, senha=:senha, cpf_cnpj=:cpf_cnpj, tipo=:tipo, localidade=:localidade";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome ?? ''));
        $this->email = htmlspecialchars(strip_tags($this->email ?? ''));
        $this->senha = htmlspecialchars(strip_tags($this->senha ?? ''));
        $this->cpf_cnpj = htmlspecialchars(strip_tags($this->cpf_cnpj ?? ''));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo ?? ''));
        $this->localidade = htmlspecialchars(strip_tags($this->localidade ?? ''));

        $password_hash = password_hash($this->senha, PASSWORD_BCRYPT);

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":senha", $password_hash);
        $stmt->bindParam(":cpf_cnpj", $this->cpf_cnpj);
        $stmt->bindParam(":tipo", $this->tipo);
        $stmt->bindParam(":localidade", $this->localidade);

        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function atualizar() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    nome = :nome,
                    email = :email,
                    cpf_cnpj = :cpf_cnpj,
                    tipo = :tipo,
                    localidade = :localidade";

        if (!empty($this->senha)) {
            $query .= ", senha = :senha";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome ?? ''));
        $this->email = htmlspecialchars(strip_tags($this->email ?? ''));
        $this->cpf_cnpj = htmlspecialchars(strip_tags($this->cpf_cnpj ?? ''));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo ?? ''));
        $this->localidade = htmlspecialchars(strip_tags($this->localidade ?? ''));
        $this->id = htmlspecialchars(strip_tags($this->id ?? ''));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':cpf_cnpj', $this->cpf_cnpj);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':localidade', $this->localidade);
        $stmt->bindParam(':id', $this->id);

        if (!empty($this->senha)) {
            $this->senha = htmlspecialchars(strip_tags($this->senha));
            $password_hash = password_hash($this->senha, PASSWORD_BCRYPT);
            $stmt->bindParam(':senha', $password_hash);
        }

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Deleta um registro de usuário do banco de dados.
     *
     * @return bool True se o usuário foi deletado com sucesso, false caso contrário.
     */
    public function deletar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        // Sanitiza o ID
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincula o ID
        $stmt->bindParam(1, $this->id);

        // Executa a query
        if ($stmt->execute()) {
            // Verifica se alguma linha foi realmente afetada
            if ($stmt->rowCount() > 0) {
                return true;
            }
        }

        return false;
    }
}
?>