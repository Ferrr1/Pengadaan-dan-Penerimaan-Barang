<div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Sub Permintaan
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Daftar Sub Permintaan...
            </p>
        </div>
        <div class="flex gap-2">
            <x-secondary-button class="mt-4 px-4 py-2">Cetak Laporan</x-secondary-button>
            <x-primary-button x-data="" x-on:click="$dispatch('open-modal', `sub_pp_modal`)"
                class="mt-4 px-4 py-2">Tambah Sub Permintaan</x-primary-button>
        </div>
    </div>
    {{-- Table Start --}}
    <div>
        <form>
            <div class="my-2 flex sm:flex-row flex-col">
                <div class="flex flex-row mb-1 sm:mb-0">
                    <div class="relative">
                        <select name="perPage" id="perPage"
                            class="appearance-none dark:bg-gray-900 h-full rounded-l border block w-full bg-white border-gray-700 dark:text-white text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            onchange="this.form.submit()">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                            <option value="all" {{ $perPage == 'all' ? 'selected' : '' }}>All</option>
                        </select>
                    </div>
                </div>
                <div class="block relative">
                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                            <path
                                d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                            </path>
                        </svg>
                    </span>
                    <input placeholder="Search By Kode & Nama" name="search" value="{{ request('search') }}"
                        onchange="this.form.submit()"
                        class="appearance-none dark:bg-gray-900 dark:text-white rounded-r rounded-l sm:rounded-l-none border border-gray-700 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                </div>
            </div>
        </form>
        <div class="pt-4 overflow-auto">
            <div class="inline-block shadow rounded-md overflow-x-auto w-full">
                <table class="min-w-full leading-normal">
                    <thead class="dark:bg-gray-900 dark:text-white bg-gray-100 text-gray-600">
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                No
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                No Detail Anggaran
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Nama Anggaran
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Kode Barang
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Nama Barang
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Spesifikasi
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Kuantitas
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Satuan
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Harga Satuan
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Jumlah Harga
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Keterangan
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
                        @forelse ($subPermintaanPembelians as $subPermintaanPembelian)
                            <tr class="text-sm border-b-2 border-gray-200 dark:border-gray-700">
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">{{ $loop->iteration }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">
                                        {{ $subPermintaanPembelian->subAnggaran->no_detail }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">
                                        {{ $subPermintaanPembelian->produk->nama_produk }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">
                                        {{ $subPermintaanPembelian->produk->kode_produk }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">
                                        {{ $subPermintaanPembelian->produk->nama_produk }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">
                                        {{ $subPermintaanPembelian->spesifikasi_sub_permintaan_pembelian }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">
                                        {{ $subPermintaanPembelian->kuantitas_sub_permintaan_pembelian }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <span
                                        class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 rounded-full"></span>
                                        <span class="relative">
                                            {{ $subPermintaanPembelian->produk->satuan->singkatan_satuan }}
                                        </span>
                                    </span>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">
                                        {{ formatRupiah($subPermintaanPembelian->harga_sub_permintaan_pembelian) }}
                                    </p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap text-nowrap">
                                        {{ formatRupiah($subPermintaanPembelian->total_sub_permintaan_pembelian) }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-nowrap text-nowrap">
                                        {{ $subPermintaanPembelian->keterangan_sub_permintaan_pembelian ?? 'Tidak ada keterangan' }}
                                    </p>
                                </td>
                                <td class="px-5 py-5 flex gap-2 items-center justify-center">
                                    <x-primary-button type="button" class="p-2" x-data=""
                                        x-on:click="$dispatch('open-modal', `edit_modal_sub_pp{{ $subPermintaanPembelian->id }}}`)">
                                        <x-eva-edit-2-outline class="w-5 h-5" />
                                    </x-primary-button>
                                    {{-- Delete Button Modal --}}
                                    <x-danger-button type="button" class="p-2" x-data=""
                                        x-on:click="$dispatch('open-modal', `delete_modal_sub_pp{{ $subPermintaanPembelian->id }}}`)">
                                        <x-eva-trash-outline class="w-5 h-5" />
                                    </x-danger-button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12"
                                    class="px-5 py-5 text-sm border-b-2 border-gray-200 dark:border-gray-700 text-center">
                                    Tidak ada data sub permintaan pembelian yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-1 flex justify-end">
                <div class="flex gap-4">
                    <div>
                        <x-input-label :value="__('Sub Total PP')" />
                        <x-text-input class="block mt-1 w-full" type="text"
                            value="{{ formatRupiah($total_harga_satuan) }}" disabled />
                    </div>
                    <div>
                        <x-input-label :value="__('Total PP')" />
                        <x-text-input class="block mt-1 w-full" type="text"
                            value="{{ formatRupiah($total_jumlah_harga) }}" disabled />
                    </div>
                </div>
            </div>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-between">
                <div>
                    @if ($subPermintaanPembelians instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{ $subPermintaanPembelians->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- Table End --}}
</div>
