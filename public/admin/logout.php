<?php
declare(strict_types=1);

require_once __DIR__ . '/../../app/includes/auth.php';
require_once __DIR__ . '/../../app/services/AdminAuthService.php';

AdminAuthService::logout();

header('Location: login.php');
exit;