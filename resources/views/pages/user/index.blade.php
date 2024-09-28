<x-app-layout :title="__('- User')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form id="userForm">
                @csrf
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 grid gap-4">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
                <x-primary-button class="mt-4 px-4 py-2">Tambah User</x-primary-button>
            </form>
            <div class="mt-4">
                @include('pages.user.table')
            </div>
            {{-- Modal --}}
            @include('pages.user.detail')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Handle submit form dengan AJAX
            $('#userForm').on('submit', function(e) {
                e.preventDefault();
                var formData = {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val()
                };

                $.ajax({
                    url: '{{ route('users.store') }}', // Ganti dengan route untuk create user
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                            $('#userForm')[0].reset();

                            var newRowTable = `
                            <tr>
                                <td class="px-5 py-5 text-sm border-b-2 border-gray-200 dark:border-gray-700">
                                    <p class="whitespace-no-wrap">${response.data.id}</p>
                                </td>
                                <td class="px-5 py-5 text-sm border-b-2 border-gray-200 dark:border-gray-700">
                                    <p class="whitespace-no-wrap">${response.data.name}</p>
                                </td>
                                <td class="px-5 py-5 text-sm border-b-2 border-gray-200 dark:border-gray-700">
                                    <p class="whitespace-no-wrap">${response.data.email}</p>
                                </td>
                                <td class="px-5 py-5 text-sm border-b-2 border-gray-200 dark:border-gray-700">
                                    <x-primary-button class="p-2"><x-eva-edit-2-outline class="w-5 h-5" /></x-primary-button>
                                    <x-danger-button class="p-2 delete-btn" data-id="${response.data.id}"><x-eva-trash-outline class="w-5 h-5" /></x-danger-button>
                                </td>
                            </tr>
                            `;
                            $('table tbody').append(newRowTable);
                        }
                    },
                    error: function(xhr) {
                        location.reload();
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';

                        // Looping untuk menampilkan error dari response
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                    }
                });
            });
            // End Handle submit form dengan AJAX

            // Handle delete user
            $(document).on('click', '.delete-btn', function() {
                var userId = $(this).data('id');
                var url = `/users/${userId}`;

                if (confirm('Apakah kamu yakin ingin menghapus data ini?')) {
                    $.ajax({
                        url: url, // URL request
                        type: 'DELETE', // metode request
                        success: function(response) {
                            // Tampilkan pesan sukses
                            if (response.success) {
                                // Tampilkan pesan sukses
                                $('#user_' + userId).remove();
                                location.reload();
                            }
                        },
                        error: function(xhr) {
                            location.reload();
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';

                            // Looping untuk menampilkan error dari response
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '<br>';
                            });
                        }
                    });
                }
            });

        });
    </script>

</x-app-layout>
