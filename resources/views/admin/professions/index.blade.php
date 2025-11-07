<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Quản lý Ngành nghề') }}
            </h2>
            <a href="{{ route('admin.professions.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                Tạo mới
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Hiển thị thông báo thành công (nếu có) --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Hiển thị các Ngành nghề CHA (Danh mục) --}}
            <div class="space-y-8">
                @forelse ($categories as $category)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="text-lg font-medium text-indigo-700">{{ $category->ten_nganh_nghe }}</h4>
                                    {{-- <span class="text-sm text-gray-500">(Danh mục cha)</span> --}}
                                </div>
                                <div>
                                    @if ($category->trang_thai == 'enable')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hiện</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ẩn</span>
                                    @endif
                                    <a href="{{ route('admin.professions.edit', $category) }}" class="ml-4 text-indigo-600 hover:text-indigo-900">Sửa</a>
                                </div>
                            </div>
                        </div>

                        {{-- Hiển thị các Ngành nghề CON của danh mục này --}}
                        <div class="p-6 text-gray-900">
                            @if ($category->children->isEmpty())
                                <p class="text-sm text-gray-500">Chưa có ngành nghề con trong danh mục này.</p>
                            @else
                                <ul class="list-disc list-inside space-y-2">
                                    @foreach ($category->children as $child)
                                        <li class="flex justify-between items-center">
                                            <div>
                                                <span>{{ $child->ten_nganh_nghe }}</span>
                                            </div>
                                            <div>
                                                @if ($child->trang_thai == 'enable')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hiện</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ẩn</span>
                                                @endif
                                                <a href="{{ route('admin.professions.edit', $child) }}" class="ml-4 text-indigo-600 hover:text-indigo-900">Sửa</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                           Bạn chưa tạo danh mục ngành nghề nào.
                        </div>
                    </div>
                @endforelse

                {{-- Hiển thị các Ngành nghề KHÔNG có cha (Nếu có) --}}
                @if ($orphans->isNotEmpty())
                     <div class="bg-yellow-50 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-yellow-900 border-b border-yellow-200">
                            <h3 class="text-lg font-medium text-yellow-700">Ngành nghề chưa phân loại</h3>
                            <span class="text-sm text-yellow-600">(Các ngành nghề này chưa được gán vào danh mục cha)</span>
                        </div>
                        <div class="p-6 text-gray-900">
                            <ul class="list-disc list-inside space-y-2">
                                @foreach ($orphans as $orphan)
                                    <li class="flex justify-between items-center">
                                        <div>
                                            <span>{{ $orphan->ten_nganh_nghe }}</span>
                                        </div>
                                        <div>
                                            @if ($orphan->trang_thai == 'enable')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hiện</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ẩn</span>
                                            @endif
                                            <a href="{{ route('admin.professions.edit', $orphan) }}" class="ml-4 text-indigo-600 hover:text-indigo-900">Sửa (Gán vào danh mục)</a>
                                        </li>
                                    @endforeach
                                </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>