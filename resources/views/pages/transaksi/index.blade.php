<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('transaksis.store') }}" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="kode_transaksi" :value="__('Kode Transaksi')" />
                                <x-text-input id="kode_transaksi" class="block mt-1 w-full" type="text"
                                    value="{{ $nextKodeTransaksi }}" readonly name="kode_transaksi" />
                                <x-input-error :messages="$errors->get('kode_transaksi')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nama_transaksi" :value="__('Nama Transaksi')" />
                                <x-text-input id="nama_transaksi" class="block mt-1 w-full" type="text"
                                    name="nama_transaksi" required />
                                <x-input-error :messages="$errors->get('nama_transaksi')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
                <x-primary-button class="mt-4 px-4 py-2">Tambah Transaksi</x-primary-button>
            </form>
            <div class="mt-4">
                @include('pages.transaksi.table')
            </div>
            {{-- Modal --}}
            @include('pages.transaksi.edit_modal')
            @include('pages.transaksi.delete_modal')
        </div>
    </div>
</x-app-layout>
