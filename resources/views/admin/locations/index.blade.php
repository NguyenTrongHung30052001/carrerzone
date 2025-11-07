<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý địa chỉ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- Hiển thị thông báo thành công (nếu có) --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Bảng Tỉnh/Thành phố -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Danh sách Tỉnh/Thành phố</h3>
                        <a href="{{ route('admin.provinces.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                            Tạo mới Tỉnh/Thành
                        </a>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên Tỉnh/Thành</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                                <th class="relative px-6 py-3"><span class="sr-only">Hành động</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($provinces as $province)
                                <tr>
                                    <td class="px-6 py-4">{{ $province->ten_tinh_thanh_pho }}</td>
                                    <td class="px-6 py-4">
                                        @if ($province->trang_thai == 'enable')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hiện</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ẩn</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.provinces.edit', $province) }}" class="text-indigo-600 hover:text-indigo-900">Sửa</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bảng Xã/Phường -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Danh sách Xã/Phường</h3>
                        <a href="{{ route('admin.wards.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                            Tạo mới Xã/Phường
                        </a>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên Xã/Phường</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thuộc Tỉnh/Thành</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                                <th class="relative px-6 py-3"><span class="sr-only">Hành động</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($wards as $ward)
                                <tr>
                                    <td class="px-6 py-4">{{ $ward->ten_xa_phuong }}</td>
                                    {{-- Hiển thị tên tỉnh nhờ 'eager loading' --}}
                                    <td class="px-6 py-4">{{ $ward->province->ten_tinh_thanh_pho ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        @if ($ward->trang_thai == 'enable')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Hiện</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ẩn</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.wards.edit', $ward) }}" class="text-indigo-600 hover:text-indigo-900">Sửa</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>