<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cập nhật Tỉnh/Thành phố') }}
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

                    <form method="POST" action="{{ route('admin.provinces.update', $province) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Tên -->
                        <div>
                            <label for="ten_tinh_thanh_pho" class="block font-medium text-sm text-gray-700">Tên Tỉnh/Thành phố</label>
                            <input id="ten_tinh_thanh_pho" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="ten_tinh_thanh_pho" value="{{ old('ten_tinh_thanh_pho', $province->ten_tinh_thanh_pho) }}" required />
                        </div>

                        <!-- Trạng thái -->
                        <div class="mt-4">
                            <label for="trang_thai" class="block font-medium text-sm text-gray-700">Trạng thái</label>
                            <select name="trang_thai" id="trang_thai" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="enable" {{ old('trang_thai', $province->trang_thai) == 'enable' ? 'selected' : '' }}>Hiện</option>
                                <option value="disable" {{ old('trang_thai', $province->trang_thai) == 'disable' ? 'selected' : '' }}>Ẩn</option>
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