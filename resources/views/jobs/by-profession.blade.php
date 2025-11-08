<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Việc làm ') . $profession->ten_nganh_nghe }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    {{-- Header của trang danh sách --}}
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                        <h1 class="text-2xl font-bold text-indigo-800">
                            {{ $posts->total() }} việc làm {{ $profession->ten_nganh_nghe }}
                        </h1>
                         <a href="{{ route('jobs.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 flex items-center transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                            Quay lại danh sách ngành nghề
                        </a>
                    </div>

                    @if ($posts->isEmpty())
                        <div class="text-center py-12">
                             <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Chưa có việc làm nào</h3>
                            <p class="mt-2 text-sm text-gray-500">Hiện tại chưa có tin tuyển dụng nào cho ngành nghề này. Vui lòng quay lại sau.</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($posts as $post)
                                {{-- CARD VIỆC LÀM --}}
                                <div class="bg-white border border-gray-200 hover:border-red-300 rounded-lg p-4 sm:p-6 shadow-sm hover:shadow-md transition-all duration-200 relative group">
                                    
                                    {{-- ======================================================================== --}}
                                    {{-- [MỚI] BUTTON ẨN PHỦ TOÀN BỘ CARD (Z-Index: 10) --}}
                                    {{-- ======================================================================== --}}
                                    <a href="{{ route('jobs.show', ['slug' => Str::slug($post->chuc_danh), 'id' => $post->id]) }}" 
                                       class="absolute inset-0 z-10"
                                       title="Xem chi tiết: {{ $post->chuc_danh }}">
                                        <span class="sr-only">Xem chi tiết bài đăng</span>
                                    </a>

                                    {{-- ACTIONS DESKTOP (Z-Index cao hơn: 20 để bấm được trên lớp phủ) --}}
                                    <div class="hidden sm:flex absolute top-6 right-6 items-center space-x-4 z-20">
                                        <button class="text-gray-400 hover:text-red-500 focus:outline-none transition-colors duration-200 relative" title="Lưu việc làm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                            </svg>
                                        </button>
                                        <a href="#" class="bg-red-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-red-700 transition-colors duration-200 relative">
                                            ỨNG TUYỂN NGAY
                                        </a>
                                    </div>

                                    <div class="flex items-start relative">
                                        {{-- LOGO --}}
                                        <div class="flex-shrink-0 mr-6 z-20 relative"> {{-- Thêm z-20 nếu muốn bấm logo vào trang cty --}}
                                            <a href="#" class="block h-28 w-28 border border-gray-100 rounded-lg overflow-hidden bg-white p-2 flex items-center justify-center transition-all duration-200 hover:border-gray-300">
                                                @if($post->employer && $post->employer->logo)
                                                    <img src="{{ $post->employer->logo }}" alt="{{ $post->ten_cong_ty }}" class="object-contain max-h-full max-w-full">
                                                @else
                                                     <div class="h-full w-full bg-gray-50 flex items-center justify-center text-gray-400 font-bold text-2xl">
                                                        {{ substr($post->ten_cong_ty, 0, 1) }}
                                                    </div>
                                                @endif
                                            </a>
                                        </div>

                                        {{-- NỘI DUNG --}}
                                        <div class="flex-grow">
                                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-red-600 transition-colors duration-200 leading-tight mb-1">
                                                {{ $post->chuc_danh }}
                                                @if($post->created_at->diffInDays(now()) < 3)
                                                    <span class="inline-block ml-2 text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full align-middle">(MỚI)</span>
                                                @endif
                                            </h3>

                                            {{-- Tên công ty (Z-Index 20 để bấm riêng được) --}}
                                            <p class="text-base text-gray-600 mb-3 line-clamp-1 relative z-20 w-fit" title="{{ $post->ten_cong_ty }}">
                                                <a href="#" class="hover:text-indigo-600 transition-colors duration-200">
                                                    {{ $post->ten_cong_ty }}
                                                </a>
                                            </p>

                                            {{-- Mức lương --}}
                                            <div class="flex items-center text-red-600 font-bold text-base mb-2">
                                                <span class="mr-2">$</span>
                                                Lương: 
                                                @if ($post->luong_hien_thi)
                                                    @if ($post->luong_from && $post->luong_to)
                                                        {{ number_format($post->luong_from / 1000000) }} Tr - {{ number_format($post->luong_to / 1000000) }} Tr {{ $post->luong_currency }}
                                                    @elseif ($post->luong_from)
                                                        Từ {{ number_format($post->luong_from / 1000000) }} Tr {{ $post->luong_currency }}
                                                    @elseif ($post->luong_to)
                                                        Đến {{ number_format($post->luong_to / 1000000) }} Tr {{ $post->luong_currency }}
                                                    @else
                                                        Thỏa thuận
                                                    @endif
                                                @else
                                                    Thỏa thuận
                                                @endif
                                            </div>

                                            {{-- Metadata --}}
                                            <div class="flex flex-wrap items-center text-sm text-gray-500 gap-x-6 gap-y-2 mb-3">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 text-gray-400">
                                                        <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.006.003.003.001a.75.75 0 01-.01-1.431l-.06-.031a10.342 10.342 0 01-.849-.47c-.533-.33-1.255-.836-1.985-1.538C5.193 13.87 4.5 11.982 4.5 9a5.5 5.5 0 0111 0c0 2.981-.693 4.87-2.213 6.358a8.84 8.84 0 01-1.985 1.538 10.341 10.341 0 01-.909.501l-.003.001.01.004zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $post->province->ten_tinh_thanh_pho ?? 'Toàn quốc' }}
                                                </div>
                                                <div class="flex items-center">
                                                    <div class="flex items-center mr-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 text-gray-400">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span>Hạn nộp: {{ $post->han_chot_nop_ho_so->format('d/m/Y') }}</span>
                                                    </div>
                                                    <span class="text-gray-300 mr-3">|</span>
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 text-gray-400">
                                                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span>Cập nhật: {{ $post->updated_at->format('d/m/Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Phúc lợi --}}
                                            @if($post->employer && $post->employer->benefits->count() > 0)
                                                <div class="flex flex-wrap items-center text-sm text-gray-600 gap-x-4 gap-y-2 relative z-0"> {{-- z-0 để không che overlay link nếu không cần bấm --}}
                                                    @foreach($post->employer->benefits->take(3) as $benefit)
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-1.5 text-gray-400">
                                                                <path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="truncate max-w-[150px]">{{ $benefit->ten_phuc_loi }}</span>
                                                        </div>
                                                    @endforeach
                                                    @if($post->employer->benefits->count() > 3)
                                                        <span class="text-xs text-gray-500">+{{ $post->employer->benefits->count() - 3 }} khác</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- ACTIONS MOBILE (Z-Index 20) --}}
                                    <div class="flex sm:hidden w-full mt-4 pt-4 border-t border-gray-100 justify-between items-center relative z-20">
                                        <button class="text-gray-400 hover:text-red-500 focus:outline-none flex items-center text-sm font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                            </svg>
                                            Lưu
                                        </button>
                                        <a href="#" class="bg-red-600 text-white px-4 py-2 rounded-md font-bold text-sm hover:bg-red-700 transition-colors duration-200">
                                            ỨNG TUYỂN NGAY
                                        </a>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $posts->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>