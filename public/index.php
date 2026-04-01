<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';
require_once __DIR__ . '/../app/services/OpportunityService.php';

$pageTitle = getPageTitle('Home');
$featured = OpportunityService::getPublishedOpportunities('', '', 6, 0);

require_once __DIR__ . '/../app/includes/header.php';
?>

<!-- <section class="hero">
    <div class="container">
        <h1>Find work and earning options that fit your life</h1>
        <p>
            Discover jobs, home-based work, self-employment, and micro-business ideas
            based on your situation, resources, and location.
        </p>
        <div class="hero-actions">
            <a class="btn btn-primary" href="<?= e(buildUrl('opportunities.php')) ?>">Browse Opportunities</a>
            <a class="btn btn-secondary" href="<?= e(buildUrl('find-work.php')) ?>">Start Guided Discovery</a>
        </div>
    </div>
</section> -->

<section class="hero hero-split">
    <div class="container hero-grid">
        <div class="hero-content">
            <h1>Find work and earning options that fit your life</h1>
            <p>
                Discover jobs, home-based work, self-employment, and micro-business ideas
                based on your situation, resources, and location.
            </p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="<?= e(buildUrl('opportunities.php')) ?>">Browse Opportunities</a>
                <a class="btn btn-secondary" href="<?= e(buildUrl('find-work.php')) ?>">Start Guided Discovery</a>
            </div>
        </div>

        <div class="hero-visual">
            <img
                src="<?= e(buildUrl('assets/images/site/hero-work-india.png')) ?>"
                alt="Different work and earning opportunities"
                loading="eager"
            >
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2>Featured Opportunities</h2>

        <div class="card-grid">
            <?php foreach ($featured as $item): ?>
                <article class="card opportunity-card">
                    <a class="card-image-wrap" href="<?= e(buildUrl('opportunity-details.php?slug=' . urlencode($item['slug']))) ?>">
                        <img
                            class="card-image"
                            src="<?= e(getOpportunityImage($item['slug'])) ?>"
                            alt="<?= e($item['title']) ?>"
                            loading="lazy"
                        >
                        <span class="card-category floating-badge">
                            <span class="icon"><?= svgIcon(getOpportunityTypeIcon($item['opportunity_type'])) ?></span>
                            <?= e($item['category_name']) ?>
                        </span>
                    </a>

                    <div class="card-body">
                        <h3>
                            <a href="<?= e(buildUrl('opportunity-details.php?slug=' . urlencode($item['slug']))) ?>">
                                <?= e($item['title']) ?>
                            </a>
                        </h3>

                        <p><?= e($item['short_summary']) ?></p>

                        <div class="meta-grid">
                            <span class="meta-pill">
                                <span class="icon"><?= svgIcon('rupee') ?></span>
                                Investment: <?= e(formatCurrency($item['investment_min'])) ?> - <?= e(formatCurrency($item['investment_max'])) ?>
                            </span>

                            <span class="meta-pill">
                                <span class="icon"><?= svgIcon('growth') ?></span>
                                Earnings: <?= e(formatCurrency($item['earning_min'])) ?> - <?= e(formatCurrency($item['earning_max'])) ?>
                            </span>
                        </div>

                        <div class="card-actions">
                            <a class="btn btn-secondary" href="<?= e(buildUrl('opportunity-details.php?slug=' . urlencode($item['slug']))) ?>">
                                View Details
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>        
    </div>
</section>

<?php require_once __DIR__ . '/../app/includes/footer.php'; ?>