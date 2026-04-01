@extends('layouts.main')
@section('title', 'Create User - Poor Graduate')
@section('content')
    <main id="main" class="main">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="card card-primary mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-title mb-0">Create New User</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User Management</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
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

            @if ($errors->any())
                <div class="tt active">
                    <div class="tt-content">
                        <i class="fas fa-solid fa-xmark-circle error"></i>
                        <div class="message">
                            <span class="text text-1">Error</span>
                            <span class="text text-2">User Creation Unsuccessful</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close"></i>
                    <div class="pg active"></div>
                </div>
            @endif

            <form class="row g-4" action="{{ route('users.store') }}" method="POST">
                @csrf
                <!-- User Information Card -->
                <div class="col-lg-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-user me-2"></i>
                                User Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name" class="form-label required">Full Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Enter Full Name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label required">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Enter Email Address" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile" class="form-label required">Mobile</label>
                                        <input type="tel" name="mobile" class="form-control" id="mobile"
                                            placeholder="Enter Mobile Number"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);"
                                            value="{{ old('mobile') }}" required>
                                        @error('mobile')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label required">Password</label>
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="Enter Password" required>
                                        {{-- <small class="form-text text-muted">The password must be at least 8
                                            characters.</small> --}}
                                        <em class="form-label" style="color: red">The password must be at least 8
                                            characters.</em>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="confirm-password" class="form-label required">Confirm Password</label>
                                        <input type="password" name="confirm-password" class="form-control"
                                            id="confirm-password" placeholder="Confirm Password" required>
                                        @error('confirm-password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Information Card -->
                <div class="col-lg-4">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-user-tag me-2"></i>
                                Role Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="roles[]" class="form-label required">Role</label>
                                        <select name="roles[]" class="form-control" id="role__" required>
                                            <option value="" disabled selected>Select Role</option>
                                            @foreach ($roles as $id => $name)
                                                <option value="{{ $id }}"
                                                    {{ old('roles') && in_array($id, old('roles')) ? 'selected' : '' }}>
                                                    {{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('roles[]')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Form Actions -->
        <div class="card card-action mt-4">
            <div class="card-body">
                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Create User
                    </button>
                    <a class="btn btn-secondary" href="{{ route('users.index') }}">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Users
                    </a>
                </div>
            </div>
        </div>
        </form>
        </div>
    </main>

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
        }

        .form-control.is-invalid {
            border-color: var(--danger-color);
        }

        .form-control.is-invalid:focus {
            border-color: var(--danger-color);
            box-shadow: 0 0 0 0.2rem rgba(230, 57, 70, 0.25);
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.375rem;
            font-size: 0.875rem;
            color: var(--danger-color);
        }

        /* Button Styles */
        .btn {
            display: inline-block;
            font-weight: 500;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            line-height: 1.5;
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

        .btn i {
            font-size: 0.9rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#role__').select2({});
        });
    </script>
@endsection
