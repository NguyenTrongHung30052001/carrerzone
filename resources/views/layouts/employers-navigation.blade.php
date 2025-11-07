<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-md sticky top-0 z-50">
    <!-- Primary Navigation Menu (Header chính) -->
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('employers.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links (Menu Chính dành cho Nhà Tuyển Dụng) -->
                @auth('tuyen_dung')
                    <div class="hidden space-x-6 xl:space-x-8 sm:-my-px sm:ms-10 sm:flex text-sm font-medium">
                        
                        {{-- Dashboard --}}
                        <x-nav-link :href="route('employers.dashboard')" :active="request()->routeIs('employers.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        {{-- Quản lý tin đăng --}}
                        <x-nav-link :href="route('employers.posts.index')" :active="request()->routeIs('employers.posts.*')">
                            {{ __('Quản lý tin đăng') }}
                        </x-nav-link>

                        {{-- Tìm kiếm Hồ sơ (Placeholder) --}}
                        <x-nav-link href="#" :active="false">
                            {{ __('Tìm kiếm Hồ sơ') }}
                        </x-nav-link>
                        
                        {{-- Thanh toán / Hợp đồng (Placeholder) --}}
                        <x-nav-link href="#" :active="false">
                            {{ __('Thanh toán') }}
                        </x-nav-link>

                    </div>
                @endauth
            </div>

            {{-- =============================================== --}}
            {{-- RIGHT SIDE: Buttons (Post Job, Switch Role) & Settings --}}
            {{-- =============================================== --}}
            <div class="flex items-center space-x-4">
                
                <!-- Links cho khách (Guest) -->
                @guest('tuyen_dung')
                <div class="hidden sm:flex sm:items-center space-x-2">
                    <a href="{{ route('employers.login') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">Đăng nhập</a>
                    <a href="{{ route('employers.register') }}" class="px-3 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">Đăng ký</a>
                </div>
                @endguest
                
                @auth('tuyen_dung')
                
                {{-- NÚT NỔI BẬT: Đăng tin mới --}}
                <a href="{{ route('employers.posts.create') }}" class="hidden sm:flex px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-md shadow-lg transition duration-150 ease-in-out">
                    Đăng tin mới
                </a>
                
                @endauth

                <!-- Settings Dropdown (Đã đăng nhập 'tuyen_dung') -->
                @auth('tuyen_dung')
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::guard('tuyen_dung')->user()->ten_cong_ty }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            {{-- SỬA Ở ĐÂY: Thêm link tới trang Thông tin công ty --}}
                            <x-dropdown-link :href="route('employers.profile.edit')">
                                {{ __('Thông tin công ty') }}
                            </x-dropdown-link>
                            
                            <form method="POST" action="{{ route('employers.logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('employers.logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endauth
                
                {{-- NÚT NỔI BẬT: QUAY VỀ TRANG ỨNG VIÊN --}}
                <a href="{{ route('dashboard') }}" class="hidden sm:flex px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-lg transition duration-150 ease-in-out">
                    Dành cho Ứng viên
                </a>

            </div>

            <!-- Hamburger (Mobile Toggle) -->
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
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        
        <!-- Responsive Links (Auth) -->
        @auth('tuyen_dung')
        <div class="pt-2 pb-3 space-y-1">
             <x-responsive-nav-link :href="route('employers.dashboard')" :active="request()->routeIs('employers.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('employers.posts.index')" :active="request()->routeIs('employers.posts.*')">
                {{ __('Quản lý tin đăng') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#" :active="false">
                {{ __('Tìm kiếm Hồ sơ') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#" :active="false">
                {{ __('Thanh toán') }}
            </x-responsive-nav-link>
            
            {{-- NÚT MOBILE: Quay về Ứng viên --}}
            <x-responsive-nav-link :href="route('dashboard')" class="text-indigo-600 hover:text-indigo-800 font-bold">
                {{ __('Quay về trang Ứng viên') }}
            </x-responsive-nav-link>
             
            <a href="{{ route('employers.posts.create') }}" class="block w-full text-left ps-3 pe-4 py-2 border-l-4 border-transparent text-base font-medium text-white bg-red-600 hover:bg-red-700 mt-2">
                Đăng tin mới
            </a>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::guard('tuyen_dung')->user()->ten_cong_ty }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::guard('tuyen_dung')->user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                {{-- SỬA Ở ĐÂY: Thêm link tới trang Thông tin công ty --}}
                <x-responsive-nav-link :href="route('employers.profile.edit')">
                    {{ __('Thông tin công ty') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('employers.logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('employers.logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth

        <!-- Responsive Links cho khách (Guest) -->
        @guest('tuyen_dung')
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('employers.login')">Đăng nhập</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('employers.register')">Đăng ký</x-responsive-nav-link>
            </div>
        </div>
        @endguest
    </div>
</nav>