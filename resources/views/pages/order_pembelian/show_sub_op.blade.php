<x-app-layout :title="__('- Sub Order Pembelian Proyek')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Pembelian - List OP') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                    <div>
                        <div x-data="{
                            kodeProject: '{{ $anggaranOrders->project->kode_project }}',
                            namaProject: `{{ $anggaranOrders->project->nama_project }}`,
                            nomorOP: '{{ $order_pembelians->nomor_op }}',
                            nomorPP: '{{ $order_pembelians->permintaanpembelian->nomor_pp }}',
                            kodeSupplier: '{{ $order_pembelians->rekanan->kode_rekanan }}',
                            namaSupplier: `{{ $order_pembelians->rekanan->nama_rekanan }}`,
                            kodeTransaksi: '{{ $order_pembelians->permintaanpembelian->transaksi->kode_transaksi }}',
                            namaTransaksi: '{{ $order_pembelians->permintaanpembelian->transaksi->nama_transaksi }}',
                        }">
                            <div class="grid grid-cols-12 gap-2">
                                <div class="col-span-6">
                                    <x-input-label for="nomor_op" :value="__('Nomor OP')" />
                                    <x-text-input id="nomor_op" class="block mt-1 w-full" type="text" readonly
                                        name="nomor_op" x-model="nomorOP" />
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
                                        <x-secondary-button disabled type="button"
                                            class="absolute py-2 px-3 right-1 top-1"
                                            x-on:click="$dispatch('open-modal', 'permintaan_modal_order_pembelian')">
                                            <x-eva-search-outline class="w-4" />
                                        </x-secondary-button>
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <x-input-label for="kode_rekanan" :value="__('Kode Supplier')" class="mt-1" />
                                    <x-text-input id="kode_rekanan" class="block mt-1 w-full" type="text"
                                        name="kode_rekanan" x-model="kodeSupplier" readonly />
                                </div>
                                <div class="col-span-8">
                                    <x-input-label for="kode_anggaran" :value="__('Nama Supplier')" class="mt-1" />
                                    <div class="relative">
                                        <x-text-input id="anggaran_project" class="block mt-1 w-full" type="text"
                                            x-model="namaSupplier" readonly />
                                        <x-secondary-button disabled type="button"
                                            class="absolute py-2 px-3 right-1 top-1"
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
                                        <x-secondary-button disabled type="button"
                                            class="absolute py-2 px-3 right-1 top-1"
                                            x-on:click="$dispatch('open-modal', 'transaksi_modal_order_pembelian')">
                                            <x-eva-search-outline class="w-4" />
                                        </x-secondary-button>
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <x-input-label for="tgl_op" :value="__('Tanggal')" class="mt-1" />
                                    <x-text-input id="tgl_op" class="block mt-1 w-full" type="date" name="tgl_op"
                                        value="{{ $order_pembelians->tgl_op }}" readonly />
                                </div>
                                <div class="col-span-8">
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex space-x-2">
                                            <div class="flex-grow">
                                                <x-input-label :value="__('Tanda Tangan')" class="mt-2" />
                                                <select id="tanda_tangan"
                                                    class="appearance-none dark:bg-gray-900 mt-1 rounded-l rounded-md border inline-block w-full bg-white border-gray-700 dark:text-white text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                    name="tanda_tangan">
                                                    @if (is_array($order_pembelians->tandatangan_op) && !empty($order_pembelians->tandatangan_op))
                                                        @foreach ($order_pembelians->tandatangan_op as $key => $value)
                                                            <option value="{{ $value['tanda_tangan'] ?? '' }}">
                                                                {{ $value['tanda_tangan'] ?? 'Tidak ada tanda tangan' }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option>Tidak ada data ttd anggaran</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="flex-grow">
                                                <x-input-label :value="__('Posisi Jabatan')" class="mt-2" />
                                                <select id="posisi_jabatan"
                                                    class="appearance-none dark:bg-gray-900 mt-1 rounded-l rounded-md border inline-block w-full bg-white border-gray-700 dark:text-white text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                    name="posisi_jabatan">
                                                    @if (is_array($order_pembelians->tandatangan_op) && !empty($order_pembelians->tandatangan_op))
                                                        @foreach ($order_pembelians->tandatangan_op as $key => $value)
                                                            <option value="{{ $value['posisi_jabatan'] ?? '' }}">
                                                                {{ $value['posisi_jabatan'] ?? 'Tidak ada tanda tangan' }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option>Tidak ada data ttd anggaran</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('orderPembelians.index') }}">
                <x-primary-button class="mt-4 px-4 py-2">Kembali</x-primary-button>
            </a>
            <div class="mt-4">
                @include('pages.order_pembelian.table_sub_op')
            </div>
            {{-- Modal --}}
            @include('pages.order_pembelian.add_sub_op_modal')
            @include('pages.order_pembelian.edit_sub_op_modal')
            @include('pages.order_pembelian.delete_sub_op_modal')
            @include('pages.order_pembelian.sub_anggaran_modal')
        </div>
    </div>
</x-app-layout>
