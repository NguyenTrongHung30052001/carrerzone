<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- ... (phần head) ... --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            
            <!-- Navigation (Sticky) -->
            @include('layouts.employers-navigation')

            {{-- 
                FIX LỖI NẰM Ở ĐÂY:
                Bọc CẢ header và main trong 1 div có padding-top (pt-16)
            --}}
            <div class="pt-16"> 
                
                <!-- Page Heading (Slot) -->
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content (Slot) -->
                <main>
                    {{ $slot }}
                </main>

            </div>

        </div>

        {{-- Thêm footer --}}
        @include('layouts.partials.footer-employers')

    </body>
</html>