@extends('layouts.main')
@section('title', 'FinancePRO | Role Management')

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
                    <span class="font-bold">Delete!</span> <span class="text-sm font-medium">{{ $message }}</span>
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
                    <h1 class="text-2xl font-bold text-gray-800">Role Management</h1>
                    <nav class="flex text-sm text-gray-500 mt-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a></li>
                            <li class="flex items-center space-x-2">
                                <span class="text-gray-400">/</span>
                                <span class="font-medium text-gray-700">Role Management</span>
                            </li>
                        </ol>
                    </nav>
                </div>

                @can('AccessManagement-Create')
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('roles.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                            <i class="bi bi-plus-lg mr-2"></i> Add New Role
                        </a>
                    </div>
                @endcan
            </div>
        </div>

        {{-- Main Content Section --}}
        <section class="section">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">

                    {{-- DataTables Container --}}
                    <div class="overflow-x-auto">
                        <table id="Role_Management_table" class="w-full text-left text-sm text-gray-600 border-collapse">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-700 w-24">S. No</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700">Name</th>
                                    <th class="px-4 py-3 font-semibold text-gray-700 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($roles as $role)
                                    <tr id="role_table_td_{{ $role->id }}" class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $role->name }}</td>

                                        <td class="px-4 py-3 text-center">
                                            {{-- Inline Action Buttons Container --}}
                                            <div class="flex items-center justify-center space-x-2">

                                                {{-- View Button --}}
                                                @can('AccessManagement-View')
                                                    <a href="{{ route('roles.show', $role->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-sm font-medium">
                                                        <i class="fa-regular fa-eye mr-1.5"></i> View
                                                    </a>
                                                @endcan

                                                {{-- Edit Button --}}
                                                @can('AccessManagement-Edit')
                                                    @if ($role->id != 1)
                                                        {{-- Protect Admin --}}
                                                        <a href="{{ route('roles.edit', $role->id) }}"
                                                            class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-600 rounded hover:bg-green-100 transition text-sm font-medium">
                                                            <i class="fa-solid fa-pencil mr-1.5"></i> Edit
                                                        </a>
                                                    @endif
                                                @endcan

                                                {{-- Delete Button --}}
                                                @can('AccessManagement-Delete')
                                                    @if ($role->id != 1)
                                                        <form method="POST" action="{{ route('roles.destroy', $role->id) }}"
                                                            class="inline-block no-export">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-sm font-medium"
                                                                onclick="confirmRoleDelete(event, this)">
                                                                <i class="fa-solid fa-trash mr-1.5"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endcan

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
        function confirmRoleDelete(event, button) {
            event.preventDefault();

            const form = button.closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "Deleting this role might affect users assigned to it!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Tailwind Red-500
                cancelButtonColor: '#6b7280', // Tailwind Gray-500
                confirmButtonText: 'Yes, delete role!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

@endsection
