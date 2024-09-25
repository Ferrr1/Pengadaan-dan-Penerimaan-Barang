@foreach ($satuans as $satuan)
    <x-modal name="edit_modal_satuan{{ $satuan->id }}}" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Edit Satuan
            </h2>
            {{-- Table Start --}}
            <div>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <form action="{{ route('satuans.update', $satuan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div class="p-1">
                                <x-input-label for="kode_satuan" :value="__('Kode Satuan')" />
                                <x-text-input id="kode_satuan" class="block mt-1 w-full" type="text"
                                    name="kode_satuan" autofocus value="{{ $satuan->kode_satuan }}" readonly />
                            </div>
                            <div class="p-1">
                                <x-input-label for="nama_satuan" :value="__('Nama Satuan')" />
                                <x-text-input id="nama_satuan" class="block mt-1 w-full" type="text"
                                    name="nama_satuan" value="{{ $satuan->nama_satuan }}" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div class="p-1">
                                <x-input-label for="singkatan_satuan" :value="__('Kode Satuan')" />
                                <x-text-input id="singkatan_satuan" class="block mt-1 w-full" type="text"
                                    name="singkatan_satuan" autofocus value="{{ $satuan->singkatan_satuan }}" />
                            </div>
                            <div class="p-1">
                                <x-input-label for="deskripsi_satuan" :value="__('Nama Satuan')" />
                                <x-text-input id="deskripsi_satuan" class="block mt-1 w-full" type="text"
                                    name="deskripsi_satuan" value="{{ $satuan->deskripsi_satuan }}" />
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
