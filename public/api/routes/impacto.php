<?php
// /public/api/routes/impacto.php

require_once __DIR__ . '/../config/Database.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
    $pdo = Database::getInstance()->getConnection();
    
    // 1. KPIs principais
    $stmt_kpis = $pdo->query("
        SELECT
            (SELECT COUNT(id) FROM usuarios WHERE tipo = 'Feirante') AS total_feirantes,
            (SELECT COUNT(id) FROM reservas WHERE status = 'Concluida') AS reservas_concluidas,
            (SELECT SUM(peso * quantidade_reservada) FROM reservas WHERE status = 'Concluida') AS total_kg_salvo,
            (SELECT SUM(preco * quantidade_reservada) FROM reservas WHERE status = 'Concluida') AS total_renda_gerada,
            (SELECT COUNT(DISTINCT consumidor_id) FROM reservas WHERE status = 'Concluida') AS familias_impactadas
    ");
    $kpis = $stmt_kpis->fetch(PDO::FETCH_ASSOC);

    // Tratamento de valores nulos caso não haja dados
    foreach ($kpis as $key => $value) {
        $kpis[$key] = $value ?? 0;
    }

    // 2. Gráfico de Status de Reservas (agrupando cancelados)
    $stmt_status = $pdo->query("
        SELECT 
            CASE 
                WHEN status LIKE 'Cancelada%' THEN 'Cancelada'
                ELSE status 
            END as status_agrupado, 
            COUNT(id) AS contagem 
        FROM reservas 
        GROUP BY status_agrupado
    ");
    $status_reservas = $stmt_status->fetchAll(PDO::FETCH_ASSOC);
    
    // 3. Gráfico de Categorias mais salvas
    $stmt_categorias = $pdo->query("
        SELECT
            o.categoria,
            SUM(r.peso * r.quantidade_reservada) AS kg_por_categoria
        FROM reservas r
        JOIN ofertas o ON r.oferta_id = o.id
        WHERE r.status = 'Concluida' AND o.categoria IS NOT NULL
        GROUP BY o.categoria
        ORDER BY kg_por_categoria DESC
        LIMIT 5
    ");
    $top_categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

    // Monta o JSON de resposta
    $response = [
        'status' => 'success',
        'data' => [
            'kpis' => [
                'alimento_salvo_kg' => round($kpis['total_kg_salvo'], 2),
                'renda_gerada_reais' => round($kpis['total_renda_gerada'], 2),
                'feirantes_parceiros' => (int) $kpis['total_feirantes'],
                'reservas_concluidas' => (int) $kpis['reservas_concluidas'],
                'familias_impactadas' => (int) $kpis['familias_impactadas']
            ],
            'graficos' => [
                'status_reservas' => $status_reservas,
                'top_categorias' => $top_categorias
            ]
        ]
    ];
    
    http_response_code(200);
    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(503); // Service Unavailable
    echo json_encode([
        "status" => "error",
        "message" => "Não foi possível calcular os dados de impacto.",
        "error_details" => $e->getMessage()
    ]);
}
?>