<x-app-layout :title="__('- Kelompok Anggaran')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelompok Anggaran') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('kelAnggarans.store') }}" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="kode_kel_anggaran" :value="__('Kode Kelompok Anggaran')" />
                                <x-text-input id="kode_kel_anggaran" class="block mt-1 w-full" type="text"
                                    value="{{ $nextKodeKelAnggaran }}" readonly name="kode_kel_anggaran" />
                                <x-input-error :messages="$errors->get('kode_kel_anggaran')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nama_kel_anggaran" :value="__('Nama Kelompok Anggaran')" />
                                <x-text-input id="nama_kel_anggaran" class="block mt-1 w-full" type="text"
                                    name="nama_kel_anggaran" required />
                                <x-input-error :messages="$errors->get('nama_kel_anggaran')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
                <x-primary-button class="mt-4 px-4 py-2">Tambah Kelompok Anggaran</x-primary-button>
            </form>
            <div class="mt-4">
                @include('pages.kel_anggaran.table')
            </div>
            {{-- Modal --}}
            @include('pages.kel_anggaran.edit_modal')
            @include('pages.kel_anggaran.delete_modal')
        </div>
    </div>
</x-app-layout>
