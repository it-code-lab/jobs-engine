<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/LocationService.php';

class RecommendationService
{
    public static function getRecommendations(array $profile): array
    {
        $weights = self::getWeights();
        $district = !empty($profile['district_id'])
            ? LocationService::getDistrictById((int)$profile['district_id'])
            : null;

        $opportunities = self::getPublishedOpportunitiesWithLocationContext();
        $results = [];

        foreach ($opportunities as $opportunity) {
            $evaluation = self::scoreOpportunity($profile, $district, $opportunity, $weights);

            if ($evaluation['eligible'] === false) {
                continue;
            }

            $results[] = array_merge($opportunity, [
                'total_score' => $evaluation['total_score'],
                'fit_label' => self::getFitLabel($evaluation['total_score']),
                'reasons' => $evaluation['reasons'],
                'warnings' => $evaluation['warnings'],
            ]);
        }

        usort($results, function ($a, $b) {
            return $b['total_score'] <=> $a['total_score'];
        });

        return $results;
    }

    private static function getWeights(): array
    {
        $pdo = db();
        $stmt = $pdo->query("SELECT rule_key, weight_value FROM jobs_scoring_weights WHERE status = 'active'");
        $rows = $stmt->fetchAll();

        $weights = [];
        foreach ($rows as $row) {
            $weights[$row['rule_key']] = (float)$row['weight_value'];
        }

        return $weights;
    }

    private static function getPublishedOpportunitiesWithLocationContext(): array
    {
        $pdo = db();

        $stmt = $pdo->query("
            SELECT
                o.*,
                c.name AS category_name
            FROM jobs_opportunities o
            INNER JOIN jobs_opportunity_categories c ON c.id = o.category_id
            WHERE o.status = 'published'
            ORDER BY o.featured_flag DESC, o.created_at DESC
        ");

        return $stmt->fetchAll();
    }

    private static function scoreOpportunity(array $profile, ?array $district, array $o, array $weights): array
    {
        $score = 0.0;
        $reasons = [];
        $warnings = [];

        $userAgeMid = self::getAgeMidpoint($profile['age_group'] ?? '');
        if ($userAgeMid !== null && !self::passesAgeEligibility($userAgeMid, $o)) {
            return ['eligible' => false, 'total_score' => 0, 'reasons' => [], 'warnings' => []];
        }

        if (!self::passesHomeBasedEligibility($profile, $o)) {
            return ['eligible' => false, 'total_score' => 0, 'reasons' => [], 'warnings' => []];
        }

        if (!self::passesInvestmentEligibility($profile, $o)) {
            return ['eligible' => false, 'total_score' => 0, 'reasons' => [], 'warnings' => []];
        }

        if (!self::passesRequiredResourcesEligibility($profile, $o)) {
            return ['eligible' => false, 'total_score' => 0, 'reasons' => [], 'warnings' => []];
        }

        $ageScore = self::scoreAge($profile, $o, $weights['age_match'] ?? 0);
        $score += $ageScore;
        if ($ageScore > 0) {
            $reasons[] = 'Suitable for your age group.';
        }

        $educationScore = self::scoreEducation($profile, $o, $weights['education_match'] ?? 0);
        $score += $educationScore;
        if ($educationScore >= (($weights['education_match'] ?? 0) * 0.7)) {
            $reasons[] = 'Fits your education level.';
        } elseif ($educationScore > 0) {
            $warnings[] = 'Your education level may be enough, but stronger qualifications may help.';
        }

        $workPreferenceScore = self::scoreWorkPreference($profile, $o, $weights['work_preference_match'] ?? 0);
        $score += $workPreferenceScore;
        if ($workPreferenceScore >= (($weights['work_preference_match'] ?? 0) * 0.7)) {
            $reasons[] = 'Matches the kind of work you are looking for.';
        }

        $investmentScore = self::scoreInvestment($profile, $o, $weights['investment_match'] ?? 0);
        $score += $investmentScore;
        if ($investmentScore >= (($weights['investment_match'] ?? 0) * 0.7)) {
            $reasons[] = 'Fits your available investment range.';
        } elseif ($investmentScore > 0) {
            $warnings[] = 'This may slightly stretch your current budget.';
        }

        $locationScore = self::scoreLocation($district, $o, $weights['location_match'] ?? 0);
        $score += $locationScore;
        if ($locationScore >= (($weights['location_match'] ?? 0) * 0.7)) {
            $reasons[] = 'Looks suitable for your district type or location context.';
        }

        $homeScore = self::scoreHomeBased($profile, $o, $weights['home_based_match'] ?? 0);
        $score += $homeScore;
        if ($homeScore >= (($weights['home_based_match'] ?? 0) * 0.7) && ($profile['home_based_preference'] ?? '') !== 'not_important') {
            $reasons[] = 'Matches your home-based work preference.';
        }

        $resourceScore = self::scoreResources($profile, $o, $weights['resource_match'] ?? 0);
        $score += $resourceScore;
        if ($resourceScore >= (($weights['resource_match'] ?? 0) * 0.7)) {
            $reasons[] = 'You already have some of the key resources needed.';
        }

        $urgencyScore = self::scoreUrgency($profile, $o, $weights['urgent_income_match'] ?? 0);
        $score += $urgencyScore;
        if ($urgencyScore >= (($weights['urgent_income_match'] ?? 0) * 0.7) && ($profile['urgent_income_need'] ?? '') === 'yes') {
            $reasons[] = 'Can help generate income relatively quickly.';
        }

        $experienceScore = self::scoreExperience($profile, $o, $weights['experience_match'] ?? 0);
        $score += $experienceScore;
        if ($experienceScore >= (($weights['experience_match'] ?? 0) * 0.7)) {
            $reasons[] = 'Fits your experience level.';
        } elseif ($experienceScore === 0 && ($o['prior_experience_required'] ?? '') === 'required') {
            $warnings[] = 'You may need experience or training before starting.';
        }

        $digitalManualScore = self::scoreDigitalManual($profile, $o, $weights['digital_manual_match'] ?? 0);
        $score += $digitalManualScore;

        $familyScore = self::scoreFamilyFit($profile, $o, $weights['family_fit_match'] ?? 0);
        $score += $familyScore;

        $riskScore = self::scoreRiskFit($profile, $o, $weights['risk_match'] ?? 0);
        $score += $riskScore;

        $reasons = array_values(array_unique($reasons));
        $warnings = array_values(array_unique($warnings));

        return [
            'eligible' => true,
            'total_score' => round($score, 2),
            'reasons' => array_slice($reasons, 0, 4),
            'warnings' => array_slice($warnings, 0, 3),
        ];
    }

    private static function getAgeMidpoint(string $ageGroup): ?int
    {
        return match ($ageGroup) {
            '18_24' => 21,
            '25_34' => 29,
            '35_44' => 39,
            '45_54' => 49,
            '55_plus' => 58,
            default => null,
        };
    }

    private static function passesAgeEligibility(int $userAgeMid, array $o): bool
    {
        $min = $o['min_age'] !== null ? (int)$o['min_age'] : null;
        $max = $o['max_age'] !== null ? (int)$o['max_age'] : null;

        if ($min !== null && $userAgeMid < $min) {
            return false;
        }
        if ($max !== null && $userAgeMid > $max) {
            return false;
        }

        return true;
    }

    private static function passesHomeBasedEligibility(array $profile, array $o): bool
    {
        $pref = $profile['home_based_preference'] ?? 'not_important';
        $suitability = $o['home_based_suitability'] ?? 'no';

        if ($pref === 'required' && $suitability === 'no') {
            return false;
        }

        return true;
    }

    private static function passesInvestmentEligibility(array $profile, array $o): bool
    {
        [$userMin, $userMax] = self::getInvestmentRange($profile['available_investment_range'] ?? 'none');
        $oppMin = (float)($o['investment_min'] ?? 0);

        if ($userMax <= 0 && $oppMin > 0) {
            return false;
        }

        if ($oppMin > ($userMax * 2) && $userMax > 0) {
            return false;
        }

        return true;
    }

    private static function passesRequiredResourcesEligibility(array $profile, array $o): bool
    {
        $requiredChecks = [
            'land_required' => !empty($profile['has_land']),
            'shop_space_required' => !empty($profile['has_shop_space']) || !empty($profile['has_home_work_space']),
            'internet_required' => !empty($profile['has_internet']),
            'computer_required' => !empty($profile['has_computer']),
            'smartphone_required' => !empty($profile['has_smartphone']),
            'vehicle_required' => !empty($profile['has_vehicle']),
            'tools_required' => !empty($profile['has_tools_equipment']),
        ];

        foreach ($requiredChecks as $field => $hasResource) {
            if (($o[$field] ?? 'no') === 'required' && !$hasResource) {
                return false;
            }
        }

        return true;
    }

    private static function scoreAge(array $profile, array $o, float $weight): float
    {
        $mid = self::getAgeMidpoint($profile['age_group'] ?? '');
        if ($mid === null) {
            return $weight * 0.5;
        }

        $min = $o['min_age'] !== null ? (int)$o['min_age'] : null;
        $max = $o['max_age'] !== null ? (int)$o['max_age'] : null;

        if ($min === null && $max === null) {
            return $weight;
        }

        if (($min === null || $mid >= $min) && ($max === null || $mid <= $max)) {
            return $weight;
        }

        return 0;
    }

    private static function scoreEducation(array $profile, array $o, float $weight): float
    {
        $rank = self::educationRankMap();
        $user = $rank[$profile['education_level'] ?? 'none'] ?? 0;
        $min = $rank[$o['min_education_level'] ?? 'none'] ?? 0;
        $pref = $rank[$o['preferred_education_level'] ?? 'none'] ?? $min;

        if ($user >= $pref) {
            return $weight;
        }

        if ($user >= $min) {
            return $weight * 0.7;
        }

        if ($user + 1 >= $min) {
            return $weight * 0.3;
        }

        return 0;
    }

    private static function scoreWorkPreference(array $profile, array $o, float $weight): float
    {
        $preference = $profile['work_preference'] ?? 'open_to_all';
        $type = $o['opportunity_type'] ?? '';

        if ($preference === 'open_to_all') {
            return $weight;
        }

        $map = [
            'jobs_only' => ['job'],
            'home_based_only' => ['home_based_work'],
            'self_employment_only' => ['self_employment'],
            'business_only' => ['micro_business'],
        ];

        if (in_array($type, $map[$preference] ?? [], true)) {
            return $weight;
        }

        if ($preference === 'home_based_only' && $o['home_based_suitability'] === 'yes') {
            return $weight * 0.7;
        }

        return 0;
    }

    private static function scoreInvestment(array $profile, array $o, float $weight): float
    {
        [$userMin, $userMax] = self::getInvestmentRange($profile['available_investment_range'] ?? 'none');
        $oppMin = (float)($o['investment_min'] ?? 0);
        $oppMax = (float)($o['investment_max'] ?? 0);

        if ($oppMin <= $userMax && $oppMax <= max($userMax, $oppMax)) {
            return $weight;
        }

        if ($oppMin <= ($userMax * 1.3)) {
            return $weight * 0.55;
        }

        return 0;
    }

    private static function scoreLocation(?array $district, array $o, float $weight): float
    {
        if (!$district) {
            return $weight * 0.5;
        }

        $districtType = $district['district_type'] ?? 'mixed';
        $field = match ($districtType) {
            'urban' => 'urban_suitability',
            'semi_urban' => 'semi_urban_suitability',
            'rural' => 'rural_suitability',
            default => null,
        };

        if ($field === null) {
            return $weight * 0.6;
        }

        $value = $o[$field] ?? 'medium';

        return match ($value) {
            'high' => $weight,
            'medium' => $weight * 0.6,
            'low' => $weight * 0.2,
            default => $weight * 0.4,
        };
    }

    private static function scoreHomeBased(array $profile, array $o, float $weight): float
    {
        $pref = $profile['home_based_preference'] ?? 'not_important';
        $suitability = $o['home_based_suitability'] ?? 'no';

        if ($pref === 'not_important') {
            return $weight * 0.6;
        }

        if ($pref === 'required') {
            return match ($suitability) {
                'yes' => $weight,
                'partial' => $weight * 0.5,
                default => 0,
            };
        }

        return match ($suitability) {
            'yes' => $weight,
            'partial' => $weight * 0.6,
            'no' => $weight * 0.2,
            default => 0,
        };
    }

    private static function scoreResources(array $profile, array $o, float $weight): float
    {
        $checks = 0;
        $matched = 0;

        $pairs = [
            'land_required' => !empty($profile['has_land']),
            'shop_space_required' => !empty($profile['has_shop_space']) || !empty($profile['has_home_work_space']),
            'internet_required' => !empty($profile['has_internet']),
            'computer_required' => !empty($profile['has_computer']),
            'smartphone_required' => !empty($profile['has_smartphone']),
            'vehicle_required' => !empty($profile['has_vehicle']),
            'tools_required' => !empty($profile['has_tools_equipment']),
        ];

        foreach ($pairs as $field => $hasResource) {
            $need = $o[$field] ?? 'no';

            if ($need === 'required' || $need === 'helpful') {
                $checks++;
                if ($hasResource) {
                    $matched++;
                }
            }
        }

        if ($checks === 0) {
            return $weight;
        }

        $ratio = $matched / $checks;

        if ($ratio >= 1) {
            return $weight;
        }
        if ($ratio >= 0.6) {
            return $weight * 0.7;
        }
        if ($ratio > 0) {
            return $weight * 0.35;
        }

        return 0;
    }

    private static function scoreUrgency(array $profile, array $o, float $weight): float
    {
        $urgent = $profile['urgent_income_need'] ?? 'no';
        $timeline = $o['time_to_start_label'] ?? 'within_1_month';

        if ($urgent === 'no') {
            return $weight * 0.7;
        }

        return match ($timeline) {
            'immediate' => $weight,
            'within_1_week' => $weight * 0.85,
            'within_1_month' => $weight * 0.5,
            'more_than_1_month' => 0,
            default => $weight * 0.4,
        };
    }

    private static function scoreExperience(array $profile, array $o, float $weight): float
    {
        $user = $profile['prior_experience_level'] ?? 'none';
        $required = $o['prior_experience_required'] ?? 'no';

        if ($required === 'no') {
            return $weight;
        }

        if ($required === 'preferred') {
            return in_array($user, ['some', 'experienced'], true) ? $weight : $weight * 0.5;
        }

        return in_array($user, ['some', 'experienced'], true) ? $weight : 0;
    }

    private static function scoreDigitalManual(array $profile, array $o, float $weight): float
    {
        $digitalRank = self::digitalRankMap();
        $levelRank = self::levelRankMap();

        $userDigital = $digitalRank[$profile['digital_literacy_level'] ?? 'none'] ?? 0;
        $oppDigital = $digitalRank[$o['digital_literacy_level'] ?? 'none'] ?? 0;

        $userManual = $levelRank[$profile['manual_work_acceptance'] ?? 'low'] ?? 1;
        $oppManual = $levelRank[$o['manual_effort_level'] ?? 'low'] ?? 1;

        $score = 0;

        if ($userDigital >= $oppDigital) {
            $score += $weight * 0.5;
        } elseif ($userDigital + 1 === $oppDigital) {
            $score += $weight * 0.25;
        }

        if ($userManual >= $oppManual) {
            $score += $weight * 0.5;
        } elseif ($userManual + 1 === $oppManual) {
            $score += $weight * 0.25;
        }

        return min($score, $weight);
    }

    private static function scoreFamilyFit(array $profile, array $o, float $weight): float
    {
        $dependents = (int)($profile['dependents_count'] ?? 0);
        $hours = $profile['work_hour_limitations'] ?? 'flexible';

        if ($dependents === 0) {
            return $weight * 0.7;
        }

        if ($hours === 'strict' && ($o['home_based_suitability'] === 'yes' || $o['family_support_helpful'] === 'yes')) {
            return $weight;
        }

        if ($hours === 'moderate') {
            return $weight * 0.6;
        }

        return $weight * 0.4;
    }

    private static function scoreRiskFit(array $profile, array $o, float $weight): float
    {
        $rank = self::levelRankMap();
        $user = $rank[$profile['risk_tolerance'] ?? 'medium'] ?? 2;
        $opp = $rank[$o['risk_level'] ?? 'medium'] ?? 2;

        if ($user >= $opp) {
            return $weight;
        }

        if ($user + 1 === $opp) {
            return $weight * 0.4;
        }

        return 0;
    }

    private static function getFitLabel(float $score): string
    {
        if ($score >= 80) {
            return 'Strong Match';
        }
        if ($score >= 60) {
            return 'Good Match';
        }
        if ($score >= 40) {
            return 'Possible Option';
        }
        return 'Lower Match';
    }

    private static function getInvestmentRange(string $band): array
    {
        return match ($band) {
            'none' => [0, 0],
            'under_5000' => [1, 5000],
            '5000_20000' => [5000, 20000],
            '20000_50000' => [20000, 50000],
            '50000_100000' => [50000, 100000],
            'above_100000' => [100000, 99999999],
            default => [0, 0],
        };
    }

    private static function educationRankMap(): array
    {
        return [
            'none' => 0,
            'primary' => 1,
            'middle' => 2,
            'secondary' => 3,
            'higher_secondary' => 4,
            'vocational' => 5,
            'diploma' => 6,
            'graduate' => 7,
            'postgraduate' => 8,
        ];
    }

    private static function digitalRankMap(): array
    {
        return [
            'none' => 0,
            'basic' => 1,
            'moderate' => 2,
            'strong' => 3,
        ];
    }

    private static function levelRankMap(): array
    {
        return [
            'low' => 1,
            'medium' => 2,
            'high' => 3,
        ];
    }
}