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
    <body class="font-sans antialiased bg-gray-50">
        
        {{-- 
            1. THANH ĐIỀU HƯỚNG (HEADER) 
            Đã được thêm 'sticky top-0 z-50'
        --}}
        @include('layouts.navigation')

        {{-- 
            2. NỘI DUNG CHÍNH (FORM ĐĂNG NHẬP/ĐĂNG KÝ)
            Đã được thêm 'pt-16' để không bị header che
        --}}
        <div class="pt-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                
                <div class="flex flex-col lg:flex-row shadow-2xl rounded-xl overflow-hidden bg-white min-h-[550px] mb-12">
                    
                    {{-- Cột trái: Hình ảnh/Tiêu đề chào mừng --}}
                    <div class="w-full lg:w-2/5 p-8 text-white bg-indigo-700 flex flex-col justify-center items-center">
                        <h1 class="text-3xl font-bold mb-4 text-center">
                            Chào mừng đến với chúng tôi!
                        </h1>
                        <p class="text-center text-indigo-100 mt-4">
                            Hơn 10,000 cơ hội việc làm đang chờ bạn. Hãy tham gia để khám phá ngay!
                        </p>
                        <div class="mt-8">
                            <img src="https://placehold.co/200x200/4c51bf/ffffff/png?text=Jobseeker+Image" alt="Hình ảnh ứng viên" class="rounded-full shadow-lg opacity-80" />
                        </div>
                    </div>

                    {{-- Cột phải: Form chính (slot) --}}
                    <div class="w-full lg:w-3/5 p-6 md:p-12 flex flex-col justify-center">
                        {{ $slot }}
                    </div>
                </div>

            </div>
        </div>

        {{-- 
            3. FOOTER
        --}}
        @include('layouts.partials.footer')

    </body>
</html>