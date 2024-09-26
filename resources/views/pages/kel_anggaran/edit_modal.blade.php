@foreach ($kel_anggarans as $kel_anggaran)
    <x-modal name="edit_modal_kel_anggaran{{ $kel_anggaran->id }}}" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Edit Kelompok Anggaran
            </h2>
            {{-- Table Start --}}
            <div>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <form action="{{ route('kel_anggarans.update', $kel_anggaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div class="p-1">
                                <x-input-label for="kode_kel_anggaran" :value="__('Kode KelAnggaran')" />
                                <x-text-input id="kode_kel_anggaran" class="block mt-1 w-full" type="text"
                                    name="kode_kel_anggaran" autofocus value="{{ $kel_anggaran->kode_kel_anggaran }}"
                                    readonly />
                            </div>
                            <div class="p-1">
                                <x-input-label for="nama_kel_anggaran" :value="__('Nama KelAnggaran')" />
                                <x-text-input id="nama_kel_anggaran" class="block mt-1 w-full" type="text"
                                    name="nama_kel_anggaran" value="{{ $kel_anggaran->nama_kel_anggaran }}" />
                            </div>
                        </div>
                        <x-primary-button class="px-4 py-2 ml-1 mt-3">Simpan</x-primary-button>
                    </form>
                </div>
            </div>
            {{-- Table End --}}
        </div>
    </x-modal>
@endforeach
