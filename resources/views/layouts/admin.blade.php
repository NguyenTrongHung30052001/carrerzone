<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        {{-- 
          Sử dụng Alpine.js (có sẵn trong Breeze) 
          để quản lý trạng thái đóng/mở của sidebar 
        --}}
        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100">
            
            <!-- Sidebar (dành cho di động) -->
            <div 
                x-show="sidebarOpen" 
                @click="sidebarOpen = false"
                class="fixed inset-0 z-40 flex md:hidden" 
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                style="display: none;"
            >
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
                <div 
                    x-show="sidebarOpen"
                    @click.stop
                    x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-800"
                    style="display: none;"
                >
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button 
                            @click="sidebarOpen = false"
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        >
                            <span class="sr-only">Close sidebar</span>
                            <!-- Heroicon name: x -->
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                        <div class="flex-shrink-0 flex items-center px-4">
                            <a href="{{ route('admin.dashboard') }}">
                                <x-application-logo class="block h-9 w-auto fill-current text-white" />
                            </a>
                        </div>
                        <nav class="mt-5 px-2 space-y-1">
                            {{-- Gọi menu navigation (chứa các link) --}}
                            @include('layouts.admin-navigation')
                        </nav>
                    </div>
                </div>
                <div class="flex-shrink-0 w-14"></div>
            </div>

            <!-- Sidebar (dành cho desktop) -->
            <div class="hidden md:flex md:flex-col md:fixed md:inset-y-0 md:w-64">
                <div class="flex flex-col flex-grow bg-gray-800 pt-5 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                         <a href="{{ route('admin.dashboard') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-white" />
                        </a>
                    </div>
                    <div class="mt-5 flex-1 flex flex-col">
                        <nav class="flex-1 px-2 pb-4 space-y-1">
                            {{-- Gọi menu navigation (chứa các link) --}}
                            @include('layouts.admin-navigation')
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content (Bao gồm Top Bar) -->
            <div class="md:pl-64 flex flex-col flex-1">
                {{-- Top Bar --}}
                <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
                    <button 
                        @click.stop="sidebarOpen = true"
                        class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
                    >
                        <span class="sr-only">Open sidebar</span>
                        <!-- Heroicon name: menu-alt-2 -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>
                    
                    <div class="flex-1 px-4 flex justify-between">
                        <div class="flex-1 flex">
                            {{-- (Có thể thêm thanh tìm kiếm ở đây) --}}
                        </div>
                        <div class="ml-4 flex items-center md:ml-6">
                            <!-- Settings Dropdown (Lấy từ file navigation cũ) -->
                            @auth('admin')
                            <div classs="hidden sm:flex sm:items-center sm:ms-6">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            <div>{{ Auth::guard('admin')->user()->full_name }}</div>
                                            <div class="ms-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <form method="POST" action="{{ route('admin.logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('admin.logout')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="flex-1 py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>