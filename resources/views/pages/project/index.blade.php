<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Proyek') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="kode_project" :value="__('Kode Proyek')" />
                                <x-text-input id="kode_project" class="block mt-1 w-full" type="text"
                                    value="{{ $nextKodeProject }}" readonly name="kode_project" />
                                <x-input-error :messages="$errors->get('kode_project')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nama_project" :value="__('Nama Proyek')" />
                                <x-text-input id="nama_project" class="block mt-1 w-full" type="text"
                                    name="nama_project" required />
                                <x-input-error :messages="$errors->get('nama_project')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tgl_mulai" :value="__('Tanggal Mulai')" />
                                <x-text-input id="tgl_mulai" class="block mt-1 w-full" type="date" required
                                    name="tgl_mulai" />
                                <x-input-error :messages="$errors->get('tgl_mulai')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="status_project" :value="__('Status Proyek')" />
                                <select name="status_project" id="status_project"
                                    class="appearance-none dark:bg-gray-900 mt-1 rounded-l rounded-md border inline-block w-full bg-white border-gray-700 dark:text-white text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    required>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak_aktif">Tidak Aktif</option>
                                </select>
                                <x-input-error :messages="$errors->get('status_project')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
                <x-primary-button class="mt-4 px-4 py-2">Add Proyek</x-primary-button>
            </form>
            <div class="mt-4">
                @include('pages.project.table')
            </div>
            {{-- Modal --}}
            @include('pages.project.edit_modal')
            @include('pages.project.delete_modal')
        </div>
    </div>
</x-app-layout>
