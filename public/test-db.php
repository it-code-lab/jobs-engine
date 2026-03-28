<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/database.php';

try {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM jobs_opportunities");
    $total = $stmt->fetchColumn();

    echo "<h1>Database connection successful</h1>";
    echo "<p>Total opportunities in database: " . htmlspecialchars((string)$total) . "</p>";
} catch (Throwable $e) {
    echo "<h1>Database connection failed</h1>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}