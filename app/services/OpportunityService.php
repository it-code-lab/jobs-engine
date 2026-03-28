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

public static function getAllForAdmin(): array
{
    $pdo = db();

    $stmt = $pdo->query("
        SELECT 
            o.id,
            o.title,
            o.slug,
            o.opportunity_type,
            o.status,
            o.featured_flag,
            o.created_at,
            c.name AS category_name
        FROM jobs_opportunities o
        INNER JOIN jobs_opportunity_categories c ON c.id = o.category_id
        ORDER BY o.created_at DESC
    ");

    return $stmt->fetchAll();
}

public static function getByIdForAdmin(int $id): ?array
{
    $pdo = db();

    $stmt = $pdo->prepare("
        SELECT *
        FROM jobs_opportunities
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute([':id' => $id]);
    $item = $stmt->fetch();

    return $item ?: null;
}

public static function createOpportunity(array $data, int $adminUserId): int
{
    $pdo = db();

    $sql = "
        INSERT INTO jobs_opportunities (
            category_id, title, slug, short_summary, full_description, opportunity_type,
            suitable_for_text, not_suitable_for_text,
            min_age, max_age, min_education_level, preferred_education_level,
            prior_experience_required, digital_literacy_level, manual_effort_level, home_based_suitability,
            investment_min, investment_max, earning_min, earning_max, time_to_start_label, growth_potential,
            land_required, shop_space_required, internet_required, computer_required, smartphone_required,
            vehicle_required, tools_required, tools_required_text, family_support_helpful, physical_effort_level,
            risk_level, scalability_level, urban_suitability, semi_urban_suitability, rural_suitability,
            market_dependency_notes, raw_material_dependency_notes, first_income_timeline, success_tips, common_mistakes,
            status, featured_flag, created_by, updated_by, published_at
        ) VALUES (
            :category_id, :title, :slug, :short_summary, :full_description, :opportunity_type,
            :suitable_for_text, :not_suitable_for_text,
            :min_age, :max_age, :min_education_level, :preferred_education_level,
            :prior_experience_required, :digital_literacy_level, :manual_effort_level, :home_based_suitability,
            :investment_min, :investment_max, :earning_min, :earning_max, :time_to_start_label, :growth_potential,
            :land_required, :shop_space_required, :internet_required, :computer_required, :smartphone_required,
            :vehicle_required, :tools_required, :tools_required_text, :family_support_helpful, :physical_effort_level,
            :risk_level, :scalability_level, :urban_suitability, :semi_urban_suitability, :rural_suitability,
            :market_dependency_notes, :raw_material_dependency_notes, :first_income_timeline, :success_tips, :common_mistakes,
            :status, :featured_flag, :created_by, :updated_by, :published_at
        )
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':category_id' => $data['category_id'],
        ':title' => $data['title'],
        ':slug' => $data['slug'],
        ':short_summary' => $data['short_summary'],
        ':full_description' => $data['full_description'],
        ':opportunity_type' => $data['opportunity_type'],
        ':suitable_for_text' => $data['suitable_for_text'],
        ':not_suitable_for_text' => $data['not_suitable_for_text'],
        ':min_age' => $data['min_age'] ?: null,
        ':max_age' => $data['max_age'] ?: null,
        ':min_education_level' => $data['min_education_level'],
        ':preferred_education_level' => $data['preferred_education_level'] ?: null,
        ':prior_experience_required' => $data['prior_experience_required'],
        ':digital_literacy_level' => $data['digital_literacy_level'],
        ':manual_effort_level' => $data['manual_effort_level'],
        ':home_based_suitability' => $data['home_based_suitability'],
        ':investment_min' => $data['investment_min'] ?: 0,
        ':investment_max' => $data['investment_max'] ?: 0,
        ':earning_min' => $data['earning_min'] ?: null,
        ':earning_max' => $data['earning_max'] ?: null,
        ':time_to_start_label' => $data['time_to_start_label'],
        ':growth_potential' => $data['growth_potential'],
        ':land_required' => $data['land_required'],
        ':shop_space_required' => $data['shop_space_required'],
        ':internet_required' => $data['internet_required'],
        ':computer_required' => $data['computer_required'],
        ':smartphone_required' => $data['smartphone_required'],
        ':vehicle_required' => $data['vehicle_required'],
        ':tools_required' => $data['tools_required'],
        ':tools_required_text' => $data['tools_required_text'],
        ':family_support_helpful' => $data['family_support_helpful'],
        ':physical_effort_level' => $data['physical_effort_level'],
        ':risk_level' => $data['risk_level'],
        ':scalability_level' => $data['scalability_level'],
        ':urban_suitability' => $data['urban_suitability'],
        ':semi_urban_suitability' => $data['semi_urban_suitability'],
        ':rural_suitability' => $data['rural_suitability'],
        ':market_dependency_notes' => $data['market_dependency_notes'],
        ':raw_material_dependency_notes' => $data['raw_material_dependency_notes'],
        ':first_income_timeline' => $data['first_income_timeline'],
        ':success_tips' => $data['success_tips'],
        ':common_mistakes' => $data['common_mistakes'],
        ':status' => $data['status'],
        ':featured_flag' => $data['featured_flag'],
        ':created_by' => $adminUserId,
        ':updated_by' => $adminUserId,
        ':published_at' => $data['status'] === 'published' ? date('Y-m-d H:i:s') : null,
    ]);

    return (int)$pdo->lastInsertId();
}

public static function updateOpportunity(int $id, array $data, int $adminUserId): bool
{
    $pdo = db();

    $sql = "
        UPDATE jobs_opportunities SET
            category_id = :category_id,
            title = :title,
            slug = :slug,
            short_summary = :short_summary,
            full_description = :full_description,
            opportunity_type = :opportunity_type,
            suitable_for_text = :suitable_for_text,
            not_suitable_for_text = :not_suitable_for_text,
            min_age = :min_age,
            max_age = :max_age,
            min_education_level = :min_education_level,
            preferred_education_level = :preferred_education_level,
            prior_experience_required = :prior_experience_required,
            digital_literacy_level = :digital_literacy_level,
            manual_effort_level = :manual_effort_level,
            home_based_suitability = :home_based_suitability,
            investment_min = :investment_min,
            investment_max = :investment_max,
            earning_min = :earning_min,
            earning_max = :earning_max,
            time_to_start_label = :time_to_start_label,
            growth_potential = :growth_potential,
            land_required = :land_required,
            shop_space_required = :shop_space_required,
            internet_required = :internet_required,
            computer_required = :computer_required,
            smartphone_required = :smartphone_required,
            vehicle_required = :vehicle_required,
            tools_required = :tools_required,
            tools_required_text = :tools_required_text,
            family_support_helpful = :family_support_helpful,
            physical_effort_level = :physical_effort_level,
            risk_level = :risk_level,
            scalability_level = :scalability_level,
            urban_suitability = :urban_suitability,
            semi_urban_suitability = :semi_urban_suitability,
            rural_suitability = :rural_suitability,
            market_dependency_notes = :market_dependency_notes,
            raw_material_dependency_notes = :raw_material_dependency_notes,
            first_income_timeline = :first_income_timeline,
            success_tips = :success_tips,
            common_mistakes = :common_mistakes,
            status = :status,
            featured_flag = :featured_flag,
            updated_by = :updated_by,
            published_at = :published_at
        WHERE id = :id
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':category_id' => $data['category_id'],
        ':title' => $data['title'],
        ':slug' => $data['slug'],
        ':short_summary' => $data['short_summary'],
        ':full_description' => $data['full_description'],
        ':opportunity_type' => $data['opportunity_type'],
        ':suitable_for_text' => $data['suitable_for_text'],
        ':not_suitable_for_text' => $data['not_suitable_for_text'],
        ':min_age' => $data['min_age'] ?: null,
        ':max_age' => $data['max_age'] ?: null,
        ':min_education_level' => $data['min_education_level'],
        ':preferred_education_level' => $data['preferred_education_level'] ?: null,
        ':prior_experience_required' => $data['prior_experience_required'],
        ':digital_literacy_level' => $data['digital_literacy_level'],
        ':manual_effort_level' => $data['manual_effort_level'],
        ':home_based_suitability' => $data['home_based_suitability'],
        ':investment_min' => $data['investment_min'] ?: 0,
        ':investment_max' => $data['investment_max'] ?: 0,
        ':earning_min' => $data['earning_min'] ?: null,
        ':earning_max' => $data['earning_max'] ?: null,
        ':time_to_start_label' => $data['time_to_start_label'],
        ':growth_potential' => $data['growth_potential'],
        ':land_required' => $data['land_required'],
        ':shop_space_required' => $data['shop_space_required'],
        ':internet_required' => $data['internet_required'],
        ':computer_required' => $data['computer_required'],
        ':smartphone_required' => $data['smartphone_required'],
        ':vehicle_required' => $data['vehicle_required'],
        ':tools_required' => $data['tools_required'],
        ':tools_required_text' => $data['tools_required_text'],
        ':family_support_helpful' => $data['family_support_helpful'],
        ':physical_effort_level' => $data['physical_effort_level'],
        ':risk_level' => $data['risk_level'],
        ':scalability_level' => $data['scalability_level'],
        ':urban_suitability' => $data['urban_suitability'],
        ':semi_urban_suitability' => $data['semi_urban_suitability'],
        ':rural_suitability' => $data['rural_suitability'],
        ':market_dependency_notes' => $data['market_dependency_notes'],
        ':raw_material_dependency_notes' => $data['raw_material_dependency_notes'],
        ':first_income_timeline' => $data['first_income_timeline'],
        ':success_tips' => $data['success_tips'],
        ':common_mistakes' => $data['common_mistakes'],
        ':status' => $data['status'],
        ':featured_flag' => $data['featured_flag'],
        ':updated_by' => $adminUserId,
        ':published_at' => $data['status'] === 'published' ? date('Y-m-d H:i:s') : null,
        ':id' => $id,
    ]);
}    
}