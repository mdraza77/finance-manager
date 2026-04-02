<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Finance Dashboard')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Dropdown hidden by default */
        .hidden-dropdown {
            display: none;
        }

        /* Smooth transitions for Sidebar and Main Content */
        #logo-sidebar {
            transition: transform 0.3s ease-in-out;
        }

        #main {
            transition: margin-left 0.3s ease-in-out;
        }

        /* Desktop Push Logic */
        @media (min-width: 1024px) {

            /* Jab sidebar open ho (default state) */
            body.sidebar-open #main {
                margin-left: 16rem;
            }

            /* Jab sidebar close ho */
            body:not(.sidebar-open) #main {
                margin-left: 0;
            }
        }

        /* Mobile: Hamesha full width dashboard */
        @media (max-width: 1023px) {
            #main {
                margin-left: 0 !important;
            }
        }
    </style>



    {{-- 1. DataTables v2.3.7 TAILWIND CSS & Buttons CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.min.css">

    {{-- 2. jQuery (Required) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- 3. DataTables v2.3.7 Core & Tailwind JS --}}
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.tailwindcss.min.js"></script>

    {{-- 4. Export Buttons JS --}}
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

    {{-- 5. Initialization Script --}}
    <script>
        $(document).ready(function() {
            // Initialize DataTable for Transactions
            if ($('#transactions_table').length) {
                $('#transactions_table').DataTable({
                    responsive: true,
                    pageLength: 10,
                    order: [[4, 'desc']], // Sort by date column (index 4) descending
                    layout: {
                        topStart: {
                            buttons: [
                                {
                                    extend: 'copy',
                                    className: 'dt-button bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-md text-sm font-medium transition',
                                    text: '<i class="fas fa-copy mr-1"></i> Copy'
                                },
                                {
                                    extend: 'csv',
                                    className: 'dt-button bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1.5 rounded-md text-sm font-medium transition',
                                    text: '<i class="fas fa-file-csv mr-1"></i> CSV'
                                },
                                {
                                    extend: 'excel',
                                    className: 'dt-button bg-green-50 hover:bg-green-100 text-green-700 px-3 py-1.5 rounded-md text-sm font-medium transition',
                                    text: '<i class="fas fa-file-excel mr-1"></i> Excel'
                                },
                                {
                                    extend: 'pdf',
                                    className: 'dt-button bg-red-50 hover:bg-red-100 text-red-700 px-3 py-1.5 rounded-md text-sm font-medium transition',
                                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF'
                                },
                                {
                                    extend: 'print',
                                    className: 'dt-button bg-gray-800 hover:bg-gray-900 text-white px-3 py-1.5 rounded-md text-sm font-medium transition',
                                    text: '<i class="fas fa-print mr-1"></i> Print'
                                }
                            ]
                        }
                    },
                    language: {
                        search: "",
                        searchPlaceholder: "Search records...",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "No entries available",
                        infoFiltered: "(filtered from _MAX_ total entries)",
                        paginate: {
                            first: '<i class="fas fa-angle-double-left"></i>',
                            last: '<i class="fas fa-angle-double-right"></i>',
                            next: '<i class="fas fa-angle-right"></i>',
                            previous: '<i class="fas fa-angle-left"></i>'
                        }
                    },
                    columnDefs: [
                        {
                            orderable: false,
                            targets: [6] // Disable sorting on Actions column
                        },
                        {
                            targets: [1, 2], // Don't export badge HTML
                            render: function(data, type, row) {
                                if (type === 'export') {
                                    return $(data).text().trim();
                                }
                                return data;
                            }
                        }
                    ],
                    dom: "<'flex flex-col md:flex-row md:items-center md:justify-between mb-4'<'mb-4 md:mb-0'l><'f'>>" +
                         "<'flex flex-col md:flex-row md:items-center md:justify-between mb-4'<'mb-4 md:mb-0'B><'dt-length'>>" +
                         "<'t'ip><'flex flex-col md:flex-row md:items-center md:justify-between mt-4'p>",
                });
            }

            // Initialize DataTable for Users (if exists)
            if ($('#User_Management_table').length) {
                $('#User_Management_table').DataTable({
                    responsive: true,
                    pageLength: 10,
                    order: [[0, 'asc']],
                    layout: {
                        topStart: {
                            buttons: [
                                {
                                    extend: 'copy',
                                    className: 'dt-button bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-md text-sm font-medium transition',
                                    text: '<i class="fas fa-copy mr-1"></i> Copy'
                                },
                                {
                                    extend: 'csv',
                                    className: 'dt-button bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1.5 rounded-md text-sm font-medium transition',
                                    text: '<i class="fas fa-file-csv mr-1"></i> CSV'
                                },
                                {
                                    extend: 'excel',
                                    className: 'dt-button bg-green-50 hover:bg-green-100 text-green-700 px-3 py-1.5 rounded-md text-sm font-medium transition',
                                    text: '<i class="fas fa-file-excel mr-1"></i> Excel'
                                },
                                {
                                    extend: 'pdf',
                                    className: 'dt-button bg-red-50 hover:bg-red-100 text-red-700 px-3 py-1.5 rounded-md text-sm font-medium transition',
                                    text: '<i class="fas fa-file-pdf mr-1"></i> PDF'
                                },
                                {
                                    extend: 'print',
                                    className: 'dt-button bg-gray-800 hover:bg-gray-900 text-white px-3 py-1.5 rounded-md text-sm font-medium transition',
                                    text: '<i class="fas fa-print mr-1"></i> Print'
                                }
                            ]
                        }
                    },
                    language: {
                        search: "",
                        searchPlaceholder: "Search users...",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "No entries available",
                        infoFiltered: "(filtered from _MAX_ total entries)",
                        paginate: {
                            first: '<i class="fas fa-angle-double-left"></i>',
                            last: '<i class="fas fa-angle-double-right"></i>',
                            next: '<i class="fas fa-angle-right"></i>',
                            previous: '<i class="fas fa-angle-left"></i>'
                        }
                    },
                    columnDefs: [
                        {
                            orderable: false,
                            targets: [5, 6] // Disable sorting on Status and Action columns
                        }
                    ],
                    dom: "<'flex flex-col md:flex-row md:items-center md:justify-between mb-4'<'mb-4 md:mb-0'l><'f'>>" +
                         "<'flex flex-col md:flex-row md:items-center md:justify-between mb-4'<'mb-4 md:mb-0'B><'dt-length'>>" +
                         "<'t'ip><'flex flex-col md:flex-row md:items-center md:justify-between mt-4'p>",
                });
            }
        });
    </script>

    {{-- 6. Custom Styling for DataTables --}}
    <style>
        /* DataTables Buttons Styling */
        .dt-buttons .dt-button {
            margin-right: 0.5rem !important;
            border: none !important;
            background: transparent !important;
        }

        /* DataTables Container Styling */
        div.dataTables_wrapper div.dataTables_length {
            padding-bottom: 0.5rem;
        }

        div.dataTables_wrapper div.dataTables_filter {
            padding-bottom: 0.5rem;
        }

        div.dataTables_wrapper div.dataTables_info {
            padding-top: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        div.dataTables_wrapper div.dataTables_paginate {
            padding-top: 0.5rem;
        }

        /* Pagination Buttons */
        div.dataTables_wrapper div.dataTables_paginate .paginate_button {
            border: 1px solid #e5e7eb !important;
            background: white !important;
            color: #374151 !important;
            margin-left: 0.25rem;
            border-radius: 0.375rem;
        }

        div.dataTables_wrapper div.dataTables_paginate .paginate_button:hover {
            background: #f3f4f6 !important;
            color: #1f2937 !important;
        }

        div.dataTables_wrapper div.dataTables_paginate .paginate_button.current {
            background: #3b82f6 !important;
            color: white !important;
            border-color: #3b82f6 !important;
        }

        div.dataTables_wrapper div.dataTables_paginate .paginate_button.disabled {
            color: #9ca3af !important;
            cursor: not-allowed;
        }

        /* Search Input Styling */
        div.dataTables_wrapper div.dataTables_filter input {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 0.75rem !important;
            margin-left: 0.5rem !important;
            outline: none !important;
        }

        div.dataTables_wrapper div.dataTables_filter input:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }

        /* Length Select Styling */
        div.dataTables_wrapper div.dataTables_length select {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 2rem 0.5rem 0.75rem !important;
            margin: 0 0.25rem !important;
            outline: none !important;
            background-color: white !important;
        }

        div.dataTables_wrapper div.dataTables_length select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }

        /* Table Styling */
        table.dataTable {
            border-collapse: collapse !important;
            width: 100% !important;
        }

        table.dataTable thead th {
            border-bottom: 2px solid #e5e7eb !important;
            padding: 0.75rem 1rem !important;
        }

        table.dataTable tbody td {
            padding: 0.75rem 1rem !important;
            border-bottom: 1px solid #f3f4f6 !important;
        }

        /* Responsive DataTable */
        div.dataTables_wrapper div.dataTables_scroll {
            border-radius: 0.5rem;
        }
    </style>
</head>

{{-- Body par 'sidebar-open' default rakha hai taaki page load par margin sahi rahe --}}

<body class="bg-gray-50 font-sans antialiased sidebar-open">

    <nav
        class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm h-16 flex items-center px-4 justify-between">
        <div class="flex items-center">
            <button onclick="toggleSidebar(event)"
                class="p-2 mr-3 text-gray-600 rounded-lg hover:bg-gray-100 focus:outline-none">
                <i class="bi bi-list text-2xl"></i>
            </button>

            <a href="/" class="flex items-center space-x-2">
                <span class="text-xl font-bold text-blue-600 hidden md:block">Finance<span
                        class="text-gray-800 text-sm">PRO</span></span>
            </a>
        </div>

        <div class="flex items-center space-x-4">
            <div class="relative">
                <button onclick="toggleProfile(event)" class="flex items-center space-x-2 focus:outline-none">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff"
                        class="w-9 h-9 rounded-full border border-gray-200">
                    <span class="hidden md:block text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                    <i class="bi bi-chevron-down text-xs text-gray-400"></i>
                </button>

                <div id="profileMenu"
                    class="hidden-dropdown absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl border border-gray-100 py-1 z-50">
                    <a href="#"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-50 font-medium">My
                        Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Sign Out</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 bg-white border-r border-gray-200 translate-x-0">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 group {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="bi bi-grid-fill mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <div class="pt-4 mt-4 space-y-2 border-t border-gray-100">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Management</p>
                    <li>
                        <a href="{{ route('transactions.index') }}"
                            class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 group">
                            <i class="bi bi-cash-stack mr-3"></i>
                            <span>Financial Records</span>
                        </a>
                    </li>
                    @can('UserManagement-Index')
                        <li>
                            <a href="{{ route('users.index') }}"
                                class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 group">
                                <i class="bi bi-people-fill mr-3"></i>
                                <span>User Management</span>
                            </a>
                        </li>
                    @endcan
                    @can('AccessManagement-Index')
                        <li>
                            <a href="{{ route('roles.index') }}"
                                class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 group">
                                <i class="bi bi-lock-fill mr-3"></i>
                                <span>Roles & Permissions</span>
                            </a>
                        </li>
                    @endcan
                </div>
            </ul>
        </div>
    </aside>

    <script>
        function toggleSidebar(e) {
            e.stopPropagation();
            const sidebar = document.getElementById('logo-sidebar');
            const body = document.body;

            // 1. Sidebar movement
            if (sidebar.classList.contains('translate-x-0')) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                // 2. Body se class hatayein taaki margin 0 ho jaye
                body.classList.remove('sidebar-open');
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                // 2. Body mein class jodein taaki margin 16rem ho jaye
                body.classList.add('sidebar-open');
            }
        }

        function toggleProfile(e) {
            e.stopPropagation();
            document.getElementById('profileMenu').classList.toggle('hidden-dropdown');
        }

        window.onclick = function(event) {
            const menu = document.getElementById('profileMenu');
            if (!event.target.closest('.relative')) {
                if (menu && !menu.classList.contains('hidden-dropdown')) {
                    menu.classList.add('hidden-dropdown');
                }
            }
        }
    </script>
</body>

</html>
