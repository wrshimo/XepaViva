<?php
// public/api/routes/categorias.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../models/Categoria.php';

function send_json_response($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    try {
        $categoriaModel = new Categoria();
        // O modelo continua retornando um array de strings simples, como solicitado.
        $categoriasStrings = $categoriaModel->getTodasCategorias();

        // O roteador transforma os dados para o formato que o frontend espera.
        $categoriasFormatadas = array_map(function($nomeCategoria) {
            return ['nome' => $nomeCategoria];
        }, $categoriasStrings);

        // A resposta é enviada com as chaves padronizadas ('status', 'data').
        send_json_response([
            'status' => 'success',
            'data' => $categoriasFormatadas
        ]);

    } catch (Exception $e) {
        send_json_response([
            'status' => 'error',
            'message' => 'Erro interno no servidor ao buscar categorias.',
            'error_details' => $e->getMessage() // Para depuração
        ], 500);
    }
} else {
    header('Allow: GET');
    send_json_response([
        'status' => 'error',
        'message' => 'Método não permitido.'
    ], 405);
}
?>