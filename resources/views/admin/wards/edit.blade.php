<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cập nhật Xã/Phường') }}
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

                    <form method="POST" action="{{ route('admin.wards.update', $ward) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Tên Xã/Phường -->
                        <div>
                            <label for="ten_xa_phuong" class="block font-medium text-sm text-gray-700">Tên Xã/Phường</label>
                            <input id="ten_xa_phuong" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="ten_xa_phuong" value="{{ old('ten_xa_phuong', $ward->ten_xa_phuong) }}" required />
                        </div>

                        <!-- Chọn Tỉnh/Thành (id_parent) -->
                        <div class="mt-4">
                            <label for="id_parent" class="block font-medium text-sm text-gray-700">Thuộc Tỉnh/Thành phố</label>
                            <select name="id_parent" id="id_parent" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Chọn Tỉnh/Thành --</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}" {{ old('id_parent', $ward->id_parent) == $province->id ? 'selected' : '' }}>
                                        {{ $province->ten_tinh_thanh_pho }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Trạng thái -->
                        <div class="mt-4">
                            <label for="trang_thai" class="block font-medium text-sm text-gray-700">Trạng thái</label>
                            <select name="trang_thai" id="trang_thai" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="enable" {{ old('trang_thai', $ward->trang_thai) == 'enable' ? 'selected' : '' }}>Hiện</option>
                                <option value="disable" {{ old('trang_thai', $ward->trang_thai) == 'disable' ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.locations.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Hủy</a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>