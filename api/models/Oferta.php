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
    public $quantidade_inicial;
    public $quantidade_disponivel;
    public $disponivel;
    public $categoria;
    public $data_criacao;
    public $data_modificacao;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Lê todos os registros de ofertas do banco de dados.
     *
     * @return PDOStatement O statement PDO com o resultado.
     */
    public function getTodas() {
        $query = "SELECT o.*, u.nome as nome_feirante FROM " . $this->table_name . " o LEFT JOIN usuarios u ON o.feirante_id = u.id ORDER BY o.data_criacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Lê um único registro de oferta pelo ID.
     *
     * @return bool True se a oferta for encontrada, false caso contrário.
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
            $this->quantidade_inicial = $row['quantidade_inicial'];
            $this->quantidade_disponivel = $row['quantidade_disponivel'];
            $this->disponivel = $row['disponivel'];
            $this->categoria = $row['categoria'];
            $this->data_criacao = $row['data_criacao'];
            $this->data_modificacao = $row['data_modificacao'];
            // Campo adicional do JOIN
            $this->nome_feirante = $row['nome_feirante'];
            return true;
        }
        return false;
    }

    /**
     * Cria uma nova oferta no banco de dados.
     *
     * @return bool True se a oferta foi criada com sucesso, false caso contrário.
     */
    public function criar() {
        $query = "INSERT INTO " . $this->table_name . " SET feirante_id=:feirante_id, nome=:nome, descricao=:descricao, foto=:foto, preco=:preco, quantidade_inicial=:quantidade_inicial, quantidade_disponivel=:quantidade_disponivel, categoria=:categoria, disponivel=:disponivel";

        $stmt = $this->conn->prepare($query);

        // Sanitiza os dados
        $this->feirante_id = htmlspecialchars(strip_tags($this->feirante_id ?? ''));
        $this->nome = htmlspecialchars(strip_tags($this->nome ?? ''));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao ?? ''));
        $this->foto = htmlspecialchars(strip_tags($this->foto ?? ''));
        $this->preco = htmlspecialchars(strip_tags($this->preco ?? ''));
        $this->quantidade_inicial = htmlspecialchars(strip_tags($this->quantidade_inicial ?? ''));
        $this->quantidade_disponivel = htmlspecialchars(strip_tags($this->quantidade_disponivel ?? ''));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria ?? ''));
        $this->disponivel = isset($this->disponivel) ? ($this->disponivel ? 1 : 0) : 1;

        // Vincula os valores
        $stmt->bindParam(":feirante_id", $this->feirante_id);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":foto", $this->foto);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":quantidade_inicial", $this->quantidade_inicial);
        $stmt->bindParam(":quantidade_disponivel", $this->quantidade_disponivel);
        $stmt->bindParam(":categoria", $this->categoria);
        $stmt->bindParam(":disponivel", $this->disponivel);

        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    /**
     * Atualiza uma oferta existente no banco de dados.
     *
     * @return bool True se a atualização foi bem-sucedida, false caso contrário.
     */
    public function atualizar() {
        $query = "UPDATE " . $this->table_name . "
                SET
                    nome = :nome,
                    descricao = :descricao,
                    foto = :foto,
                    preco = :preco,
                    quantidade_inicial = :quantidade_inicial,
                    quantidade_disponivel = :quantidade_disponivel,
                    disponivel = :disponivel,
                    categoria = :categoria
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitiza os dados
        $this->id = htmlspecialchars(strip_tags($this->id ?? ''));
        $this->nome = htmlspecialchars(strip_tags($this->nome ?? ''));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao ?? ''));
        $this->foto = htmlspecialchars(strip_tags($this->foto ?? ''));
        $this->preco = htmlspecialchars(strip_tags($this->preco ?? ''));
        $this->quantidade_inicial = htmlspecialchars(strip_tags($this->quantidade_inicial ?? ''));
        $this->quantidade_disponivel = htmlspecialchars(strip_tags($this->quantidade_disponivel ?? ''));
        $this->disponivel = isset($this->disponivel) ? ($this->disponivel ? 1 : 0) : 1;
        $this->categoria = htmlspecialchars(strip_tags($this->categoria ?? ''));

        // Vincula os novos valores
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':foto', $this->foto);
        $stmt->bindParam(':preco', $this->preco);
        $stmt->bindParam(':quantidade_inicial', $this->quantidade_inicial);
        $stmt->bindParam(':quantidade_disponivel', $this->quantidade_disponivel);
        $stmt->bindParam(':disponivel', $this->disponivel);
        $stmt->bindParam(':categoria', $this->categoria);

        // Executa a query
        if ($stmt->execute()) {
            // Verifica se alguma linha foi realmente afetada
            if ($stmt->rowCount() > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Deleta uma oferta do banco de dados.
     *
     * @return bool True se a deleção foi bem-sucedida, false caso contrário.
     */
    public function deletar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        // Sanitiza e vincula o ID
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        // Executa a query
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return true;
            }
        }

        return false;
    }
}
?>