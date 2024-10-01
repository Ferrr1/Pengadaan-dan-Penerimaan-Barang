@foreach ($rekanans as $rekanan)
    <x-modal name="edit_modal_rekanan{{ $rekanan->id }}}" :show="false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Edit Rekanan
            </h2>
            {{-- Table Start --}}
            <div>
                <div class="p-4 overflow-x-auto">
                    <form action="{{ route('suppliers.update', $rekanan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div>
                                <x-input-label for="kode_rekanan" :value="__('Kode Rekanan')" />
                                <x-text-input id="kode_rekanan" class="block mt-1 w-full" type="text" readonly
                                    name="kode_rekanan" value="{{ $rekanan->kode_rekanan }}" />
                                <x-input-error :messages="$errors->get('kode_rekanan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nama_rekanan" :value="__('Nama Rekanan')" />
                                <x-text-input id="nama_rekanan" class="block mt-1 w-full" type="text"
                                    name="nama_rekanan" required value="{{ $rekanan->nama_rekanan }}" />
                                <x-input-error :messages="$errors->get('nama_rekanan')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div>
                                <x-input-label for="alamat_rekanan" :value="__('Alamat Rekanan')" />
                                <x-text-input id="alamat_rekanan" class="block mt-1 w-full" type="text" required
                                    name="alamat_rekanan" value="{{ $rekanan->alamat_rekanan }}" />
                                <x-input-error :messages="$errors->get('alamat_rekanan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="telepon_rekanan" :value="__('Telepon Rekanan')" />
                                <x-text-input id="telepon_rekanan" class="block mt-1 w-full" type="number" required
                                    name="telepon_rekanan" value="{{ $rekanan->telepon_rekanan }}" />
                                <x-input-error :messages="$errors->get('telepon_rekanan')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="email_rekanan" :value="__('Email Rekanan')" />
                                <x-text-input id="email_rekanan" class="block mt-1 w-full" type="email" required
                                    name="email_rekanan" value="{{ $rekanan->email_rekanan }}" />
                                <x-input-error :messages="$errors->get('email_rekanan')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="status_rekanan" :value="__('Status Rekanan')" />
                                <select name="status_rekanan" id="status_rekanan"
                                    class="appearance-none dark:bg-gray-900 mt-1 rounded-l rounded-md border inline-block w-full bg-white border-gray-700 dark:text-white text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    required>
                                    <option value="aktif" {{ $rekanan->status_rekanan === 'aktif' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="tidak_aktif"
                                        {{ $rekanan->status_rekanan === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>

                                <x-input-error :messages="$errors->get('status_rekanan')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 min-w-full overflow-hidden">
                            <div>
                                <x-input-label for="tgl_bergabung" :value="__('Tgl Bergabung Rekanan')" />
                                <x-text-input id="tgl_bergabung" class="block mt-1 w-full" type="date" required
                                    name="tgl_bergabung" value="{{ $rekanan->tgl_bergabung }}" />
                                <x-input-error :messages="$errors->get('tgl_bergabung')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tgl_akhir" :value="__('Tgl Akhir Rekanan')" />
                                <x-text-input id="tgl_akhir" class="block mt-1 w-full" type="date" required
                                    name="tgl_akhir" value="{{ $rekanan->tgl_akhir }}" />
                                <x-input-error :messages="$errors->get('tgl_akhir')" class="mt-2" />
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
