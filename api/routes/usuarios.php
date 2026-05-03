<?php
// api/routes/usuarios.php

// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../models/Usuario.php';

function send_response($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

$usuario = new Usuario();
$method = $_SERVER['REQUEST_METHOD'];

// Detecta a fonte de entrada (CLI vs. Web)
$input_source = (php_sapi_name() === 'cli') ? 'php://stdin' : 'php://input';

switch ($method) {
    case 'GET':
        try {
            if (isset($_GET['id'])) {
                $usuario->id = intval($_GET['id']);
                if ($usuario->getUm()) {
                    $usuario_item = [
                        "id" => $usuario->id,
                        "nome" => $usuario->nome,
                        "email" => $usuario->email,
                        "cpf_cnpj" => $usuario->cpf_cnpj,
                        "tipo" => $usuario->tipo,
                        "localidade" => $usuario->localidade,
                        "data_cadastro" => $usuario->data_cadastro
                    ];
                    send_response($usuario_item);
                } else {
                    send_response(["mensagem" => "Usuário não encontrado."], 404);
                }
            } else {
                $stmt = $usuario->getTodos();
                $num = $stmt->rowCount();
                if ($num > 0) {
                    $usuarios_arr = ["registros" => [], "contagem" => $num];
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        $usuario_item = [
                            "id" => $id,
                            "nome" => $nome,
                            "email" => $email,
                            "cpf_cnpj" => $cpf_cnpj,
                            "tipo" => $tipo,
                            "localidade" => $localidade,
                            "data_cadastro" => $data_cadastro
                        ];
                        array_push($usuarios_arr["registros"], $usuario_item);
                    }
                    send_response($usuarios_arr);
                } else {
                    send_response(["mensagem" => "Nenhum usuário encontrado."], 404);
                }
            }
        } catch (Exception $e) {
            send_response(["mensagem" => "Erro interno no servidor.", "erro" => $e->getMessage()], 500);
        }
        break;

    case 'POST':
        try {
            $data = json_decode(file_get_contents($input_source));
            if (!empty($data->nome) && !empty($data->email) && !empty($data->senha) && !empty($data->tipo)) {
                $usuario->nome = $data->nome;
                $usuario->email = $data->email;
                $usuario->senha = $data->senha;
                $usuario->tipo = $data->tipo;
                $usuario->cpf_cnpj = $data->cpf_cnpj ?? null;
                $usuario->localidade = $data->localidade ?? null;

                if($usuario->criar()){
                    send_response(["mensagem" => "Usuário criado com sucesso.", "id" => $usuario->id], 201);
                } else {
                    send_response(["mensagem" => "Não foi possível criar o usuário."], 503);
                }
            } else {
                send_response(["mensagem" => "Dados incompletos para criar usuário."], 400);
            }
        } catch (Exception $e) {
            send_response(["mensagem" => "Erro interno no servidor.", "erro" => $e->getMessage()], 500);
        }
        break;

    case 'PUT':
        try {
            $data = json_decode(file_get_contents($input_source));

            if (!isset($_GET['id'])) {
                send_response(["mensagem" => "ID do usuário não fornecido."], 400);
                return;
            }
            
            if (!empty($data->nome) && !empty($data->email) && !empty($data->tipo)) {
                $usuario->id = intval($_GET['id']);
                $usuario->nome = $data->nome;
                $usuario->email = $data->email;
                $usuario->tipo = $data->tipo;
                $usuario->cpf_cnpj = $data->cpf_cnpj ?? null;
                $usuario->localidade = $data->localidade ?? null;
                $usuario->senha = $data->senha ?? null;

                if($usuario->atualizar()){
                    send_response(["mensagem" => "Usuário atualizado com sucesso."]);
                } else {
                     send_response(["mensagem" => "Não foi possível atualizar o usuário. Verifique o ID ou se os dados foram modificados."], 404);
                }
            } else {
                send_response(["mensagem" => "Dados incompletos para atualizar usuário."], 400);
            }
        } catch (Exception $e) {
            send_response(["mensagem" => "Erro interno no servidor.", "erro" => $e->getMessage()], 500);
        }
        break;

    case 'DELETE':
        try {
            if (!isset($_GET['id'])) {
                send_response(["mensagem" => "ID do usuário não fornecido."], 400);
                return;
            }

            $usuario->id = intval($_GET['id']);

            if($usuario->deletar()){
                send_response(["mensagem" => "Usuário deletado com sucesso."]);
            } else {
                send_response(["mensagem" => "Não foi possível deletar o usuário. Verifique se o ID existe."], 404);
            }
        } catch (Exception $e) {
            send_response(["mensagem" => "Erro interno no servidor.", "erro" => $e->getMessage()], 500);
        }
        break;

    default:
        header('Allow: GET, POST, PUT, DELETE');
        send_response(["mensagem" => "Método não permitido."], 405);
        break;
}
?>