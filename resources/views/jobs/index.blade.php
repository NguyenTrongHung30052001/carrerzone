<x-app-layout>
    {{-- PHẦN 1: HEADER (Sử dụng header của app.layout) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Việc làm theo Ngành nghề') }}
        </h2>
    </x-slot>

    {{-- =============================================== --}}
    {{-- PHẦN 2: DANH SÁCH NGÀNH NGHỀ (Đã cập nhật) --}}
    {{-- =============================================== --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    <h1 class="text-3xl font-bold mb-6 text-gray-800">Tìm việc làm theo ngành nghề</h1>

                    @if ($categories->isEmpty())
                        <p class="text-center text-gray-500">Chưa có ngành nghề nào được hiển thị.</p>
                    @else
                        <div class="columns-1 md:columns-2 lg:columns-4 gap-x-6">
                            
                            @foreach ($categories as $category)
                                <div class="space-y-2 break-inside-avoid mb-6"> 
                                    
                                    {{-- Danh mục cha (Đã xóa href) --}}
                                    <h3 class="text-lg font-semibold text-indigo-700 border-b pb-2">
                                        {{ $category->ten_nganh_nghe }}
                                    </h3>
                                    
                                    {{-- Danh mục con --}}
                                    <ul class="space-y-2">
                                        @foreach ($category->children as $child)
                                            <li class="flex justify-between items-start space-x-2">
                                                {{-- 
                                                    ĐÃ SỬA:
                                                    - Dùng cú pháp mảng ['slug' => $child->slug]
                                                    - Thêm kiểm tra ($child->slug) để tránh lỗi nếu slug = null
                                                --}}
                                                <a href="{{ $child->slug ? route('jobs.showByProfession', ['slug' => $child->slug]) : '#' }}" 
                                                   class="text-gray-600 hover:text-indigo-600" 
                                                   title="{{ $child->ten_nganh_nghe }}">
                                                    {{ $child->ten_nganh_nghe }}
                                                </a>
                                                
                                                <span class="text-sm font-medium text-[#00b2a3] flex-shrink-0">
                                                    ({{ $child->posts_count }})
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>