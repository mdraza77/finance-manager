@extends('layouts.main')
@section('title', 'FinancePRO | User Management')

@section('content')
    <main id="main" class="p-6 bg-gray-50 min-h-screen transition-all duration-300">

        {{-- Alert Messages --}}
        @if ($message = Session::get('success'))
            <div
                class="mb-4 flex items-center p-4 text-green-800 bg-green-50 rounded-lg border border-green-200 shadow-sm relative">
                <i class="fas fa-check-circle text-lg mr-3"></i>
                <div>
                    <span class="font-bold">Success!</span> <span class="text-sm font-medium">{{ $message }}</span>
                </div>
                <button type="button" class="ml-auto text-green-500 hover:text-green-700"
                    onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if ($message = Session::get('update'))
            <div
                class="mb-4 flex items-center p-4 text-blue-800 bg-blue-50 rounded-lg border border-blue-200 shadow-sm relative">
                <i class="fas fa-check-circle text-lg mr-3"></i>
                <div>
                    <span class="font-bold">Update!</span> <span class="text-sm font-medium">{{ $message }}</span>
                </div>
                <button type="button" class="ml-auto text-blue-500 hover:text-blue-700"
                    onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if ($message = Session::get('delete'))
            <div
                class="mb-4 flex items-center p-4 text-red-800 bg-red-50 rounded-lg border border-red-200 shadow-sm relative">
                <i class="fas fa-exclamation-circle text-lg mr-3"></i>
                <div>
                    <span class="font-bold">Status Changed!</span> <span
                        class="text-sm font-medium">{{ $message }}</span>
                </div>
                <button type="button" class="ml-auto text-red-500 hover:text-red-700"
                    onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- Page Header --}}
        <div class="mb-6 bg-white rounded-lg shadow-sm border-l-4 border-blue-600 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
                    <nav class="flex text-sm text-gray-500 mt-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li><a href="{{ url('/dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a></li>
                            <li class="flex items-center space-x-2">
                                <span class="text-gray-400">/</span>
                                <span class="font-medium text-gray-700">User Management</span>
                            </li>
                        </ol>
                    </nav>
                </div>

                @can('UserManagement-Create')
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('users.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                            <i class="bi bi-person-plus-fill mr-2"></i> Add New User
                        </a>
                    </div>
                @endcan
            </div>
        </div>

        {{-- Main Content Section --}}
        <section class="section">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">

                    {{-- Warning Note --}}
                    <div class="mb-4">
                        <p class="text-sm text-red-500 font-medium"><i class="bi bi-info-circle mr-1"></i> Note: Admin and
                            Super Admin cannot be deleted.</p>
                    </div>

                    {{-- DataTables Container --}}
                    <div class="overflow-x-auto">
                        <table id="User_Management_table" class="w-full text-left text-sm text-gray-600 border-collapse">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-700">S. No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Full Name</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Role</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Mobile No.</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Email</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700 text-center">Status</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($data as $key => $user)
                                    <tr class="hover:bg-gray-50 transition">

                                        <td class="px-4 py-4">{{ $loop->iteration }}</td>

                                        {{-- Profile Box --}}
                                        <td class="px-4 py-4">
                                            <div class="flex items-center justify-content-between gap-2">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=dbeafe&color=1d4ed8&bold=true""
                                                    class="w-9 h-9 rounded-full border border-gray-200" alt="">
                                                <div>
                                                    <h6 class="font-bold text-gray-800 mb-0">{{ $user->name }}
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Roles --}}
                                        <td class="px-4 py-4">
                                            @if (!empty($user->getRoleNames()))
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach ($user->getRoleNames() as $v)
                                                        <span
                                                            class="px-2.5 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-md border border-green-200">
                                                            {{ $v }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Mobile & Email --}}
                                        <td class="px-4 py-4 font-medium text-gray-700">{{ $user->mobile }}</td>
                                        <td class="px-4 py-4">{{ $user->email }}</td>

                                        {{-- Status Badge --}}
                                        <td class="px-4 py-4 text-center">
                                            @if ($user->deleted_at != null)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full border border-red-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                                    Inactive
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full border border-green-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                                                    Active
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Action Buttons (Inline) --}}
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-2">

                                                @can('UserManagement-View')
                                                    <a href="{{ route('users.show', $user->id) }}"
                                                        class="inline-flex items-center px-2.5 py-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-xs font-medium no-export"
                                                        title="View">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                @endcan

                                                @if ($user->id != 1 && !$user->hasAnyRole(['Super Admin']))
                                                    {{-- Edit Button (Only if Active) --}}
                                                    @can('UserManagement-Edit')
                                                        @if ($user->deleted_at == null)
                                                            <a href="{{ route('users.edit', $user->id) }}"
                                                                class="inline-flex items-center px-2.5 py-1.5 bg-green-50 text-green-600 rounded hover:bg-green-100 transition text-xs font-medium no-export"
                                                                title="Edit">
                                                                <i class="fa-solid fa-pencil"></i>
                                                            </a>
                                                        @endif
                                                    @endcan

                                                    {{-- Activate/Deactivate Logic --}}
                                                    @can('UserManagement-Delete')
                                                        @if ($user->deleted_at != null)
                                                            {{-- Activate Button --}}
                                                            <form method="POST"
                                                                action="{{ route('users.restore', $user->id) }}"
                                                                class="inline-block no-export">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="inline-flex items-center px-2.5 py-1.5 bg-yellow-50 text-yellow-600 rounded hover:bg-yellow-100 transition text-xs font-medium"
                                                                    onclick="confirmActivate(event, this)" title="Activate">
                                                                    <i class="fa-solid fa-rotate-right"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            {{-- Inactive Button --}}
                                                            <form method="POST"
                                                                action="{{ route('users.destroy', $user->id) }}"
                                                                class="inline-block no-export">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="inline-flex items-center px-2.5 py-1.5 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-xs font-medium"
                                                                    onclick="confirmDeactivate(event, this)"
                                                                    title="Deactivate">
                                                                    <i class="fa-solid fa-power-off"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endcan
                                                @endif
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <script>
        function confirmDeactivate(event, button) {
            event.preventDefault(); // Stop default button action

            // Find the form that contains the clicked button
            const form = button.closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be deactivated and unable to login.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Red for danger action
                cancelButtonColor: '#6b7280', // Gray for cancel
                confirmButtonText: 'Yes, deactivate user!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the specific form found above
                    form.submit();
                }
            });
        }

        function confirmActivate(event, button) {
            event.preventDefault(); // Stop default button action

            // Find the form that contains the clicked button
            const form = button.closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be activated and granted access again.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#eab308', // Tailwind Yellow-500 to match the button
                cancelButtonColor: '#6b7280', // Tailwind Gray-500
                confirmButtonText: 'Yes, activate user!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the specific form
                    form.submit();
                }
            });
        }
    </script>
@endsection
