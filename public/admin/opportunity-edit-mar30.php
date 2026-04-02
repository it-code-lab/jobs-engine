<?php
declare(strict_types=1);

require_once __DIR__ . '/../../app/includes/auth.php';
require_once __DIR__ . '/../../app/includes/functions.php';
require_once __DIR__ . '/../../app/services/CategoryService.php';
require_once __DIR__ . '/../../app/services/OpportunityService.php';
requireAdminAuth();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    exit('Invalid opportunity ID.');
}

$item = OpportunityService::getByIdForAdmin($id);
if (!$item) {
    exit('Opportunity not found.');
}

$categories = CategoryService::getActiveCategories();
$adminUser = getAdminUser();
$error = '';
$success = isset($_GET['created']) ? 'Opportunity created successfully.' : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $data['slug'] = trim($data['slug']) !== '' ? trim($data['slug']) : strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['title'])));

    try {
        OpportunityService::updateOpportunity($id, $data, (int)$adminUser['id']);
        $item = OpportunityService::getByIdForAdmin($id);
        $success = 'Opportunity updated successfully.';
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$pageTitle = 'Edit Opportunity';
require_once __DIR__ . '/partials/admin-header.php';
?>

<h1>Edit Opportunity</h1>

<?php if ($success): ?>
    <p style="color:#15803d;"><?= e($success) ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color:#b91c1c;"><?= e($error) ?></p>
<?php endif; ?>

<?php require __DIR__ . '/partials/opportunity-form.php'; ?>

<?php require_once __DIR__ . '/partials/admin-footer.php'; ?>