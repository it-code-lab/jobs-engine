<?php
declare(strict_types=1);

require_once __DIR__ . '/../../app/config/config.php';
require_once __DIR__ . '/../../app/includes/functions.php';
require_once __DIR__ . '/../../app/includes/auth.php';
require_once __DIR__ . '/../../app/services/AdminAuthService.php';

if (isAdminLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (AdminAuthService::login($email, $password)) {
        header('Location: dashboard.php');
        exit;
    }

    $error = 'Invalid email or password.';
}

$pageTitle = 'Admin Login';
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
<section class="section">
    <div class="container" style="max-width: 500px;">
        <div class="detail-card">
            <h1>Admin Login</h1>

            <?php if ($error): ?>
                <p style="color:#b91c1c;"><?= e($error) ?></p>
            <?php endif; ?>

            <form method="post">
                <div style="margin-bottom: 16px;">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div style="margin-bottom: 16px;">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <button class="btn btn-primary" type="submit">Login</button>
            </form>
        </div>
    </div>
</section>
</body>
</html>