<x-custom-guest-layout>
    {{-- Hiển thị thông báo trạng thái (nếu có) --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Tabs Đăng nhập / Đăng ký --}}
    <div class="mb-8 border-b border-gray-300">
        <div class="flex justify-center space-x-8 -mb-px">
            <a href="{{ route('login') }}" class="py-2 px-4 text-lg font-semibold border-b-2 border-indigo-600 text-indigo-600">
                Đăng nhập
            </a>
            <a href="{{ route('register') }}" class="py-2 px-4 text-lg font-semibold text-gray-500 border-b-2 border-transparent hover:text-indigo-600 hover:border-indigo-600 transition duration-150">
                Đăng ký
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mật khẩu')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex justify-between items-center mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ghi nhớ đăng nhập') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="underline text-sm text-indigo-600 hover:text-indigo-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Quên mật khẩu?') }}
                </a>
            @endif
        </div>

        <div class="flex flex-col items-center justify-end mt-6 space-y-3">
            <x-primary-button class="w-full justify-center py-3 bg-red-600 hover:bg-red-700">
                Đăng nhập ngay
            </x-primary-button>
        </div>
    </form>

    {{-- Tùy chọn chuyển đổi vai trò --}}
    <div class="mt-6 pt-4 border-t text-center text-sm">
        <p class="text-gray-500">Bạn là nhà tuyển dụng?</p>
        <a href="{{ route('employers.login') }}" class="font-medium text-indigo-600 hover:text-indigo-800">
            Đăng nhập vào trang Nhà Tuyển Dụng
        </a>
    </div>
</x-custom-guest-layout>
