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
                                idProject: '',
                                kodeProject: '',
                                namaProject: '',
                                nomorPP: '{{ $newPPCode }}',
                                updateNomorPP() {
                                    this.nomorPP = this.nomorPP.replace('XXXXX', this.kodeProject);
                                }
                            }"
                                @select-anggaran.window="
                                idProject = $event.detail.id;
                                kodeProject = $event.detail.kode;
                                namaProject = $event.detail.name;
                                updateNomorPP();
                            ">
                                <div>
                                    <x-input-label for="nomor_pp" :value="__('Nomor PP')" />
                                    <x-text-input id="nomor_pp" class="block mt-1 w-full" type="text" readonly
                                        name="nomor_pp" x-model="nomorPP" />
                                    <input type="text" name="anggaran_id" x-model="idProject" hidden>
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
                                            x-on:click="$dispatch('open-modal', 'anggaran_modal_permintaan_pembelian')">
                                            <x-eva-search-outline class="w-4" />
                                        </x-secondary-button>
                                    </div>
                                    <div class="col-span-4">
                                        <x-input-label for="tgl_pp" :value="__('Tanggal')" class="mt-2" />
                                        <x-text-input id="tgl_pp" class="block mt-1 w-full" type="date"
                                            name="tgl_pp" required />
                                    </div>
                                    <div x-data="tandaTanganHandler()" class="col-span-8">
                                        <template x-for="(item, index) in items" :key="index">
                                            <div class="flex flex-col space-y-2">
                                                <div class="flex space-x-2">
                                                    <div class="flex-grow">
                                                        <x-input-label :value="__('Tanda Tangan')" class="mt-2" />
                                                        <x-text-input
                                                            x-bind:id="'tandatangan_pp_' + index + '_tanda_tangan'"
                                                            class="block mt-1 w-full" type="text"
                                                            x-bind:name="'tandatangan_pp[' + index + '][tanda_tangan]'"
                                                            x-model="item.tandaTangan" required />
                                                    </div>
                                                    <div class="flex-grow">
                                                        <x-input-label :value="__('Posisi Jabatan')" class="mt-2" />
                                                        <x-text-input
                                                            x-bind:id="'tandatangan_pp_' + index + '_posisi_jabatan'"
                                                            class="block mt-1 w-full" type="text"
                                                            x-bind:name="'tandatangan_pp[' + index + '][posisi_jabatan]'"
                                                            x-model="item.posisiJabatan" required />
                                                    </div>
                                                    <div class="flex items-end mb-0.5 gap-2">
                                                        <x-primary-button type="button" @click="addItem" class="p-2"
                                                            x-show="items.length < 5">
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
                @include('pages.permintaan_pembelian.table')
            </div>
            {{-- Modal --}}
            @include('pages.permintaan_pembelian.delete_modal')
            @include('pages.permintaan_pembelian.project_anggaran_modal')
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('tgl_pp').valueAsDate = new Date();

    function tandaTanganHandler() {
        return {
            items: [{
                tandaTangan: '',
                posisiJabatan: ''
            }],
            addItem() {
                if (this.items.length < 5) {
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
