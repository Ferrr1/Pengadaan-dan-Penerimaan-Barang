<x-modal name="sub_anggaran_modal_sub_pp" :show="false">
    <div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Sub Anggaran
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Daftar Sub Anggaran...
        </p>
        {{-- Table Start --}}
        <input id="searchSubAnggaran" placeholder="Search" name="searchSubAnggaran"
            class="appearance-none dark:bg-gray-900 dark:text-white rounded-md mt-2 border border-gray-700 border-b block py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
        <div>
            <div class="pt-4 overflow-x">
                <div class="inline-block min-w-full shadow rounded-md overflow-x-auto w-full">
                    <table id="tableForSearchSubAnggaran" class="min-w-full leading-normal">
                        <thead class="dark:bg-gray-900 dark:text-white bg-gray-100 text-gray-600">
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                    No
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                    No Detail
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                    Kode
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                    Nama
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                    Kuantitas
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                    Harga Satuan
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
                            @forelse ($subAnggarans as $subAnggaran)
                                <tr class="text-sm border-b-2 border-gray-200 dark:border-gray-700">
                                    <td class="px-5 py-5">
                                        <p class="whitespace-no-wrap">{{ $loop->iteration }}</p>
                                    </td>
                                    <td class="px-5 py-5">
                                        <p class="whitespace-no-wrap">{{ $subAnggaran->no_detail }}</p>
                                    </td>
                                    <td class="px-5 py-5">
                                        <p class="whitespace-no-wrap">{{ $subAnggaran->produks->kode_produk }}</p>
                                    </td>
                                    <td class="px-5 py-5">
                                        <p class="whitespace-no-wrap">{{ $subAnggaran->produks->nama_produk }}</p>
                                    </td>
                                    <td class="px-5 py-5">
                                        <p class="whitespace-no-wrap">
                                            {{ formatAngka($subAnggaran->kuantitas_anggaran) }}</p>
                                    </td>
                                    <td class="px-5 py-5">
                                        <p class="whitespace-no-wrap">{{ formatRupiah($subAnggaran->harga_anggaran) }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 flex gap-2 items-center justify-start">
                                        <!-- Checkmark Button with Click Event -->
                                        <x-primary-button class="p-1" x-data
                                            x-on:click="
                                        $dispatch('select-sub-anggaran', { id: '{{ $subAnggaran->id }}', idProduk: '{{ $subAnggaran->produks->id }}', kodeProduk: '{{ $subAnggaran->produks->kode_produk }}', satuanProduk: '{{ $subAnggaran->produks->satuan->nama_satuan }}' , nodetail: '{{ $subAnggaran->no_detail }}', name: '{{ $subAnggaran->produks->nama_produk }}', satuan: '{{ $subAnggaran->produks->satuan->nama_satuan }}', harga: '{{ $subAnggaran->harga_anggaran }}' });
                                        $dispatch('close-modal', 'sub_anggaran_modal_sub_pp');">
                                            <x-eva-checkmark-outline class="w-5 h-5" />
                                        </x-primary-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-5 py-5 text-sm border-b-2 border-gray-200 dark:border-gray-700 text-center">
                                        Tidak ada data Sub Anggaran yang tersedia.
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
    document.getElementById('searchSubAnggaran').addEventListener('keyup', function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tableForSearchSubAnggaran tbody tr');

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
