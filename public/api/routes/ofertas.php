<?php
// public/api/routes/ofertas.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../models/Oferta.php';

function send_response($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        try {
            $filtros = [];
            $ofertaModel = new Oferta();

            // Sanitiza e aplica filtros da URL
            if (!empty($_GET['q'])) $filtros['q'] = htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8');
            if (!empty($_GET['categoria'])) $filtros['categoria'] = htmlspecialchars($_GET['categoria'], ENT_QUOTES, 'UTF-8');
            if (isset($_GET['id'])) $filtros['id'] = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            
            $feirante_id = filter_input(INPUT_GET, 'feirante_id', FILTER_VALIDATE_INT);
            if ($feirante_id) {
                $filtros['feirante_id'] = $feirante_id;
            }

            // LÓGICA DE NEGÓCIOS: SEPARAÇÃO DE PAPÉIS (CONSUMIDOR vs FEIRANTE)
            if (isset($_GET['disponivel'])) {
                // Se o filtro `disponivel` é passado explicitamente, ele tem prioridade.
                $filtros['disponivel'] = filter_var($_GET['disponivel'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            } else if (!$feirante_id) {
                // Se NENHUM feirante_id foi especificado, é uma busca de consumidor.
                // Neste caso, FORÇAMOS o filtro para mostrar apenas ofertas disponíveis.
                $filtros['disponivel'] = true;
            }
            // Se um feirante_id FOI especificado e `disponivel` não, nenhum filtro de disponibilidade é aplicado,
            // mostrando ao feirante todas as suas ofertas (ativas e inativas).

            $ofertas = $ofertaModel->buscar($filtros);
            
            send_response(['status' => 'success', 'data' => $ofertas]);

        } catch (Exception $e) {
            send_response(['status' => 'error', 'message' => 'Erro ao buscar ofertas', 'details' => $e->getMessage()], 500);
        }
        break;

    case 'POST':
        try {
            $ofertaModel = new Oferta();
            $data = json_decode(file_get_contents('php://input'));

            if (empty($data->feirante_id) || empty($data->nome) || !isset($data->preco) || !isset($data->quantidade_inicial)) {
                send_response(["status" => "error", "message" => "Dados incompletos para criar oferta."], 400);
                return;
            }

            $ofertaModel->feirante_id = $data->feirante_id;
            $ofertaModel->nome = $data->nome;
            $ofertaModel->preco = $data->preco;
            $ofertaModel->quantidade_inicial = $data->quantidade_inicial;
            $ofertaModel->quantidade_disponivel = $data->quantidade_inicial;
            $ofertaModel->descricao = $data->descricao ?? null;
            $ofertaModel->categoria = $data->categoria ?? null;

            if ($ofertaModel->criar()) {
                send_response(["status" => "success", "message" => "Oferta criada com sucesso.", "id" => $ofertaModel->id], 201);
            } else {
                send_response(["status" => "error", "message" => "Não foi possível criar a oferta."], 503);
            }
        } catch (Exception $e) {
            send_response(["status" => "error", "message" => "Erro interno no servidor ao criar.", "erro" => $e->getMessage()], 500);
        }
        break;

    case 'PUT':
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (!$id) {
                send_response(["status" => "error", "message" => "ID da oferta não fornecido."], 400);
                return;
            }

            $ofertaParaAtualizar = new Oferta();
            if (!$ofertaParaAtualizar->carregarPeloId($id)) {
                send_response(["status" => "error", "message" => "Oferta não encontrada."], 404);
                return;
            }

            $data = json_decode(file_get_contents('php://input'));

            foreach ($data as $key => $value) {
                if (property_exists($ofertaParaAtualizar, $key)) {
                    $ofertaParaAtualizar->$key = $value;
                }
            }

            if ($ofertaParaAtualizar->atualizar()) {
                send_response(["status" => "success", "message" => "Oferta atualizada com sucesso."]);
            } else {
                send_response(["status" => "error", "message" => "Não foi possível atualizar a oferta."], 500);
            }
        } catch (Exception $e) {
            send_response(["status" => "error", "message" => "Erro interno no servidor ao atualizar.", "erro" => $e->getMessage()], 500);
        }
        break;

    case 'DELETE':
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (!$id) {
                send_response(["status" => "error", "message" => "ID da oferta não fornecido."], 400);
                return;
            }
            $ofertaModel = new Oferta();
            $ofertaModel->id = $id;
            if ($ofertaModel->deletar()) {
                send_response(["status" => "success", "message" => "Oferta excluída com sucesso."]);
            } else {
                send_response(["status" => "error", "message" => "Não foi possível excluir a oferta."], 503);
            }
        } catch (Exception $e) {
            send_response(["status" => "error", "message" => "Erro interno no servidor ao deletar.", "erro" => $e->getMessage()], 500);
        }
        break;

    default:
        header('Allow: GET, POST, PUT, DELETE');
        send_response(["message" => "Método não permitido."], 405);
        break;
}
?>