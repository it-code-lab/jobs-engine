<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/includes/db.php';

header('Content-Type: application/json; charset=utf-8');

$stateId = (int)($_GET['state_id'] ?? 0);

if ($stateId <= 0) {
    echo json_encode([]);
    exit;
}

$pdo = db();

$stmt = $pdo->prepare("
    SELECT id, name
    FROM jobs_districts
    WHERE state_id = :state_id
      AND status = 'active'
    ORDER BY sort_order ASC, name ASC
");

$stmt->execute([':state_id' => $stateId]);

echo json_encode($stmt->fetchAll());