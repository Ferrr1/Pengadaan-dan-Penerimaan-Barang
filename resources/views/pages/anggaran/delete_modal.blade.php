@foreach ($anggarans as $anggaran)
    <x-modal name="delete_modal_anggaran{{ $anggaran->id }}}" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Delete Anggaran
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Apakah anda yakin ingin menghapus anggaran ini?</p>
            {{-- Table Start --}}
            <div class="flex justify-end">
                <div class="p-4 overflow-x-auto">
                    <form action="{{ route('anggarans.destroy', $anggaran->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-danger-button class="px-4 py-2 ml-1 mt-3">Delete</x-danger-button>
                    </form>
                </div>
            </div>
            {{-- Table End --}}
        </div>
    </x-modal>
@endforeach
