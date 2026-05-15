@props(['status', 'size' => 'sm'])

@php
    $colors = [
        'pending' => 'bg-amber-100 text-amber-800',
        'approved' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
        'active' => 'bg-blue-100 text-blue-800',
        'completed' => 'bg-gray-100 text-gray-800',
        'terminated' => 'bg-red-100 text-red-800',
        'draft' => 'bg-gray-100 text-gray-800',
        'submitted' => 'bg-yellow-100 text-yellow-800',
        'reviewed' => 'bg-green-100 text-green-800',
        'flagged' => 'bg-orange-100 text-orange-800',
        'midterm' => 'bg-blue-100 text-blue-800',
        'final' => 'bg-purple-100 text-purple-800',
    ];

    $sizes = [
        'xs' => 'px-2 py-0.5 text-xs',
        'sm' => 'px-2.5 py-0.5 text-xs',
        'md' => 'px-3 py-1 text-sm',
        'lg' => 'px-4 py-1.5 text-base',
    ];

    $colorClass = $colors[strtolower($status)] ?? 'bg-gray-100 text-gray-800';
    $sizeClass = $sizes[$size] ?? $sizes['sm'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full font-medium $colorClass $sizeClass"]) }}>
    {{ ucfirst($status) }}
</span>
