<x-modal name="modal_user" :show="false">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Detail User
        </h2>
        {{-- Table Start --}}
        <div>
            <div class="p-4 overflow-x-auto">
                <form action="">
                    <div class="grid grid-cols-2 gap-4 min-w-full shadow rounded-md overflow-hidden">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                disabled />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email"
                                disabled />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- Table End --}}
    </div>
</x-modal>
