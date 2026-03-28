<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isAdminLoggedIn(): bool
{
    return !empty($_SESSION['admin_user']);
}

function requireAdminAuth(): void
{
    if (!isAdminLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function getAdminUser(): ?array
{
    return $_SESSION['admin_user'] ?? null;
}