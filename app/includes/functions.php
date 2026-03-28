<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function formatCurrency($amount): string
{
    if ($amount === null || $amount === '') {
        return 'N/A';
    }

    return '₹' . number_format((float)$amount, 0);
}

function buildUrl(string $path): string
{
    return rtrim(APP_URL, '/') . '/' . ltrim($path, '/');
}

function getFitBadgeClass(string $level): string
{
    return match ($level) {
        'Strong Match' => 'badge-success',
        'Good Match' => 'badge-primary',
        'Possible Option' => 'badge-warning',
        default => 'badge-muted',
    };
}

function getPageTitle(string $title = ''): string
{
    if ($title === '') {
        return APP_NAME;
    }

    return $title . ' | ' . APP_NAME;
}