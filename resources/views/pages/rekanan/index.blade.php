<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rekanan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="kode_rekanan" :value="__('Kode Rekanan')" />
                                <x-text-input id="kode_rekanan" class="block mt-1 w-full" type="text"
                                    value="{{ $nextKodeRekanan }}" readonly name="kode_rekanan" />
                                <x-input-error :messages="$errors->get('kode_rekanan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nama_rekanan" :value="__('Nama Rekanan')" />
                                <x-text-input id="nama_rekanan" class="block mt-1 w-full" type="text"
                                    name="nama_rekanan" required />
                                <x-input-error :messages="$errors->get('nama_rekanan')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="alamat_rekanan" :value="__('Alamat Rekanan')" />
                                <x-text-input id="alamat_rekanan" class="block mt-1 w-full" type="text" required
                                    name="alamat_rekanan" />
                                <x-input-error :messages="$errors->get('alamat_rekanan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="telepon_rekanan" :value="__('Telepon Rekanan')" />
                                <x-text-input id="telepon_rekanan" class="block mt-1 w-full" type="number" required
                                    name="telepon_rekanan" />
                                <x-input-error :messages="$errors->get('telepon_rekanan')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="email_rekanan" :value="__('Email Rekanan')" />
                                <x-text-input id="email_rekanan" class="block mt-1 w-full" type="email" required
                                    name="email_rekanan" />
                                <x-input-error :messages="$errors->get('email_rekanan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="status_rekanan" :value="__('Status Rekanan')" />
                                <select name="status_rekanan" id="status_rekanan"
                                    class="appearance-none dark:bg-gray-900 mt-1 rounded-l rounded-md border inline-block w-full bg-white border-gray-700 dark:text-white text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    required>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak_aktif">Tidak Aktif</option>
                                </select>
                                <x-input-error :messages="$errors->get('status_rekanan')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tgl_bergabung" :value="__('Tgl Bergabung Rekanan')" />
                                <x-text-input id="tgl_bergabung" class="block mt-1 w-full" type="date" required
                                    name="tgl_bergabung" />
                                <x-input-error :messages="$errors->get('tgl_bergabung')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tgl_akhir" :value="__('Tgl Akhir Rekanan')" />
                                <x-text-input id="tgl_akhir" class="block mt-1 w-full" type="date" required
                                    name="tgl_akhir" />
                                <x-input-error :messages="$errors->get('tgl_akhir')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
                <x-primary-button class="mt-4 px-4 py-2">Tambah Rekanan</x-primary-button>
            </form>
            <div class="mt-4">
                @include('pages.rekanan.table')
            </div>
            {{-- Modal --}}
            @include('pages.rekanan.edit_modal')
            @include('pages.rekanan.delete_modal')
        </div>
    </div>
</x-app-layout>
