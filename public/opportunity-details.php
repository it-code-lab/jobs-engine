<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';
require_once __DIR__ . '/../app/services/OpportunityService.php';

$slug = trim($_GET['slug'] ?? '');

if ($slug === '') {
    http_response_code(400);
    exit('Missing opportunity slug.');
}

$item = OpportunityService::getOpportunityBySlug($slug);

if (!$item) {
    http_response_code(404);
    exit('Opportunity not found.');
}

$steps = OpportunityService::getOpportunitySteps((int)$item['id']);
$risks = OpportunityService::getOpportunityRisks((int)$item['id']);

$pageTitle = getPageTitle($item['title']);

require_once __DIR__ . '/../app/includes/header.php';
?>

<section class="section">
    <div class="container detail-page">
        <div class="detail-header">
            <span class="card-category"><?= e($item['category_name']) ?></span>
            <h1><?= e($item['title']) ?></h1>
            <p class="lead"><?= e($item['short_summary']) ?></p>
        </div>

        <div class="detail-grid">
            <div class="detail-main">
                <section class="detail-card">
                    <h2>Overview</h2>
                    <p><?= nl2br(e($item['full_description'] ?? '')) ?></p>
                </section>

                <section class="detail-card">
                    <h2>Who this is suitable for</h2>
                    <p><?= nl2br(e($item['suitable_for_text'] ?? '')) ?></p>
                </section>

                <section class="detail-card">
                    <h2>Who should avoid it</h2>
                    <p><?= nl2br(e($item['not_suitable_for_text'] ?? '')) ?></p>
                </section>

                <section class="detail-card">
                    <h2>First Steps</h2>
                    <?php if (empty($steps)): ?>
                        <p>No steps added yet.</p>
                    <?php else: ?>
                        <ol class="steps-list">
                            <?php foreach ($steps as $step): ?>
                                <li>
                                    <strong><?= e($step['step_title']) ?></strong><br>
                                    <?= e($step['step_description']) ?>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                </section>

                <section class="detail-card">
                    <h2>Risks and Challenges</h2>
                    <?php if (empty($risks)): ?>
                        <p>No risks added yet.</p>
                    <?php else: ?>
                        <ul class="risk-list">
                            <?php foreach ($risks as $risk): ?>
                                <li>
                                    <strong><?= e($risk['risk_title']) ?>:</strong>
                                    <?= e($risk['risk_description']) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </section>
            </div>

            <aside class="detail-sidebar">
                <div class="detail-card">
                    <h3>Quick Facts</h3>
                    <ul class="facts-list">
                        <li><strong>Type:</strong> <?= e(str_replace('_', ' ', ucfirst($item['opportunity_type']))) ?></li>
                        <li><strong>Investment:</strong> <?= e(formatCurrency($item['investment_min'])) ?> - <?= e(formatCurrency($item['investment_max'])) ?></li>
                        <li><strong>Earnings:</strong> <?= e(formatCurrency($item['earning_min'])) ?> - <?= e(formatCurrency($item['earning_max'])) ?></li>
                        <li><strong>Time to Start:</strong> <?= e(str_replace('_', ' ', $item['time_to_start_label'])) ?></li>
                        <li><strong>Home-Based:</strong> <?= e($item['home_based_suitability']) ?></li>
                        <li><strong>Risk Level:</strong> <?= e(ucfirst($item['risk_level'])) ?></li>
                        <li><strong>Growth Potential:</strong> <?= e(ucfirst($item['growth_potential'])) ?></li>
                    </ul>
                </div>

                <div class="detail-card">
                    <h3>Requirements</h3>
                    <ul class="facts-list">
                        <li><strong>Minimum Education:</strong> <?= e($item['min_education_level']) ?></li>
                        <li><strong>Experience:</strong> <?= e($item['prior_experience_required']) ?></li>
                        <li><strong>Digital Literacy:</strong> <?= e($item['digital_literacy_level']) ?></li>
                        <li><strong>Manual Effort:</strong> <?= e($item['manual_effort_level']) ?></li>
                        <li><strong>Land:</strong> <?= e($item['land_required']) ?></li>
                        <li><strong>Shop Space:</strong> <?= e($item['shop_space_required']) ?></li>
                        <li><strong>Internet:</strong> <?= e($item['internet_required']) ?></li>
                        <li><strong>Vehicle:</strong> <?= e($item['vehicle_required']) ?></li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../app/includes/footer.php'; ?>