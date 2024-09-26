<!-- resources/views/components/sidebar.blade.php -->
<nav
    class="bg-white dark:bg-gray-800 sticky dark:text-white w-[300px] min-h-screen p-4 transition-all duration-300 ease-in-out">
    <div class="flex items-center mb-8">
        <h2 class="text-2xl font-semibold sidebar-full text-nowrap">SIM</h2>
    </div>
    <ul>
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="mb-4">
            <div class="flex items-center gap-2">
                <x-akar-dashboard class="w-5" /> {{ __('Dashboard') }}
            </div>
        </x-nav-link>
        <x-nav-link onclick="toggleSubmenu(this)" class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-2">
                <x-eva-list-outline class="w-5" />{{ __('Administrasi') }}
            </div>
            <x-eva-arrow-ios-downward-outline id="arrow"
                class="w-4 h-4 transition-transform duration-200 ease-in-out" />
        </x-nav-link>
        <ul class="p-4 bg-gray-400 dark:bg-gray-900 rounded-md hidden mb-4">
            <div class="flex flex-col gap-2">
                <x-nav-link :href="route('anggarans.index')" :active="request()->routeIs('anggarans.index')">
                    <div class="flex items-center gap-2">
                        <x-elemplus-money class="w-5" />{{ __('APP') }}
                    </div>
                </x-nav-link>
            </div>
        </ul>
        <x-nav-link onclick="toggleSubmenu(this)" class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-2">
                <x-eva-list-outline class="w-5" />{{ __('Data') }}
            </div>
            <x-eva-arrow-ios-downward-outline id="arrow"
                class="w-4 h-4 transition-transform duration-200 ease-in-out" />
        </x-nav-link>
        <ul class="p-4 bg-gray-400 dark:bg-gray-900 rounded-md hidden mb-4">
            <div class="flex flex-col gap-2">
                <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                    <div class="flex items-center gap-2">
                        <x-carbon-product class="w-5" />{{ __('Produk') }}
                    </div>
                </x-nav-link>
                <x-nav-link>
                    <div class="flex items-center gap-2">
                        <x-carbon-product class="w-5" />{{ __('Transaksi') }}
                    </div>
                </x-nav-link>
                <x-nav-link>
                    <div class="flex items-center gap-2">
                        <x-carbon-product class="w-5" />{{ __('Kel. Anggaran') }}
                    </div>
                </x-nav-link>
                <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.index')">
                    <div class="flex items-center gap-2">
                        <x-carbon-ibm-cloud-hyper-protect-dbaas class="w-5" />{{ __('Proyek') }}
                    </div>
                </x-nav-link>
                <x-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.index')">
                    <div class="flex items-center gap-2">
                        <x-carbon-box-small class="w-5" />{{ __('Supplier') }}
                    </div>
                </x-nav-link>
                <x-nav-link :href="route('satuans.index')" :active="request()->routeIs('satuans.index')">
                    <div class="flex items-center gap-2">
                        <x-iconoir-weight-alt class="w-5" />{{ __('Satuan') }}
                    </div>
                </x-nav-link>
                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    <div class="flex items-center gap-2">
                        <x-carbon-user-service class="w-5" />{{ __('Users') }}
                    </div>
                </x-nav-link>
            </div>
        </ul>
    </ul>
</nav>

<script>
    function toggleSubmenu(el) {
        const submenu = el.nextElementSibling;
        submenu.classList.toggle('hidden');
        el.querySelector('#arrow').classList.toggle('rotate-180');
    }
</script>
