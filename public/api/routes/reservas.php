<?php
// /public/api/routes/reservas.php

// Headers para permitir requisições de qualquer origem (CORS) e definir o tipo de conteúdo.
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET"); // Futuramente podemos adicionar GET para listar reservas
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../helpers/response.php'; // Helper para padronizar as respostas

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    // Lógica para criar uma nova reserva
    try {
        // 1. OBTER DADOS DA REQUISIÇÃO
        $data = json_decode(file_get_contents("php://input"));

        // 2. VALIDAR DADOS
        // Verifica se os campos essenciais foram enviados na requisição.
        if (
            empty($data->consumidor_id) ||
            empty($data->oferta_id) ||
            empty($data->quantidade_reservada)
        ) {
            send_response(400, ["status" => "error", "message" => "Dados incompletos. Campos obrigatórios: consumidor_id, oferta_id, quantidade_reservada."]);
            return;
        }

        // 3. INSTANCIAR E PREENCHER O MODELO
        $reserva = new Reserva();
        $reserva->consumidor_id = $data->consumidor_id;
        $reserva->oferta_id = $data->oferta_id;
        $reserva->quantidade_reservada = $data->quantidade_reservada;

        // 4. TENTAR CRIAR A RESERVA
        // O método criar() no modelo Reserva contém toda a lógica de transação e verificação de estoque.
        if ($reserva->criar()) {
            // Se a criação for bem-sucedida, retorna o status 201 (Created)
            send_response(201, [
                "status" => "success", 
                "message" => "Reserva criada com sucesso.",
                "data" => [
                    "reserva_id" => $reserva->id,
                    "codigo_retirada" => $reserva->codigo_retirada
                ]
            ]);
        } else {
            // Se criar() retorna false, pode ser por estoque insuficiente ou outro erro de banco de dados.
            send_response(503, ["status" => "error", "message" => "Não foi possível criar a reserva. Verifique o estoque da oferta ou tente novamente mais tarde."]);
        }

    } catch (Exception $e) {
        // Captura qualquer erro inesperado durante o processo.
        send_response(500, ["status" => "error", "message" => "Erro interno no servidor.", "error_details" => $e->getMessage()]);
    }
} else {
    // Se o método não for POST, retorna um erro 405 (Method Not Allowed).
    header('Allow: POST');
    send_response(405, ["status" => "error", "message" => "Método não permitido."]);
}
?>