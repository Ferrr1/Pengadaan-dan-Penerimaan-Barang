<x-app-layout :title="__('- Anggaran Pelaksanaan Proyek')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Anggaran Pelaksanaan Proyek - Daftar Anggaran') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('anggarans.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-input-label for="kode" :value="__('Kode Proyek')" />
                                <div class="relative">
                                    <div x-data="{ kodeProject: '', namaProject: '' }"
                                        @select-project.window="kodeProject = $event.detail.id; namaProject = $event.detail.name">
                                        <x-text-input id="project" class="block mt-1 w-full" type="text"
                                            name="project" x-model="kodeProject" readonly required />
                                        <x-input-label for="kode" class="mt-2" :value="__('Nama Proyek')" />
                                        <x-text-input id="project" class="block mt-1 w-full" type="text"
                                            name="project" x-model="namaProject" readonly required />
                                        <input type="hidden" name="kode_anggaran_project" x-model="kodeProject" />
                                        <input type="hidden" name="nama_anggaran_project" x-model="namaProject" />
                                        <x-input-error :messages="$errors->get('kel_anggaran_project')" class="mt-2" />
                                        <x-secondary-button type="button" class="absolute py-2 px-3 right-1 top-1"
                                            x-on:click="$dispatch('open-modal', 'project_modal_anggaran')">
                                            <x-eva-search-outline class="w-4" />
                                        </x-secondary-button>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
                <x-primary-button class="mt-4 px-4 py-2">Tambah Anggaran</x-primary-button>
            </form>
            <div class="mt-4">
                @include('pages.anggaran.table')
            </div>
            {{-- Modal --}}
            @include('pages.anggaran.delete_modal')
            @include('pages.anggaran.project_modal')
        </div>
    </div>
</x-app-layout>
