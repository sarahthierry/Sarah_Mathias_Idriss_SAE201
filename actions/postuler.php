<?php
// actions/postuler.php
// Placeholder: créer une candidature pour une offre

require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => 'Méthode non autorisée']);
    exit;
}

$id_offre = isset($_POST['id_offre']) ? (int)$_POST['id_offre'] : 0;
if ($id_offre <= 0) {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => 'id_offre manquant']);
    exit;
}

// TODO: insert DB candidature (étudiant_id récupéré via session)

header('Content-Type: application/json; charset=utf-8');
echo json_encode(['ok' => true, 'message' => 'Candidature envoyée (placeholder)']);

