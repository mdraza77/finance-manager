@extends('layouts.main')
@section('title', 'User Details - Poor Graduate')
@section('content')
    <main id="main" class="main">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="card card-primary mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-title mb-0">User Details</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User Management</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User and Role Information Cards -->
            <div class="d-flex flex-column flex-lg-row gap-4 mb-4">
                <!-- User Information Card -->
                <div class="card card-primary flex-fill">
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
                                    <label class="form-label">Full Name</label>
                                    <div class="form-control readonly">{{ $user->name ?? 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <div class="form-control readonly">{{ $user->email ?? 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Mobile</label>
                                    <div class="form-control readonly">{{ $user->mobile ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Information Card -->
                <div class="card card-secondary flex-fill">
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
                                    <label class="form-label">Role</label>
                                    <div class="form-control readonly">
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $v)
                                                <span class="badge bg-success me-1">{{ $v }}</span>
                                            @endforeach
                                        @else
                                            N/A
                                        @endif
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
                        <a class="btn btn-secondary" href="{{ route('users.index') }}">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Users
                        </a>
                    </div>
                </div>
            </div>
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

        /* Additional styles for readonly fields */
        .readonly {
            background-color: var(--gray-100);
            border-color: var(--gray-300);
            cursor: not-allowed;
            opacity: 0.8;
        }
    </style>
@endsection
