<?php
declare(strict_types=1);

require_once __DIR__ . '/../../app/includes/auth.php';
require_once __DIR__ . '/../../app/services/OpportunityService.php';
requireAdminAuth();

$items = OpportunityService::getAllForAdmin();

$pageTitle = 'Manage Opportunities';
require_once __DIR__ . '/partials/admin-header.php';
?>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
    <h1>Manage Opportunities</h1>
    <a class="btn btn-primary" href="opportunity-create.php">Add New</a>
</div>

<div class="detail-card">
    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align:left; border-bottom:1px solid #e5e7eb;">
                <th style="padding:12px;">Title</th>
                <th style="padding:12px;">Category</th>
                <th style="padding:12px;">Type</th>
                <th style="padding:12px;">Status</th>
                <th style="padding:12px;">Featured</th>
                <th style="padding:12px;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:12px;"><?= e($item['title']) ?></td>
                    <td style="padding:12px;"><?= e($item['category_name']) ?></td>
                    <td style="padding:12px;"><?= e($item['opportunity_type']) ?></td>
                    <td style="padding:12px;"><?= e($item['status']) ?></td>
                    <td style="padding:12px;"><?= (int)$item['featured_flag'] === 1 ? 'Yes' : 'No' ?></td>
                    <td style="padding:12px;">
                        <a href="opportunity-edit.php?id=<?= (int)$item['id'] ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/partials/admin-footer.php'; ?>