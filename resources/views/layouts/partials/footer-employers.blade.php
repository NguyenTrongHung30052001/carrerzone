{{-- =============================================== --}}
{{-- FOOTER CỦA NHÀ TUYỂN DỤNG --}}
{{-- =ia diện dựa trên mẫu careerviet.vn/vi/employers --}}
{{-- =============================================== --}}
<footer class="bg-gray-800 text-gray-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            {{-- Cột 1: Giới thiệu (Logo + Slogan) --}}
            <div>
                <a href="{{ route('employers.dashboard') }}" class="mb-4 inline-block">
                    <x-application-logo class="block h-10 w-auto fill-current text-white" />
                </a>
                <p class="text-sm text-gray-300">
                    Nền tảng tuyển dụng hàng đầu, kết nối Nhà Tuyển Dụng với hàng triệu ứng viên tài năng.
                </p>
                <div class="mt-4 flex space-x-4">
                    {{-- Thêm các icon social media nếu muốn --}}
                    <a href="#" class="text-gray-400 hover:text-white transition duration-150">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>
                    </a>
                    {{-- Thêm icon LinkedIn, v.v. --}}
                </div>
            </div>

            {{-- Cột 2: Về Chúng Tôi (Giả định) --}}
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Về Chúng Tôi</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm hover:text-white transition duration-150">Giới thiệu</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition duration-150">Điều khoản sử dụng</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition duration-150">Chính sách bảo mật</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition duration-150">Liên hệ</a></li>
                </ul>
            </div>

            {{-- Cột 3: Dịch vụ (Giả định) --}}
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Dịch vụ cho NTD</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm hover:text-white transition duration-150">Đăng tin tuyển dụng</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition duration-150">Tìm kiếm hồ sơ</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition duration-150">Giải pháp thương hiệu</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition duration-150">Bảng giá</a></li>
                </ul>
            </div>

            {{-- Cột 4: Hỗ trợ (Giả định) --}}
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Hỗ trợ</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm hover:text-white transition duration-150">Trung tâm trợ giúp</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition duration-150">Câu hỏi thường gặp</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition duration-150">(+84) 123 456 789</a></li>
                    <li><a href="#" class="text-sm hover:text-white transition duration-150">support@tuyendung.com</a></li>
                </ul>
            </div>

        </div>

        {{-- Dòng Copyright ở cuối --}}
        <div class="mt-8 pt-8 border-t border-gray-700 text-center">
            <p class="text-sm">&copy; {{ date('Y') }} Tên Công Ty Của Bạn. Đã đăng ký bản quyền.</p>
        </div>
    </div>
</footer>