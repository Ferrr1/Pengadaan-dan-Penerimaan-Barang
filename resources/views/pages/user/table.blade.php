<div class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        User
    </h2>
    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Table Data User...
    </p>
    {{-- Table Start --}}
    <div>
        <div class="my-2 flex sm:flex-row flex-col">
            <div class="flex flex-row mb-1 sm:mb-0">
                <div class="relative">
                    <select
                        class="appearance-none dark:bg-gray-900 h-full rounded-l border block w-full bg-white border-gray-700 dark:text-white text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option>5</option>
                        <option>10</option>
                        <option>20</option>
                    </select>
                </div>
                <div class="relative">
                    <select
                        class="appearance-none dark:bg-gray-900 h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block w-full bg-white border-gray-700 dark:text-white text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                        <option>Semua</option>
                        <option>Aktif</option>
                        <option>Tidak Aktif</option>
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
                <input placeholder="Cari"
                    class="appearance-none dark:bg-gray-900 dark:text-white rounded-r rounded-l sm:rounded-l-none border border-gray-700 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
            </div>
        </div>
        <div class="pt-4 overflow-x">
            <div class="inline-block min-w-full shadow rounded-md overflow-x-auto w-full">
                <table class="min-w-full leading-normal">
                    <thead class="dark:bg-gray-900 dark:text-white bg-gray-100 text-gray-600">
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Id
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Nama
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Email
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-left text-xs font-semibold uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
                        @foreach ($users as $user)
                            <tr id="user_{{ $user->id }}"
                                class="text-sm border-b-2 border-gray-200 dark:border-gray-700">
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">{{ $user->id }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">{{ $user->name }}</p>
                                </td>
                                <td class="px-5 py-5">
                                    <p class="whitespace-no-wrap">{{ $user->email }}</p>
                                </td>
                                <td class="px-5 py-5 flex gap-2 items-center justify-center">
                                    <x-primary-button x-data=""
                                        x-on:click="fetchUserData({{ $user->id }}).then(() => $dispatch('open-modal', 'modal_user'))"
                                        class="p-2"><x-eva-edit-2-outline class="w-5 h-5" /></x-primary-button>
                                    <x-danger-button class="p-2 delete-btn"
                                        data-id="{{ $user->id }}"><x-eva-trash-outline
                                            class="w-5 h-5" /></x-danger-button>
                                </td>
                            </tr>
                        @endforeach
                        <!-- Tambahkan baris lain sesuai kebutuhan -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Table End --}}
</div>
