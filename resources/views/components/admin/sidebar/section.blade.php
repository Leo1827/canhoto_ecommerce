@props(['title'])

<div class="mt-6">
    <h3 class="text-xs font-bold uppercase text-gray-500 px-4 mb-2 tracking-wide">{{ $title }}</h3>
    <div class="space-y-1">
        {{ $slot }}
    </div>
</div>
