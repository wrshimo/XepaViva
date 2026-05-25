<?php
// api/models/Oferta.php

require_once __DIR__ . '/../config/Database.php';

class Oferta {

    private $conn;
    private $table_name = "ofertas";

    // Propriedades da Oferta
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

    /**
     * Lê todos os registros de ofertas disponíveis.
     * Somente retorna ofertas com disponivel = 1.
     * @return PDOStatement
     */
    public function getTodas() {
        $query = "SELECT o.*, u.nome as nome_feirante FROM " . $this->table_name . " o LEFT JOIN usuarios u ON o.feirante_id = u.id WHERE o.disponivel = 1 ORDER BY o.data_criacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Lê todas as ofertas disponíveis para um feirante específico.
     * Somente retorna ofertas com disponivel = 1.
     * @param int $feirante_id
     * @return PDOStatement
     */
    public function getPorFeirante($feirante_id) {
        $query = "SELECT o.*, u.nome as nome_feirante FROM " . $this->table_name . " o LEFT JOIN usuarios u ON o.feirante_id = u.id WHERE o.feirante_id = ? AND o.disponivel = 1 ORDER BY o.data_criacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $feirante_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Lê um único registro de oferta pelo ID.
     * @return bool
     */
    public function getUm() {
        $query = "SELECT o.*, u.nome as nome_feirante FROM " . $this->table_name . " o LEFT JOIN usuarios u ON o.feirante_id = u.id WHERE o.id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->feirante_id = $row['feirante_id'];
            $this->nome = $row['nome'];
            $this->descricao = $row['descricao'];
            $this->foto = $row['foto'];
            $this->preco = $row['preco'];
            $this->peso = $row['peso'];
            $this->quantidade_inicial = $row['quantidade_inicial'];
            $this->quantidade_disponivel = $row['quantidade_disponivel'];
            $this->disponivel = $row['disponivel'];
            $this->categoria = $row['categoria'];
            $this->data_criacao = $row['data_criacao'];
            $this->data_modificacao = $row['data_modificacao'];
            $this->nome_feirante = $row['nome_feirante'];
            return true;
        }
        return false;
    }

    /**
     * Cria uma nova oferta no banco de dados.
     * @return bool
     */
    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " SET feirante_id=:feirante_id, nome=:nome, descricao=:descricao, foto=:foto, preco=:preco, peso=:peso, quantidade_disponivel=:quantidade_disponivel, quantidade_inicial=:quantidade_disponivel, categoria=:categoria, disponivel=1";
        $stmt = $this->conn->prepare($query);

        // Sanitiza
        $this->feirante_id = htmlspecialchars(strip_tags($this->feirante_id));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->foto = htmlspecialchars(strip_tags($this->foto ?? ''));
        $this->preco = htmlspecialchars(strip_tags($this->preco));
        $this->peso = htmlspecialchars(strip_tags($this->peso ?? null));
        $this->quantidade_disponivel = htmlspecialchars(strip_tags($this->quantidade_disponivel));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        
        // Vincula
        $stmt->bindParam(":feirante_id", $this->feirante_id);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":foto", $this->foto);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":peso", $this->peso);
        $stmt->bindParam(":quantidade_disponivel", $this->quantidade_disponivel);
        $stmt->bindParam(":categoria", $this->categoria);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Atualiza uma oferta existente no banco de dados.
     * @return bool
     */
    public function atualizar() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    nome = :nome,
                    descricao = :descricao,
                    foto = :foto,
                    preco = :preco,
                    peso = :peso, 
                    quantidade_disponivel = :quantidade_disponivel,
                    disponivel = :disponivel,
                    categoria = :categoria
                WHERE
                    id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitiza
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->foto = htmlspecialchars(strip_tags($this->foto ?? ''));
        $this->preco = htmlspecialchars(strip_tags($this->preco));
        $this->peso = htmlspecialchars(strip_tags($this->peso ?? null));
        $this->quantidade_disponivel = htmlspecialchars(strip_tags($this->quantidade_disponivel));
        $this->disponivel = isset($this->disponivel) ? ($this->disponivel ? 1 : 0) : 1;
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));

        // Vincula
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':foto', $this->foto);
        $stmt->bindParam(':preco', $this->preco);
        $stmt->bindParam(':peso', $this->peso);
        $stmt->bindParam(':quantidade_disponivel', $this->quantidade_disponivel);
        $stmt->bindParam(':disponivel', $this->disponivel);
        $stmt->bindParam(':categoria', $this->categoria);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Realiza a exclusão lógica de uma oferta (soft delete).
     * @return bool
     */
    public function deletar() {
        $query = "UPDATE " . $this->table_name . " SET disponivel = 0 WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
?>