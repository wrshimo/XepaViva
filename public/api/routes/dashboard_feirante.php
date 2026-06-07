<?php
// public/api/routes/dashboard_feirante.php

require_once __DIR__ . '/../config/Database.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'Feirante') {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Acesso negado.']);
    exit;
}

$feirante_id = $_SESSION['usuario_id'];

try {
    $pdo = Database::getInstance()->getConnection();

    // 1. KPIs
    // CORREÇÃO: Especificado r.id em COUNT(r.id) para resolver ambiguidade de coluna.
    $stmt_kpis = $pdo->prepare("
        SELECT 
            (SELECT COUNT(id) FROM ofertas WHERE feirante_id = :id1 AND disponivel = 1) as ofertas_ativas,
            (SELECT COUNT(r.id) FROM reservas r JOIN ofertas o ON r.oferta_id = o.id WHERE o.feirante_id = :id2 AND r.status = 'Aguardando Retirada') as reservas_para_hoje,
            (SELECT COUNT(DISTINCT consumidor_id) FROM reservas r JOIN ofertas o ON r.oferta_id = o.id WHERE o.feirante_id = :id3 AND r.status = 'Concluida') as clientes_atendidos
    ");
    $stmt_kpis->execute(['id1' => $feirante_id, 'id2' => $feirante_id, 'id3' => $feirante_id]);
    $kpis = $stmt_kpis->fetch(PDO::FETCH_ASSOC);

    // 2. Detalhes das Reservas Aguardando Retirada
    $stmt_retirada = $pdo->prepare("
        SELECT r.id as reserva_id, o.nome as produto_nome, r.quantidade_reservada as quantidade, u.nome as consumidor_nome, r.codigo_retirada
        FROM reservas r
        JOIN ofertas o ON r.oferta_id = o.id
        JOIN usuarios u ON r.consumidor_id = u.id
        WHERE o.feirante_id = :id AND r.status = 'Aguardando Retirada'
        ORDER BY r.data_reserva ASC
    ");
    $stmt_retirada->execute(['id' => $feirante_id]);
    $reservas_para_retirada = $stmt_retirada->fetchAll(PDO::FETCH_ASSOC);

    // 3. Produtos Mais Vendidos (Top 5)
    $stmt_top_produtos = $pdo->prepare("
        SELECT o.nome as produto_nome, SUM(r.quantidade_reservada) as total_vendido
        FROM reservas r
        JOIN ofertas o ON r.oferta_id = o.id
        WHERE o.feirante_id = :id AND r.status = 'Concluida'
        GROUP BY o.nome
        ORDER BY total_vendido DESC
        LIMIT 5
    ");
    $stmt_top_produtos->execute(['id' => $feirante_id]);
    $produtos_mais_vendidos = $stmt_top_produtos->fetchAll(PDO::FETCH_ASSOC);

    // Monta a resposta
    $response = [
        'status' => 'success',
        'data' => [
            'kpis' => [
                'ofertas_ativas' => (int) $kpis['ofertas_ativas'],
                'reservas_para_hoje' => (int) $kpis['reservas_para_hoje'],
                'clientes_atendidos' => (int) $kpis['clientes_atendidos']
            ],
            'reservas_para_retirada' => $reservas_para_retirada,
            'produtos_mais_vendidos' => $produtos_mais_vendidos
        ]
    ];

    http_response_code(200);
    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(503);
    echo json_encode(['status' => 'error', 'message' => 'Erro ao buscar dados do dashboard do feirante.', 'error_details' => $e->getMessage()]);
}

?>