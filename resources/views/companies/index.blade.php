<x-app-layout>
    {{-- PHẦN 1: HEADER (Sử dụng header của app.layout) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Danh sách Công ty') }}
        </h2>
    </x-slot>

    {{-- =============================================== --}}
    {{-- PHẦN 2: DANH SÁCH CÔNG TY (Grid Layout) --}}
    {{-- =============================================== --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    <h1 class="text-3xl font-bold mb-6 text-gray-800">Tất cả Nhà Tuyển Dụng</h1>

                    @if ($allEmployers->isEmpty())
                        <p class="text-center text-gray-500">Chưa có nhà tuyển dụng nào được hiển thị.</p>
                    @else
                        {{-- Grid Layout --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($allEmployers as $employer)
                                <div class="flex flex-col bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition duration-200 overflow-hidden">
                                    {{-- Phần Header của Card (Logo và Tên) --}}
                                    <div class="flex items-center p-4 border-b">
                                        {{-- Logo (Placeholder nếu không có logo) --}}
                                        <div class="flex-shrink-0">
                                            @if ($employer->logo)
                                                <img src="{{ $employer->logo }}" alt="{{ $employer->ten_cong_ty }}" class="h-16 w-16 object-contain rounded-md border p-1">
                                            @else
                                                <div class="h-16 w-16 bg-gray-200 flex items-center justify-center rounded-md border p-1">
                                                    <span class="text-xl font-semibold text-gray-600">{{ substr($employer->ten_cong_ty, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold text-indigo-700 hover:text-indigo-900 line-clamp-2">
                                                {{-- Link này có thể trỏ đến trang chi tiết công ty sau --}}
                                                <a href="#">{{ $employer->ten_cong_ty }}</a>
                                            </h3>
                                            {{-- Hiển thị Tỉnh/Thành phố nếu có --}}
                                            @if ($employer->province)
                                                <p class="text-sm text-gray-500 mt-1">
                                                    <svg class="inline-block w-4 h-4 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    {{ $employer->province->ten_tinh_thanh_pho }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    {{-- Phần Giới thiệu (nếu có) --}}
                                    @if ($employer->company_introduction)
                                        <div class="p-4">
                                            <p class="text-sm text-gray-600 line-clamp-3">
                                                {{ $employer->company_introduction }}
                                            </p>
                                        </div>
                                    @endif
                                    
                                    {{-- Phần Footer của Card (Link xem việc làm - sẽ thêm sau) --}}
                                    <div class="p-4 bg-gray-50 border-t mt-auto text-right">
                                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                            Xem các việc làm
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- PHẦN PHÂN TRANG (PAGINATION) --}}
                        <div class="mt-8">
                            {{ $allEmployers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>