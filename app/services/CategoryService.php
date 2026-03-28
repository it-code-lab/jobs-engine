<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';

class CategoryService
{
    public static function getActiveCategories(): array
    {
        $pdo = db();

        $stmt = $pdo->query("
            SELECT id, name, slug
            FROM jobs_opportunity_categories
            WHERE status = 'active'
            ORDER BY sort_order ASC, name ASC
        ");

        return $stmt->fetchAll();
    }
}