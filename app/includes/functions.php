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
        'rupee-delit' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 5h10v2h-4.2A4 4 0 0 1 14 9H7v2h7l-5 8H6l4.4-7H7V9h4a2 2 0 0 0-1.7-2H7V5Z" fill="currentColor"/></svg>',
        'rupee-new' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 3h12M6 8h12m-3.5 0c0 4.5-5.5 4.5-5.5 4.5L14 21M7 12.5h3" /></svg>',
        'rupee' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 10a6 6 0 0 0-6-6H3v2a6 6 0 0 0 6 6h3Z"/><path d="M12 10a6 6 0 0 1 6-6h3v2a6 6 0 0 1-6 6h-3Z"/><path d="M12 22V10"/><path d="M9 18h6"/></svg>',
        'clock-delit' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1 5h-2v6l5 3 1-1.7-4-2.3V7Z" fill="currentColor"/></svg>',
        'clock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
        'shield' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2 4 5v6c0 5 3.4 9.7 8 11 4.6-1.3 8-6 8-11V5l-8-3Z" fill="currentColor"/></svg>',
        'growth' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4Z"/></svg>',
        'growth-chart' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19h16v2H2V3h2v16Zm4-4 3-3 3 2 5-6 1.5 1.3-6.2 7.4-3.1-2.1L9.4 16.4 8 15Z" fill="currentColor"/></svg>',
        'home-check' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 3 10v10h18V10l-9-7Zm-1 12 6-6 1.4 1.4L11 17.8 7.6 14.4 9 13l2 2Z" fill="currentColor"/></svg>',
        'education' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 2 8l10 5 8-4v6h2V8L12 3Zm-6 8v4l6 3 6-3v-4l-6 3-6-3Z" fill="currentColor"/></svg>',
        'internet' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 18a2 2 0 1 0 2 2 2 2 0 0 0-2-2Zm-4.2-3.8 1.4 1.4a4 4 0 0 1 5.6 0l1.4-1.4a6 6 0 0 0-8.4 0ZM5 11.4l1.4 1.4a8 8 0 0 1 11.2 0l1.4-1.4A10 10 0 0 0 5 11.4Zm-2.8-2.8 1.4 1.4a12 12 0 0 1 16.8 0l1.4-1.4a14 14 0 0 0-19.6 0Z" fill="currentColor"/></svg>',
        'digital-literacy-old' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><path d="M12 6v6m3-3h-6m6 7h-6"/></svg>',
        'digital-literacy' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/><path d="m9 10 2 2 4-4"/><circle cx="19" cy="5" r="2" opacity="0.5"/></svg>',
        'experience' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8.21 13.89L7 23l5-3 5 3-1.21-9.12"/><circle cx="12" cy="8" r="7"/><path d="M12 5l1 2h2l-1.5 1.5.5 2.5-2-1.5-2 1.5.5-2.5-1.5-1.5h2z"/></svg>',
        'manual-effort' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v5"/><path d="M14 10V5a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v10"/><path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v10"/><path d="M6 14v-1.5a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2V18a7 7 0 0 0 7 7h3a10 10 0 0 0 10-10v-2.5"/><path d="M22 14.5a3 3 0 0 1-6 0v-4.5"/><circle cx="12" cy="8" r="1.5"/></svg>',
        'physical-effort-old' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="5" r="3"/><path d="M6.5 9l4.5 3-2 8"/><path d="M17.5 9l-4.5 3 2 8"/><path d="M12 12V8l-3 3"/><path d="M12 12v4l3-3"/></svg>',
        'physical-effort' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 3l14 9-14 9V3z"/><path d="M19 12H5"/><path d="M12 5l7 7-7 7" stroke-dasharray="2 2"/></svg>',
        'computer' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
        'smartphone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>',
        'vehicle-old' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 16a2 2 0 1 0 2 2 2 2 0 0 0-2-2Zm14 0a2 2 0 1 0 2 2 2 2 0 0 0-2-2ZM5 6h11l4 5v5h-1a3 3 0 0 0-6 0h-5a3 3 0 0 0-6 0H1V9a3 3 0 0 1 3-3Z" fill="currentColor"/></svg>',
        'vehicle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/></svg>',
        'tools-required' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/><path d="M16 9V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v4"/><path d="M12 12v3"/><path d="M8 13v2"/><path d="M16 13v2"/></svg>',
        'land' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 18h18v2H3v-2Zm2-2 4-8 4 5 3-3 3 6H5Z" fill="currentColor"/></svg>',
        'shop-space' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16v4H4V4Zm1 6h14v10H5V10Zm3 2v6h3v-6H8Zm5 0v6h3v-6h-3Z" fill="currentColor"/></svg>',
        'check' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 16.2 4.8 12 3.4 13.4 9 19l12-12-1.4-1.4L9 16.2Z" fill="currentColor"/></svg>',
        'warning' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 1 21h22L12 3Zm1 14h-2v2h2v-2Zm0-6h-2v4h2v-4Z" fill="currentColor"/></svg>',
    ];

    return $icons[$name] ?? '';
}