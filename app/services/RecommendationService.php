<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/ScoringService.php';

class RecommendationService
{
    public static function getScoringWeights(): array
    {
        $pdo = db();

        $stmt = $pdo->query("
            SELECT rule_key, weight_value
            FROM jobs_scoring_weights
            WHERE status = 'active'
        ");

        $rows = $stmt->fetchAll();
        $weights = [];

        foreach ($rows as $row) {
            $weights[$row['rule_key']] = (float)$row['weight_value'];
        }

        return $weights;
    }

    public static function getDistrictInfo(int $districtId): ?array
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

    public static function getLocationRuleLevel(int $opportunityId, int $districtId, int $stateId): ?string
    {
        $pdo = db();

        $stmt = $pdo->prepare("
            SELECT suitability_level
            FROM jobs_opportunity_location_rules
            WHERE opportunity_id = :opportunity_id
              AND (district_id = :district_id OR (district_id IS NULL AND state_id = :state_id))
            ORDER BY district_id DESC
            LIMIT 1
        ");

        $stmt->execute([
            ':opportunity_id' => $opportunityId,
            ':district_id' => $districtId,
            ':state_id' => $stateId,
        ]);

        $row = $stmt->fetch();

        return $row['suitability_level'] ?? null;
    }

    public static function getPublishedOpportunitiesForRecommendation(): array
    {
        $pdo = db();

        $stmt = $pdo->query("
            SELECT *
            FROM jobs_opportunities
            WHERE status = 'published'
            ORDER BY featured_flag DESC, created_at DESC
        ");

        return $stmt->fetchAll();
    }

    public static function getRecommendations(array $profile): array
    {
        $weights = self::getScoringWeights();
        $districtInfo = self::getDistrictInfo((int)$profile['district_id']);
        $items = self::getPublishedOpportunitiesForRecommendation();

        $results = [];

        foreach ($items as $item) {
            if (!self::passesHardFilters($profile, $item)) {
                continue;
            }

            $score = 0;
            $reasons = [];
            $warnings = [];

            $ageScore = ScoringService::scoreAgeFit($profile, $item, $weights['age_match'] ?? 8);
            $score += $ageScore;
            if ($ageScore > 0) {
                $reasons[] = 'Fits your age group.';
            }

            $eduScore = ScoringService::scoreEducationFit($profile, $item, $weights['education_match'] ?? 10);
            $score += $eduScore;
            if ($eduScore >= (($weights['education_match'] ?? 10) * 0.7)) {
                $reasons[] = 'Matches your education level.';
            } elseif ($eduScore > 0) {
                $warnings[] = 'May need slightly stronger education or extra preparation.';
            }

            $prefScore = ScoringService::scoreWorkPreferenceFit($profile, $item, $weights['work_preference_match'] ?? 10);
            $score += $prefScore;
            if ($prefScore > 0) {
                $reasons[] = 'Matches your work preference.';
            }

            $investScore = ScoringService::scoreInvestmentFit($profile, $item, $weights['investment_match'] ?? 15);
            $score += $investScore;
            if ($investScore >= (($weights['investment_match'] ?? 15) * 0.7)) {
                $reasons[] = 'Fits your available investment range.';
            } elseif ($investScore > 0) {
                $warnings[] = 'May stretch your current budget.';
            }

            $homeScore = ScoringService::scoreHomeBasedFit($profile, $item, $weights['home_based_match'] ?? 10);
            $score += $homeScore;
            if ($homeScore >= (($weights['home_based_match'] ?? 10) * 0.7)) {
                $reasons[] = 'Matches your home-based work preference.';
            }

            $urgencyScore = ScoringService::scoreUrgencyFit($profile, $item, $weights['urgent_income_match'] ?? 8);
            $score += $urgencyScore;
            if (($profile['urgent_income_need'] ?? 'no') === 'yes' && $urgencyScore > 0) {
                $reasons[] = 'Can potentially help you start earning relatively quickly.';
            }

            $resourceScore = ScoringService::scoreResourceFit($profile, $item, $weights['resource_match'] ?? 12);
            $score += $resourceScore;
            if ($resourceScore >= (($weights['resource_match'] ?? 12) * 0.7)) {
                $reasons[] = 'Fits the resources you currently have.';
            } elseif ($resourceScore > 0) {
                $warnings[] = 'You may need a few additional resources to begin.';
            }

            $digitalManualScore = ScoringService::scoreDigitalManualFit($profile, $item, $weights['digital_manual_match'] ?? 3);
            $score += $digitalManualScore;

            $riskScore = ScoringService::scoreRiskFit($profile, $item, $weights['risk_match'] ?? 2);
            $score += $riskScore;

            $locationScore = self::scoreLocationFit($item, $districtInfo, $profile, $weights['location_match'] ?? 15);
            $score += $locationScore['score'];

            if ($locationScore['reason']) {
                $reasons[] = $locationScore['reason'];
            }

            if (($profile['family_support_available'] ?? 'no') === 'yes' && ($item['family_support_helpful'] ?? 'no') === 'yes') {
                $score += ($weights['family_fit_match'] ?? 2);
                $reasons[] = 'Family support can help in this opportunity.';
            }

            $fitLabel = ScoringService::getFitLabel($score);

            $results[] = [
                'id' => $item['id'],
                'title' => $item['title'],
                'slug' => $item['slug'],
                'short_summary' => $item['short_summary'],
                'opportunity_type' => $item['opportunity_type'],
                'home_based_suitability' => $item['home_based_suitability'],
                'investment_min' => $item['investment_min'],
                'investment_max' => $item['investment_max'],
                'earning_min' => $item['earning_min'],
                'earning_max' => $item['earning_max'],
                'time_to_start_label' => $item['time_to_start_label'],
                'risk_level' => $item['risk_level'],
                'score' => round($score, 2),
                'fit_label' => $fitLabel,
                'reasons' => array_slice(array_unique($reasons), 0, 4),
                'warnings' => array_slice(array_unique($warnings), 0, 3),
            ];
        }

        usort($results, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return $results;
    }

    public static function passesHardFilters(array $profile, array $item): bool
    {
        $age = ScoringService::ageGroupToApproxAge($profile['age_group'] ?? '');

        if (!empty($item['min_age']) && $age < (int)$item['min_age']) {
            return false;
        }

        if (!empty($item['max_age']) && $age > (int)$item['max_age']) {
            return false;
        }

        if (($profile['home_based_preference'] ?? '') === 'required' && ($item['home_based_suitability'] ?? 'no') === 'no') {
            return false;
        }

        $budgetMap = ScoringService::investmentBandMap();
        $userBand = $budgetMap[$profile['available_investment_range'] ?? 'none'] ?? [0, 0];
        $userMax = $userBand[1];
        $oppMin = (float)($item['investment_min'] ?? 0);

        if ($oppMin > 0 && $userMax > 0 && $oppMin > ($userMax * 2.5)) {
            return false;
        }

        if (($item['land_required'] ?? 'no') === 'required' && (int)($profile['has_land'] ?? 0) !== 1) {
            return false;
        }

        if (($item['shop_space_required'] ?? 'no') === 'required' && (int)($profile['has_shop_space'] ?? 0) !== 1) {
            return false;
        }

        if (($item['smartphone_required'] ?? 'no') === 'required' && (int)($profile['has_smartphone'] ?? 0) !== 1) {
            return false;
        }

        if (($item['internet_required'] ?? 'no') === 'required' && (int)($profile['has_internet'] ?? 0) !== 1) {
            return false;
        }

        if (($item['computer_required'] ?? 'no') === 'required' && (int)($profile['has_computer'] ?? 0) !== 1) {
            return false;
        }

        if (($item['vehicle_required'] ?? 'no') === 'required' && (int)($profile['has_vehicle'] ?? 0) !== 1) {
            return false;
        }

        if (($item['tools_required'] ?? 'no') === 'required' && (int)($profile['has_tools_equipment'] ?? 0) !== 1) {
            return false;
        }

        return true;
    }

    public static function scoreLocationFit(array $item, ?array $districtInfo, array $profile, float $weight): array
    {
        if (!$districtInfo) {
            return ['score' => $weight * 0.5, 'reason' => 'General location fit applied.'];
        }

        $ruleLevel = self::getLocationRuleLevel((int)$item['id'], (int)$districtInfo['id'], (int)$districtInfo['state_id']);

        if ($ruleLevel) {
            return match ($ruleLevel) {
                'high' => ['score' => $weight, 'reason' => 'Strong match for your district/city.'],
                'medium' => ['score' => $weight * 0.65, 'reason' => 'Reasonably suitable for your district/city.'],
                'low' => ['score' => $weight * 0.25, 'reason' => 'Possible but weaker fit for your district/city.'],
                'not_recommended' => ['score' => 0, 'reason' => 'Less suitable for your location.'],
                default => ['score' => $weight * 0.5, 'reason' => 'General location fit applied.'],
            };
        }

        $districtType = $districtInfo['district_type'] ?? 'mixed';

        $field = match ($districtType) {
            'urban' => 'urban_suitability',
            'semi_urban' => 'semi_urban_suitability',
            'rural' => 'rural_suitability',
            default => null,
        };

        if (!$field) {
            return ['score' => $weight * 0.5, 'reason' => 'General location fit applied.'];
        }

        $level = $item[$field] ?? 'medium';

        return match ($level) {
            'high' => ['score' => $weight, 'reason' => 'Well suited to your area type.'],
            'medium' => ['score' => $weight * 0.65, 'reason' => 'Reasonably suited to your area type.'],
            'low' => ['score' => $weight * 0.25, 'reason' => 'Less strong fit for your area type.'],
            default => ['score' => $weight * 0.5, 'reason' => 'General location fit applied.'],
        };
    }
}