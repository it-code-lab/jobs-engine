<?php
declare(strict_types=1);

class ScoringService
{
    public static function educationRankMap(): array
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

    public static function investmentBandMap(): array
    {
        return [
            'none' => [0, 0],
            'under_5000' => [1, 5000],
            '5000_20000' => [5000, 20000],
            '20000_50000' => [20000, 50000],
            '50000_100000' => [50000, 100000],
            'above_100000' => [100000, 99999999],
        ];
    }

    public static function levelRankMap(): array
    {
        return [
            'low' => 1,
            'medium' => 2,
            'high' => 3,
        ];
    }

    public static function digitalRankMap(): array
    {
        return [
            'none' => 0,
            'basic' => 1,
            'moderate' => 2,
            'strong' => 3,
        ];
    }

    public static function ageGroupToApproxAge(string $ageGroup): int
    {
        return match ($ageGroup) {
            '18_24' => 21,
            '25_34' => 30,
            '35_44' => 40,
            '45_54' => 50,
            '55_plus' => 58,
            default => 30,
        };
    }

    public static function scoreAgeFit(array $profile, array $opportunity, float $weight): float
    {
        $age = self::ageGroupToApproxAge($profile['age_group'] ?? '');

        $min = isset($opportunity['min_age']) ? (int)$opportunity['min_age'] : 0;
        $max = isset($opportunity['max_age']) ? (int)$opportunity['max_age'] : 100;

        if ($age >= $min && $age <= $max) {
            return $weight;
        }

        if ($age >= ($min - 3) && $age <= ($max + 3)) {
            return $weight * 0.5;
        }

        return 0;
    }

    public static function scoreEducationFit(array $profile, array $opportunity, float $weight): float
    {
        $map = self::educationRankMap();

        $user = $map[$profile['education_level'] ?? 'none'] ?? 0;
        $min = $map[$opportunity['min_education_level'] ?? 'none'] ?? 0;
        $preferred = $map[$opportunity['preferred_education_level'] ?? 'none'] ?? $min;

        if ($user >= $preferred) {
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

    public static function scoreWorkPreferenceFit(array $profile, array $opportunity, float $weight): float
    {
        $userPref = $profile['work_preference'] ?? 'open_to_all';
        $type = $opportunity['opportunity_type'] ?? '';

        if ($userPref === 'open_to_all') {
            return $weight;
        }

        $exactMap = [
            'jobs_only' => 'job',
            'home_based_only' => 'home_based_work',
            'self_employment_only' => 'self_employment',
            'business_only' => 'micro_business',
        ];

        if (($exactMap[$userPref] ?? '') === $type) {
            return $weight;
        }

        if ($userPref === 'home_based_only' && ($opportunity['home_based_suitability'] ?? 'no') === 'yes') {
            return $weight * 0.6;
        }

        return 0;
    }

    public static function scoreInvestmentFit(array $profile, array $opportunity, float $weight): float
    {
        $bands = self::investmentBandMap();
        $band = $bands[$profile['available_investment_range'] ?? 'none'] ?? [0, 0];
        $userMax = $band[1];

        $oppMin = (float)($opportunity['investment_min'] ?? 0);
        $oppMax = (float)($opportunity['investment_max'] ?? 0);

        if ($oppMax <= $userMax) {
            return $weight;
        }

        if ($oppMin <= $userMax) {
            return $weight * 0.55;
        }

        return 0;
    }

    public static function scoreHomeBasedFit(array $profile, array $opportunity, float $weight): float
    {
        $pref = $profile['home_based_preference'] ?? 'not_important';
        $fit = $opportunity['home_based_suitability'] ?? 'no';

        if ($pref === 'not_important') {
            return $weight;
        }

        if ($pref === 'required') {
            return match ($fit) {
                'yes' => $weight,
                'partial' => $weight * 0.5,
                default => 0,
            };
        }

        return match ($fit) {
            'yes' => $weight,
            'partial' => $weight * 0.6,
            'no' => $weight * 0.2,
            default => 0,
        };
    }

    public static function scoreUrgencyFit(array $profile, array $opportunity, float $weight): float
    {
        $urgent = $profile['urgent_income_need'] ?? 'no';
        $timeline = $opportunity['time_to_start_label'] ?? 'within_1_month';

        if ($urgent === 'no') {
            return $weight * 0.75;
        }

        return match ($timeline) {
            'immediate' => $weight,
            'within_1_week' => $weight * 0.85,
            'within_1_month' => $weight * 0.45,
            default => 0,
        };
    }

    public static function scoreDigitalManualFit(array $profile, array $opportunity, float $weight): float
    {
        $digitalMap = self::digitalRankMap();
        $levelMap = self::levelRankMap();

        $userDigital = $digitalMap[$profile['digital_literacy_level'] ?? 'none'] ?? 0;
        $oppDigital = $digitalMap[$opportunity['digital_literacy_level'] ?? 'none'] ?? 0;

        $userManual = $levelMap[$profile['manual_work_acceptance'] ?? 'low'] ?? 1;
        $oppManual = $levelMap[$opportunity['manual_effort_level'] ?? 'low'] ?? 1;

        $score = 0;

        if ($userDigital >= $oppDigital) {
            $score += 0.5;
        } elseif ($userDigital + 1 >= $oppDigital) {
            $score += 0.25;
        }

        if ($userManual >= $oppManual) {
            $score += 0.5;
        } elseif ($userManual + 1 >= $oppManual) {
            $score += 0.25;
        }

        return $weight * min($score, 1);
    }

    public static function scoreRiskFit(array $profile, array $opportunity, float $weight): float
    {
        $map = self::levelRankMap();

        $user = $map[$profile['risk_tolerance'] ?? 'medium'] ?? 2;
        $opp = $map[$opportunity['risk_level'] ?? 'medium'] ?? 2;

        if ($user >= $opp) {
            return $weight;
        }

        if ($user + 1 >= $opp) {
            return $weight * 0.5;
        }

        return 0;
    }

    public static function scoreResourceFit(array $profile, array $opportunity, float $weight): float
    {
        $checks = [
            ['field' => 'land_required', 'user' => (int)($profile['has_land'] ?? 0)],
            ['field' => 'shop_space_required', 'user' => (int)($profile['has_shop_space'] ?? 0)],
            ['field' => 'internet_required', 'user' => (int)($profile['has_internet'] ?? 0)],
            ['field' => 'computer_required', 'user' => (int)($profile['has_computer'] ?? 0)],
            ['field' => 'smartphone_required', 'user' => (int)($profile['has_smartphone'] ?? 0)],
            ['field' => 'vehicle_required', 'user' => (int)($profile['has_vehicle'] ?? 0)],
            ['field' => 'tools_required', 'user' => (int)($profile['has_tools_equipment'] ?? 0)],
        ];

        $total = count($checks);
        $points = 0;

        foreach ($checks as $check) {
            $requirement = $opportunity[$check['field']] ?? 'no';

            if ($requirement === 'no') {
                $points += 1;
            } elseif ($requirement === 'helpful') {
                $points += $check['user'] ? 1 : 0.5;
            } elseif ($requirement === 'required') {
                $points += $check['user'] ? 1 : 0;
            }
        }

        return $weight * ($points / $total);
    }

    public static function getFitLabel(float $score): string
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
}