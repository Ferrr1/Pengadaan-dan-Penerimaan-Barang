<x-app-layout :title="__('- Sub Permintaan Pembelian Proyek')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permintaan Pembelian - List Anggaran') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <x-input-label for="kode" :value="__('Kode Proyek')" />
                            <div class="relative">
                                <div x-data="{ kodeProject: '{{ $projects->kode_project }}', namaProject: '{{ $projects->nama_project }}' }"
                                    @select-project.window="kodeProject = $event.detail.id; namaProject = $event.detail.name">
                                    <x-text-input id="project" class="block mt-1 w-full" type="text" name="project"
                                        x-model="kodeProject" readonly />
                                    <x-input-label for="kode" class="mt-2" :value="__('Nama Proyek')" />
                                    <x-text-input id="project" class="block mt-1 w-full" type="text" name="project"
                                        x-model="namaProject" readonly />
                                    {{-- <input type="hidden" name="kode_project" x-model="kodeProject" />
                                        <input type="hidden" name="nama_project" x-model="namaProject" /> --}}

                                    <x-secondary-button disabled type="button" class="absolute py-2 px-3 right-1 top-1"
                                        x-on:click="$dispatch('open-modal', 'project_modal_anggaran')">
                                        <x-eva-search-outline class="w-4" />
                                    </x-secondary-button>
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('no_detail')" class="mt-2" />
                        <x-input-error :messages="$errors->get('kode_anggaran')" class="mt-2" />
                        <x-input-error :messages="$errors->get('nama_anggaran')" class="mt-2" />
                        <x-input-error :messages="$errors->get('satuan_id')" class="mt-2" />
                        <x-input-error :messages="$errors->get('kuantitas_anggaran')" class="mt-2" />
                        <x-input-error :messages="$errors->get('harga_anggaran')" class="mt-2" />
                    </div>
                </div>
            </div>
            <a href="{{ route('anggarans.index') }}">
                <x-primary-button class="mt-4 px-4 py-2">Kembali</x-primary-button>
            </a>
            <div class="mt-4">
                @include('pages.anggaran.table_sub_anggaran')
            </div>
            {{-- Modal --}}
            @include('pages.anggaran.add_sub_anggaran_modal')
            @include('pages.anggaran.edit_sub_anggaran_modal')
            @include('pages.anggaran.delete_sub_anggaran_modal')
            @include('pages.anggaran.satuan')
            {{-- @include('pages.anggaran.delete_modal') --}}
        </div>
    </div>
</x-app-layout>
