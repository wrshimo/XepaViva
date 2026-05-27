<?php
// Define o cabeçalho como JSON para todas as respostas.
header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/config.php';

$response = ['status' => 'error', 'message' => 'Requisição inválida.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega os dados JSON enviados pelo cliente (fetch)
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'] ?? '';
    $senha = $data['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $response['message'] = 'Email e senha são obrigatórios.';
        http_response_code(400); // Bad Request
    } else {
        try {
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->buscarPorEmail($email);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Login bem-sucedido: Armazena na sessão do PHP
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_tipo'] = $usuario['tipo'];

                // Prepara a resposta de sucesso para o JavaScript
                $response['status'] = 'success';
                $response['message'] = 'Login bem-sucedido.';
                // Envia os dados do usuário para serem armazenados no localStorage
                $response['user'] = [
                    'id' => $usuario['id'],
                    'nome' => $usuario['nome'],
                    'tipo' => $usuario['tipo']
                ];
                // Define a URL de redirecionamento para o JS
                $response['redirect_url'] = $usuario['tipo'] === 'Feirante' ? 'feirante.php' : 'consumidor.php';
                http_response_code(200); // OK

            } else {
                $response['message'] = 'Email ou senha inválidos.';
                http_response_code(401); // Unauthorized
            }
        } catch (Exception $e) {
            error_log("Erro no login: " . $e->getMessage());
            $response['message'] = 'Ocorreu um erro no servidor. Tente novamente mais tarde.';
            http_response_code(500); // Internal Server Error
        }
    }
} else {
    http_response_code(405); // Method Not Allowed
    $response['message'] = 'Método não permitido.';
}

echo json_encode($response);
exit();
?>