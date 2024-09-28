<x-app-layout :title="__('- Permintaan Pembelian')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permintaan Pembelian - Daftar PP') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('permintaanPembelians.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                        <div>
                            <div x-data="{
                                kodeProject: '',
                                namaProject: '',
                                nomorPP: '{{ $newPPCode }}',
                                updateNomorPP() {
                                    this.nomorPP = this.nomorPP.replace('XXXXX', this.kodeProject);
                                }
                            }"
                                @select-anggaran.window="
                                kodeProject = $event.detail.id;
                                namaProject = $event.detail.name;
                                updateNomorPP();
                            ">
                                <div>
                                    <x-input-label for="nomor_pp" :value="__('Nomor PP')" />
                                    <x-text-input id="nomor_pp" class="block mt-1 w-full" type="text" readonly
                                        name="nomor_pp" x-model="nomorPP" />
                                    <x-input-error :messages="$errors->get('nomor_pp')" class="mt-2" />
                                </div>
                                <x-input-label class="mt-2" for="kode_anggaran" :value="__('Proyek Peminta')" />
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-4">
                                        <x-text-input id="kode_anggaran" class="block mt-1 w-full" type="text"
                                            name="kode_anggaran" x-model="kodeProject" readonly required />
                                    </div>
                                    <div class="relative col-span-8">
                                        <x-text-input id="anggaran_project" class="block mt-1 w-full" type="text"
                                            x-model="namaProject" readonly required />
                                        <x-secondary-button type="button" class="absolute py-2 px-3 right-1 top-2"
                                            x-on:click="$dispatch('open-modal', 'anggaran_modal_permintaan_pembelian')">
                                            <x-eva-search-outline class="w-4" />
                                        </x-secondary-button>
                                    </div>
                                    <div class="col-span-4">
                                        <x-input-label for="tgl_pp" :value="__('Tanggal')" />
                                        <x-text-input id="tgl_pp" class="block mt-1 w-full" type="date"
                                            name="tgl_pp" required />
                                    </div>
                                    <div class="relative col-span-8">
                                        <x-input-label for="tandatangan_pp" :value="__('Tanda Tangan')" />
                                        <x-text-input id="tandatangan_pp" class="block mt-1 w-full" type="text"
                                            name="tandatangan_pp" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <x-primary-button class="mt-4 px-4 py-2">Tambah Permintaan Pembelian</x-primary-button>
            </form>
            <div class="mt-4">
                @include('pages.permintaan_pembelian.table')
            </div>
            {{-- Modal --}}
            @include('pages.permintaan_pembelian.delete_modal')
            @include('pages.permintaan_pembelian.project_anggaran_modal')
        </div>
    </div>
</x-app-layout>
