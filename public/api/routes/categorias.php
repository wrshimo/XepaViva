<?php
// public/api/routes/categorias.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../models/Categoria.php';

function send_response($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    try {
        $categoriaModel = new Categoria();
        $categorias = $categoriaModel->getTodasCategorias();
        send_response([
            'sucesso' => true,
            'dados' => $categorias
        ]);
    } catch (Exception $e) {
        send_response([
            'sucesso' => false,
            'mensagem' => 'Erro interno no servidor ao buscar categorias.',
            'erro' => $e->getMessage()
        ], 500);
    }
} else {
    header('Allow: GET');
    send_response([
        'sucesso' => false,
        'mensagem' => 'Método não permitido.'
    ], 405);
}
?>