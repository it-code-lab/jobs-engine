<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';

class LocationService
{
    public static function getActiveStates(): array
    {
        $pdo = db();

        $stmt = $pdo->query("
            SELECT id, name
            FROM jobs_states
            WHERE status = 'active'
            ORDER BY sort_order ASC, name ASC
        ");

        return $stmt->fetchAll();
    }

    public static function getDistrictsByStateId(int $stateId): array
    {
        $pdo = db();

        $stmt = $pdo->prepare("
            SELECT id, name, district_type
            FROM jobs_districts
            WHERE state_id = :state_id
              AND status = 'active'
            ORDER BY sort_order ASC, name ASC
        ");

        $stmt->execute([':state_id' => $stateId]);

        return $stmt->fetchAll();
    }

    public static function getDistrictById(int $districtId): ?array
    {
        $pdo = db();

        $stmt = $pdo->prepare("
            SELECT d.id, d.name, d.district_type, d.state_id, s.name AS state_name
            FROM jobs_districts d
            INNER JOIN jobs_states s ON s.id = d.state_id
            WHERE d.id = :district_id
            LIMIT 1
        ");

        $stmt->execute([':district_id' => $districtId]);

        $row = $stmt->fetch();
        return $row ?: null;
    }
}