<x-employers-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thông tin công ty') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- =============================================== --}}
            {{-- BẮT ĐẦU: PHẦN CẬP NHẬT LOGO --}}
            {{-- =============================================== --}}
            <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-lg">
                <div class="max-w-xl">
                    
                    <section x-data="{ logoPreview: null }">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Logo Công ty') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Cập nhật logo đại diện cho công ty của bạn.") }}
                            </p>
                        </header>

                        {{-- Hiển thị thông báo thành công (nếu có) --}}
                        @if (session('status') === 'logo-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="mt-4 text-sm font-medium text-green-600"
                            >{{ __('Đã lưu logo thành công.') }}</p>
                        @endif

                        {{-- Form tải lên (Lưu ý enctype) --}}
                        <form method="post" action="{{ route('employers.profile.updateLogo') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            @method('put') {{-- Sử dụng PUT cho việc cập nhật tài nguyên con --}}

                            {{-- Hiển thị Logo hiện tại / Xem trước --}}
                            <div class="col-span-6 sm:col-span-4">
                                <!-- Logo hiện tại -->
                                <div x-show="!logoPreview">
                                    @if (Auth::guard('tuyen_dung')->user()->logo)
                                        <img src="{{ Auth::guard('tuyen_dung')->user()->logo }}" alt="{{ Auth::guard('tuyen_dung')->user()->ten_cong_ty }}" class="rounded-md h-32 w-32 object-contain border border-gray-200 p-2">
                                    @else
                                        <div class="rounded-md h-32 w-32 bg-gray-100 flex items-center justify-center text-gray-500 border border-gray-200">
                                            (Chưa có logo)
                                        </div>
                                    @endif
                                </div>
                                <!-- Xem trước Logo mới -->
                                <div x-show="logoPreview" style="display: none;">
                                    <span class="block rounded-md w-32 h-32 bg-cover bg-no-repeat bg-center border border-gray-200 p-2"
                                          x-bind:style="'background-image: url(\'' + logoPreview + '\');'">
                                    </span>
                                </div>
                            </div>

                            <!-- Nút chọn Logo mới -->
                            <div>
                                <x-input-label for="logo" :value="__('Chọn logo mới')" />
                                <input id="logo" name="logo" type="file" class="mt-1 block w-full text-sm text-gray-700
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100
                                "
                                @change="
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        logoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($event.target.files[0]);
                                ">
                                <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Lưu Logo') }}</x-primary-button>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
            {{-- =============================================== --}}
            {{-- KẾT THÚC: PHẦN CẬP NHẬT LOGO --}}
            {{-- =============================================== --}}

            {{-- (Bạn có thể thêm các phần khác như Thông tin chung, Mật khẩu... vào đây sau) --}}

        </div>
    </div>
</x-employers-layout>