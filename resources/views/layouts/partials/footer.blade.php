<footer class="bg-gray-800 text-gray-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-8">
            
            <!-- Logo & Thông tin liên hệ (Chiếm 2 cột) -->
            <div class="lg:col-span-2">
                <a href="{{ route('dashboard') }}" class="mb-4 inline-block">
                    {{-- Logo (phiên bản màu trắng) --}}
                    {{-- Giả sử <x-application-logo> có thể đổi màu, nếu không, bạn cần thay bằng <img> --}}
                    <x-application-logo class="block h-10 w-auto fill-current text-white" />
                </a>
                <p class="text-sm mt-4">
                    Tầng 10, Tòa nhà ABC, 123 Đường XYZ, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh
                </p>
                <p class="text-sm mt-2">Điện thoại: (028) 1234 5678</p>
                <p class="text-sm mt-2">Email: contact@yourdomain.com</p>
                
                <!-- Mạng xã hội (sử dụng SVG placeholder) -->
                <div class="flex space-x-4 mt-6">
                    <a href="#" class="text-gray-400 hover:text-white" aria-label="Facebook">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.35C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.732 0 1.325-.593 1.325-1.325V1.325C24 .593 23.407 0 22.675 0z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white" aria-label="LinkedIn">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.447 20.45h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.284zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.017H3.55V9h3.569v11.45zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Cột 2: Về Chúng Tôi -->
            <div>
                <h5 class="font-bold text-white uppercase tracking-wider mb-4">Về Chúng Tôi</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition duration-150">Giới thiệu</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Liên hệ</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Câu hỏi thường gặp</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Điều khoản sử dụng</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Chính sách bảo mật</a></li>
                </ul>
            </div>

            <!-- Cột 3: Dành cho Ứng viên -->
            <div>
                <h5 class="font-bold text-white uppercase tracking-wider mb-4">Ứng Viên</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition duration-150">Tìm việc làm</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Tạo CV</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Việc làm đã lưu</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Tư vấn nghề nghiệp</a></li>
                </ul>
            </div>

            <!-- Cột 4: Dành cho Nhà Tuyển Dụng -->
            <div>
                <h5 class="font-bold text-white uppercase tracking-wider mb-4">Nhà Tuyển Dụng</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('employers.login') }}" class="hover:text-white transition duration-150">Đăng nhập</a></li>
                    <li><a href="{{ route('employers.register') }}" class="hover:text-white transition duration-150">Đăng ký</a></li>
                    <li><a href="{{ route('employers.posts.create') }}" class="hover:text-white transition duration-150">Đăng tin tuyển dụng</a></li>
                    <li><a href="#" class="hover:text-white transition duration-150">Tìm hồ sơ</a></li>
                </ul>
            </div>

            <!-- Cột 5: Tải ứng dụng (Placeholder) -->
            <div>
                <h5 class="font-bold text-white uppercase tracking-wider mb-4">Tải ứng dụng</h5>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="#" class="block">
                            <img src="https://placehold.co/120x40/2D3748/FFFFFF?text=App+Store" alt="App Store" class="rounded opacity-80 hover:opacity-100">
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block">
                            <img src="https://placehold.co/120x40/2D3748/FFFFFF?text=Google+Play" alt="Google Play" class="rounded opacity-80 hover:opacity-100">
                        </a>
                    </li>
                </ul>
            </div>

        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm">
            <p>&copy; {{ date('Y') }} Tên Công Ty Của Bạn. Đã đăng ký bản quyền.</p>
        </div>
    </div>
</footer>