<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../app/config/config.php';
require_once __DIR__ . '/../../../app/includes/functions.php';
require_once __DIR__ . '/../../../app/includes/auth.php';

$adminUser = getAdminUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Admin') ?></title>
    <link rel="stylesheet" href="<?= e(buildUrl('assets/css/style.css')) ?>">
</head>
<body>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="logo" href="dashboard.php">Admin Panel</a>
        <nav class="main-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="opportunities.php">Opportunities</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
</header>
<main class="site-main">
    <div class="container" style="padding-top: 24px;">
        <?php if ($adminUser): ?>
            <p style="margin-bottom: 8px; color:#6b7280;">Logged in as <?= e($adminUser['full_name']) ?></p>
        <?php endif; ?>