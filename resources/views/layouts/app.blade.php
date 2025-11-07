<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            
            {{-- 
                1. HEADER (Navigation) 
                Gọi file navigation.blade.php
            --}}
            @include('layouts.navigation')

            {{-- 
                2. NỘI DUNG TRANG (Page Content) 
                Đã thêm 'pt-16' để nội dung không bị header (sticky h-16) che mất
            --}}
            <main class="pt-16">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif
                
                {{-- Slot chứa nội dung chính (ví dụ: dashboard.blade.php) --}}
                {{ $slot }}
            </main>

            {{-- 
                3. FOOTER 
                Gọi file footer.blade.php (đã tạo)
            --}}
            @include('layouts.partials.footer')
            
        </div>
    </body>
</html>