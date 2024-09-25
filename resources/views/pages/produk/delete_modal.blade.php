@foreach ($produks as $produk)
    <x-modal name="delete_modal_produk{{ $produk->id }}}" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Delete Produk
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Apakah anda yakin ingin menghapus produk ini?</p>
            {{-- Table Start --}}
            <div class="flex justify-end">
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <form action="{{ route('products.destroy', $produk->id) }}" method="POST">
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
