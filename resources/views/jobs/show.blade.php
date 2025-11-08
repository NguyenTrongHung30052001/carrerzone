<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight truncate">
            {{ $post->chuc_danh }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-4">{{ $post->chuc_danh }}</h1>
                    <p class="text-xl text-gray-700 mb-8">{{ $post->ten_cong_ty }}</p>
                    
                    <div class="prose max-w-none">
                        <h3>Mô tả công việc</h3>
                        <p class="whitespace-pre-line">{{ $post->mo_ta_cong_viec }}</p>

                        <h3>Yêu cầu công việc</h3>
                        <p class="whitespace-pre-line">{{ $post->yeu_cau_cong_viec }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>