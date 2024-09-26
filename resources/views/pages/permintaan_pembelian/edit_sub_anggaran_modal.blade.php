@foreach ($subAnggarans as $subAnggaran)
    <x-modal name="edit_modal_subAnggaran{{ $subAnggaran->id }}}" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Edit Sub Anggaran
            </h2>
            {{-- Table Start --}}
            <div>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <form action="{{ route('subAnggarans.update', $anggaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div class="p-1">
                                <x-input-label for="no_detail" :value="__('No Detail')" />
                                <x-text-input id="no_detail" class="block mt-1 w-full" type="text" name="no_detail"
                                    value="{{ $subAnggaran->no_detail }}" readonly />
                            </div>
                            <div class="p-1">
                                <x-input-label for="kode_anggaran" :value="__('Kode Anggaran')" />
                                <x-text-input id="kode_anggaran" class="block mt-1 w-full" type="text"
                                    name="kode_anggaran" value="{{ $subAnggaran->kode_anggaran }}" readonly />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div class="p-1">
                                <x-input-label for="nama_anggaran" :value="__('Nama Anggaran')" />
                                <x-text-input id="nama_anggaran" class="block mt-1 w-full" type="text"
                                    name="nama_anggaran" autofocus value="{{ $subAnggaran->nama_anggaran }}" />
                            </div>
                            <div class="p-1">
                                <x-input-label for="satuan" :value="__('Satuan')" />
                                <div class="relative">
                                    <div x-data="{ satuanId: '{{ $subAnggaran->satuan_id }}', satuanName: '{{ $subAnggaran->satuan->nama_satuan }}' }"
                                        @select-satuan.window="satuanId = $event.detail.id; satuanName = $event.detail.name">
                                        <x-text-input id="satuan" class="block mt-1 w-full" type="text"
                                            name="satuan" x-model="satuanName" readonly />
                                        <input type="hidden" name="satuan_id" x-model="satuanId" />

                                        <x-secondary-button type="button" class="absolute py-2 px-3 right-1 top-1"
                                            x-on:click="$dispatch('open-modal', 'satuan_modal_sub_anggaran')">
                                            <x-eva-search-outline class="w-4" />
                                        </x-secondary-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div class="p-1">
                                <x-input-label for="kuantitas_anggaran" :value="__('Kuantitas')" />
                                <x-text-input id="kuantitas_anggaran" class="block mt-1 w-full" type="number"
                                    name="kuantitas_anggaran" value="{{ $subAnggaran->kuantitas_anggaran }}" />
                            </div>
                            <div class="p-1">
                                <x-input-label for="harga_anggaran" :value="__('Harga Satuan')" />
                                <x-text-input id="harga_anggaran" class="block mt-1 w-full" type="number"
                                    name="harga_anggaran" value="{{ $subAnggaran->harga_anggaran }}" />
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
