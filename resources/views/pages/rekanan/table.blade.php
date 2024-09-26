<div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        Rekanan
    </h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Daftar Rekanan...
    </p>
    {{-- Table Start --}}
    <div>
        <form action="{{ route('suppliers.index') }}" method="GET">
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
                    <div class="relative">
                        <select name="perStatus" id="perStatus" onchange="this.form.submit()"
                            class="appearance-none
                            dark:bg-gray-900 h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b
                            block w-full bg-white border-gray-700 dark:text-white text-gray-700 py-2 px-4 pr-8
                            leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white
                            focus:border-gray-500">
                            <option value="all" {{ $perStatus === 'tidak_aktif' ? 'selected' : '' }}>Semua</option>
                            <option value="aktif" {{ $perStatus === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ $perStatus === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif
                            </option>
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
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-md overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead class="dark:bg-gray-900 dark:text-white bg-gray-100 text-gray-600">
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                No
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Kode Rekanan
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Nama Rekanan
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Alamat Rekanan
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                No Telp Rekanan
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Email Rekanan
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Status Rekanan
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Tgl Gabung Rekanan
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Tgl Akhir Rekanan
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
                        @forelse ($rekanans as $rekanan)
                            <tr class="text-sm border-b-2 border-gray-200 dark:border-gray-700">
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">{{ $loop->iteration }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">{{ $rekanan->kode_rekanan }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">{{ $rekanan->nama_rekanan }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">{{ $rekanan->alamat_rekanan }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">{{ $rekanan->telepon_rekanan }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">{{ $rekanan->email_rekanan }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <span
                                        class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 rounded-full"></span>
                                        <span class="relative">
                                            {{ $rekanan->status_rekanan === 'aktif' ? 'AKTIF' : 'TIDAK AKTIF' }}
                                        </span>
                                    </span>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">{{ $rekanan->tgl_bergabung }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">{{ $rekanan->tgl_akhir }}</p>
                                </td>
                                <td class="px-5 py-5 flex gap-2 items-center justify-center">
                                    <x-primary-button class="p-2" x-data=""
                                        x-on:click="$dispatch('open-modal', `edit_modal_rekanan{{ $rekanan->id }}}`)">
                                        <x-eva-edit-2-outline class="w-5 h-5" />
                                    </x-primary-button>
                                    {{-- Delete Button --}}
                                    <x-danger-button class="p-2" x-data=""
                                        x-on:click="$dispatch('open-modal', `delete_modal_rekanan{{ $rekanan->id }}}`)">
                                        <x-eva-trash-outline class="w-5 h-5" />
                                    </x-danger-button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11"
                                    class="px-5 py-5 text-sm border-b-2 border-gray-200 dark:border-gray-700 text-center">
                                    Tidak ada data proyek yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-between">
                <div>
                    @if ($rekanans instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{ $rekanans->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- Table End --}}
</div>
