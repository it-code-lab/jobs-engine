<?php
declare(strict_types=1);

require_once __DIR__ . '/../../app/includes/auth.php';
require_once __DIR__ . '/../../app/includes/functions.php';
require_once __DIR__ . '/../../app/services/CategoryService.php';
require_once __DIR__ . '/../../app/services/OpportunityService.php';
requireAdminAuth();

$categories = CategoryService::getActiveCategories();
$adminUser = getAdminUser();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $data['slug'] = trim($data['slug']) !== '' ? trim($data['slug']) : strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['title'])));

    try {
        $newId = OpportunityService::createOpportunity($data, (int)$adminUser['id']);
        header('Location: opportunity-edit.php?id=' . $newId . '&created=1');
        exit;
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$pageTitle = 'Create Opportunity';
require_once __DIR__ . '/partials/admin-header.php';
?>

<h1>Create Opportunity</h1>

<?php if ($error): ?>
    <p style="color:#b91c1c;"><?= e($error) ?></p>
<?php endif; ?>

<?php $item = null; ?>
<?php require __DIR__ . '/partials/opportunity-form.php'; ?>

<?php require_once __DIR__ . '/partials/admin-footer.php'; ?>