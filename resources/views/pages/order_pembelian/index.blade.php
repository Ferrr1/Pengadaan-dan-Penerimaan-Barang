<x-app-layout :title="__('- Order Pembelian')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Pembelian - Daftar OP') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('orderPembelians.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                        <div>
                            <div x-data="{
                                idProject: '',
                                kodeProject: '',
                                namaProject: '',
                                nomorOP: '{{ $newOPCode }}',
                                idSupplier: '',
                                kodeSupplier: '',
                                namaSupplier: '',
                                idTransaksi: '',
                                kodeTransaksi: '',
                                namaTransaksi: '',
                                nomorPP: '',
                                updateNomorOP() {
                                    if (this.nomorOP.includes('XXXXX')) {
                                        this.nomorOP = this.nomorOP.replace('XXXXX', this.kodeProject);
                                    } else {
                                        // Jika tidak ada, ganti bagian tertentu dari nomorOP
                                        let parts = this.nomorOP.split('/');
                                        if (parts.length >= 3) {
                                            parts[2] = this.kodeProject;
                                            this.nomorOP = parts.join('/');
                                        }
                                    }
                                }
                            }"
                                @select-anggaran.window="
                                idProject = $event.detail.id;
                                kodeProject = $event.detail.kode;
                                namaProject = $event.detail.name;
                                nomorPP = $event.detail.nomor_pp;
                                updateNomorOP();
                            "
                                @select-rekanan.window="
                                idSupplier = $event.detail.id;
                                kodeSupplier = $event.detail.kode;
                                namaSupplier = $event.detail.name;
                            "
                                @select-transaksi.window="
                                idTransaksi = $event.detail.id;
                                kodeTransaksi = $event.detail.kode;
                                namaTransaksi = $event.detail.name;
                            ">
                                <div class="grid grid-cols-12 gap-2">
                                    <div class="col-span-6">
                                        <x-input-label for="nomor_op" :value="__('Nomor OP')" />
                                        <x-text-input id="nomor_op" class="block mt-1 w-full" type="text" readonly
                                            name="nomor_op" x-model="nomorOP" />
                                        <input type="text" name="permintaanpembelian_id" x-model="idProject" hidden>
                                        <x-input-error :messages="$errors->get('nomor_op')" class="mt-2" />
                                    </div>
                                    <div class="col-span-6">
                                        <x-input-label for="nomor_pp" :value="__('Nomor PP')" />
                                        <x-text-input id="nomor_pp" class="block mt-1 w-full" type="text" readonly
                                            name="nomor_pp" x-model="nomorPP" />
                                        <x-input-error :messages="$errors->get('nomor_op')" class="mt-2" />
                                    </div>
                                    <div class="col-span-4">
                                        <x-input-label class="mt-2" for="kode_anggaran" :value="__('Kode Proyek')" />
                                        <x-text-input id="kode_anggaran" class="block mt-1 w-full" type="text"
                                            name="kode_anggaran" x-model="kodeProject" readonly required />
                                    </div>
                                    <div class="col-span-8">
                                        <x-input-label class="mt-2" for="kode_anggaran" :value="__('Proyek Peminta')" />
                                        <div class="relative">
                                            <x-text-input id="anggaran_project" class="block mt-1 w-full" type="text"
                                                x-model="namaProject" readonly required />
                                            <x-secondary-button type="button" class="absolute py-2 px-3 right-1 top-1"
                                                x-on:click="$dispatch('open-modal', 'permintaan_modal_order_pembelian')">
                                                <x-eva-search-outline class="w-4" />
                                            </x-secondary-button>
                                        </div>
                                    </div>
                                    <div class="col-span-4">
                                        <x-input-label for="kode_rekanan" :value="__('Kode Supplier')" class="mt-1" />
                                        <x-text-input id="kode_rekanan" class="block mt-1 w-full" type="text"
                                            name="kode_rekanan" x-model="kodeSupplier" readonly required />
                                        <input type="text" name="rekanan_id" x-model="idSupplier" hidden>
                                    </div>
                                    <div class="col-span-8">
                                        <x-input-label for="nama_rekanan" :value="__('Nama Supplier')" class="mt-1" />
                                        <div class="relative">
                                            <x-text-input id="nama_rekanan" class="block mt-1 w-full" type="text"
                                                x-model="namaSupplier" readonly required />
                                            <x-secondary-button type="button" class="absolute py-2 px-3 right-1 top-1"
                                                x-on:click="$dispatch('open-modal', 'rekanan_modal_order_pembelian')">
                                                <x-eva-search-outline class="w-4" />
                                            </x-secondary-button>
                                        </div>
                                    </div>
                                    <div class="col-span-4">
                                        <x-input-label for="kode_transaksi" :value="__('Kode Transaksi')" class="mt-1" />
                                        <x-text-input id="kode_transaksi" class="block mt-1 w-full" type="text"
                                            name="kode_transaksi" x-model="kodeTransaksi" readonly required />
                                        <input type="text" name="transaksi_id" x-model="idTransaksi" hidden>
                                    </div>
                                    <div class="col-span-8">
                                        <x-input-label for="nama_transaksi" :value="__('Nama Transaksi')" class="mt-1" />
                                        <div class="relative">
                                            <x-text-input id="nama_transaksi" class="block mt-1 w-full" type="text"
                                                x-model="namaTransaksi" readonly required />
                                            <x-secondary-button type="button" class="absolute py-2 px-3 right-1 top-1"
                                                x-on:click="$dispatch('open-modal', 'transaksi_modal_order_pembelian')">
                                                <x-eva-search-outline class="w-4" />
                                            </x-secondary-button>
                                        </div>
                                    </div>
                                    <div class="col-span-4">
                                        <x-input-label for="tgl_op" :value="__('Tanggal')" class="mt-1" />
                                        <x-text-input id="tgl_op" class="block mt-1 w-full" type="date"
                                            name="tgl_op" required />
                                    </div>
                                    <div x-data="tandaTanganHandler()" class="col-span-8">
                                        <template x-for="(item, index) in items" :key="index">
                                            <div class="flex flex-col space-y-2">
                                                <div class="flex space-x-2">
                                                    <div class="flex-grow">
                                                        <x-input-label :value="__('Tanda Tangan')" class="mt-1" />
                                                        <x-text-input
                                                            x-bind:id="'tandatangan_op_' + index + '_tanda_tangan'"
                                                            class="block mt-1 w-full" type="text"
                                                            x-bind:name="'tandatangan_op[' + index + '][tanda_tangan]'"
                                                            x-model="item.tandaTangan" required />
                                                    </div>
                                                    <div class="flex-grow">
                                                        <x-input-label :value="__('Posisi Jabatan')" class="mt-1" />
                                                        <x-text-input
                                                            x-bind:id="'tandatangan_op_' + index + '_posisi_jabatan'"
                                                            class="block mt-1 w-full" type="text"
                                                            x-bind:name="'tandatangan_op[' + index + '][posisi_jabatan]'"
                                                            x-model="item.posisiJabatan" required />
                                                    </div>
                                                    <div class="flex items-end mb-0.5 gap-2">
                                                        <x-primary-button type="button" @click="addItem"
                                                            class="p-2" x-show="items.length < 2">
                                                            <x-eva-plus class="w-5 h-5" />
                                                        </x-primary-button>
                                                        <x-secondary-button type="button" @click="removeItem(index)"
                                                            class="p-2">
                                                            <x-eva-trash-outline class="w-5 h-5" />
                                                        </x-secondary-button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <x-primary-button class="mt-4 px-4 py-2">Tambah Permintaan Pembelian</x-primary-button>
            </form>
            <div class="mt-4">
                @include('pages.order_pembelian.table')
            </div>
            {{-- Modal --}}
            @include('pages.order_pembelian.delete_modal')
            @include('pages.order_pembelian.project_op_modal')
            @include('pages.order_pembelian.rekanan_modal')
            @include('pages.order_pembelian.transaksi_modal')
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('tgl_op').valueAsDate = new Date();

    function tandaTanganHandler() {
        return {
            items: [{
                tandaTangan: '',
                posisiJabatan: ''
            }],
            addItem() {
                if (this.items.length < 2) {
                    this.items.push({
                        tandaTangan: '',
                        posisiJabatan: ''
                    });
                }
            },
            removeItem(index) {
                this.items.splice(index, 1);
                if (this.items.length === 0) {
                    this.items.push({
                        tandaTangan: '',
                        posisiJabatan: ''
                    });
                }
            }
        }
    }
</script>
