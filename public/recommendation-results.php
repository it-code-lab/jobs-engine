<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';
require_once __DIR__ . '/../app/services/RecommendationService.php';

$coreRequiredFields = [
    'age_group',
    'education_level',
    'available_investment_range',
    'work_preference',
    'home_based_preference',
];

foreach ($coreRequiredFields as $field) {
    if (!isset($_GET[$field]) || trim((string)$_GET[$field]) === '') {
        header('Location: ' . buildUrl('find-work.php'));
        exit;
    }
}

$profile = [
    'age_group' => trim((string)($_GET['age_group'] ?? '')),
    'current_work_status' => trim((string)($_GET['current_work_status'] ?? 'unemployed')),
    'education_level' => trim((string)($_GET['education_level'] ?? 'none')),
    'state_id' => (int)($_GET['state_id'] ?? 0),
    'district_id' => (int)($_GET['district_id'] ?? 0),
    'available_investment_range' => trim((string)($_GET['available_investment_range'] ?? 'none')),
    'work_preference' => trim((string)($_GET['work_preference'] ?? 'open_to_all')),
    'home_based_preference' => trim((string)($_GET['home_based_preference'] ?? 'not_important')),
    'urgent_income_need' => trim((string)($_GET['urgent_income_need'] ?? 'no')),
    'digital_literacy_level' => trim((string)($_GET['digital_literacy_level'] ?? 'none')),
    'manual_work_acceptance' => trim((string)($_GET['manual_work_acceptance'] ?? 'medium')),
    'risk_tolerance' => trim((string)($_GET['risk_tolerance'] ?? 'medium')),
    'has_land' => (int)($_GET['has_land'] ?? 0),
    'has_shop_space' => (int)($_GET['has_shop_space'] ?? 0),
    'has_smartphone' => (int)($_GET['has_smartphone'] ?? 1),
    'has_internet' => (int)($_GET['has_internet'] ?? 0),
    'has_computer' => (int)($_GET['has_computer'] ?? 0),
    'has_vehicle' => (int)($_GET['has_vehicle'] ?? 0),
    'has_tools_equipment' => (int)($_GET['has_tools_equipment'] ?? 0),
    'family_support_available' => trim((string)($_GET['family_support_available'] ?? 'no')),
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
                These matches are based on your basic profile and preferences.
                Optional filters like location, resources, and digital skills are used when provided.
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



                    <article class="card opportunity-card recommended-card">
                        <a class="card-image-wrap" href="<?= e(buildUrl('opportunity-details.php?slug=' . urlencode($item['slug']))) ?>">
                            <img
                                class="card-image"
                                src="<?= e(getOpportunityImage($item['slug'])) ?>"
                                alt="<?= e($item['title']) ?>"
                                loading="lazy"
                            >
                            <span class="card-category floating-badge fit-badge">
                                <?= e($item['fit_label']) ?>
                            </span>
                        </a>

                        <div class="card-body">
                            <h3>
                                <a href="<?= e(buildUrl('opportunity-details.php?slug=' . urlencode($item['slug']))) ?>">
                                    <?= e($item['title']) ?>
                                </a>
                            </h3>

                            <p><?= e($item['short_summary']) ?></p>

                            <div class="match-score">
                                <div class="match-score-label">
                                    <strong>Match Score:</strong> <?= e((string)$item['score']) ?>/100
                                </div>
                                <div class="progress-bar">
                                    <span style="width: <?= max(0, min(100, (int)$item['score'])) ?>%"></span>
                                </div>
                            </div>

                            <div class="meta-grid">
                                <span class="meta-pill">
                                    <span class="icon"><?= svgIcon('rupee') ?></span>
                                    Investment: <?= e(formatCurrency($item['investment_min'])) ?> - <?= e(formatCurrency($item['investment_max'])) ?>
                                </span>
                                <span class="meta-pill">
                                    <span class="icon"><?= svgIcon('growth') ?></span>
                                    Earnings: <?= e(formatCurrency($item['earning_min'])) ?> - <?= e(formatCurrency($item['earning_max'])) ?>
                                </span>
                                <span class="meta-pill">
                                    <span class="icon"><?= svgIcon('clock') ?></span>
                                    <?= e(str_replace('_', ' ', $item['time_to_start_label'])) ?>
                                </span>
                            </div>

                            <?php if (!empty($item['reasons'])): ?>
                                <div class="insight-box positive">
                                    <strong>Why this matches you</strong>
                                    <ul class="risk-list">
                                        <?php foreach ($item['reasons'] as $reason): ?>
                                            <li><?= e($reason) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($item['warnings'])): ?>
                                <div class="insight-box caution">
                                    <strong>Things to note</strong>
                                    <ul class="risk-list">
                                        <?php foreach ($item['warnings'] as $warning): ?>
                                            <li><?= e($warning) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <div class="card-actions">
                                <a class="btn btn-secondary" href="<?= e(buildUrl('opportunity-details.php?slug=' . urlencode($item['slug']))) ?>">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </article>



                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../app/includes/footer.php'; ?>