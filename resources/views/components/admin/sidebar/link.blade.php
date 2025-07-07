@props(['route', 'label', 'icon'])

@php
    $active = request()->routeIs($route) || request()->routeIs($route . '.*');
@endphp

<a href="{{ route($route) }}"
   class="group flex items-center gap-3 px-4 py-2 text-sm transition-all duration-200 rounded-md relative
       {{ $active 
           ? 'text-black font-semibold bg-gray-100 before:content-[""] before:absolute before:bottom-0 before:left-4 before:right-4 before:h-[2px] before:bg-blue-600' 
           : 'text-gray-600 hover:bg-gray-100 hover:text-black' }}">

    <i data-lucide="{{ $icon }}" class="w-5 h-5 text-inherit"></i>
    <span>{{ $label }}</span>
</a>
