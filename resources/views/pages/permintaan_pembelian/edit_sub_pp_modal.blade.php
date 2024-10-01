@foreach ($subPermintaanPembelians as $subPermintaanPembelian)
    <x-modal name="edit_modal_sub_pp{{ $subPermintaanPembelian->id }}}" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Edit Sub Permintaan Pembelian
            </h2>
            {{-- Table Start --}}
            <div>
                <div class="p-4 overflow-x-auto">
                    <form action="{{ route('subPermintaanPembelians.update', $permintaan_Pembelian->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div class="p-1">
                                <x-input-label for="no_detail" :value="__('No Detail')" />
                                <x-text-input id="no_detail" class="block mt-1 w-full" type="text" name="no_detail"
                                    value="{{ $subPermintaanPembelian->no_detail }}" readonly />
                            </div>
                            <div class="p-1">
                                <x-input-label for="kode_anggaran" :value="__('Kode Permintaan Pembelian')" />
                                <x-text-input id="kode_anggaran" class="block mt-1 w-full" type="text"
                                    name="kode_anggaran" value="{{ $subPermintaanPembelian->kode_anggaran }}"
                                    readonly />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div class="p-1">
                                <x-input-label for="nama_anggaran" :value="__('Nama Permintaan Pembelian')" />
                                <x-text-input id="nama_anggaran" class="block mt-1 w-full" type="text"
                                    name="nama_anggaran" autofocus
                                    value="{{ $subPermintaanPembelian->nama_anggaran }}" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div class="p-1">
                                <x-input-label for="kuantitas_anggaran" :value="__('Kuantitas')" />
                                <x-text-input id="kuantitas_anggaran" class="block mt-1 w-full" type="number"
                                    name="kuantitas_anggaran"
                                    value="{{ $subPermintaanPembelian->kuantitas_anggaran }}" />
                            </div>
                            <div class="p-1">
                                <x-input-label for="harga_anggaran" :value="__('Harga Satuan')" />
                                <x-text-input id="harga_anggaran" class="block mt-1 w-full" type="number"
                                    name="harga_anggaran" value="{{ $subPermintaanPembelian->harga_anggaran }}" />
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
