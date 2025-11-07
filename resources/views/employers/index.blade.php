<x-guest-layout>
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <h1 class="text-lg font-bold text-center">Trang Nhà Tuyển Dụng</h1>
        <p class="mt-4 text-center">Đây là trang công khai. Mọi người đều có thể thấy.</p>
        
        <div class="mt-6 flex flex-col items-center">
            @auth('tuyen_dung')
                <p class="text-green-600">Bạn đã đăng nhập với tư cách Nhà Tuyển Dụng.</p>
                <!-- Nút đăng xuất -->
                <form method="POST" action="{{ route('employers.logout') }}" class="mt-2">
                    @csrf
                    <x-primary-button>Đăng xuất</x-primary-button>
                </form>
            @else
                <p class="text-red-600">Bạn chưa đăng nhập.</p>
                <a href="{{ route('employers.login') }}" class="mt-2 underline text-sm text-gray-600 hover:text-gray-900">
                    Đi đến trang Đăng nhập Nhà Tuyển Dụng
                </a>
            @endauth
        </div>
    </div>
</x-guest-layout>