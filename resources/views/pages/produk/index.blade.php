<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Produk') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="kode_produk" :value="__('Kode Produk')" />
                                <x-text-input id="kode_produk" class="block mt-1 w-full" type="text"
                                    value="{{ $nextKodeProduk }}" readonly name="kode_produk" />
                                <x-input-error :messages="$errors->get('kode_produk')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nama_produk" :value="__('Nama Produk')" />
                                <x-text-input id="nama_produk" class="block mt-1 w-full" type="text"
                                    name="nama_produk" required />
                                <x-input-error :messages="$errors->get('nama_produk')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="harga_produk" :value="__('Harga Produk')" />
                                <x-text-input id="harga_produk" class="block mt-1 w-full" type="number"
                                    name="harga_produk" required step="0.01" />
                                <x-input-error :messages="$errors->get('harga_produk')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="satuan" :value="__('Satuan')" />
                                <div class="relative">
                                    <div x-data="{ satuanId: '', satuanName: '' }"
                                        @select-satuan.window="satuanId = $event.detail.id; satuanName = $event.detail.name">
                                        <x-text-input id="satuan" class="block mt-1 w-full" type="text"
                                            name="satuan" x-model="satuanName" readonly />
                                        <input type="hidden" name="satuan_id" x-model="satuanId" />

                                        <x-secondary-button type="button" class="absolute py-2 px-3 right-1 top-1"
                                            x-on:click="$dispatch('open-modal', 'satuan_modal_produk')">
                                            <x-eva-search-outline class="w-4" />
                                        </x-secondary-button>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
                <x-primary-button class="mt-4 px-4 py-2">Add Produk</x-primary-button>
            </form>
            <div class="mt-4">
                @include('pages.produk.table')
            </div>
            {{-- Modal --}}
            @include('pages.produk.edit_modal')
            @include('pages.produk.satuan')
            @include('pages.produk.delete_modal')
        </div>
    </div>
</x-app-layout>
