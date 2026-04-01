@extends('layouts.main')
@section('title', 'User Management - Poor Graduate')
@section('content')
    <main id="main" class="main">
        <!-- Main Form -->
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="card card-primary mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-title mb-0">User Management Details</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">User Management</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="tt active">
                    <div class="tt-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Success</span>
                            <span class="text text-2"> {{ $message }}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close"></i>
                    <div class="pg active"></div>
                </div>
            @endif

            @if ($message = Session::get('update'))
                <div class="tt active">
                    <div class="tt-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Update</span>
                            <span class="text text-2"> {{ $message }}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close"></i>
                    <div class="pg active"></div>
                </div>
            @endif

            @if ($message = Session::get('delete'))
                <div class="tt active">
                    <div class="tt-content">
                        <i class="fas fa-solid fa-exclamation exclamation update"></i>
                        <div class="message">
                            <span class="text text-1">Delete</span>
                            <span class="text text-2"> {{ $message }}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close"></i>
                    <div class="pg active"></div>
                </div>
            @endif

            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row pt-4">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="pd-20">
                                            <h4 class="text-blue h4">User Management</h4>
                                            <em style="color: red"> Note: Admin can't be deleted</em><br>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 d-flex justify-content-end">
                                        <div class="me-3 add_btn_row_in_user_table" style="display: none">
                                            <div class="col-lg-12">
                                                @can('UserManagement-View')
                                                    <a class="btn btn-primary" id="user_table_view_btn">View</a>
                                                @endcan
                                                @can('UserManagement-Edit')
                                                    <a class="btn btn-success" id="user_table_edit_btn">Edit</a>
                                                @endcan
                                                @can('UserManagement-Delete')
                                                    <a class="btn btn-danger" id="user_table_delete_btn">Delete</a>
                                                @endcan
                                            </div>
                                        </div>
                                        @can('UserManagement-Create')
                                            <div class="btn-group">
                                                <a class="btn btn-primary mb-4 mr-3" href="{{ route('users.create') }}"><i
                                                        class="fas fa-user-plus me-2"></i> Add New
                                                    User</a>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                                <!-- Table with stripped rows -->
                                <table id="User_Management_table" class="display stripe row-border order-column"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text__left">S. No</th>
                                            {{-- <th>Employee ID</th> --}}
                                            <th>Full Name</th>
                                            <th>Role</th>
                                            <th class="text__left">Mobile No.</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $user)
                                            <tr>
                                                <td class="text__left">{{ $loop->iteration }}</td>
                                                {{-- <td> {{ $user->employee_id ?? 'N/A' }}</td> --}}
                                                {{-- <td>{{ $user->name }}</td> --}}
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-3 bg-soft-primary rounded-circle d-flex align-items-center justify-content-center fw-bold text-primary"
                                                            style="width: 40px; height: 40px; background: #eef2ff;">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-bold">{{ $user->name }}
                                                                {{ $user->last_name }}</h6>
                                                            {{-- <small class="text-muted">{{ $user->email }}</small> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if (!empty($user->getRoleNames()))
                                                        @foreach ($user->getRoleNames() as $v)
                                                            <label class="badge bg-success">{{ $v }}</label>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                {{-- <td class="text__left">{{ $user->mobile }}</td> --}}
                                                <td class="text__left">
                                                    <div class="small fw-500">
                                                        {{-- <i class="bi bi-phone me-1"></i> --}}
                                                        {{ $user->mobile }}
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                @if ($user->deleted_at != null)
                                                    <td><span class="badge bg-danger">Inactive</span></td>
                                                @else
                                                    <td><span class="badge bg-success">Active</span></td>
                                                @endif
                                                <td>
                                                    <div class="filter">
                                                        <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                                                class="bi bi-three-dots"></i></a>
                                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                            @can('UserManagement-View')
                                                                <li> <a class="dropdown-item"
                                                                        href="{{ route('users.show', $user->id) }}"><i
                                                                            class="fa-regular fa-eye"></i> View</a>
                                                                </li>
                                                            @endcan

                                                            @can('UserManagement-Edit')
                                                                <li>
                                                                    @if ($user->id != 1 && !$user->hasAnyRole(['Super Admin']))
                                                                        @if ($user->deleted_at == null)
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('users.edit', $user->id) }}"><i
                                                                                    class="fa-solid fa-pencil"></i>Edit</a>
                                                                        @endif
                                                                    @endif
                                                                </li>
                                                            @endcan
                                                            <li>
                                                                @if ($user->id != 1 && !$user->hasAnyRole(['Super Admin']))
                                                                    @if ($user->deleted_at != null)
                                                                        {{-- Activate Button Logic --}}
                                                                        @can('UserManagement-Delete')
                                                                            <form method="POST"
                                                                                action="{{ route('users.resoter', $user->id) }}">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="button"
                                                                                    class="dropdown-item activate-button">
                                                                                    <i
                                                                                        class="fa-solid fa-rotate-right me-2 text-success"></i>
                                                                                    Activate
                                                                                </button>
                                                                            </form>
                                                                        @endcan
                                                                    @else
                                                                        {{-- Inactive Button Logic --}}
                                                                        @can('UserManagement-Delete')
                                                                            <form method="POST"
                                                                                action="{{ route('users.destroy', $user->id) }}">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="button"
                                                                                    class="dropdown-item inactive-button">
                                                                                    <i
                                                                                        class="fa-solid fa-power-off me-2 text-danger"></i>
                                                                                    Inactive
                                                                                </button>
                                                                            </form>
                                                                        @endcan
                                                                    @endif
                                                                @endif
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- End Table with stripped rows -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <style>
                /* Design System Variables */
                :root {
                    --primary-color: #4361ee;
                    --secondary-color: #3f37c9;
                    --success-color: #4cc9f0;
                    --info-color: #4895ef;
                    --warning-color: #f72585;
                    --danger-color: #e63946;
                    --light-color: #f8f9fa;
                    --dark-color: #212529;
                    --gray-100: #f8f9fa;
                    --gray-200: #e9ecef;
                    --gray-300: #dee2e6;
                    --gray-400: #ced4da;
                    --gray-500: #adb5bd;
                    --gray-600: #6c757d;
                    --gray-700: #495057;
                    --gray-800: #343a40;
                    --gray-900: #212529;

                    --border-radius: 8px;
                    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);

                    --card-padding: 1.5rem;
                    --card-border: 1px solid var(--gray-200);
                }

                /* Card Header Section */
                .card-header-section {
                    border-left: 4px solid var(--info-color);
                }

                .page-title {
                    font-size: 1.5rem;
                    font-weight: 600;
                    color: var(--gray-800);
                    margin-bottom: 0.25rem;
                }

                .breadcrumb {
                    background-color: transparent;
                    padding: 0;
                    margin: 0;
                    font-size: 0.9rem;
                }

                .breadcrumb-item {
                    display: flex;
                    align-items: center;
                }

                .breadcrumb-item a {
                    color: var(--primary-color);
                    text-decoration: none;
                    transition: color 0.15s ease;
                }

                .breadcrumb-item a:hover {
                    color: var(--secondary-color);
                }

                .breadcrumb-item+.breadcrumb-item::before {
                    content: ">";
                    color: var(--gray-400);
                    padding: 0 0.5rem;
                }

                .breadcrumb-item.active {
                    color: var(--gray-700);
                    font-weight: 500;
                }

                /* Alert Styles */
                .alert {
                    border: none;
                    border-radius: var(--border-radius);
                    padding: 0.75rem 1rem;
                    margin-bottom: 1rem;
                }

                .alert-body {
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }

                .alert-success {
                    background-color: #d1e7dd;
                    color: #0f5132;
                }

                .alert-danger {
                    background-color: #f8d7da;
                    color: #842029;
                }

                .btn-close {
                    background: none;
                    border: none;
                    opacity: 0.5;
                }

                .btn-close:hover {
                    opacity: 1;
                }

                /* Card Styles */
                .card {
                    border: var(--card-border);
                    border-radius: var(--border-radius);
                    box-shadow: var(--shadow);
                    margin-bottom: 1.5rem;
                    transition: box-shadow 0.15s ease;
                }

                .card:hover {
                    box-shadow: var(--shadow-lg);
                }

                .card-primary {
                    border-left: 4px solid var(--primary-color);
                }

                .card-secondary {
                    border-left: 4px solid var(--success-color);
                }

                .card-tertiary {
                    border-left: 4px solid var(--warning-color);
                }

                .card-action {
                    border-left: 4px solid var(--success-color);
                }

                .card-header {
                    background-color: white;
                    border-bottom: 1px solid var(--gray-200);
                    padding: 1rem var(--card-padding);
                    border-top-left-radius: var(--border-radius);
                    border-top-right-radius: var(--border-radius);
                }

                .card-title {
                    font-size: 1.1rem;
                    font-weight: 600;
                    color: var(--gray-800);
                    margin: 0;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }

                .card-body {
                    padding: var(--card-padding);
                }

                /* Form Styles */
                .form-group {
                    margin-bottom: 1rem;
                }

                .form-label {
                    display: block;
                    font-weight: 500;
                    color: var(--gray-700);
                    margin-bottom: 0.375rem;
                    font-size: 0.9rem;
                }

                .required::after {
                    content: " *";
                    color: var(--danger-color);
                }

                .form-control {
                    display: block;
                    width: 100%;
                    padding: 0.5rem 0.75rem;
                    font-size: 0.9rem;
                    font-weight: 400;
                    line-height: 1.5;
                    color: var(--gray-700);
                    background-color: white;
                    background-clip: padding-box;
                    border: 1px solid var(--gray-300);
                    border-radius: var(--border-radius);
                    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                }

                .form-control:focus {
                    color: var(--gray-700);
                    background-color: white;
                    border-color: var(--primary-color);
                    outline: 0;
                    box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
                }

                .form-control:read-only {
                    background-color: var(--gray-100);
                    opacity: 1;
                }

                .form-control:read-only:focus {
                    border-color: var(--gray-300);
                    box-shadow: none;
                }

                textarea.form-control {
                    min-height: 6rem;
                }

                /* Invalid Feedback */
                .invalid-feedback {
                    display: none;
                    width: 100%;
                    margin-top: 0.25rem;
                    font-size: 0.875em;
                    color: var(--danger-color);
                }

                .is-invalid .form-control {
                    border-color: var(--danger-color);
                }

                .is-invalid .form-control:focus {
                    border-color: var(--danger-color);
                    box-shadow: 0 0 0 0.2rem rgba(230, 57, 70, 0.25);
                }

                /* Upload Section */
                .upload-section {
                    text-align: center;
                }

                .upload-label {
                    display: block;
                    cursor: pointer;
                }

                .upload-container {
                    border: 2px dashed var(--gray-400);
                    border-radius: var(--border-radius);
                    padding: 2rem;
                    transition: all 0.2s ease;
                    background-color: var(--gray-50);
                }

                .upload-container:hover {
                    border-color: var(--primary-color);
                    background-color: #f0f7ff;
                }

                .upload-content {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 0.5rem;
                }

                .upload-icon {
                    font-size: 2rem;
                    color: var(--gray-400);
                }

                .upload-text {
                    font-weight: 600;
                    color: var(--gray-700);
                    margin: 0;
                }

                .upload-hint {
                    font-size: 0.8rem;
                    color: var(--gray-500);
                    margin: 0;
                }

                .upload-input {
                    display: none;
                }

                /* Logo Preview */
                .logo-preview-section {
                    text-align: center;
                }

                .preview-title {
                    font-weight: 600;
                    color: var(--gray-700);
                    margin-bottom: 1rem;
                    font-size: 0.9rem;
                }

                .logo-preview-container {
                    border: 1px solid var(--gray-200);
                    border-radius: var(--border-radius);
                    padding: 1rem;
                    background-color: white;
                }

                .logo-preview {
                    width: auto;
                    max-width: 100%;
                }

                /* Action Buttons */
                .action-buttons {
                    display: flex;
                    justify-content: flex-end;
                    gap: 0.75rem;
                    flex-wrap: wrap;
                }

                .btn {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    padding: 0.5rem 1.25rem;
                    font-size: 0.9rem;
                    font-weight: 500;
                    line-height: 1.5;
                    text-align: center;
                    text-decoration: none;
                    vertical-align: middle;
                    border: 1px solid transparent;
                    border-radius: var(--border-radius);
                    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                }

                .btn-primary {
                    color: #fff;
                    background-color: var(--primary-color);
                    border-color: var(--primary-color);
                }

                .btn-primary:hover {
                    color: #fff;
                    background-color: var(--secondary-color);
                    border-color: var(--secondary-color);
                }

                .btn-secondary {
                    color: #fff;
                    background-color: var(--gray-600);
                    border-color: var(--gray-600);
                }

                .btn-secondary:hover {
                    color: #fff;
                    background-color: var(--gray-700);
                    border-color: var(--gray-700);
                }
            </style>
        </div>
    </main>
@endsection
