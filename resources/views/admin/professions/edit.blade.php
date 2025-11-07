<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cập nhật Ngành nghề') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- 
                    SỬA LỖI:
                    1. Đơn giản hóa x-data.
                    2. Sửa lại logic checkbox cho nhất quán.
                --}}
                <div class="p-6 text-gray-900" 
                     x-data="{ 
                        isCategory: {{ old('is_category', $profession->is_category) ? 'true' : 'false' }} 
                     }">
                    
                    {{-- Hiển thị lỗi validation (nếu có) --}}
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.professions.update', $profession) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Tên ngành nghề -->
                        <div>
                            <label for="ten_nganh_nghe" class="block font-medium text-sm text-gray-700">Tên ngành nghề</label>
                            {{-- 
                                Dữ liệu ($profession->ten_nganh_nghe) sẽ tự động điền vào đây
                                sau khi bạn sửa Controller
                            --}}
                            <input id="ten_nganh_nghe" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="ten_nganh_nghe" value="{{ old('ten_nganh_nghe', $profession->ten_nganh_nghe) }}" required />
                        </div>

                        <!-- Checkbox "Là danh mục" -->
                        <div class="mt-4">
                            <label for="is_category_checkbox" class="inline-flex items-center">
                                <input id="is_category_checkbox" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm" name="is_category" x-model="isCategory">
                                <span class="ms-2 text-sm text-gray-700">Đây là danh mục (cha)</span>
                            </label>
                        </div>

                        <!-- Danh mục cha -->
                        <div class="mt-4" x-show="!isCategory" x-transition>
                            <label for="parent_id" class="block font-medium text-sm text-gray-700">Danh mục cha</label>
                            <select name="parent_id" id="parent_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" :disabled="isCategory">
                                <option value="">-- Chọn danh mục --</option>
                                {{-- 
                                    Dropdown này sẽ tự động điền sau khi bạn sửa Controller
                                --}}
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('parent_id', $profession->parent_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->ten_nganh_nghe }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Trạng thái -->
                        <div class="mt-4">
                            <label for="trang_thai" class="block font-medium text-sm text-gray-700">Trạng thái</label>
                            <select name="trang_thai" id="trang_thai" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="enable" {{ old('trang_thai', $profession->trang_thai) == 'enable' ? 'selected' : '' }}>
                                    Hiện
                                </option>
                                <option value="disable" {{ old('trang_thai', $profession->trang_thai) == 'disable' ? 'selected' : '' }}>
                                    Ẩn
                                </option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.professions.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Hủy
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>