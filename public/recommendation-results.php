<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';
require_once __DIR__ . '/../app/services/RecommendationService.php';

$requiredFields = [
    'age_group',
    'current_work_status',
    'education_level',
    'state_id',
    'district_id',
    'available_investment_range',
    'work_preference',
    'home_based_preference',
    'urgent_income_need',
    'digital_literacy_level',
    'manual_work_acceptance',
    'risk_tolerance',
    'has_land',
    'has_shop_space',
    'has_smartphone',
    'has_internet',
    'has_computer',
    'has_vehicle',
    'has_tools_equipment',
    'family_support_available',
];

foreach ($requiredFields as $field) {
    if (!isset($_GET[$field]) || $_GET[$field] === '') {
        header('Location: ' . buildUrl('find-work.php'));
        exit;
    }
}

$profile = [
    'age_group' => trim($_GET['age_group']),
    'current_work_status' => trim($_GET['current_work_status']),
    'education_level' => trim($_GET['education_level']),
    'state_id' => (int)$_GET['state_id'],
    'district_id' => (int)$_GET['district_id'],
    'available_investment_range' => trim($_GET['available_investment_range']),
    'work_preference' => trim($_GET['work_preference']),
    'home_based_preference' => trim($_GET['home_based_preference']),
    'urgent_income_need' => trim($_GET['urgent_income_need']),
    'digital_literacy_level' => trim($_GET['digital_literacy_level']),
    'manual_work_acceptance' => trim($_GET['manual_work_acceptance']),
    'risk_tolerance' => trim($_GET['risk_tolerance']),
    'has_land' => (int)$_GET['has_land'],
    'has_shop_space' => (int)$_GET['has_shop_space'],
    'has_smartphone' => (int)$_GET['has_smartphone'],
    'has_internet' => (int)$_GET['has_internet'],
    'has_computer' => (int)$_GET['has_computer'],
    'has_vehicle' => (int)$_GET['has_vehicle'],
    'has_tools_equipment' => (int)$_GET['has_tools_equipment'],
    'family_support_available' => trim($_GET['family_support_available']),
];

$results = RecommendationService::getRecommendations($profile);

$pageTitle = getPageTitle('Your Matches');

require_once __DIR__ . '/../app/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="detail-card" style="margin-bottom: 24px;">
            <h1>Your Recommended Opportunities</h1>
            <p class="lead">
                These matches are based on your education, investment range, location,
                work preference, and available resources.
            </p>

            <div class="hero-actions" style="justify-content:flex-start;">
                <a class="btn btn-secondary" href="<?= e(buildUrl('find-work.php')) ?>">Edit Answers</a>
                <a class="btn btn-primary" href="<?= e(buildUrl('opportunities.php')) ?>">Browse All Opportunities</a>
            </div>
        </div>

        <?php if (empty($results)): ?>
            <div class="detail-card">
                <h2>No strong matches found yet</h2>
                <p>
                    Try broadening your preferences, especially work type, investment range,
                    or home-based requirement.
                </p>
            </div>
        <?php else: ?>
            <div class="card-grid">
                <?php foreach ($results as $item): ?>
                    <article class="card">
                        <div class="card-body">
                            <span class="card-category"><?= e($item['fit_label']) ?></span>

                            <h3>
                                <a href="<?= e(buildUrl('opportunity-details.php?slug=' . urlencode($item['slug']))) ?>">
                                    <?= e($item['title']) ?>
                                </a>
                            </h3>

                            <p><?= e($item['short_summary']) ?></p>

                            <div class="meta">
                                <span><strong>Score:</strong> <?= e((string)$item['score']) ?></span>
                                <span><strong>Investment:</strong> <?= e(formatCurrency($item['investment_min'])) ?> - <?= e(formatCurrency($item['investment_max'])) ?></span>
                                <span><strong>Earnings:</strong> <?= e(formatCurrency($item['earning_min'])) ?> - <?= e(formatCurrency($item['earning_max'])) ?></span>
                                <span><strong>Time to Start:</strong> <?= e(str_replace('_', ' ', $item['time_to_start_label'])) ?></span>
                            </div>

                            <?php if (!empty($item['reasons'])): ?>
                                <div style="margin: 14px 0;">
                                    <strong>Why this matches you:</strong>
                                    <ul class="risk-list">
                                        <?php foreach ($item['reasons'] as $reason): ?>
                                            <li><?= e($reason) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($item['warnings'])): ?>
                                <div style="margin: 14px 0;">
                                    <strong>Things to note:</strong>
                                    <ul class="risk-list">
                                        <?php foreach ($item['warnings'] as $warning): ?>
                                            <li><?= e($warning) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <a class="btn btn-secondary" href="<?= e(buildUrl('opportunity-details.php?slug=' . urlencode($item['slug']))) ?>">
                                View Details
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../app/includes/footer.php'; ?>