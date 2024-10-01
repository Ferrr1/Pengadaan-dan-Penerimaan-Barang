    <x-modal name="sub_anggaran_modal" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Tambah Sub Anggaran
            </h2>
            {{-- Table Start --}}
            <div>
                <div class="p-4 overflow-x-auto">
                    <form action="{{ route('subAnggarans.store', $anggaran->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div x-data="{ produkId: '', produkKode: '', produkName: '', produkSatuan: '' }"
                            @select-produk.window="produkId = $event.detail.id; produkKode = $event.detail.kode; produkName = $event.detail.name; produkSatuan = $event.detail.satuan;">
                            <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                                <div class="p-1">
                                    <x-input-label for="no_detail" :value="__('No Detail')" />
                                    <x-text-input id="no_detail" class="block mt-1 w-full" type="text"
                                        name="no_detail" value="{{ $nextNoDetailAnggaran }}" readonly />
                                </div>
                                <div class="p-1">
                                    <x-input-label for="kode_anggaran" :value="__('Kode Anggaran')" />
                                    <div class="relative">
                                        <div>
                                            <x-text-input id="kode_anggaran" class="block mt-1 w-full" type="text"
                                                name="kode_anggaran" x-model="produkKode" readonly />
                                            <input type="hidden" name="produk_id" x-model="produkId" />
                                            <x-secondary-button type="button" class="absolute py-2 px-3 right-1 top-1"
                                                x-on:click="$dispatch('open-modal', 'produk_modal_sub_anggaran')">
                                                <x-eva-search-outline class="w-4" />
                                            </x-secondary-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                                <div class="p-1">
                                    <x-input-label for="nama_anggaran" :value="__('Nama Anggaran')" />
                                    <x-text-input id="nama_anggaran" class="block mt-1 w-full" type="text"
                                        name="nama_anggaran" x-model="produkName" />
                                </div>
                                <div class="p-1">
                                    <x-input-label for="produkSatuan" :value="__('Satuan')" />
                                    <x-text-input id="produkSatuan" class="block mt-1 w-full" type="text"
                                        name="produkSatuan" x-model="produkSatuan" readonly />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                                <div class="p-1">
                                    <x-input-label for="kuantitas_anggaran" :value="__('Kuantitas')" />
                                    <x-text-input id="kuantitas_anggaran" class="block mt-1 w-full" type="number"
                                        name="kuantitas_anggaran" />
                                </div>
                                <div class="p-1">
                                    <x-input-label for="harga_anggaran" :value="__('Harga Satuan')" />
                                    <x-text-input id="harga_anggaran" class="block mt-1 w-full" type="number"
                                        name="harga_anggaran" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 min-w-full overflow-hidden">
                                <div class="p-1">
                                    <x-input-label for="kel_anggaran" :value="__('Kelompok Anggaran')" />
                                    <select name="kel_anggaran" id="kel_anggaran"
                                        class="appearance-none dark:bg-gray-900 mt-1 rounded-l rounded-md border inline-block w-full bg-white border-gray-700 dark:text-white text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        required>
                                        @forelse ($kel_anggarans as $kel_anggaran)
                                            <option value="{{ $kel_anggaran->id }}">
                                                {{ $kel_anggaran->nama_kel_anggaran }}</option>
                                        @empty
                                            <option readonly>
                                                Tidak ada data kelompok anggaran</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <x-primary-button class="px-4 py-2 ml-1 mt-3">Simpan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Table End --}}
        </div>
    </x-modal>
