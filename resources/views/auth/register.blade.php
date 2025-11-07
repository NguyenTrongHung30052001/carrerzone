<x-custom-guest-layout>
    {{-- Tabs Đăng nhập / Đăng ký --}}
    <div class="mb-8 border-b border-gray-300">
        <div class="flex justify-center space-x-8 -mb-px">
            {{-- Tab Đăng nhập (Inactive) --}}
            <a href="{{ route('login') }}" class="py-2 px-4 text-lg font-semibold text-gray-500 border-b-2 border-transparent hover:text-indigo-600 hover:border-indigo-600 transition duration-150">
                Đăng nhập
            </a>
            {{-- Tab Đăng ký (Active) --}}
            <a href="{{ route('register') }}" class="py-2 px-4 text-lg font-semibold border-b-2 border-indigo-600 text-indigo-600">
                Đăng ký
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Họ và tên lót -->
        <div>
            <x-input-label for="ho_va_ten_lot" value="Họ và tên lót" />
            <x-text-input id="ho_va_ten_lot" class="block mt-1 w-full" type="text" name="ho_va_ten_lot" :value="old('ho_va_ten_lot')" required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('ho_va_ten_lot')" class="mt-2" />
        </div>

        <!-- Tên -->
        <div class="mt-4">
            <x-input-label for="ten" value="Tên" />
            <x-text-input id="ten" class="block mt-1 w-full" type="text" name="ten" :value="old('ten')" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('ten')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mật khẩu')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Xác nhận Mật khẩu')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- START CHECKBOX ĐỒNG Ý ĐIỀU KHOẢN --}}
        <div class="mt-4">
            <label for="terms" class="inline-flex items-start text-sm text-gray-700 space-x-2">
                <input id="terms" type="checkbox" name="terms" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm mt-1">
                <span class="ms-2 leading-snug">
                    Tôi xác nhận đã được thông báo về việc xử lý thông tin cá nhân của mình theo 
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-800 underline">Thông báo về việc xử lý dữ liệu cá nhân</a> của CareerViet. 
                    Tôi đồng thời xác nhận đã đọc, hiểu, và đồng ý cung cấp thông tin cá nhân và đồng ý với việc xử lý dữ liệu cá nhân của mình theo 
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-800 underline">Điều Khoản Sử Dụng</a> và 
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-800 underline">Chính Sách Quyền Riêng Tư</a> của CareerViet.
                </span>
            </label>
            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
        </div>
        {{-- END CHECKBOX ĐỒNG Ý ĐIỀU KHOẢN --}}

        <div class="flex flex-col items-center justify-end mt-6 space-y-3">
            <x-primary-button class="w-full justify-center py-3 bg-red-600 hover:bg-red-700">
                Đăng ký ngay
            </x-primary-button>
        </div>
    </form>
    
    {{-- Tùy chọn chuyển đổi vai trò --}}
    <div class="mt-6 pt-4 border-t text-center text-sm">
        <p class="text-gray-500">Bạn đã có tài khoản?</p>
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-800">
            Đăng nhập ngay
        </a>
    </div>

</x-custom-guest-layout>