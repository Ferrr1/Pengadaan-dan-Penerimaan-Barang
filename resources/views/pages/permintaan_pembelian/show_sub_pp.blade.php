<x-app-layout :title="__('- Sub Permintaan Pembelian Proyek')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permintaan Pembelian - List PP') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                    <div>
                        <div x-data="{
                            kodeProject: '{{ $permintaan_Pembelian->anggaran->project->kode_project }}',
                            namaProject: `{{ $permintaan_Pembelian->anggaran->project->nama_project }}`,
                            kodeTransaksi: '{{ $permintaan_Pembelian->transaksi->kode_transaksi }}',
                            namaTransaksi: '{{ $permintaan_Pembelian->transaksi->nama_transaksi }}',
                            nomorPP: '{{ $permintaan_Pembelian->nomor_pp }}',
                        }">
                            <div>
                                <x-input-label for="nomor_pp" :value="__('Nomor PP')" />
                                <x-text-input id="nomor_pp" class="block mt-1 w-full" type="text" readonly
                                    name="nomor_pp" x-model="nomorPP" />
                                <x-input-error :messages="$errors->get('nomor_pp')" class="mt-2" />
                            </div>
                            <x-input-label class="mt-2" for="kode_anggaran" :value="__('Proyek Peminta')" />
                            <div class="grid grid-cols-12 gap-2">
                                <div class="col-span-4">
                                    <x-text-input id="kode_anggaran" class="block mt-1 w-full" type="text"
                                        name="kode_anggaran" x-model="kodeProject" readonly required />
                                </div>
                                <div class="relative col-span-8">
                                    <x-text-input id="anggaran_project" class="block mt-1 w-full" type="text"
                                        x-model="namaProject" readonly required />
                                    <x-secondary-button type="button" class="absolute py-2 px-3 right-1 top-2"
                                        x-on:click="$dispatch('open-modal', 'anggaran_modal_permintaan_pembelian')"
                                        disabled>
                                        <x-eva-search-outline class="w-4" />
                                    </x-secondary-button>
                                </div>
                                <div class="col-span-4">
                                    <x-input-label for="kode_rekanan" :value="__('Kode Transaksi')" class="mt-1" />
                                    <x-text-input id="kode_rekanan" class="block mt-1 w-full" type="text"
                                        name="kode_rekanan" x-model="kodeTransaksi" readonly required />
                                    <input type="text" name="rekanan_id" x-model="idTransaksi" hidden>
                                </div>
                                <div class="col-span-8">
                                    <x-input-label for="kode_anggaran" :value="__('Nama Transaksi')" class="mt-1" />
                                    <div class="relative">
                                        <x-text-input id="anggaran_project" class="block mt-1 w-full" type="text"
                                            x-model="namaTransaksi" readonly required />
                                        <x-secondary-button disabled type="button"
                                            class="absolute py-2 px-3 right-1 top-1"
                                            x-on:click="$dispatch('open-modal', 'transaksi_modal_order_pembelian')">
                                            <x-eva-search-outline class="w-4" />
                                        </x-secondary-button>
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <x-input-label for="tgl_pp" :value="__('Tanggal')" class="mt-2" />
                                    <x-text-input id="tgl_pp" class="block mt-1 w-full" type="date" name="tgl_pp"
                                        value="{{ $permintaan_Pembelian->tgl_pp }}" readonly />
                                </div>
                                <div class="col-span-8">
                                    <div class="flex flex-col space-y-2">
                                        <div class="flex space-x-2">
                                            <div class="flex-grow">
                                                <x-input-label :value="__('Tanda Tangan')" class="mt-2" />
                                                <select id="tanda_tangan"
                                                    class="appearance-none dark:bg-gray-900 mt-1 rounded-l rounded-md border inline-block w-full bg-white border-gray-700 dark:text-white text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                    name="tanda_tangan">
                                                    @if (is_array($permintaan_Pembelian->tandatangan_pp) && !empty($permintaan_Pembelian->tandatangan_pp))
                                                        @foreach ($permintaan_Pembelian->tandatangan_pp as $key => $value)
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
                                                    @if (is_array($permintaan_Pembelian->tandatangan_pp) && !empty($permintaan_Pembelian->tandatangan_pp))
                                                        @foreach ($permintaan_Pembelian->tandatangan_pp as $key => $value)
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
            <a href="{{ route('permintaanPembelians.index') }}">
                <x-primary-button class="mt-4 px-4 py-2">Kembali</x-primary-button>
            </a>
            <div class="mt-4">
                @include('pages.permintaan_pembelian.table_sub_pp')
            </div>
            {{-- Modal --}}
            @include('pages.permintaan_pembelian.add_sub_pp_modal')
            @include('pages.permintaan_pembelian.edit_sub_pp_modal')
            @include('pages.permintaan_pembelian.delete_sub_pp_modal')
            @include('pages.permintaan_pembelian.sub_anggaran_modal')
        </div>
    </div>
</x-app-layout>
