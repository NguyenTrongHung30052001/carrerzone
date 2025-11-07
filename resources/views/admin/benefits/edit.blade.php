<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cập nhật Phúc lợi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Hiển thị lỗi validation (nếu có) --}}
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.benefits.update', $benefit) }}">
                        @csrf
                        @method('PATCH') {{-- Quan trọng: Dùng method PATCH để update --}}

                        <!-- Tên phúc lợi -->
                        <div>
                            <label for="ten_phuc_loi" class="block font-medium text-sm text-gray-700">Tên phúc lợi</label>
                            <input id="ten_phuc_loi" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="ten_phuc_loi" value="{{ old('ten_phuc_loi', $benefit->ten_phuc_loi) }}" required />
                        </div>

                        <!-- Trạng thái -->
                        <div class="mt-4">
                            <label for="trang_thai" class="block font-medium text-sm text-gray-700">Trạng thái</Labe>
                            <select name="trang_thai" id="trang_thai" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="enable" {{ old('trang_thai', $benefit->trang_thai) == 'enable' ? 'selected' : '' }}>
                                    Hiện
                                </option>
                                <option value="disable" {{ old('trang_thai', $benefit->trang_thai) == 'disable' ? 'selected' : '' }}>
                                    Ẩn
                                </option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.benefits.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Hủy
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>