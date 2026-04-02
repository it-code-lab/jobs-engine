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
        <div class="detail-header detail-header-enhanced">
            <div class="detail-header-content">
                <span class="card-category">
                    <span class="icon"><?= svgIcon(getOpportunityTypeIcon($item['opportunity_type'])) ?></span>
                    <?= e($item['category_name']) ?>
                </span>

                <h1><?= e($item['title']) ?></h1>
                <p class="lead"><?= e($item['short_summary']) ?></p>

                <div class="detail-highlights">
                    <span class="meta-pill">
                        <span class="icon"><?= svgIcon('rupee') ?></span>
                        <?= e(formatCurrency($item['investment_min'])) ?> - <?= e(formatCurrency($item['investment_max'])) ?>
                    </span>
                    <span class="meta-pill">
                        <span class="icon"><?= svgIcon('growth') ?></span>
                        <?= e(formatCurrency($item['earning_min'])) ?> - <?= e(formatCurrency($item['earning_max'])) ?>
                    </span>
                    <span class="meta-pill">
                        <span class="icon"><?= svgIcon('clock') ?></span>
                        <?= e(str_replace('_', ' ', $item['time_to_start_label'])) ?>
                    </span>
                </div>
            </div>

            <div class="detail-header-image">
                <img
                    src="<?= e(getOpportunityImage($item['slug'])) ?>"
                    alt="<?= e($item['title']) ?>"
                    loading="eager"
                >
            </div>
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


                        <ol class="steps-list enhanced-steps">
                            <?php foreach ($steps as $step): ?>
                                <li>
                                    <span class="step-icon"><?= svgIcon('check') ?></span>
                                    <div>
                                        <strong><?= e($step['step_title']) ?></strong><br>
                                        <?= e($step['step_description']) ?>
                                    </div>
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


                        <ul class="risk-list enhanced-risks">
                            <?php foreach ($risks as $risk): ?>
                                <li>
                                    <span class="risk-icon"><?= svgIcon('warning') ?></span>
                                    <div>
                                        <strong><?= e($risk['risk_title']) ?>:</strong>
                                        <?= e($risk['risk_description']) ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>


                    <?php endif; ?>
                </section>
            </div>

            <aside class="detail-sidebar">
                <div class="detail-card">
                    <h3>Quick Facts</h3>
                    <ul class="facts-list facts-list-icons">
                        <li><span class="icon"><?= svgIcon(getOpportunityTypeIcon($item['opportunity_type'])) ?></span><strong>Type:</strong> <?= e(formatOpportunityType($item['opportunity_type'])) ?></li>
                        <li><span class="icon"><?= svgIcon('rupee') ?></span><strong>Investment:</strong> <?= e(formatCurrency($item['investment_min'])) ?> - <?= e(formatCurrency($item['investment_max'])) ?></li>
                        <li><span class="icon"><?= svgIcon('growth') ?></span><strong>Earnings:</strong> <?= e(formatCurrency($item['earning_min'])) ?> - <?= e(formatCurrency($item['earning_max'])) ?></li>
                        <li><span class="icon"><?= svgIcon('clock') ?></span><strong>Time to Start:</strong> <?= e(str_replace('_', ' ', $item['time_to_start_label'])) ?></li>
                        <li><span class="icon"><?= svgIcon('home-check') ?></span><strong>Home-Based:</strong> <?= e($item['home_based_suitability']) ?></li>
                        <li><span class="icon"><?= svgIcon('shield') ?></span><strong>Risk Level:</strong> <?= e(ucfirst($item['risk_level'])) ?></li>
                        <li><span class="icon"><?= svgIcon('growth') ?></span><strong>Growth Potential:</strong> <?= e(ucfirst($item['growth_potential'])) ?></li>
                    </ul>
                </div>                

                <div class="detail-card">
                    <h3>Requirements</h3>
                    <ul class="facts-list facts-list-icons">
                        <li><span class="icon"><?= svgIcon('education') ?></span><strong>Minimum Education:</strong> <?= e($item['min_education_level']) ?></li>
                        <li><span class="icon"><?= svgIcon('check') ?></span><strong>Experience:</strong> <?= e($item['prior_experience_required']) ?></li>
                        <li><span class="icon"><?= svgIcon('internet') ?></span><strong>Digital Literacy:</strong> <?= e($item['digital_literacy_level']) ?></li>
                        <li><span class="icon"><?= svgIcon('check') ?></span><strong>Manual Effort:</strong> <?= e($item['manual_effort_level']) ?></li>
                        <li><span class="icon"><?= svgIcon('land') ?></span><strong>Land:</strong> <?= e($item['land_required']) ?></li>
                        <li><span class="icon"><?= svgIcon('shop-space') ?></span><strong>Shop Space:</strong> <?= e($item['shop_space_required']) ?></li>
                        <li><span class="icon"><?= svgIcon('internet') ?></span><strong>Internet:</strong> <?= e($item['internet_required']) ?></li>
                        <li><span class="icon"><?= svgIcon('vehicle') ?></span><strong>Vehicle:</strong> <?= e($item['vehicle_required']) ?></li>
                    </ul>
                </div>                

            </aside>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../app/includes/footer.php'; ?>