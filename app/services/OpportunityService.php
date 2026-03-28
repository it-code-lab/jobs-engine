<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';

class OpportunityService
{
    public static function getPublishedOpportunities(
        string $search = '',
        string $type = '',
        int $limit = 12,
        int $offset = 0
    ): array {
        $pdo = db();

        $sql = "
            SELECT 
                o.id,
                o.title,
                o.slug,
                o.short_summary,
                o.opportunity_type,
                o.home_based_suitability,
                o.investment_min,
                o.investment_max,
                o.earning_min,
                o.earning_max,
                o.time_to_start_label,
                o.risk_level,
                c.name AS category_name
            FROM jobs_opportunities o
            INNER JOIN jobs_opportunity_categories c ON c.id = o.category_id
            WHERE o.status = 'published'
        ";

        $params = [];

        if ($search !== '') {
            $sql .= " AND (o.title LIKE :search OR o.short_summary LIKE :search OR c.name LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if ($type !== '') {
            $sql .= " AND o.opportunity_type = :type";
            $params[':type'] = $type;
        }

        $sql .= " ORDER BY o.featured_flag DESC, o.created_at DESC LIMIT :limit OFFSET :offset";

        $stmt = $pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function countPublishedOpportunities(string $search = '', string $type = ''): int
    {
        $pdo = db();

        $sql = "
            SELECT COUNT(*) AS total
            FROM jobs_opportunities o
            INNER JOIN jobs_opportunity_categories c ON c.id = o.category_id
            WHERE o.status = 'published'
        ";

        $params = [];

        if ($search !== '') {
            $sql .= " AND (o.title LIKE :search OR o.short_summary LIKE :search OR c.name LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if ($type !== '') {
            $sql .= " AND o.opportunity_type = :type";
            $params[':type'] = $type;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn();
    }

    public static function getOpportunityBySlug(string $slug): ?array
    {
        $pdo = db();

        $sql = "
            SELECT 
                o.*,
                c.name AS category_name
            FROM jobs_opportunities o
            INNER JOIN jobs_opportunity_categories c ON c.id = o.category_id
            WHERE o.slug = :slug
              AND o.status = 'published'
            LIMIT 1
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':slug' => $slug]);

        $opportunity = $stmt->fetch();

        return $opportunity ?: null;
    }

    public static function getOpportunitySteps(int $opportunityId): array
    {
        $pdo = db();

        $stmt = $pdo->prepare("
            SELECT step_no, step_title, step_description
            FROM jobs_opportunity_steps
            WHERE opportunity_id = :opportunity_id
            ORDER BY step_no ASC
        ");

        $stmt->execute([':opportunity_id' => $opportunityId]);

        return $stmt->fetchAll();
    }

    public static function getOpportunityRisks(int $opportunityId): array
    {
        $pdo = db();

        $stmt = $pdo->prepare("
            SELECT risk_title, risk_description
            FROM jobs_opportunity_risks
            WHERE opportunity_id = :opportunity_id
            ORDER BY sort_order ASC, id ASC
        ");

        $stmt->execute([':opportunity_id' => $opportunityId]);

        return $stmt->fetchAll();
    }
}