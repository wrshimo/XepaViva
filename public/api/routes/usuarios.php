<?php
// /public/api/routes/usuarios.php

require_once __DIR__ . '/../../../config/Database.php';
require_once __DIR__ . '/../models/Usuario.php';

// Headers para permitir requisições de origens diferentes (CORS) e definir o tipo de conteúdo
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Método não permitido
    echo json_encode(["status" => "error", "message" => "Método não permitido."]);
    exit;
}

// Pega os dados enviados no corpo da requisição
$data = json_decode(file_get_contents("php://input"));

// Validação básica dos dados recebidos
if (
    !isset($data->nome) || empty(trim($data->nome)) ||
    !isset($data->email) || !filter_var($data->email, FILTER_VALIDATE_EMAIL) ||
    !isset($data->senha) || empty($data->senha) ||
    !isset($data->telefone) || empty(trim($data->telefone)) ||
    !isset($data->tipo) || ($data->tipo !== 'Consumidor' && $data->tipo !== 'Feirante')
) {
    http_response_code(400); // Requisição inválida
    echo json_encode(["status" => "error", "message" => "Dados inválidos ou incompletos. Por favor, preencha todos os campos corretamente."]);
    exit;
}

try {
    $usuario = new Usuario();

    // Verifica se o e-mail já está cadastrado
    if ($usuario->buscarPorEmail($data->email)) {
        http_response_code(409); // Conflito
        echo json_encode(["status" => "error", "message" => "Este endereço de e-mail já está em uso."]);
        exit;
    }

    // Atribui os valores ao objeto Usuario
    $usuario->nome = $data->nome;
    $usuario->email = $data->email;
    $usuario->telefone = $data->telefone;
    $usuario->tipo = $data->tipo;
    
    // Gera o hash da senha
    $usuario->senha_hash = password_hash($data->senha, PASSWORD_DEFAULT);

    // Tenta criar o usuário
    if ($usuario->criar()) {
        http_response_code(201); // Criado
        echo json_encode(["status" => "success", "message" => "Cadastro realizado com sucesso! Você será redirecionado para o login."]);
    } else {
        http_response_code(500); // Erro do servidor
        echo json_encode(["status" => "error", "message" => "Não foi possível criar o usuário. Tente novamente."]);
    }
} catch (Exception $e) {
    // Em um ambiente de produção, seria ideal logar o erro em vez de exibi-lo.
    // error_log($e->getMessage());
    http_response_code(503); // Serviço indisponível
    echo json_encode(["status" => "error", "message" => "Ocorreu um erro inesperado no servidor."]);
}

?>