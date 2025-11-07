<x-app-layout>
    {{-- PHẦN 1: THANH TÌM KIẾM (Search Bar) --}}
    <div class="bg-indigo-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold mb-4 text-center">Tìm kiếm cơ hội, nắm bắt tương lai</h1>
            <p class="text-center text-indigo-100 mb-8">Hơn 10,000+ việc làm đang chờ bạn.</p>
            
            <form action="#" method="GET">
                <div class="flex flex-col md:flex-row gap-2 max-w-3xl mx-auto bg-white p-2 rounded-lg shadow-2xl">
                    <input 
                        type="text" 
                        name="keyword" 
                        placeholder="Chức danh, Kỹ năng, Tên công ty..."
                        class="flex-grow w-full md:w-1/2 px-4 py-3 border-0 text-gray-700 focus:ring-indigo-500 rounded-md"
                    >
                    <button 
                        type="submit" 
                        class="w-full md:w-auto px-6 py-3 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 transition duration-200"
                    >
                        Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- PHẦN 2: NHÀ TUYỂN DỤNG HÀNG ĐẦU (Top Employers) --}}
    {{-- =============================================== --}}
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    {{-- Tiêu đề Section --}}
                    <h2 class="text-2xl font-bold text-center text-indigo-800 mb-8">
                        NHÀ TUYỂN DỤNG HÀNG ĐẦU
                    </h2>

                    @if ($topEmployers->isEmpty())
                        <p class="text-center text-gray-500">Chưa có nhà tuyển dụng nào được hiển thị.</p>
                    @else
                        {{-- 
                            ĐÃ SỬA (Change 1 & 2): 
                            - 8 cột trên desktop (lg:grid-cols-8)
                            - 4 cột trên mobile (grid-cols-4)
                        --}}
                        <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
                            @foreach ($topEmployers as $employer)
                                <a href="#" class="flex items-center justify-center p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition duration-200 h-28">
                                    {{-- 
                                        ĐÃ SỬA (Change 3):
                                        - Đã xóa khối @else để "để trống luôn" nếu không có logo
                                    --}}
                                    @if ($employer->logo)
                                        <img src="{{ $employer->logo }}" alt="{{ $employer->ten_cong_ty }}" class="max-h-full max-w-full object-contain">
                                    @endif
                                    {{-- Nếu không có logo, thẻ <a> này sẽ trống --}}
                                </a>
                            @endforeach
                        </div>

                        {{-- =============================================== --}}
                        {{-- NÚT XEM THÊM (ĐÃ SỬA VỊ TRÍ) --}}
                        {{-- =============================================== --}}
                        <div class="flex justify-end mt-6">
                            {{-- 
                                ĐÃ SỬA (Change 4):
                                - Sửa route 'company.list' thành 'companies.index'
                            --}}
                            <a href="{{ route('companies.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center">
                                Xem thêm
                                {{-- Thêm icon mũi tên --}}
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    {{-- (Các phần khác của Dashboard sẽ được thêm vào đây) --}}

</x-app-layout>