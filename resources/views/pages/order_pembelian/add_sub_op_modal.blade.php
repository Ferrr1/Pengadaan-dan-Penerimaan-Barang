    <x-modal name="sub_op_modal" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Tambah Sub Order Pembelian
            </h2>
            {{-- Table Start --}}
            <div>
                <div class="p-4 overflow-x-auto">
                    <form action="{{ route('subOrderPembelians.store', $order_pembelians->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div x-data="{
                            subAnggaranId: '',
                            subAnggaranSatuanProduk: '',
                            subOrderKodeBarang: '',
                            subOrderNamaProduk: '',
                            subAnggaranHarga: '',
                            subOrderSpesifikasi: ''
                        }"
                            @select-sub-anggaran.window="subAnggaranId = $event.detail.id;
                            subAnggaranSatuanProduk = $event.detail.satuanProduk;
                            subOrderKodeBarang = $event.detail.kodeProduk;
                            subOrderNamaProduk = $event.detail.namaProduk;
                            subAnggaranHarga = $event.detail.harga;
                            subOrderSpesifikasi = $event.detail.spesifikasi;">
                            <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                                <div class="p-1">
                                    <x-input-label for="nodetail" :value="__('Kode Barang')" />
                                    <div class="relative">
                                        <x-text-input id="nodetail" class="block mt-1 w-full" type="text"
                                            name="nodetail" x-model="subOrderKodeBarang" readonly />
                                        <input type="hidden" name="sub_permintaanpembelian_id" x-model='subAnggaranId'>
                                        <x-secondary-button type="button" class="absolute py-2 px-3 right-1 top-1"
                                            x-on:click="$dispatch('open-modal', 'sub_anggaran_modal_sub_pp')">
                                            <x-eva-search-outline class="w-4" />
                                        </x-secondary-button>
                                    </div>
                                </div>
                                <div class="p-1">
                                    <x-input-label for="nama_produk" :value="__('Nama Produk')" />
                                    <x-text-input id="nama_produk" class="block mt-1 w-full" type="text"
                                        name="nama_produk" x-model="subOrderNamaProduk" readonly />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                                <div class="p-1">
                                    <x-input-label for="satuan_id" :value="__('Satuan')" />
                                    <x-text-input id="satuan_id" class="block mt-1 w-full" type="text"
                                        name="satuan_id" x-model="subAnggaranSatuanProduk" readonly />
                                </div>
                                <div class="p-1">
                                    <x-input-label for="harga_sub_order_pembelian" :value="__('Harga Satuan')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="harga_sub_order_pembelian" class="block w-full pr-10"
                                            type="text" name="harga_sub_order_pembelian" x-model="subAnggaranHarga"
                                            readonly />
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
                                    <x-input-label for="ppn_sub_order_pembelian" :value="__('PPN')" />
                                    <div class="relative mt-1">
                                        <x-text-input id="ppn_sub_order_pembelian" class="block w-full pr-10"
                                            type="text" name="ppn_sub_order_pembelian" value="11" readonly />
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <span
                                                class="dark:text-gray-200 text-gray-500 dark:bg-gray-700 bg-gray-200 rounded-md px-2 py-1 opacity-50 sm:text-sm">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-1">
                                    <x-input-label for="spesifikasi_sub_order_pembelian" :value="__('Spesifikasi')" />
                                    <x-text-input id="spesifikasi_sub_order_pembelian" class="block mt-1 w-full"
                                        type="text" x-model="subOrderSpesifikasi"
                                        name="spesifikasi_sub_order_pembelian" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                                <div class="p-1">
                                    <x-input-label for="kuantitas_sub_order_pembelian" :value="__('Kuantitas')" />
                                    <x-text-input id="kuantitas_sub_order_pembelian" class="block mt-1 w-full"
                                        type="text" name="kuantitas_sub_order_pembelian" />
                                </div>
                                <div class="p-1">
                                    <x-input-label for="catatan_sub_order_pembelian" :value="__('Catatan')" />
                                    <x-text-input id="catatan_sub_order_pembelian" class="block mt-1 w-full"
                                        type="text" name="catatan_sub_order_pembelian" />
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
