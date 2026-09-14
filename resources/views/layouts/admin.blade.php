<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') · Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <div class="min-h-screen">
        {{-- Mobile top bar --}}
        <div class="lg:hidden sticky top-0 z-30 flex items-center justify-between border-b border-gray-200 bg-white px-4 py-3">
            <button type="button" onclick="toggleSidebar()" class="rounded-md p-2 text-gray-500 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <span class="text-sm font-semibold text-indigo-950">Admin Dashboard</span>
            <div class="h-8 w-8 rounded-full bg-indigo-950 text-white text-xs font-semibold flex items-center justify-center">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>

        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-indigo-950 transition-transform duration-200 lg:translate-x-0">
            <div class="flex items-center gap-2 px-6 py-5">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-base font-semibold text-white">Admin Panel</span>
            </div>

            <nav class="mt-2 flex-1 space-y-1 px-3">
                @php
                    $navItemClasses = fn (bool $active) => $active
                        ? 'flex items-center gap-3 rounded-lg bg-indigo-600 px-3 py-2.5 text-sm font-medium text-white'
                        : 'flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-indigo-200 hover:bg-indigo-900 hover:text-white transition-colors';
                @endphp

                <a href="{{ url('/dashboard') }}" class="{{ $navItemClasses(request()->is('dashboard')) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ url('/dashboard') }}#users" class="{{ $navItemClasses(request()->is('dashboard/users*')) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 100-8 4 4 0 000 8zm6 4v-2a4 4 0 00-3-3.87M9 4.13a4 4 0 010 7.75" />
                    </svg>
                    Users
                </a>

                <a href="{{ url('/dashboard') }}#posts" class="{{ $navItemClasses(request()->is('dashboard/posts*')) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Posts
                </a>

                <a href="{{ route('dashboard.endpoints') }}" class="{{ $navItemClasses(request()->routeIs('dashboard.endpoints')) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 8l-4 4 4 4" />
                    </svg>
                    API Docs
                </a>
            </nav>

            <div class="border-t border-indigo-900 px-3 py-4">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-indigo-200 hover:bg-indigo-900 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Overlay for mobile sidebar --}}
        <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 z-30 hidden bg-black/30 lg:hidden"></div>

        {{-- Main content --}}
        <div class="lg:pl-64">
            <header class="hidden lg:flex items-center justify-between border-b border-gray-200 bg-white px-8 py-5">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Admin Dashboard')</h1>
                    <p class="mt-1 text-sm text-gray-500">@yield('page-subtitle', 'Manage users, posts, and application content from one place.')</p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-indigo-950 text-white text-sm font-semibold flex items-center justify-center">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}" class="ml-1">
                        @csrf
                        <button type="submit" class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            {{-- Mobile page title --}}
            <div class="px-4 pt-5 lg:hidden">
                <h1 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Admin Dashboard')</h1>
                <p class="mt-1 text-sm text-gray-500">@yield('page-subtitle', 'Manage users, posts, and application content from one place.')</p>
            </div>

            <main class="px-4 py-6 lg:px-8 lg:py-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebarOverlay').classList.toggle('hidden');
        }
    </script>
    @yield('scripts')
</body>
</html>
