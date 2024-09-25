@foreach ($produks as $produk)
    <x-modal name="edit_modal_produk{{ $produk->id }}}" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Edit Produk
            </h2>
            {{-- Table Start --}}
            <div>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <form action="{{ route('products.update', $produk->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div class="p-1">
                                <x-input-label for="kode_produk" :value="__('Kode Produk')" />
                                <x-text-input id="kode_produk" class="block mt-1 w-full" type="text"
                                    name="kode_produk" autofocus value="{{ $produk->kode_produk }}" readonly />
                            </div>
                            <div class="p-1">
                                <x-input-label for="nama_produk" :value="__('Nama Produk')" />
                                <x-text-input id="nama_produk" class="block mt-1 w-full" type="text"
                                    name="nama_produk" value="{{ $produk->nama_produk }}" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="harga_produk" :value="__('Harga Produk')" />
                                <x-text-input id="harga_produk" class="block mt-1 w-full" type="number" required
                                    name="harga_produk" value="{{ $produk->harga_produk }}" />
                                <x-input-error :messages="$errors->get('harga_produk')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="satuan" :value="__('Satuan')" />
                                <div class="relative">
                                    <div x-data="{ satuanId: {{ $produk->satuan_id }}, satuanName: '{{ $produk->satuan->nama_satuan }}' }"
                                        @select-satuan.window="satuanId = $event.detail.id; satuanName = $event.detail.name">
                                        <x-text-input id="satuan" class="block mt-1 w-full" type="text"
                                            name="satuan" x-model="satuanName" readonly />
                                        <input type="hidden" name="satuan_id" x-model="satuanId" />

                                        <x-secondary-button type="button" class="absolute py-2 px-3 right-1 top-1"
                                            x-on:click="$dispatch('open-modal', 'satuan_modal_produk')">
                                            <x-eva-search-outline class="w-4" />
                                        </x-secondary-button>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />

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
