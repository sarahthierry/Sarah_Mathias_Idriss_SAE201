<?php
// actions/valider_convention.php
// Endpoint placeholder: valider une convention (mettre statut = validée)

require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => 'Méthode non autorisée']);
    exit;
}

$id_convention = isset($_POST['id_convention']) ? (int)$_POST['id_convention'] : 0;
if ($id_convention <= 0) {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => 'id_convention manquant']);
    exit;
}

// TODO: update DB
// db()->query('UPDATE stage SET statut=... WHERE id=...');

header('Content-Type: application/json; charset=utf-8');
echo json_encode(['ok' => true, 'message' => 'Convention validée (placeholder)']);

