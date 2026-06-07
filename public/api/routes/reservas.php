<?php
// /public/api/routes/reservas.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../models/Reserva.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        try {
            $reserva = new Reserva();
            $data = json_decode(file_get_contents("php://input"));
            if (empty($data->consumidor_id) || empty($data->oferta_id) || empty($data->quantidade_reservada)) {
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "Dados incompletos."]);
                return;
            }
            $reserva->consumidor_id = $data->consumidor_id;
            $reserva->oferta_id = $data->oferta_id;
            $reserva->quantidade_reservada = $data->quantidade_reservada;
            if ($reserva->criar()) {
                http_response_code(201);
                echo json_encode(["status" => "success", "message" => "Reserva criada com sucesso.", "data" => ["reserva_id" => $reserva->id, "codigo_retirada" => $reserva->codigo_retirada]]);
            } else {
                http_response_code(503);
                echo json_encode(["status" => "error", "message" => "Não foi possível criar a reserva. Estoque indisponível ou erro interno."]);
            }
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Erro fatal ao criar reserva.", "details" => $e->getMessage()]);
        }
        break;

    case 'GET':
        try {
            $reserva = new Reserva();

            if (isset($_GET['id'])) {
                $reserva_id = htmlspecialchars(strip_tags($_GET['id']));
                $dados_reserva = $reserva->buscarPorId($reserva_id);
                if ($dados_reserva) {
                    http_response_code(200);
                    echo json_encode(["status" => "success", "data" => $dados_reserva]);
                } else {
                    http_response_code(404);
                    echo json_encode(["status" => "error", "message" => "Reserva não encontrada."]);
                }
            } elseif (isset($_GET['consumidor_id'])) {
                $consumidor_id = htmlspecialchars(strip_tags($_GET['consumidor_id']));
                $status_filter = (isset($_GET['status']) && is_array($_GET['status'])) ? $_GET['status'] : [];
                $stmt = $reserva->listarPorConsumidor($consumidor_id, $status_filter);
                $num = $stmt->rowCount();
                if ($num > 0) {
                    $reservas_arr = [];
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $row['valor_total'] = number_format((float)$row['valor_total'], 2, '.', '');
                        array_push($reservas_arr, $row);
                    }
                    http_response_code(200);
                    echo json_encode(["status" => "success", "data" => $reservas_arr]);
                } else {
                    http_response_code(200);
                    echo json_encode(["status" => "success", "data" => [], "message" => "Nenhuma reserva encontrada para os filtros selecionados."]);
                }
            } elseif (isset($_GET['feirante_id'])) {
                $feirante_id = htmlspecialchars(strip_tags($_GET['feirante_id']));
                $status_filter = (isset($_GET['status']) && is_array($_GET['status'])) ? $_GET['status'] : [];
                $stmt = $reserva->listarPorFeirante($feirante_id, $status_filter);
                $num = $stmt->rowCount();
                if ($num > 0) {
                    $reservas_arr = [];
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $reserva_item = ["id" => $id, "cliente_nome" => $cliente_nome, "oferta_nome" => $oferta_nome, "quantidade_reservada" => $quantidade_reservada, "codigo_retirada" => $codigo_retirada, "status" => $status, "data_reserva" => $data_reserva];
                        array_push($reservas_arr, $reserva_item);
                    }
                    http_response_code(200);
                    echo json_encode(["status" => "success", "data" => $reservas_arr]);
                } else {
                    http_response_code(200);
                    echo json_encode(["status" => "success", "data" => [], "message" => "Nenhuma reserva encontrada."]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "ID da reserva, do consumidor ou do feirante é obrigatório."]);
            }
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Erro fatal ao buscar reservas.", "details" => $e->getMessage(), "file" => $e->getFile(), "line" => $e->getLine()]);
        }
        break;

    case 'PUT':
        try {
            $reserva = new Reserva();
            $data = json_decode(file_get_contents("php://input"));
            if (empty($data->reserva_id) || empty($data->status)) {
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "ID da reserva e novo status são obrigatórios."]);
                return;
            }
            $reserva->id = $data->reserva_id;
            $reserva->status = $data->status;
            if ($reserva->atualizarStatus()) {
                http_response_code(200);
                echo json_encode(["status" => "success", "message" => "Status da reserva atualizado com sucesso."]);
            } else {
                http_response_code(503);
                echo json_encode(["status" => "error", "message" => "Não foi possível atualizar o status da reserva."]);
            }
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Erro fatal ao atualizar reserva.", "details" => $e->getMessage()]);
        }
        break;

    default:
        header('Allow: GET, POST, PUT');
        http_response_code(405);
        echo json_encode(["status" => "error", "message" => "Método não permitido."]);
        break;
}
?>