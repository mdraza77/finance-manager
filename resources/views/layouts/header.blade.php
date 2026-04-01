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
                        <a href="#"
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
