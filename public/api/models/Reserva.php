<?php
// /public/api/models/Reserva.php

require_once __DIR__ . '/../config/Database.php';

class Reserva {

    private $conn;
    private $table_name = "reservas";

    // Propriedades da Reserva
    public $id;
    public $consumidor_id;
    public $oferta_id;
    public $quantidade_reservada;
    public $preco; 
    public $peso;  
    public $status;
    public $codigo_retirada;
    public $data_reserva;
    public $data_retirada_prevista;
    public $data_retirada_efetiva;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function criar() {
        $this->conn->beginTransaction();

        try {
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

            $query_update_stock = "UPDATE ofertas SET quantidade_disponivel = quantidade_disponivel - :quantidade_reservada WHERE id = :oferta_id";
            $stmt_update_stock = $this->conn->prepare($query_update_stock);
            $stmt_update_stock->bindParam(':quantidade_reservada', $this->quantidade_reservada, PDO::PARAM_INT);
            $stmt_update_stock->bindParam(':oferta_id', $this->oferta_id, PDO::PARAM_INT);
            $stmt_update_stock->execute();

            $this->codigo_retirada = 'XV-' . substr(strtoupper(bin2hex(random_bytes(3))), 0, 4);

            $query_create_reserva = "INSERT INTO " . $this->table_name . " SET consumidor_id=:consumidor_id, oferta_id=:oferta_id, quantidade_reservada=:quantidade_reservada, preco=:preco, peso=:peso, codigo_retirada=:codigo_retirada, status='Aguardando Retirada'";
            $stmt_create_reserva = $this->conn->prepare($query_create_reserva);

            $this->consumidor_id = htmlspecialchars(strip_tags($this->consumidor_id));
            $this->oferta_id = htmlspecialchars(strip_tags($this->oferta_id));
            $this->quantidade_reservada = htmlspecialchars(strip_tags($this->quantidade_reservada));

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

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function listarPorFeirante($feirante_id, $status_filter = []) {
        $query = "SELECT 
                        r.id, 
                        u.nome as cliente_nome, 
                        o.nome as oferta_nome, 
                        r.quantidade_reservada,
                        r.codigo_retirada, 
                        r.status, 
                        r.data_reserva
                    FROM 
                        " . $this->table_name . " r
                        JOIN usuarios u ON r.consumidor_id = u.id
                        JOIN ofertas o ON r.oferta_id = o.id
                    WHERE 
                        o.feirante_id = :feirante_id";

        $params = [':feirante_id' => $feirante_id];

        if (!empty($status_filter)) {
            $status_placeholders = [];
            foreach ($status_filter as $key => $status) {
                $placeholder = ":status_" . $key;
                $status_placeholders[] = $placeholder;
                $params[$placeholder] = $status;
            }
            $query .= " AND r.status IN (" . implode(', ', $status_placeholders) . ")";
        }

        $query .= " ORDER BY r.data_reserva DESC";

        $stmt = $this->conn->prepare($query);
        
        foreach ($params as $key => $val) {
            $param_type = ($key === ':feirante_id') ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($key, $val, $param_type);
        }

        $stmt->execute();
        return $stmt;
    }

    /**
     * NOVO MÉTODO: Lista todas as reservas de um consumidor específico.
     */
    public function listarPorConsumidor($consumidor_id) {
        $query = "SELECT 
                        r.id,
                        r.codigo_retirada,
                        r.quantidade_reservada,
                        r.status,
                        DATE_FORMAT(r.data_reserva, '%d/%m/%Y às %H:%i') as data_reserva_formatada,
                        o.nome as oferta_nome,
                        o.foto,
                        u.nome as feirante_nome,
                        (r.preco * r.quantidade_reservada) as valor_total
                    FROM 
                        " . $this->table_name . " r
                        JOIN ofertas o ON r.oferta_id = o.id
                        JOIN usuarios u ON o.feirante_id = u.id
                    WHERE 
                        r.consumidor_id = :consumidor_id
                    ORDER BY 
                        r.data_reserva DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':consumidor_id', $consumidor_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function atualizarStatus() {
        $allowed_status = ['Confirmada', 'Aguardando Retirada', 'Concluida', 'Cancelada pelo Consumidor', 'Cancelada pelo Feirante', 'Nao Compareceu'];
        if (!in_array($this->status, $allowed_status)) {
            return false;
        }

        $query = "UPDATE " . $this->table_name . " SET status = :status";

        if ($this->status === 'Concluida') {
            $query .= ", data_retirada_efetiva = NOW()";
        }

        $query .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->status = htmlspecialchars(strip_tags($this->status));
        
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return true;
        }        
        return false;
    }
}
?>