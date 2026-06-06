<?php
// actions/soumettre_convention.php
// Endpoint placeholder: upload + enregistrement convention (à brancher à la DB)

require_once __DIR__ . '/../includes/db.php';

// TODO: sécurisation (auth, CSRF, validation)

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => 'Méthode non autorisée']);
    exit;
}

$id_stage = isset($_POST['id_stage']) ? (int)$_POST['id_stage'] : 0;
if ($id_stage <= 0) {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => 'id_stage manquant']);
    exit;
}

if (!isset($_FILES['convention']) || $_FILES['convention']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => 'Fichier manquant ou upload invalide']);
    exit;
}

$file = $_FILES['convention'];
$mime = $file['type'] ?? '';
$ext = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));

// Vérification simple
if ($ext !== 'pdf') {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => 'Le fichier doit être un PDF']);
    exit;
}

$uploadDir = __DIR__ . '/../uploads/conventions';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

$targetName = 'convention_' . $id_stage . '_' . time() . '.pdf';
$targetPath = $uploadDir . '/' . $targetName;

if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok' => false, 'error' => 'Impossible de déplacer le fichier']);
    exit;
}

// TODO: insertion/maj dans stage.convention
// Exemple (à adapter au schéma exact) :
// $pdo = db()->... (selon mysqli ou PDO)

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'ok' => true,
    'uploaded_as' => $targetName,
    'message' => 'Upload réussi (placeholder DB)'
]);

