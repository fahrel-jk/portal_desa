@props(['status'])

@php
    $config = match($status) {
        'pending_review' => [
            'label' => 'Menunggu Review',
            'bg' => 'bg-status-pending-bg',
            'text' => 'text-status-pending-text',
        ],
        'published' => [
            'label' => 'Disetujui / Tayang',
            'bg' => 'bg-status-approved-bg',
            'text' => 'text-status-approved-text',
        ],
        'rejected' => [
            'label' => 'Ditolak',
            'bg' => 'bg-status-rejected-bg',
            'text' => 'text-status-rejected-text',
        ],
        'draft' => [
            'label' => 'Draft',
            'bg' => 'bg-status-draft-bg',
            'text' => 'text-status-draft-text',
        ],
        default => [
            'label' => ucfirst($status),
            'bg' => 'bg-obsidian-button',
            'text' => 'text-ash-text',
        ],
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$config['bg']} {$config['text']}"]) }}>
    {{ $config['label'] }}
</span>
