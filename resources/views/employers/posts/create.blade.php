<x-employers-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tạo tin đăng tuyển dụng mới') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    {{-- Hiển thị lỗi validation (nếu có) --}}
                    @if ($errors->any())
                        <div class="mb-6">
                            <div class="font-medium text-red-600">Rất tiếc! Đã xảy ra lỗi.</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('employers.posts.store') }}">
                        @csrf
                        
                        {{-- Dữ liệu form với Alpine.js --}}
                        <div x-data="{ 
                                luongCurrency: '{{ old('luong_currency', 'VNĐ') }}', 
                                luongHienThi: {{ old('luong_hien_thi', 'true') == 'true' ? 'true' : 'false' }},
                                wards: [],
                                selectedWard: '{{ old('ward_id') }}'
                            }"
                             class="space-y-6">

                            <!-- Chức danh tuyển dụng -->
                            <div>
                                <x-input-label for="chuc_danh" :value="__('Chức danh tuyển dụng')" />
                                <x-text-input id="chuc_danh" class="block mt-1 w-full" type="text" name="chuc_danh" :value="old('chuc_danh')" required autofocus />
                            </div>

                            <!-- Ngành nghề -->
                            <div class="mt-4">
                                <x-input-label for="profession_id" :value="__('Ngành nghề')" />
                                <select name="profession_id" id="profession_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">-- Chọn ngành nghề --</option>
                                    @foreach ($categories as $category)
                                        <optgroup label="{{ $category->ten_nganh_nghe }}">
                                            @foreach ($category->children as $child)
                                                <option value="{{ $child->id }}" {{ old('profession_id') == $child->id ? 'selected' : '' }}>
                                                    {{ $child->ten_nganh_nghe }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('profession_id')" class="mt-2" />
                            </div>

                            <!-- Nơi làm việc -->
                            <div class="mt-4 border-t pt-4">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Nơi làm việc</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <!-- Tỉnh/Thành phố -->
                                    <div>
                                        <x-input-label for="province_id" :value="__('Tỉnh/Thành phố')" />
                                        <select name="province_id" id="province_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required
                                                @change="loadWards($event.target.value)">
                                            <option value="">-- Chọn Tỉnh/Thành --</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                                    {{ $province->ten_tinh_thanh_pho }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Phường/Xã -->
                                    <div>
                                        <x-input-label for="ward_id" :value="__('Phường/Xã')" />
                                        <select name="ward_id" id="ward_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required :disabled="wards.length === 0">
                                            <option value="">-- Vui lòng chọn Tỉnh/Thành --</option>
                                            <template x-for="ward in wards" :key="ward.id">
                                                <option :value="ward.id" :selected="ward.id == selectedWard" x-text="ward.ten_xa_phuong"></option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <!-- Địa chỉ (tự nhập) -->
                                <div class="mt-4">
                                    <x-input-label for="dia_chi_lam_viec" :value="__('Địa chỉ (Số nhà, tên đường)')" />
                                    <x-text-input id="dia_chi_lam_viec" class="block mt-1 w-full" type="text" name="dia_chi_lam_viec" :value="old('dia_chi_lam_viec')" required />
                                </div>
                            </div>

                            <!-- Mô tả công việc -->
                            <div class="mt-4">
                                <x-input-label for="mo_ta_cong_viec" :value="__('Mô tả công việc')" />
                                <textarea id="mo_ta_cong_viec" name="mo_ta_cong_viec" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="5" required>{{ old('mo_ta_cong_viec') }}</textarea>
                            </div>

                            <!-- Yêu cầu công việc -->
                            <div class="mt-4">
                                <x-input-label for="yeu_cau_cong_viec" :value="__('Yêu cầu công việc')" />
                                <textarea id="yeu_cau_cong_viec" name="yeu_cau_cong_viec" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="5" required>{{ old('yeu_cau_cong_viec') }}</textarea>
                            </div>

                            <!-- Lương -->
                            <div class="mt-4 border-t pt-4">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Lương</h3>
                                <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <!-- Loại tiền tệ -->
                                    <div>
                                        <x-input-label for="luong_currency" :value="__('Loại tiền tệ')" />
                                        <select name="luong_currency" id="luong_currency" x-model="luongCurrency" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="VNĐ">VNĐ</option>
                                            <option value="USD">USD</option>
                                        </select>
                                    </div>
                                    <!-- Từ (lương) -->
                                    <div>
                                        <x-input-label for="luong_from" :value="__('Từ')" />
                                        <x-text-input id="luong_from" class="block mt-1 w-full" type="number" name="luong_from" :value="old('luong_from')" />
                                    </div>
                                    <!-- Đến (lương) -->
                                    <div>
                                        <x-input-label for="luong_to" :value="__('Đến')" />
                                        <x-text-input id="luong_to" class="block mt-1 w-full" type="number" name="luong_to" :value="old('luong_to')" required />
                                    </div>
                                </div>
                                <!-- Hiển thị mức lương -->
                                <div class="mt-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="luong_hien_thi" class="rounded border-gray-300 text-indigo-600 shadow-sm" x-model="luongHienThi" value="true">
                                        <span class="ms-2 text-sm text-gray-700">Hiển thị mức lương trên tin tuyển dụng</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Hình thức (Checkbox nhiều lựa chọn) -->
                            <div class="mt-4">
                                <x-input-label :value="__('Hình thức làm việc')" />
                                <div class="mt-2 space-y-2">
                                    @php
                                        $hinh_thuc_options = ['Nhân viên chính thức', 'Bán thời gian', 'Thời vụ - Nghề tự do', 'Thực tập'];
                                        $old_hinh_thuc = old('hinh_thuc', []);
                                    @endphp
                                    @foreach ($hinh_thuc_options as $option)
                                    <label class="inline-flex items-center mr-4">
                                        <input type="checkbox" name="hinh_thuc[]" value="{{ $option }}" 
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm"
                                               @if(is_array($old_hinh_thuc) && in_array($option, $old_hinh_thuc)) checked @endif>
                                        <span class="ms-2 text-sm text-gray-700">{{ $option }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Hạn chót nhận hồ sơ -->
                            <div class="mt-4">
                                <x-input-label for="han_chot_nop_ho_so" :value="__('Hạn chót nhận hồ sơ')" />
                                <x-text-input id="han_chot_nop_ho_so" class="block mt-1 w-full" type="date" name="han_chot_nop_ho_so" :value="old('han_chot_nop_ho_so')" required />
                            </div>

                            <!-- Yêu cầu thư giới thiệu -->
                            <div class="mt-4">
                                <x-input-label for="yeu_cau_thu_gioi_thieu" :value="__('Yêu cầu thư giới thiệu')" />
                                <select name="yeu_cau_thu_gioi_thieu" id="yeu_cau_thu_gioi_thieu" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach (['Bắt buộc', 'Hiển thị nhưng không bắt buộc', 'Không hiển thị'] as $option)
                                        <option value="{{ $option }}" {{ old('yeu_cau_thu_gioi_thieu') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Ngôn ngữ hồ sơ -->
                            <div class="mt-4">
                                <x-input-label :value="__('Ngôn ngữ trình bày hồ sơ')" />
                                <div class="mt-2 space-y-2">
                                    @php
                                        $ngon_ngu_options = ['Tiếng Anh', 'Tiếng Việt', 'Tiếng Pháp', 'Tiếng Trung', 'Tiếng Nhật', 'Tiếng Hàn Quốc'];
                                        $old_ngon_ngu = old('ngon_ngu_ho_so', []);
                                    @endphp
                                    @foreach ($ngon_ngu_options as $option)
                                    <label class="inline-flex items-center mr-4">
                                        <input type="checkbox" name="ngon_ngu_ho_so[]" value="{{ $option }}" 
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm"
                                               @if(is_array($old_ngon_ngu) && in_array($option, $old_ngon_ngu)) checked @endif>
                                        <span class="ms-2 text-sm text-gray-700">{{ $option }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Giới tính, Tuổi, Kinh nghiệm, Cấp bậc, Bằng cấp -->
                            <div class="mt-4 border-t pt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Giới tính -->
                                <div>
                                    <x-input-label for="gioi_tinh" :value="__('Giới tính')" />
                                    <select name="gioi_tinh" id="gioi_tinh" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        @foreach (['Nam/Nữ', 'Nam', 'Nữ'] as $option)
                                            <option value="{{ $option }}" {{ old('gioi_tinh') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Kinh nghiệm -->
                                <div>
                                    <x-input-label for="kinh_nghiem" :value="__('Kinh nghiệm')" />
                                    <select name="kinh_nghiem" id="kinh_nghiem" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        @foreach (['Không yêu cầu kinh nghiệm', 'Có kinh nghiệm', 'Chưa có kinh nghiệm'] as $option)
                                            <option value="{{ $option }}" {{ old('kinh_nghiem') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Tuổi từ -->
                                <div>
                                    <x-input-label for="tuoi_from" :value="__('Tuổi từ')" />
                                    <x-text-input id="tuoi_from" class="block mt-1 w-full" type="number" name="tuoi_from" :value="old('tuoi_from')" />
                                </div>
                                <!-- Tuổi đến -->
                                <div>
                                    <x-input-label for="tuoi_to" :value="__('Đến tuổi')" />
                                    <x-text-input id="tuoi_to" class="block mt-1 w-full" type="number" name="tuoi_to" :value="old('tuoi_to')" />
                                </div>
                                <!-- Cấp bậc -->
                                <div>
                                    <x-input-label for="cap_bac" :value="__('Cấp bậc')" />
                                    <select name="cap_bac" id="cap_bac" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        @foreach (['Sinh viên/ Thực tập sinh', 'Mới tốt nghiệp', 'Nhân viên', 'Trưởng nhóm / Giám sát', 'Quản lý', 'Phó Giám đốc', 'Giám đốc', 'Tổng giám đốc', 'Chủ tịch / Phó Chủ tịch'] as $option)
                                            <option value="{{ $option }}" {{ old('cap_bac') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Bằng cấp -->
                                <div>
                                    <x-input-label for="bang_cap" :value="__('Bằng cấp')" />
                                    <select name="bang_cap" id="bang_cap" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        @foreach (['Không yêu cầu bằng cấp', 'Trung học', 'Trung cấp', 'Cao đẳng', 'Đại học', 'Sau đại học', 'Khác'] as $option)
                                            <option value="{{ $option }}" {{ old('bang_cap') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Thông tin khác -->
                            <div class="mt-4">
                                <x-input-label for="thong_tin_khac" :value="__('Thông tin khác (nếu có)')" />
                                <textarea id="thong_tin_khac" name="thong_tin_khac" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ old('thong_tin_khac') }}</textarea>
                            </div>

                            <div class="flex items-center justify-end mt-6 border-t pt-6">
                                <a href="{{ route('employers.posts.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                    Hủy
                                </a>
                                <x-primary-button>
                                    Đăng tin
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Hàm loadWards cần được định nghĩa toàn cục hoặc bên ngoài x-data nếu bạn
            // muốn gọi nó từ @change
            function loadWards(provinceId) {
                let wardSelect = document.getElementById('ward_id');
                let selectedWard = '{{ old("ward_id") }}'; // Lấy ward_id cũ

                // Xóa các lựa chọn cũ
                wardSelect.innerHTML = '<option value="">-- Đang tải... --</option>';
                wardSelect.disabled = true;

                if (provinceId) {
                    // Gọi API
                    fetch('/api/wards/' + provinceId)
                        .then(response => response.json())
                        .then(data => {
                            wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
                            data.forEach(ward => {
                                let option = document.createElement('option');
                                option.value = ward.id;
                                option.textContent = ward.ten_xa_phuong;
                                // Kiểm tra xem ward này có phải là ward đã chọn trước đó không
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

            // Kích hoạt sự kiện 'change' khi tải trang nếu province đã được chọn (trường hợp validation fail)
            document.addEventListener('DOMContentLoaded', function() {
                let provinceSelect = document.getElementById('province_id');
                if (provinceSelect.value) {
                    // Chúng ta cần gọi hàm loadWards và truyền giá trị đã chọn
                    loadWards(provinceSelect.value);
                }
            });
        </script>
    </div>
</x-employers-layout>