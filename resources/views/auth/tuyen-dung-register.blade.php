<x-employers-guest-layout>
    {{-- Tabs Đăng nhập / Đăng ký --}}
    <div class="mb-8 border-b border-gray-300">
        <div class="flex justify-center space-x-8 -mb-px">
            {{-- Tab Đăng nhập (Inactive) --}}
            <a href="{{ route('employers.login') }}" class="py-2 px-4 text-lg font-semibold text-gray-500 border-b-2 border-transparent hover:text-indigo-600 hover:border-indigo-600 transition duration-150">
                Đăng nhập
            </a>
            {{-- Tab Đăng ký (Active) --}}
            <a href="{{ route('employers.register') }}" class="py-2 px-4 text-lg font-semibold border-b-2 border-indigo-600 text-indigo-600">
                Đăng ký
            </a>
        </div>
    </div>

    {{-- Hiển thị lỗi validation (nếu có) --}}
    @if ($errors->any())
        <div class="mb-4">
            <div class="font-medium text-red-600">Rất tiếc! Đã xảy ra lỗi.</div>
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 
        Do form đăng ký Nhà Tuyển Dụng quá dài, chúng ta sẽ để nó cuộn (scroll) 
        nếu nội dung vượt quá chiều cao.
    --}}
    <div class="max-h-[60vh] overflow-y-auto pr-4">
        <form method="POST" action="{{ route('employers.register') }}" class="space-y-6" x-data="{ wards: [], selectedWard: '{{ old('ward_id') }}' }">
            @csrf

            <!-- Tên công ty -->
            <div>
                <x-input-label for="ten_cong_ty" :value="__('Tên công ty')" />
                <x-text-input id="ten_cong_ty" class="block mt-1 w-full" type="text" name="ten_cong_ty" :value="old('ten_cong_ty')" required autofocus />
                <x-input-error :messages="$errors->get('ten_cong_ty')" class="mt-2" />
            </div>
            
            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email (Dùng để đăng nhập)')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Mật khẩu -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mật khẩu')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Xác nhận Mật khẩu -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            
            <div class="border-t pt-6 space-y-6">
                <!-- Loại hình hoạt động -->
                <div>
                    <x-input-label for="operation_type" :value="__('Loại hình hoạt động')" />
                    <select name="operation_type" id="operation_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Chọn loại hình --</option>
                        @foreach ($operation_types as $type)
                            <option value="{{ $type }}" {{ old('operation_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('operation_type')" class="mt-2" />
                </div>

                <!-- Số nhân viên -->
                <div>
                    <x-input-label for="total_employees" :value="__('Số nhân viên')" />
                    <select name="total_employees" id="total_employees" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Chọn số nhân viên --</option>
                        @foreach ($employee_counts as $count)
                            <option value="{{ $count }}" {{ old('total_employees') == $count ? 'selected' : '' }}>{{ $count }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('total_employees')" class="mt-2" />
                </div>
                
                <!-- Tỉnh/Thành phố -->
                <div>
                    <x-input-label for="province_id" :value="__('Tỉnh/Thành phố')" />
                    <select name="province_id" id="province_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required
                            @change="loadWards($event.target.value)">
                        <option value="">-- Chọn Tỉnh/Thành --</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                {{ $province->ten_tinh_thanh_pho }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('province_id')" class="mt-2" />
                </div>

                <!-- Phường/Xã -->
                <div>
                    <x-input-label for="ward_id" :value="__('Phường/Xã')" />
                    <select name="ward_id" id="ward_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required :disabled="wards.length === 0">
                        <option value="">-- Vui lòng chọn Tỉnh/Thành --</option>
                        <template x-for="ward in wards" :key="ward.id">
                            <option :value="ward.id" :selected="ward.id == selectedWard" x-text="ward.ten_xa_phuong"></option>
                        </template>
                    </select>
                    <x-input-error :messages="$errors->get('ward_id')" class="mt-2" />
                </div>

                <!-- Địa chỉ (Số nhà, tên đường) -->
                <div>
                    <x-input-label for="address" :value="__('Địa chỉ (Số nhà, tên đường)')" />
                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
                
                <!-- Giới thiệu công ty -->
                <div>
                    <x-input-label for="company_introduction" :value="__('Giới thiệu công ty')" />
                    <textarea id="company_introduction" name="company_introduction" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ old('company_introduction') }}</textarea>
                    <x-input-error :messages="$errors->get('company_introduction')" class="mt-2" />
                </div>
                
                <!-- Tên người liên hệ -->
                <div>
                    <x-input-label for="contact_name" :value="__('Tên người liên hệ')" />
                    <x-text-input id="contact_name" class="block mt-1 w-full" type="text" name="contact_name" :value="old('contact_name')" />
                    <x-input-error :messages="$errors->get('contact_name')" class="mt-2" />
                </div>
                
                <!-- Điện thoại liên hệ -->
                <div>
                    <x-input-label for="phone" :value="__('Điện thoại liên hệ')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
                
                <!-- Mã số thuế -->
                <div>
                    <x-input-label for="tax_code" :value="__('Mã số thuế')" />
                    <x-text-input id="tax_code" class="block mt-1 w-full" type="text" name="tax_code" :value="old('tax_code')" required />
                    <x-input-error :messages="$errors->get('tax_code')" class="mt-2" />
                </div>
            </div>

            <div class="flex flex-col items-center justify-end mt-6 space-y-3">
                <x-primary-button class="w-full justify-center py-3 bg-red-600 hover:bg-red-700">
                    Đăng ký Nhà Tuyển Dụng
                </x-primary-button>
            </div>
            
        </form>
    </div>

    {{-- Tùy chọn chuyển đổi vai trò --}}
    <div class="mt-6 pt-4 border-t text-center text-sm">
        <p class="text-gray-500">Bạn là ứng viên?</p>
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-800">
            Đăng nhập trang Ứng viên
        </a>
    </div>

    <script>
        // Hàm loadWards (AJAX)
        function loadWards(provinceId) {
            let wardSelect = document.getElementById('ward_id');
            let selectedWard = '{{ old("ward_id") }}';

            wardSelect.innerHTML = '<option value="">-- Đang tải... --</option>';
            wardSelect.disabled = true;

            if (provinceId) {
                fetch('/api/wards/' + provinceId)
                    .then(response => response.json())
                    .then(data => {
                        wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
                        data.forEach(ward => {
                            let option = document.createElement('option');
                            option.value = ward.id;
                            option.textContent = ward.ten_xa_phuong;
                            if (ward.id == selectedWard) {
                                option.selected = true;
                            }
                            wardSelect.appendChild(option);
                        });
                        wardSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching wards:', error);
                        wardSelect.innerHTML = '<option value="">-- Lỗi khi tải Phường/Xã --</option>';
                    });
            } else {
                wardSelect.innerHTML = '<option value="">-- Vui lòng chọn Tỉnh/Thành trước --</option>';
            }
        }

        // Tự động tải phường/xã nếu có Tỉnh/Thành được chọn (khi validation fail)
        document.addEventListener('DOMContentLoaded', function() {
            let provinceSelect = document.getElementById('province_id');
            if (provinceSelect.value) {
                loadWards(provinceSelect.value);
            }
        });
    </script>
</x-employers-guest-layout>