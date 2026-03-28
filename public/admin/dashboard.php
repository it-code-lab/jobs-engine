<?php
declare(strict_types=1);

require_once __DIR__ . '/../../app/includes/auth.php';
requireAdminAuth();

$pageTitle = 'Admin Dashboard';
require_once __DIR__ . '/partials/admin-header.php';
?>

<h1>Admin Dashboard</h1>

<div class="card-grid" style="margin-top: 24px;">
    <div class="detail-card">
        <h3>Manage Opportunities</h3>
        <p>Create, edit, publish, and organize opportunities.</p>
        <a class="btn btn-primary" href="opportunities.php">Open Opportunities</a>
    </div>

    <div class="detail-card">
        <h3>Add New Opportunity</h3>
        <p>Add a new job, home-based work, self-employment, or micro-business record.</p>
        <a class="btn btn-secondary" href="opportunity-create.php">Create Opportunity</a>
    </div>
</div>

<?php require_once __DIR__ . '/partials/admin-footer.php'; ?>