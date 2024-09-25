@foreach ($projects as $project)
    <x-modal name="edit_modal_project{{ $project->id }}}" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Edit Project
            </h2>
            {{-- Table Start --}}
            <div>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <form action="{{ route('projects.update', $project->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div class="p-1">
                                <x-input-label for="kode_project" :value="__('Kode Project')" />
                                <x-text-input id="kode_project" class="block mt-1 w-full" type="text"
                                    name="kode_project" autofocus value="{{ $project->kode_project }}" readonly />
                            </div>
                            <div class="p-1">
                                <x-input-label for="nama_project" :value="__('Nama Project')" />
                                <x-text-input id="nama_project" class="block mt-1 w-full" type="text"
                                    name="nama_project" value="{{ $project->nama_project }}" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tgl_mulai" :value="__('Tanggal Mulai')" />
                                <x-text-input id="tgl_mulai" class="block mt-1 w-full" type="date" required
                                    name="tgl_mulai" value="{{ $project->tgl_mulai }}" />
                                <x-input-error :messages="$errors->get('tgl_mulai')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="status_project" :value="__('Status Proyek')" />
                                <select name="status_project" id="status_project"
                                    class="appearance-none dark:bg-gray-900 mt-1 rounded-l rounded-md border inline-block w-full bg-white border-gray-700 dark:text-white text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    required>
                                    <option value="aktif" {{ $project->status_project === 'aktif' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="tidak_aktif"
                                        {{ $project->status_project === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>

                                <x-input-error :messages="$errors->get('status_project')" class="mt-2" />
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
