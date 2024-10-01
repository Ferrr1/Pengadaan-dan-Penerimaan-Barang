<x-modal name="satuan_modal_produk" :show="false">
    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Satuan
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Daftar Satuan...
        </p>
        {{-- Table Start --}}
        <input id="search" placeholder="Search" name="search"
            class="appearance-none dark:bg-gray-900 dark:text-white rounded-md mt-2 border border-gray-700 border-b block py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
        <div>
            <div class="pt-4 overflow-x-auto">
                <div class="inline-block min-w-full shadow rounded-md overflow-hidden">
                    <table id="tableForSearch" class="min-w-full leading-normal">
                        <thead class="dark:bg-gray-900 dark:text-white bg-gray-100 text-gray-600">
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                    No
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                    Kode Satuan
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                    Nama Satuan
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                    Singkatan Satuan
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
                            @forelse ($satuans as $satuan)
                                <tr class="text-sm border-b-2 border-gray-200 dark:border-gray-700">
                                    <td class="px-5 py-5">
                                        <p class="whitespace-no-wrap">{{ $loop->iteration }}</p>
                                    </td>
                                    <td class="px-5 py-5">
                                        <p class="whitespace-no-wrap">{{ $satuan->kode_satuan }}</p>
                                    </td>
                                    <td class="px-5 py-5">
                                        <p class="whitespace-no-wrap">{{ $satuan->nama_satuan }}</p>
                                    </td>
                                    <td class="px-5 py-5">
                                        <p class="whitespace-no-wrap">{{ $satuan->singkatan_satuan }}</p>
                                    </td>
                                    <td class="px-5 py-5 flex gap-2 items-center justify-start">
                                        <!-- Checkmark Button with Click Event -->
                                        <x-primary-button class="p-1" x-data
                                            x-on:click="
                                        $dispatch('select-satuan', { id: '{{ $satuan->id }}', name: '{{ $satuan->nama_satuan }}' });
                                        $dispatch('close-modal', 'satuan_modal_produk');">
                                            <x-eva-checkmark-outline class="w-5 h-5" />
                                        </x-primary-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-5 py-5 text-sm border-b-2 border-gray-200 dark:border-gray-700 text-center">
                                        Tidak ada data Satuan yang tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- Table End --}}
    </div>
</x-modal>
<script>
    document.getElementById('search').addEventListener('keyup', function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tableForSearch tbody tr');

        rows.forEach(row => {
            const cells = row.getElementsByTagName('td');
            let rowVisible = false;

            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(query)) {
                    rowVisible = true;
                    break;
                }
            }

            row.style.display = rowVisible ? '' : 'none';
        });
    });
</script>
