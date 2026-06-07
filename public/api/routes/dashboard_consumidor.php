<?php
// public/api/routes/dashboard_consumidor.php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Reserva.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Garante que o usuário esteja logado e seja um consumidor
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'Consumidor') {
    http_response_code(403); // Forbidden
    echo json_encode(['status' => 'error', 'message' => 'Acesso negado.']);
    exit;
}

$consumidor_id = $_SESSION['usuario_id'];

try {
    $pdo = Database::getInstance()->getConnection();
    
    // 1. KPIs de Impacto Pessoal
    // CORREÇÃO: Trocou o.preco_original por o.preco, que existe na tabela ofertas.
    $stmt_kpis = $pdo->prepare("
        SELECT 
            COALESCE(SUM(o.preco * r.quantidade_reservada - r.preco * r.quantidade_reservada), 0) as economia_total,
            COALESCE(SUM(r.peso * r.quantidade_reservada), 0) as kg_salvos,
            (SELECT COUNT(id) FROM reservas WHERE consumidor_id = :id1) as total_reservas
        FROM reservas r
        JOIN ofertas o ON r.oferta_id = o.id
        WHERE r.consumidor_id = :id2 AND r.status = 'Concluida'
    ");
    $stmt_kpis->execute(['id1' => $consumidor_id, 'id2' => $consumidor_id]);
    $kpis = $stmt_kpis->fetch(PDO::FETCH_ASSOC);

    // 2. Reservas Ativas (Aguardando Retirada)
    // CORREÇÃO: A coluna de nome do produto está em `ofertas` como `nome`, não `produto`.
    // CORREÇÃO: A coluna de nome do feirante está em `usuarios` como `nome`, não `nome_fantasia` (para feirantes).
    $stmt_ativas = $pdo->prepare("
        SELECT r.id, o.nome as produto, u.nome as feirante
        FROM reservas r
        JOIN ofertas o ON r.oferta_id = o.id
        JOIN usuarios u ON o.feirante_id = u.id
        WHERE r.consumidor_id = :id AND r.status = 'Aguardando Retirada'
        ORDER BY r.data_reserva DESC
    ");
    $stmt_ativas->execute(['id' => $consumidor_id]);
    $reservas_ativas = $stmt_ativas->fetchAll(PDO::FETCH_ASSOC);

    // 3. Histórico de Últimas Reservas
    $stmt_historico = $pdo->prepare("
        SELECT r.id, o.nome as produto, r.status, r.data_reserva, (r.preco * r.quantidade_reservada) as preco_final
        FROM reservas r
        JOIN ofertas o ON r.oferta_id = o.id
        WHERE r.consumidor_id = :id
        ORDER BY r.data_reserva DESC
        LIMIT 5
    ");
    $stmt_historico->execute(['id' => $consumidor_id]);
    $historico_reservas = $stmt_historico->fetchAll(PDO::FETCH_ASSOC);

    // 4. Feirantes Favoritos
    $stmt_favoritos = $pdo->prepare("
        SELECT u.nome as nome_fantasia, COUNT(r.id) as num_reservas
        FROM reservas r
        JOIN ofertas o ON r.oferta_id = o.id
        JOIN usuarios u ON o.feirante_id = u.id
        WHERE r.consumidor_id = :id AND r.status = 'Concluida'
        GROUP BY u.nome
        ORDER BY num_reservas DESC
        LIMIT 3
    ");
    $stmt_favoritos->execute(['id' => $consumidor_id]);
    $feirantes_favoritos = $stmt_favoritos->fetchAll(PDO::FETCH_ASSOC);

    // Monta a resposta
    $response = [
        'status' => 'success',
        'data' => [
            'kpis' => [
                'economia_total_reais' => round($kpis['economia_total'], 2),
                'alimentos_salvos_kg' => round($kpis['kg_salvos'], 2),
                'total_reservas' => (int) $kpis['total_reservas']
            ],
            'reservas_ativas' => $reservas_ativas,
            'historico_reservas' => $historico_reservas,
            'feirantes_favoritos' => $feirantes_favoritos
        ]
    ];

    http_response_code(200);
    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(503);
    echo json_encode(['status' => 'error', 'message' => 'Erro ao buscar dados do dashboard.', 'error_details' => $e->getMessage()]);
}

?>