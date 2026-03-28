<?php
declare(strict_types=1);

if (!isset($pageTitle)) {
    $pageTitle = APP_NAME;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= e(buildUrl('assets/css/style.css')) ?>">
</head>
<body>
    <header class="site-header">
        <div class="container nav-wrap">
            <a class="logo" href="<?= e(buildUrl('index.php')) ?>">
                <?= e(APP_NAME) ?>
            </a>

            <nav class="main-nav">
                <a href="<?= e(buildUrl('index.php')) ?>">Home</a>
                <a href="<?= e(buildUrl('opportunities.php')) ?>">Browse Opportunities</a>
                <a href="#">How It Works</a>
                <a href="#">Login</a>
            </nav>
        </div>
    </header>

    <main class="site-main"></main>