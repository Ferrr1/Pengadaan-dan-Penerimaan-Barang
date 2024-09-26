@foreach ($transaksis as $transaksi)
    <x-modal name="edit_modal_transaksi{{ $transaksi->id }}}" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Edit Transaksi
            </h2>
            {{-- Table Start --}}
            <div>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <form action="{{ route('transaksis.update', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div class="p-1">
                                <x-input-label for="kode_transaksi" :value="__('Kode KelTransaksi')" />
                                <x-text-input id="kode_transaksi" class="block mt-1 w-full" type="text"
                                    name="kode_transaksi" autofocus value="{{ $transaksi->kode_transaksi }}" readonly />
                            </div>
                            <div class="p-1">
                                <x-input-label for="nama_transaksi" :value="__('Nama KelTransaksi')" />
                                <x-text-input id="nama_transaksi" class="block mt-1 w-full" type="text"
                                    name="nama_transaksi" value="{{ $transaksi->nama_transaksi }}" />
                            </div>
                        </div>
                        <x-primary-button class="px-4 py-2 ml-1 mt-3">Simpan</x-primary-button>
                    </form>
                </div>
            </div>
            {{-- Table End --}}
        </div>
    </x-modal>
@endforeach
