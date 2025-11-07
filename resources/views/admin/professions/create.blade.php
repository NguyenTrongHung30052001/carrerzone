<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tạo mới Ngành nghề') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{--
                        Sử dụng Alpine.js để ẩn/hiện dropdown 'parent_id'
                        x-data="{ isCategory: false }"
                    --}}
                    <form method="POST" action="{{ route('admin.professions.store') }}" x-data="{ isCategory: {{ old('is_category', 'false') == 'true' ? 'true' : 'false' }} }">
                        @csrf

                        <!-- Tên ngành nghề -->
                        <div>
                            <label for="ten_nganh_nghe" class="block font-medium text-sm text-gray-700">Tên ngành nghề</label>
                            <input id="ten_nganh_nghe" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="ten_nganh_nghe" value="{{ old('ten_nganh_nghe') }}" required autofocus />
                        </div>

                        <!-- Checkbox: Là danh mục -->
                        <div class="block mt-4">
                            <label for="is_category" class="inline-flex items-center">
                                <input id="is_category" type="checkbox"
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                       name="is_category" value="true"
                                       @click="isCategory = !isCategory"
                                       :checked="isCategory">
                                <span class="ms-2 text-sm text-gray-600">Đây là danh mục (cha)?</span>
                            </label>
                        </div>

                        <!-- Dropdown Danh mục cha -->
                        {{-- 
                            Chỉ hiển thị (x-show) khi KHÔNG PHẢI (IS NOT) là danh mục
                            (!isCategory)
                        --}}
                        <div class="mt-4" x-show="!isCategory" style="display: none;">
                            <label for="parent_id" class="block font-medium text-sm text-gray-700">Thuộc danh mục cha</label>
                            <select name="parent_id" id="parent_id" 
                                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                    {{-- Yêu cầu (required) chỉ khi nó đang hiển thị --}}
                                    :required="!isCategory"> 
                                <option value="">-- Chọn danh mục cha --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->ten_nganh_nghe }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Chỉ hiển thị nếu đây KHÔNG phải là danh mục.</p>
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.professions.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Hủy
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Lưu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>