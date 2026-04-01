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


function formatOpportunityType(string $type): string
{
    return match ($type) {
        'job' => 'Job',
        'home_based_work' => 'Home-Based Work',
        'self_employment' => 'Self-Employment',
        'micro_business' => 'Micro-Business',
        default => ucwords(str_replace('_', ' ', $type)),
    };
}

function getOpportunityImage(?string $slug = null): string
{
    $slug = trim((string)$slug);

    if ($slug !== '') {
        $candidate = __DIR__ . '/../../public/assets/images/opportunities/' . $slug . '.png';
        if (file_exists($candidate)) {
            return buildUrl('assets/images/opportunities/' . $slug . '.png');
        }
    }

    return buildUrl('assets/images/opportunities/default-opportunity.png');
}

function getOpportunityTypeIcon(string $type): string
{
    return match ($type) {
        'job' => 'briefcase',
        'home_based_work' => 'house',
        'self_employment' => 'user-gear',
        'micro_business' => 'shop',
        default => 'spark',
    };
}

function svgIcon(string $name): string
{
    $icons = [
        'briefcase' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 6V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v1h3a2 2 0 0 1 2 2v3H2V8a2 2 0 0 1 2-2h5Zm2 0h2V5h-2v1Zm11 7v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-5h8v1h4v-1h8Z" fill="currentColor"/></svg>',
        'house' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 3 10v10h6v-6h6v6h6V10l-9-7Z" fill="currentColor"/></svg>',
        'user-gear' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm-7 8a7 7 0 0 1 14 0H5Zm14.7-10.3 1.3.7-.4 1.5 1 1.2-1 1.2.4 1.5-1.3.7-1.2-1-1.5.4-.7-1.3-1.5-.4v-1.6l1.5-.4.7-1.3 1.5.4 1.2-1Z" fill="currentColor"/></svg>',
        'shop' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 10l2-5h14l2 5v2a2 2 0 0 1-2 2v6H5v-6a2 2 0 0 1-2-2v-2Zm4 4v4h10v-4H7Z" fill="currentColor"/></svg>',
        'rupee' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 5h10v2h-4.2A4 4 0 0 1 14 9H7v2h7l-5 8H6l4.4-7H7V9h4a2 2 0 0 0-1.7-2H7V5Z" fill="currentColor"/></svg>',
        'clock' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1 5h-2v6l5 3 1-1.7-4-2.3V7Z" fill="currentColor"/></svg>',
        'shield' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2 4 5v6c0 5 3.4 9.7 8 11 4.6-1.3 8-6 8-11V5l-8-3Z" fill="currentColor"/></svg>',
        'growth' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16v2H2V3h2v16Zm4-4 3-3 3 2 5-6 1.5 1.3-6.2 7.4-3.1-2.1L9.4 16.4 8 15Z" fill="currentColor"/></svg>',
        'home-check' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 3 10v10h18V10l-9-7Zm-1 12 6-6 1.4 1.4L11 17.8 7.6 14.4 9 13l2 2Z" fill="currentColor"/></svg>',
        'education' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 2 8l10 5 8-4v6h2V8L12 3Zm-6 8v4l6 3 6-3v-4l-6 3-6-3Z" fill="currentColor"/></svg>',
        'internet' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 18a2 2 0 1 0 2 2 2 2 0 0 0-2-2Zm-4.2-3.8 1.4 1.4a4 4 0 0 1 5.6 0l1.4-1.4a6 6 0 0 0-8.4 0ZM5 11.4l1.4 1.4a8 8 0 0 1 11.2 0l1.4-1.4A10 10 0 0 0 5 11.4Zm-2.8-2.8 1.4 1.4a12 12 0 0 1 16.8 0l1.4-1.4a14 14 0 0 0-19.6 0Z" fill="currentColor"/></svg>',
        'vehicle' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 16a2 2 0 1 0 2 2 2 2 0 0 0-2-2Zm14 0a2 2 0 1 0 2 2 2 2 0 0 0-2-2ZM5 6h11l4 5v5h-1a3 3 0 0 0-6 0h-5a3 3 0 0 0-6 0H1V9a3 3 0 0 1 3-3Z" fill="currentColor"/></svg>',
        'land' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 18h18v2H3v-2Zm2-2 4-8 4 5 3-3 3 6H5Z" fill="currentColor"/></svg>',
        'shop-space' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16v4H4V4Zm1 6h14v10H5V10Zm3 2v6h3v-6H8Zm5 0v6h3v-6h-3Z" fill="currentColor"/></svg>',
        'check' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 16.2 4.8 12 3.4 13.4 9 19l12-12-1.4-1.4L9 16.2Z" fill="currentColor"/></svg>',
        'warning' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 1 21h22L12 3Zm1 14h-2v2h2v-2Zm0-6h-2v4h2v-4Z" fill="currentColor"/></svg>',
    ];

    return $icons[$name] ?? '';
}