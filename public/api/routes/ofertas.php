<?php
// api/routes/ofertas.php

// Headers
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

$oferta = new Oferta();
$method = $_SERVER['REQUEST_METHOD'];
$input_source = (php_sapi_name() === 'cli') ? 'php://stdin' : 'php://input';

switch ($method) {
    case 'GET':
        try {
            $stmt = null;
            // Se um feirante_id é especificado, busca as ofertas dele
            if (isset($_GET['feirante_id'])) {
                $stmt = $oferta->getPorFeirante(intval($_GET['feirante_id']));
            } 
            // Se um id de oferta é especificado, busca essa oferta
            else if (isset($_GET['id'])) {
                $oferta->id = intval($_GET['id']);
                if ($oferta->getUm()) {
                    $oferta_item = [
                        "id" => $oferta->id,
                        "feirante_id" => $oferta->feirante_id,
                        "nome_feirante" => $oferta->nome_feirante,
                        "produto" => $oferta->nome, 
                        "descricao" => $oferta->descricao,
                        "foto" => $oferta->foto,
                        "preco" => $oferta->preco,
                        "peso" => $oferta->peso,
                        "quantidade_disponivel" => $oferta->quantidade_disponivel,
                        "disponivel" => (bool)$oferta->disponivel,
                        "categoria" => $oferta->categoria,
                        "data_criacao" => $oferta->data_criacao,
                        "data_modificacao" => $oferta->data_modificacao
                    ];
                    send_response($oferta_item);
                } else {
                    send_response(["mensagem" => "Oferta não encontrada."], 404);
                }
                return; // Encerra a execução aqui
            } 
            // Senão, busca todas as ofertas
            else {
                $stmt = $oferta->getTodas();
            }

            $num = $stmt->rowCount();
            if ($num > 0) {
                $ofertas_arr = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $oferta_item = [
                        "id" => $id,
                        "feirante_id" => $feirante_id,
                        "nome_feirante" => $nome_feirante,
                        "produto" => $nome,
                        "descricao" => $descricao,
                        "foto" => $foto,
                        "preco" => $preco,
                        "peso" => $peso,
                        "quantidade_disponivel" => $quantidade_disponivel,
                        "disponivel" => (bool)$disponivel,
                        "categoria" => $categoria,
                        "data_criacao" => $data_criacao,
                        "data_modificacao" => $data_modificacao
                    ];
                    array_push($ofertas_arr, $oferta_item);
                }
                send_response($ofertas_arr);
            } else {
                send_response([]); // Envia um array vazio
            }
        } catch (Exception $e) {
            send_response(["mensagem" => "Erro interno no servidor.", "erro" => $e->getMessage()], 500);
        }
        break;

    case 'POST':
        try {
            $data = json_decode(file_get_contents($input_source));
            if (!empty($data->feirante_id) && !empty($data->produto) && isset($data->preco) && isset($data->quantidade_disponivel)) {
                $oferta->feirante_id = $data->feirante_id;
                $oferta->nome = $data->produto;
                $oferta->preco = $data->preco;
                $oferta->peso = $data->peso ?? null;
                $oferta->quantidade_inicial = $data->quantidade_disponivel; 
                $oferta->quantidade_disponivel = $data->quantidade_disponivel;
                $oferta->descricao = $data->descricao ?? null;
                $oferta->foto = $data->foto ?? null;
                $oferta->categoria = $data->categoria ?? null;
                $oferta->disponivel = $data->disponivel ?? true;

                if($oferta->criar()){
                    send_response(["status" => "success", "message" => "Oferta criada com sucesso.", "id" => $oferta->id], 201);
                } else {
                    send_response(["status" => "error", "message" => "Não foi possível criar a oferta."], 503);
                }
            } else {
                send_response(["status" => "error", "message" => "Dados incompletos. Campos obrigatórios: feirante_id, produto, preco, quantidade_disponivel."], 400);
            }
        } catch (Exception $e) {
            send_response(["status" => "error", "message" => "Erro interno no servidor.", "erro" => $e->getMessage()], 500);
        }
        break;

    case 'PUT':
        try {
            $data = json_decode(file_get_contents($input_source));
            if (!isset($_GET['id'])) {
                send_response(["mensagem" => "ID da oferta não fornecido."], 400);
                return;
            }

            if (!empty($data->produto) && isset($data->preco) && isset($data->quantidade_disponivel)) {
                $oferta->id = intval($_GET['id']);
                $oferta->nome = $data->produto;
                $oferta->preco = $data->preco;
                $oferta->peso = $data->peso ?? null;
                $oferta->quantidade_inicial = $data->quantidade_disponivel;
                $oferta->descricao = $data->descricao ?? null;
                $oferta->foto = $data->foto ?? null;
                $oferta->categoria = $data->categoria ?? null;
                $oferta->disponivel = $data->disponivel ?? true;

                if($oferta->atualizar()){
                    send_response(["status" => "success", "message" => "Oferta atualizada com sucesso."]);
                } else {
                    send_response(["status" => "error", "message" => "Não foi possível atualizar a oferta. Verifique o ID ou se os dados foram modificados."], 404);
                }
            } else {
                send_response(["status" => "error", "message" => "Dados incompletos para atualizar. Campos obrigatórios: produto, preco, quantidade_disponivel."], 400);
            }
        } catch (Exception $e) {
            send_response(["status" => "error", "message" => "Erro interno no servidor.", "erro" => $e->getMessage()], 500);
        }
        break;

    case 'DELETE':
        try {
            $data = json_decode(file_get_contents('php://input'));
            if ($data && !empty($data->id)) {
                $oferta->id = $data->id;
                if($oferta->deletar()){
                    send_response(["status" => "success", "message" => "Oferta deletada com sucesso."]);
                } else {
                    send_response(["status" => "error", "message" => "Não foi possível deletar a oferta."], 503);
                }
            } else {
                 send_response(["status" => "error", "message" => "ID da oferta não fornecido."], 400);
            }
        } catch (Exception $e) {
            send_response(["status" => "error", "message" => "Erro interno no servidor.", "erro" => $e->getMessage()], 500);
        }
        break;

    default:
        header('Allow: GET, POST, PUT, DELETE');
        send_response(["message" => "Método não permitido."], 405);
        break;
}
?>