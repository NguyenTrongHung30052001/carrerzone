{{-- 
    ĐÃ CẬP NHẬT:
    - Thêm "sticky top-0 z-50" để cố định header
--}}
<nav x-data="{ 
        open: false, 
        megaMenuOpen: false,
        mobileMenuOpen: false
    }" 
    class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
    
    <!-- Primary Navigation Menu -->
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            {{-- =============================================== --}}
            {{-- LEFT SIDE: Logo & Main Menu --}}
            {{-- =============================================== --}}
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-6 xl:space-x-8 sm:-my-px sm:ms-10 sm:flex text-sm font-medium">
                    
                    {{-- 1. TÌM VIỆC LÀM (Có Mega Menu) --}}
                    <div class="relative flex" @mouseenter="megaMenuOpen = true" @mouseleave="megaMenuOpen = false">
                        <button 
                            class="inline-flex items-center px-1 pt-1 border-b-2 
                                   {{ request()->routeIs('dashboard') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                                   focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            Tìm Việc Làm
                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        
                        {{-- MEGA MENU CONTENT (ĐÃ SỬA VỊ TRÍ) --}}
                        <div 
                            x-show="megaMenuOpen" 
                            @click.away="megaMenuOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute top-full left-0 mt-0 w-auto min-w-[500px] bg-white rounded-md shadow-lg border z-50 p-6"
                            style="display: none;"
                        >
                            <div class="grid grid-cols-2 gap-x-12 gap-y-4">
                                {{-- Cột 1: Việc Làm --}}
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-3 border-b pb-2">VIỆC LÀM</h3>
                                    <ul class="space-y-3">
                                        <li><a href="#" class="text-gray-600 hover:text-indigo-600">Việc làm mới nhất</a></li>
                                        <li><a href="{{ route('jobs.index')}}" class="text-gray-600 hover:text-indigo-600">Việc làm theo ngành nghề</a></li>
                                    </ul>
                                </div>
                                {{-- Cột 2: Công Ty --}}
                                <div>
                                    <h3 class="font-bold text-gray-900 mb-3 border-b pb-2">CÔNG TY</h3>
                                    <ul class="space-y-3">
                                        <li><a href="{{ route('companies.index') }}" class="text-gray-600 hover:text-indigo-600">Danh sách công ty</a></li>
                                        <li><a href="#" class="text-gray-600 hover:text-indigo-600">Doanh nghiệp yêu thích</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. CV HAY --}}
                    <x-nav-link href="#" :active="false">
                        CV Hay
                    </x-nav-link>

                    {{-- 3. VietnamSalary --}}
                    <x-nav-link href="#" :active="false">
                        VietnamSalary
                    </x-nav-link>

                    {{-- 4. CareerMap --}}
                    <x-nav-link href="#" :active="false">
                        CareerMap
                    </x-nav-link>

                    {{-- 5. Cẩm Nang --}}
                    <x-nav-link href="#" :active="false">
                        Cẩm Nang
                    </x-nav-link>

                    {{-- 6. CareerStart --}}
                    <x-nav-link href="#" :active="false">
                        CareerStart
                    </x-nav-link>
                    
                    {{-- 7. Tiện Ích --}}
                    <x-nav-link href="#" :active="false">
                        Tiện Ích
                    </x-nav-link>

                </div>
            </div>

            {{-- =============================================== --}}
            {{-- RIGHT SIDE: Notification, Auth, Employer Button --}}
            {{-- =============================================== --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                
                <!-- Notification Bell -->
                <button class="p-2 text-gray-400 hover:text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <span class="sr-only">View notifications</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341A6.002 6.002 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>

                <!-- Auth Links (Logged in or Guest) -->
                @auth('web')
                    <!-- Settings Dropdown (Đã đăng nhập 'web') -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->ho_va_ten_lot . ' ' . Auth::user()->ten }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- Nút Đăng nhập / Đăng ký (Guest) --}}
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-sm">
                        Đăng ký
                    </a>
                @endauth
                
                <!-- Nút Dành cho Nhà Tuyển Dụng -->
                <a href="{{ route('employers.index') }}" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md shadow-sm">
                    Dành cho Nhà Tuyển Dụng
                </a>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b">
        <div class="pt-2 pb-3 space-y-1">
            
            {{-- 1. TÌM VIỆC LÀM (Responsive - Dropdown) --}}
            <div x-data="{ mobileMenuOpen: false }">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="flex items-center justify-between w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('dashboard') ? 'border-indigo-400 text-indigo-700 bg-indigo-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                    <span>Tìm Việc Làm</span>
                    <svg class="h-5 w-5 transform transition-transform" :class="{ 'rotate-180': mobileMenuOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                {{-- Nội dung dropdown mobile --}}
                <div x-show="mobileMenuOpen" class="mt-2 space-y-1 ps-8" style="display: none;">
                    <x-responsive-nav-link href="#">Việc làm mới nhất</x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('jobs.index')}}">Việc làm theo ngành nghề</x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('companies.index') }}">Danh sách công ty</x-responsive-nav-link>
                    <x-responsive-nav-link href="#">Doanh nghiệp yêu thích</x-responsive-nav-link>
                </div>
            </div>

            <x-responsive-nav-link href="#" :active="false">CV Hay</x-responsive-nav-link>
            <x-responsive-nav-link href="#" :active="false">VietnamSalary</x-responsive-nav-link>
            <x-responsive-nav-link href="#" :active="false">CareerMap</x-responsive-nav-link>
            <x-responsive-nav-link href="#" :active="false">Cẩm Nang</x-responsive-nav-link>
            <x-responsive-nav-link href="#" :active="false">CareerStart</x-responsive-nav-link>
            <x-responsive-nav-link href="#" :active="false">Tiện Ích</x-responsive-nav-link>
        </div>

        <!-- Responsive Settings (Auth) -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth('web')
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->ho_va_ten_lot . ' ' . Auth::user()->ten }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        Đăng nhập
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        Đăng ký
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
        
        <!-- Nút Dành cho Nhà Tuyển Dụng (Mobile) -->
        <div class="py-2 border-t border-gray-200">
             <a href="{{ route('employers.index') }}" class="block w-full text-left ps-3 pe-4 py-2 text-base font-medium text-red-700 bg-red-50 hover:bg-red-100">
                Dành cho Nhà Tuyển Dụng
            </a>
        </div>
    </div>
</nav>