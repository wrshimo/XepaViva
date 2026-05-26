<?php
// /public/api/models/Reserva.php

// CORRIGIDO: O nome do arquivo é Database.php (D maiúsculo)
require_once __DIR__ . '/../config/Database.php';

class Reserva {

    private $conn;
    private $table_name = "reservas";

    // Propriedades da Reserva
    public $id;
    public $consumidor_id;
    public $oferta_id;
    public $quantidade_reservada;
    public $preco; // Preço no momento da reserva
    public $peso;  // Peso no momento da reserva
    public $status;
    public $codigo_retirada;
    public $data_reserva;
    public $data_retirada_prevista;
    public $data_retirada_efetiva;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Cria uma nova reserva e atualiza o estoque da oferta de forma transacional.
     * @return bool True se a reserva foi criada com sucesso, false caso contrário.
     */
    public function criar() {
        $this->conn->beginTransaction();

        try {
            // 1. VERIFICAR ESTOQUE E OBTER DADOS DA OFERTA
            $query_check_stock = "SELECT quantidade_disponivel, preco, peso FROM ofertas WHERE id = :oferta_id AND disponivel = 1 FOR UPDATE";
            $stmt_check_stock = $this->conn->prepare($query_check_stock);
            $stmt_check_stock->bindParam(':oferta_id', $this->oferta_id, PDO::PARAM_INT);
            $stmt_check_stock->execute();

            $oferta = $stmt_check_stock->fetch(PDO::FETCH_ASSOC);

            if (!$oferta || $oferta['quantidade_disponivel'] < $this->quantidade_reservada) {
                $this->conn->rollBack();
                return false; 
            }
            
            $this->preco = $oferta['preco'];
            $this->peso = $oferta['peso'];

            // 2. ATUALIZAR O ESTOQUE NA TABELA DE OFERTAS
            $query_update_stock = "UPDATE ofertas SET quantidade_disponivel = quantidade_disponivel - :quantidade_reservada WHERE id = :oferta_id";
            $stmt_update_stock = $this->conn->prepare($query_update_stock);
            $stmt_update_stock->bindParam(':quantidade_reservada', $this->quantidade_reservada, PDO::PARAM_INT);
            $stmt_update_stock->bindParam(':oferta_id', $this->oferta_id, PDO::PARAM_INT);
            $stmt_update_stock->execute();

            // 3. GERAR UM CÓDIGO DE RETIRADA ÚNICO
            $this->codigo_retirada = 'XV-' . substr(strtoupper(bin2hex(random_bytes(3))), 0, 4);

            // 4. INSERIR O REGISTRO NA TABELA DE RESERVAS
            $query_create_reserva = "INSERT INTO " . $this->table_name . " SET consumidor_id=:consumidor_id, oferta_id=:oferta_id, quantidade_reservada=:quantidade_reservada, preco=:preco, peso=:peso, codigo_retirada=:codigo_retirada, status='Pendente'";
            $stmt_create_reserva = $this->conn->prepare($query_create_reserva);

            // Sanitiza os dados
            $this->consumidor_id = htmlspecialchars(strip_tags($this->consumidor_id));
            $this->oferta_id = htmlspecialchars(strip_tags($this->oferta_id));
            $this->quantidade_reservada = htmlspecialchars(strip_tags($this->quantidade_reservada));

            // Vincula os valores
            $stmt_create_reserva->bindParam(":consumidor_id", $this->consumidor_id);
            $stmt_create_reserva->bindParam(":oferta_id", $this->oferta_id);
            $stmt_create_reserva->bindParam(":quantidade_reservada", $this->quantidade_reservada);
            $stmt_create_reserva->bindParam(":preco", $this->preco);
            $stmt_create_reserva->bindParam(":peso", $this->peso);
            $stmt_create_reserva->bindParam(":codigo_retirada", $this->codigo_retirada);

            if(!$stmt_create_reserva->execute()) {
                $this->conn->rollBack();
                return false;
            }
            
            $this->id = $this->conn->lastInsertId();

            // 5. SE TUDO DEU CERTO, CONFIRMA AS MUDANÇAS NO BANCO DE DADOS.
            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>