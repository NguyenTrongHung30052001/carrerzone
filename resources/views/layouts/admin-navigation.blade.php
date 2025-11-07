{{-- 
  File này chỉ chứa các link. 
  CSS (màu chữ, hover, v.v.) được lấy từ file admin.blade.php
  vì file này được 'include' vào trong đó.
--}}

{{-- Helper class cho link active/inactive --}}
@php
$activeClass = 'bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md';
$inactiveClass = 'text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md';
@endphp

<!-- Dashboard Link -->
<a 
    href="{{ route('admin.dashboard') }}"
    class="{{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}"
>
    <!-- Heroicon: home -->
    <svg class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
    </svg>
    {{ __('Admin Dashboard') }}
</a>

<!-- Quản lý phúc lợi -->
<a 
    href="{{ route('admin.benefits.index') }}"
    class="{{ request()->routeIs('admin.benefits.*') ? $activeClass : $inactiveClass }}"
>
    <!-- Heroicon: gift -->
    <svg class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
    </svg>
    {{ __('Quản lý phúc lợi') }}
</a>

<!-- Quản lý địa chỉ -->
@php
    $isLocationsActive = request()->routeIs('admin.locations.*') || request()->routeIs('admin.provinces.*') || request()->routeIs('admin.wards.*');
@endphp
<a 
    href="{{ route('admin.locations.index') }}"
    class="{{ $isLocationsActive ? $activeClass : $inactiveClass }}"
>
    <!-- Heroicon: map -->
    <svg class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l6.553-3.276A1 1 0 0021 12.618V5.618a1 1 0 00-1.447-.894L15 7m-6 3l6-3m0 0l6-3m-6 3v10" />
    </svg>
    {{ __('Quản lý địa chỉ') }}
</a>

<!-- MỤC MỚI: Quản lý ngành nghề -->
<a 
    href="{{ route('admin.professions.index') }}"
    class="{{ request()->routeIs('admin.professions.*') ? $activeClass : $inactiveClass }}"
>
    <!-- Heroicon: briefcase -->
    <svg class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.07a2.25 2.25 0 01-2.25 2.25H5.126a2.25 2.25 0 01-2.25-2.25v-4.07a2.25 2.25 0 01.9-1.63L3.75 9.75l-.35-3.037a.75.75 0 01.528-.731L7.5 4.708l.223.04.52.091.302.053c.84.149 1.68.22 2.528.22s1.688-.07 2.528-.22l.302-.053.52-.091.223-.04L19.5 5.98a.75.75 0 01.528.731l-.35 3.037 1.176.621a2.25 2.25 0 01.9 1.63z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.75h16.5" />
    </svg>
    {{ __('Quản lý ngành nghề') }}
</a>

{{-- Thêm các mục quản lý khác của bạn ở đây --}}