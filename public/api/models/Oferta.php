<?php
// public/api/models/Oferta.php

require_once __DIR__ . '/../config/Database.php';

class Oferta {
    private $conn;
    private $table_name = "ofertas";

    // Propriedades
    public $id;
    public $feirante_id;
    public $nome;
    public $descricao;
    public $foto;
    public $preco;
    public $peso;
    public $quantidade_inicial;
    public $quantidade_disponivel;
    public $disponivel;
    public $categoria;
    public $data_criacao;
    public $data_modificacao;
    public $nome_feirante;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function carregarPeloId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            foreach ($row as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
            return true;
        }
        return false;
    }
    
    public function buscar($filtros = []) {
        $query = "SELECT o.id, o.feirante_id, o.nome, o.descricao, o.foto, o.preco, o.peso, 
                       o.quantidade_disponivel, o.disponivel, o.categoria, o.data_criacao, o.data_modificacao,
                       u.nome as nome_feirante
                  FROM " . $this->table_name . " o
                  LEFT JOIN usuarios u ON o.feirante_id = u.id";
        
        $where_clauses = [];
        $params = [];

        if (!empty($filtros['q'])) {
            $where_clauses[] = "(o.nome LIKE :q OR o.descricao LIKE :q OR u.nome LIKE :q)";
            $params[':q'] = '%' . $filtros['q'] . '%';
        }
        if (!empty($filtros['categoria'])) {
            $where_clauses[] = "o.categoria = :categoria";
            $params[':categoria'] = $filtros['categoria'];
        }
        if (isset($filtros['disponivel'])) {
            $where_clauses[] = "o.disponivel = :disponivel";
            $params[':disponivel'] = filter_var($filtros['disponivel'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }
        if (!empty($filtros['feirante_id'])) {
            $where_clauses[] = "o.feirante_id = :feirante_id";
            $params[':feirante_id'] = $filtros['feirante_id'];
        }

        if (!empty($where_clauses)) {
            $query .= " WHERE " . implode(" AND ", $where_clauses);
        }
        $query .= " ORDER BY o.data_criacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " SET feirante_id=:feirante_id, nome=:nome, descricao=:descricao, preco=:preco, peso=:peso, quantidade_inicial=:quantidade_inicial, quantidade_disponivel=:quantidade_disponivel, categoria=:categoria, disponivel=1";
        $stmt = $this->conn->prepare($query);

        // Sanitização e Validação
        $this->feirante_id = intval($this->feirante_id);
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao ?? ''));
        $this->preco = floatval($this->preco);
        $this->peso = floatval($this->peso);
        $this->quantidade_inicial = intval($this->quantidade_inicial);
        $this->quantidade_disponivel = intval($this->quantidade_inicial); // Regra de negócio
        $this->categoria = htmlspecialchars(strip_tags($this->categoria ?? ''));

        $stmt->bindParam(":feirante_id", $this->feirante_id, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":peso", $this->peso);
        $stmt->bindParam(":quantidade_inicial", $this->quantidade_inicial, PDO::PARAM_INT);
        $stmt->bindParam(":quantidade_disponivel", $this->quantidade_disponivel, PDO::PARAM_INT);
        $stmt->bindParam(":categoria", $this->categoria);

        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    public function atualizar() {
        $query = "UPDATE " . $this->table_name . " SET nome=:nome, descricao=:descricao, preco=:preco, peso=:peso, quantidade_disponivel=:quantidade_disponivel, disponivel=:disponivel, categoria=:categoria WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        // Sanitização e Validação
        $this->id = intval($this->id);
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao ?? ''));
        $this->preco = floatval($this->preco);
        $this->peso = floatval($this->peso);
        $this->quantidade_disponivel = intval($this->quantidade_disponivel);
        $this->disponivel = filter_var($this->disponivel, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $this->categoria = htmlspecialchars(strip_tags($this->categoria ?? ''));
        
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":peso", $this->peso);
        $stmt->bindParam(":quantidade_disponivel", $this->quantidade_disponivel, PDO::PARAM_INT);
        $stmt->bindParam(":disponivel", $this->disponivel, PDO::PARAM_INT);
        $stmt->bindParam(":categoria", $this->categoria);

        return $stmt->execute();
    }

    public function deletar() {
        $query = "UPDATE " . $this->table_name . " SET disponivel = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $this->id = intval($this->id);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->rowCount() > 0;
        }
        return false;
    }
}
?>