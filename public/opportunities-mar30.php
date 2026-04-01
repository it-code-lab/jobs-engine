<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/includes/functions.php';
require_once __DIR__ . '/../app/services/OpportunityService.php';

$search = trim($_GET['search'] ?? '');
$type   = trim($_GET['type'] ?? '');
$page   = max(1, (int)($_GET['page'] ?? 1));

$limit  = ITEMS_PER_PAGE;
$offset = ($page - 1) * $limit;

$items = OpportunityService::getPublishedOpportunities($search, $type, $limit, $offset);
$total = OpportunityService::countPublishedOpportunities($search, $type);
$totalPages = (int)ceil($total / $limit);

$pageTitle = getPageTitle('Browse Opportunities');

require_once __DIR__ . '/../app/includes/header.php';
?>

<section class="section">
    <div class="container">
        <h1>Browse Opportunities</h1>

        <form method="get" class="filter-form">
            <div class="form-row">
                <input type="text" name="search" placeholder="Search opportunities..." value="<?= e($search) ?>">

                <select name="type">
                    <option value="">All Types</option>
                    <option value="job" <?= $type === 'job' ? 'selected' : '' ?>>Jobs</option>
                    <option value="home_based_work" <?= $type === 'home_based_work' ? 'selected' : '' ?>>Home-Based Work</option>
                    <option value="self_employment" <?= $type === 'self_employment' ? 'selected' : '' ?>>Self-Employment</option>
                    <option value="micro_business" <?= $type === 'micro_business' ? 'selected' : '' ?>>Micro-Business</option>
                </select>

                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <p class="results-text">Showing <?= count($items) ?> of <?= $total ?> opportunities</p>

        <div class="card-grid">
            <?php if (empty($items)): ?>
                <div class="empty-state">
                    <p>No opportunities found.</p>
                </div>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <article class="card">
                        <div class="card-body">
                            <span class="card-category"><?= e($item['category_name']) ?></span>
                            <h3>
                                <a href="<?= e(buildUrl('opportunity-details.php?slug=' . urlencode($item['slug']))) ?>">
                                    <?= e($item['title']) ?>
                                </a>
                            </h3>

                            <p><?= e($item['short_summary']) ?></p>

                            <div class="meta">
                                <span>Type: <?= e(str_replace('_', ' ', ucfirst($item['opportunity_type']))) ?></span>
                                <span>Home-based: <?= e($item['home_based_suitability']) ?></span>
                                <span>Risk: <?= e(ucfirst($item['risk_level'])) ?></span>
                            </div>

                            <div class="meta">
                                <span>Investment: <?= e(formatCurrency($item['investment_min'])) ?> - <?= e(formatCurrency($item['investment_max'])) ?></span>
                                <span>Earnings: <?= e(formatCurrency($item['earning_min'])) ?> - <?= e(formatCurrency($item['earning_max'])) ?></span>
                            </div>

                            <a class="btn btn-secondary" href="<?= e(buildUrl('opportunity-details.php?slug=' . urlencode($item['slug']))) ?>">
                                View Details
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a class="<?= $i === $page ? 'active' : '' ?>"
                       href="<?= e(buildUrl('opportunities.php?search=' . urlencode($search) . '&type=' . urlencode($type) . '&page=' . $i)) ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../app/includes/footer.php'; ?>