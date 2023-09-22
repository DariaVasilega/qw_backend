<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Static Resources -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Page Heading -->
        @hasSection('header')
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="mx-auto p-2 px-4 sm:p-4 lg:p-6">
                    <div class="flex justify-between items-center">
                        @hasSection('sidebar')
                            <button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                                <span class="sr-only">Open sidebar</span>
                                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                                </svg>
                            </button>
                        @endif
                        @yield('header')
                    </div>
                </div>
            </header>
        @endif

        <!-- Page -->
        <div class="after:content-[''] after:table after:clear-both">
            <!-- Page Sidebar -->
            @hasSection('sidebar')
                <aside id="default-sidebar" class="fixed z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 sm:static sm:float-left sm:my-0.5" aria-label="Sidebar">
                    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                        <ul class="space-y-2 font-medium">
                            @yield('sidebar')
                        </ul>
                    </div>
                </aside>
            @endif

            <!-- Page Content -->
            @hasSection('content')
                <main class="min-h-screen">
                    <div class="@hasSection('sidebar') sm:ml-64 @endif p-4 md:p-8">
                        <div class="content">
                            @yield('content')
                        </div>
                    </div>
                </main>
            @endif
        </div>

        <!-- Page Footer -->
        @hasSection('footer')
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="mx-auto p-2 px-4 sm:p-4 lg:p-6">
                    <div class="flex justify-between items-center">
                        @yield('footer')
                    </div>
                </div>
            </header>
        @endif
    </div>
</body>
</html>