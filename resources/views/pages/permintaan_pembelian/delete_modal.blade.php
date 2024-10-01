@foreach ($permintaan_pembelians as $permintaan_pembelian)
    <x-modal name="delete_modal_permintaan_pembelian{{ $permintaan_pembelian->id }}}" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Delete Permintaan
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Apakah anda yakin ingin menghapus
                permintaan ini?</p>
            {{-- Table Start --}}
            <div class="flex justify-end">
                <div class="p-4 overflow-x-auto">
                    <form action="{{ route('permintaanPembelians.destroy', $permintaan_pembelian->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-danger-button class="px-4 py-2 ml-1 mt-3">Delete</x-danger-button>
                    </form>
                </div>
            </div>
            {{-- Table End --}}
        </div>
    </x-modal>
@endforeach
