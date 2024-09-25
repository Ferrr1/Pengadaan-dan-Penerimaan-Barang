<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Satuan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('satuans.store') }}" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="kode_satuan" :value="__('Kode Satuan')" />
                                <x-text-input id="kode_satuan" class="block mt-1 w-full" type="text"
                                    name="kode_satuan" value="{{ $nextKodeSatuan }}" readonly />
                                <x-input-error :messages="$errors->get('kode_satuan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nama_satuan" :value="__('Nama Satuan')" />
                                <x-text-input id="nama_satuan" class="block mt-1 w-full" type="text"
                                    name="nama_satuan" required />
                                <x-input-error :messages="$errors->get('nama_satuan')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="singkatan_satuan" :value="__('Singkatan Satuan')" />
                                <x-text-input id="singkatan_satuan" class="block mt-1 w-full" type="text"
                                    name="singkatan_satuan" required />
                                <x-input-error :messages="$errors->get('singkatan_satuan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="deskripsi_satuan" :value="__('Deskripsi Satuan')" />
                                <x-text-input id="deskripsi_satuan" class="block mt-1 w-full" type="text"
                                    name="deskripsi_satuan" required />
                                <x-input-error :messages="$errors->get('deskripsi_satuan')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
                <x-primary-button class="mt-4 px-4 py-2">Add Satuan</x-primary-button>
            </form>
            <div class="mt-4">
                @include('pages.satuan.table')
            </div>
            {{-- Modal --}}
            @include('pages.satuan.edit_modal')
            @include('pages.satuan.delete_modal')
        </div>
    </div>
</x-app-layout>
