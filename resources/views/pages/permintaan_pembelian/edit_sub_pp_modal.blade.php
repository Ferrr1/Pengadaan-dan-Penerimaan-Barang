@foreach ($subPermintaanPembelians as $subPermintaanPembelian)
    <x-modal name="edit_modal_sub_pp{{ $subPermintaanPembelian->id }}}" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Edit Sub Permintaan Pembelian
            </h2>
            {{-- Table Start --}}
            <div>
                <div class="p-4 overflow-x-auto">
                    <form action="{{ route('subPermintaanPembelians.update', $subPermintaanPembelian->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div x-data="{
                            subAnggaranId: '{{ $subPermintaanPembelian->subAnggaran->id }}',
                            subAnggaranProdukId: '{{ $subPermintaanPembelian->subAnggaran->produks->id }}',
                            subAnggaranKodeProduk: '{{ $subPermintaanPembelian->subAnggaran->produks->kode_produk }}',
                            subAnggaranSatuanProduk: '{{ $subPermintaanPembelian->subAnggaran->produks->satuan->nama_satuan }}',
                            subAnggaranNoDetail: '{{ $subPermintaanPembelian->subAnggaran->no_detail }}',
                            subAnggaranName: '{{ $subPermintaanPembelian->subAnggaran->produks->nama_produk }}',
                            subAnggaranHarga: '{{ $subPermintaanPembelian->subAnggaran->harga_anggaran }}',
                        }"
                            @select-sub-anggaran.window="subAnggaranId = $event.detail.id; subAnggaranProdukId = $event.detail.idProduk; subAnggaranKodeProduk = $event.detail.kodeProduk; subAnggaranSatuanProduk = $event.detail.satuanProduk; subAnggaranNoDetail = $event.detail.nodetail; subAnggaranName = $event.detail.name; subAnggaranHarga = $event.detail.harga;">
                            <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                                <div class="p-1">
                                    <x-input-label for="nodetail" :value="__('No Detail')" />
                                    <div class="relative">
                                        <x-text-input id="nodetail" class="block mt-1 w-full" type="text"
                                            name="nodetail" x-model="subAnggaranNoDetail" readonly />
                                        <x-secondary-button type="button" class="absolute py-2 px-3 right-1 top-1"
                                            x-on:click="$dispatch('open-modal', 'sub_anggaran_modal_sub_pp')">
                                            <x-eva-search-outline class="w-4" />
                                        </x-secondary-button>
                                    </div>
                                </div>
                                <div class="p-1">
                                    <x-input-label for="nama_anggaran" :value="__('Nama Anggaran')" />
                                    <x-text-input id="nama_anggaran" class="block mt-1 w-full" type="text"
                                        name="nama_anggaran" x-model="subAnggaranName" readonly />
                                    <input type="hidden" name="sub_anggaran_id" x-model="subAnggaranId" />

                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                                <div class="p-1">
                                    <x-input-label for="produk" :value="__('Kode Produk')" />
                                    <x-text-input id="produk" class="block mt-1 w-full" type="text" name="produk"
                                        x-model="subAnggaranKodeProduk" readonly />
                                </div>
                                <div class="p-1">
                                    <x-input-label for="harga_sub_permintaan_pembelian" :value="__('Harga Satuan')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="harga_sub_permintaan_pembelian" class="block w-full pr-10"
                                            type="text" name="harga_sub_permintaan_pembelian"
                                            x-model="subAnggaranHarga" readonly />
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <span
                                                class="dark:text-gray-200 text-gray-500 dark:bg-gray-700 bg-gray-200 rounded-md px-2 py-1 opacity-50 sm:text-sm">Rp</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                                <div class="p-1">
                                    <x-input-label for="satuan_id" :value="__('Satuan')" />
                                    <x-text-input id="satuan_id" class="block mt-1 w-full" type="text"
                                        name="satuan_id" x-model="subAnggaranSatuanProduk" readonly />
                                </div>
                                <div class="p-1">
                                    <x-input-label for="nama_produk" :value="__('Nama Produk')" />
                                    <x-text-input id="nama_produk" class="block mt-1 w-full" type="text"
                                        name="nama_produk" x-model="subAnggaranName" readonly />
                                    <input type="hidden" name="produk_id" x-model="subAnggaranProdukId" />

                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                                <div class="p-1">
                                    <x-input-label for="spesifikasi_sub_permintaan_pembelian" :value="__('Spesifikasi')" />
                                    <x-text-input id="spesifikasi_sub_permintaan_pembelian" class="block mt-1 w-full"
                                        type="text" name="spesifikasi_sub_permintaan_pembelian"
                                        value="{{ $subPermintaanPembelian->spesifikasi_sub_permintaan_pembelian }}" />
                                </div>
                                <div class="p-1">
                                    <x-input-label for="kuantitas_sub_permintaan_pembelian" :value="__('Kuantitas')" />
                                    <x-text-input id="kuantitas_sub_permintaan_pembelian" class="block mt-1 w-full"
                                        type="text" name="kuantitas_sub_permintaan_pembelian"
                                        value="{{ $subPermintaanPembelian->kuantitas_sub_permintaan_pembelian }}" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                                <div class="p-1 col-span-2">
                                    <x-input-label for="keterangan_sub_permintaan_pembelian" :value="__('Keterangan')" />
                                    <x-text-input id="keterangan_sub_permintaan_pembelian" class="block mt-1 w-full"
                                        type="text" name="keterangan_sub_permintaan_pembelian"
                                        value="{{ $subPermintaanPembelian->keterangan_sub_permintaan_pembelian }}" />
                                </div>
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
