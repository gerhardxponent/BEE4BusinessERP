<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Inter Google Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"> --}}

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400&display=swap" rel="stylesheet">

        {{-- <link href="http://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet"> --}}
        {{-- <link rel="preconnect" href="//fdn.fontcdn.ir">
        <link rel="preconnect" href="//v1.fontapi.ir">
        <link href="https://v1.fontapi.ir/css/SFProDisplay" rel="stylesheet"> --}}

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/emailsEditor.css') }}">
        {{-- <link rel="stylesheet" href="{{ URL::asset('css/mention.css') }}"> --}}
        <link rel="stylesheet" href="{{ URL::asset('css/tribute.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/billboard.js/3.5.1/billboard.min.css">

        @livewireStyles
        @powerGridStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <link rel="stylesheet" href="{{ URL::asset('css/filepond.min.css') }}">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div>
                <div class="flex h-screen overflow-y-hidden bg-white" x-data="setup()" x-init="$refs.loading.classList.add('hidden')">
                <!-- Loading screen -->
                <div
                    x-ref="loading"
                    class="fixed inset-0 z-50 flex items-center justify-center text-white bg-black bg-opacity-50"
                    style="backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px)">
                    Loading.....
                </div>

                <!-- Sidebar backdrop -->
                <div
                    x-show.in.out.opacity="isSidebarOpen"
                    class="fixed inset-0 z-10 bg-black bg-opacity-20 lg:hidden"
                    style="backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px)">
                </div>

                <!-- Sidebar -->
                <aside
                    x-transition:enter="transition transform duration-300"
                    x-transition:enter-start="-translate-x-full opacity-30  ease-in"
                    x-transition:enter-end="translate-x-0 opacity-100 ease-out"
                    x-transition:leave="transition transform duration-300"
                    x-transition:leave-start="translate-x-0 opacity-100 ease-out"
                    x-transition:leave-end="-translate-x-full opacity-0 ease-in"
                    class="fixed inset-y-0 z-10 flex flex-col flex-shrink-0 w-20 max-h-screen transition-all transform bg-white border-r shadow-lg lg:z-auto lg:static lg:shadow-none"
                    :class="{ 'w-64': isSidebarOpen, '-translate-x-full lg:translate-x-0 lg:w-20' : !isSidebarOpen }"
                    >
                    <!-- sidebar header -->
                    <div class="flex items-center justify-between flex-shrink-0 p-2" :class="{'lg:justify-center': !isSidebarOpen}">
                    <span class="p-2 text-xl font-semibold leading-8 tracking-wider uppercase whitespace-nowrap text-white">
                        B<span :class="{'lg:hidden': !isSidebarOpen}">EE4BUSINESS</span>
                    </span>
                    <button @click="toggleSidbarMenu()" class="p-2 rounded-md lg:hidden">
                        <svg
                        class="w-6 h-6 text-gray-600"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    </div>
                    <!-- Sidebar links -->
                    <nav class="flex-1">
                        <ul class="p-2">
                            <li>
                                {{-- Dashboard --}}
                                <x-nav-link :active="request()->routeIs('dashboard')">
                                    <x-slot name="route">
                                        {{ route('dashboard') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dashboard" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <circle cx="12" cy="13" r="2"></circle>
                                            <line x1="13.45" y1="11.55" x2="15.5" y2="9.5"></line>
                                            <path d="M6.4 20a9 9 0 1 1 11.2 0z"></path>
                                        </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Dashboard') }}</x-slot>
                                </x-nav-link>
                                {{-- Management --}}
                                <x-nav-link :active="request()->routeIs('management')">
                                    <x-slot name="route">
                                        {{ route('management') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-report-analytics" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                                        <rect x="9" y="3" width="6" height="4" rx="2"></rect>
                                        <path d="M9 17v-5"></path>
                                        <path d="M12 17v-1"></path>
                                        <path d="M15 17v-3"></path>
                                    </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Management') }}</x-slot>
                                </x-nav-link>
                                {{-- Clients --}}
                                @can('view clients')
                                <x-nav-link :active="request()->routeIs('clients')">
                                    <x-slot name="route">
                                        {{ route('clients') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <line x1="3" y1="21" x2="21" y2="21"></line>
                                            <line x1="9" y1="8" x2="10" y2="8"></line>
                                            <line x1="9" y1="12" x2="10" y2="12"></line>
                                            <line x1="9" y1="16" x2="10" y2="16"></line>
                                            <line x1="14" y1="8" x2="15" y2="8"></line>
                                            <line x1="14" y1="12" x2="15" y2="12"></line>
                                            <line x1="14" y1="16" x2="15" y2="16"></line>
                                            <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16"></path>
                                        </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Clients') }}</x-slot>
                                </x-nav-link>
                                @endcan
                                {{-- Audits --}}
                                <x-nav-link :active="request()->routeIs('audits')">
                                    <x-slot name="route">
                                        {{ route('audits') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <x-icons.book />
                                    </x-slot>

                                    <x-slot name="name">{{ __('Audits') }}</x-slot>
                                </x-nav-link>
                                {{-- Leads --}}
                                @can('view leads')
                                <x-nav-link :active="request()->routeIs('leads')">
                                    <x-slot name="route">
                                        {{ route('leads') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone-incoming" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                        <line x1="15" y1="9" x2="20" y2="4"></line>
                                        <polyline points="15 5 15 9 19 9"></polyline>
                                        </svg>
                                        </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Leads') }}</x-slot>
                                </x-nav-link>
                                @endcan
                                {{-- Contacts --}}
                                @can('view contacts')
                                <x-nav-link :active="request()->routeIs('contacts')">
                                    <x-slot name="route">
                                        {{ route('contacts') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Contacts') }}</x-slot>
                                </x-nav-link>
                                @endcan
                                {{-- Quotes --}}
                                @can('view quotes')
                                <x-nav-link :active="request()->routeIs('quotes')">
                                    <x-slot name="route">
                                        {{ route('quotes') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notes" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <rect x="5" y="3" width="14" height="18" rx="2"></rect>
                                            <line x1="9" y1="7" x2="15" y2="7"></line>
                                            <line x1="9" y1="11" x2="15" y2="11"></line>
                                            <line x1="9" y1="15" x2="13" y2="15"></line>
                                        </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Quotes') }}</x-slot>
                                </x-nav-link>
                                @endcan
                                {{-- Products --}}
                                @can('view products')
                                <x-nav-link :active="request()->routeIs('products')">
                                    <x-slot name="route">
                                        {{ route('products') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-box" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3"></polyline>
                                            <line x1="12" y1="12" x2="20" y2="7.5"></line>
                                            <line x1="12" y1="12" x2="12" y2="21"></line>
                                            <line x1="12" y1="12" x2="4" y2="7.5"></line>
                                        </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Products') }}</x-slot>
                                </x-nav-link>
                                @endcan
                                {{-- Services --}}
                                @can('view services')
                                {{-- <x-nav-link :active="request()->routeIs('services')">
                                    <x-slot name="route">
                                        {{ route('services') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-hammer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M11.414 10l-7.383 7.418a2.091 2.091 0 0 0 0 2.967a2.11 2.11 0 0 0 2.976 0l7.407 -7.385"></path>
                                            <path d="M18.121 15.293l2.586 -2.586a1 1 0 0 0 0 -1.414l-7.586 -7.586a1 1 0 0 0 -1.414 0l-2.586 2.586a1 1 0 0 0 0 1.414l7.586 7.586a1 1 0 0 0 1.414 0z"></path>
                                        </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Services') }}</x-slot>
                                </x-nav-link> --}}
                                @endcan
                                {{-- Boards --}}
                                {{-- <x-nav-link :active="request()->routeIs('boards')">
                                    <x-slot name="route">
                                        {{ route('boards') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                                            <rect x="9" y="3" width="6" height="4" rx="2"></rect>
                                            <path d="M9 14l2 2l4 -4"></path>
                                        </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Boards') }}</x-slot>
                                </x-nav-link> --}}
                                {{-- Consultations --}}
                                @can('view consultations')
                                <x-nav-link :active="request()->routeIs('consultations')">
                                    <x-slot name="route">
                                        {{ route('consultations') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                        </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Consultations') }}</x-slot>
                                </x-nav-link>
                                @endcan
                                {{-- Reports --}}
                                {{-- @can('view reports')
                                <x-nav-link :active="request()->routeIs('reports')">
                                    <x-slot name="route">
                                        {{ route('reports') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                        </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Reports') }}</x-slot>
                                </x-nav-link>
                                @endcan --}}
                                {{-- Projects --}}
                                {{-- <x-nav-link :active="request()->routeIs('projects')">
                                    <x-slot name="route">
                                        {{ route('projects') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-line" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <line x1="4" y1="19" x2="20" y2="19"></line>
                                        <polyline points="4 15 8 9 12 11 16 6 20 10"></polyline>
                                        </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Projects') }}</x-slot>
                                </x-nav-link> --}}
                                {{-- Calendar --}}
                                <x-nav-link :active="request()->routeIs('calendar')">
                                    <x-slot name="route">
                                        {{ route('calendar') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                                        <line x1="16" y1="3" x2="16" y2="7"></line>
                                        <line x1="8" y1="3" x2="8" y2="7"></line>
                                        <line x1="4" y1="11" x2="20" y2="11"></line>
                                        <line x1="11" y1="15" x2="12" y2="15"></line>
                                        <line x1="12" y1="15" x2="12" y2="18"></line>
                                    </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Calendar') }}</x-slot>
                                </x-nav-link>
                                 Files
{{--                                <x-nav-link :active="request()->routeIs('files')">--}}
{{--                                    <x-slot name="route">--}}
{{--                                        {{ route('files') }}--}}
{{--                                    </x-slot>--}}

{{--                                    <x-slot name="icon">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-files" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">--}}
{{--                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>--}}
{{--                                            <path d="M15 3v4a1 1 0 0 0 1 1h4"></path>--}}
{{--                                            <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z"></path>--}}
{{--                                            <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2"></path>--}}
{{--                                        </svg>--}}
{{--                                    </x-slot>--}}

{{--                                    <x-slot name="name">{{ __('Files') }}</x-slot>--}}
{{--                                </x-nav-link>--}}
                                {{-- Support --}}
                                <x-nav-link :active="request()->routeIs('support')">
                                    <x-slot name="route">
                                        {{ route('support') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <x-icons.chat />
                                    </x-slot>

                                    <x-slot name="name">{{ __('Support') }}</x-slot>
                                </x-nav-link>
                                {{-- Tasks --}}
                                <x-nav-link :active="request()->routeIs('tasks')">
                                    <x-slot name="route">
                                        {{ route('tasks') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checklist" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8"></path>
                                            <path d="M14 19l2 2l4 -4"></path>
                                            <path d="M9 8h4"></path>
                                            <path d="M9 12h2"></path>
                                        </svg>
                                    </x-slot>

                                    <x-slot name="name">{{ __('Tasks') }}</x-slot>
                                </x-nav-link>
                                {{-- Resources --}}
                                <x-nav-link :active="request()->routeIs('resources')">
                                    <x-slot name="route">
                                        {{ route('resources') }}
                                    </x-slot>

                                    <x-slot name="icon">
                                        <x-icons.info-square />
                                    </x-slot>

                                    <x-slot name="name">{{ __('Resources') }}</x-slot>
                                </x-nav-link>
                            </li>
                            <!-- Sidebar Links... -->
                        </ul>
                    </nav>
                    <!-- Sidebar footer -->
                    <div class="flex-shrink-0 p-2 border-t border-gray-200 max-h-14">
                        <button
                            class="flex items-center justify-center w-full px-4 py-2 space-x-1 font-medium tracking-wider uppercase bg-gray-100 border border-gray-200 rounded-md focus:outline-none focus:ring">
                            <span>
                            <svg
                                class="w-6 h-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            </span>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <a href="{{ route('logout') }}"
                                            @click.prevent="$root.submit();">
                                    <!-- {{ __('Logout') }}-->
                                </a>
                            </form>
                        </button>
                    </div>
                </aside>

                <div class="flex flex-col flex-1 h-full overflow-hidden">
                    <!-- Navbar -->
                    <header class="flex-shrink-0 border-b border-gray-200">
                    <div class="flex items-center justify-between p-2">
                        <!-- Navbar left -->
                        <div class="flex items-center space-x-3">
                            <span class="p-2 text-xl font-semibold tracking-wider uppercase lg:hidden">EDGE</span>
                            <!-- Toggle sidebar button -->
                            <button @click="toggleSidbarMenu()" class="p-2 rounded-md focus:outline-none focus:ring">
                                <svg
                                class="w-4 h-4 text-gray-600"
                                :class="{'transform transition-transform -rotate-180': isSidebarOpen}"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                </svg>
                            </button>
                            <div>
                                @isset($title)
                                    <div>{{ $title }}</div>
                                    {{-- <x-back>{{ $title }}</x-back> --}}
                                @endisset
                            </div>
                        </div>

                        <!-- Mobile search box -->
                        <div
                            x-show.transition="isSearchBoxOpen"
                            class="fixed inset-0 z-10 bg-black bg-opacity-20"
                            style="backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px)"
                            >
                        <div
                            @click.away="isSearchBoxOpen = false"
                            class="absolute inset-x-0 flex items-center justify-between p-2 bg-white shadow-md">
                            <div class="flex items-center flex-1 px-2 space-x-2">
                            <!-- search icon -->
                            <span>
                                <svg
                                class="w-6 h-6 text-gray-500"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </span>
                            <input
                                type="text"
                                placeholder="Search"
                                class="w-full px-4 py-3 text-gray-600 rounded-md focus:bg-gray-100 focus:outline-none"/>
                            </div>
                            <!-- close button -->
                            <button @click="isSearchBoxOpen = false" class="flex-shrink-0 p-4 rounded-md">
                            <svg
                                class="w-4 h-4 text-gray-500"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            </button>
                        </div>
                        </div>

                        <?php /*
                        <!-- Desktop search box -->
                        <div class="items-center hidden px-2 space-x-2 md:flex-1 md:flex md:mr-auto md:ml-5">
                        <!-- search icon -->
                        <span>
                            <svg
                            class="w-5 h-5 text-gray-500"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            placeholder="Search"
                            class="px-4 py-3 rounded-md hover:bg-gray-100 lg:max-w-sm md:py-2 md:flex-1 focus:outline-none md:focus:bg-gray-100 md:focus:shadow md:focus:border"/>
                        </div>
                        */ ?>

                        <!-- Navbar right -->
                        <div class="relative flex items-center space-x-3">
                        <!-- Search button -->
                        <button
                            @click="isSearchBoxOpen = true"
                            class="p-2 bg-gray-100 rounded-full md:hidden focus:outline-none focus:ring hover:bg-gray-200">
                            <svg
                            class="w-6 h-6 text-gray-500"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>

                        <div class="items-center hidden space-x-3 md:flex">
                            <!-- Notification Button -->
                            <div class="relative" x-data="{ isOpen: false }">
                                <!-- red dot -->
                                <div class="absolute right-0 p-1 bg-red-400 rounded-full animate-ping"></div>
                                <div class="absolute right-0 p-1 bg-red-400 border rounded-full"></div>
                                <button
                                    @click="isOpen = !isOpen"
                                    class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 focus:outline-none focus:ring">
                                    <svg
                                    class="w-6 h-6 text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                </button>

                                <!-- Dropdown card -->
                                <div
                                    @click.away="isOpen = false"
                                    x-show.transition.opacity="isOpen"
                                    class="absolute w-48 max-w-md mt-3 transform bg-white rounded-md shadow-lg -translate-x-3/4 min-w-max"
                                    >
                                    <div class="p-4 font-medium border-b border-gray-200">
                                        <span class="text-gray-800">Notification</span>
                                    </div>
                                    <ul class="flex flex-col p-2 my-2 space-y-1">
                                        <li>
                                            <a href="#" class="block px-2 py-1 transition rounded-md hover:bg-gray-100">Link</a>
                                        </li>
                                        <li>
                                            <a href="#" class="block px-2 py-1 transition rounded-md hover:bg-gray-100">Another Link</a>
                                        </li>
                                    </ul>
                                    <div class="flex items-center justify-center p-4 text-blue-700 underline border-t border-gray-200">
                                        <a href="#">See All</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Services Button -->
                            <div x-data="{ isOpen: false }">
                            <button
                                @click="isOpen = !isOpen"
                                class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 focus:outline-none focus:ring">
                                <svg
                                class="w-6 h-6 text-gray-500"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </button>

                            <!-- Dropdown -->
                            <div
                                @click.away="isOpen = false"
                                @keydown.escape="isOpen = false"
                                x-show.transition.opacity="isOpen"
                                class="absolute mt-3 transform bg-white rounded-md shadow-lg -translate-x-3/4 min-w-max">
                                <div class="p-4 text-lg font-medium border-b border-gray-200">Web apps & services</div>
                                <ul class="flex flex-col p-2 my-3 space-y-3">
                                <li>
                                    <a href="#" class="flex items-start px-2 py-1 space-x-2 rounded-md hover:bg-gray-100">
                                    <span class="block mt-1">
                                        <svg
                                        class="w-6 h-6 text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path fill="#fff" d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path
                                            fill="#fff"
                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                                        </svg>
                                    </span>
                                    <span class="flex flex-col">
                                        <span class="text-lg">Atlassian</span>
                                        <span class="text-sm text-gray-400">Lorem ipsum dolor sit.</span>
                                    </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-start px-2 py-1 space-x-2 rounded-md hover:bg-gray-100">
                                    <span class="block mt-1">
                                        <svg
                                        class="w-6 h-6 text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                        </svg>
                                    </span>
                                    <span class="flex flex-col">
                                        <span class="text-lg">Slack</span>
                                        <span class="text-sm text-gray-400">Lorem ipsum, dolor sit amet consectetur adipisicing elit.</span>
                                    </span>
                                    </a>
                                </li>
                                </ul>
                                <div class="flex items-center justify-center p-4 text-blue-700 underline border-t border-gray-200">
                                <a href="#">Show all apps</a>
                                </div>
                            </div>
                            </div>

                            <!-- Options Button -->
                            <div class="relative" x-data="{ isOpen: false }">
                            <button
                                @click="isOpen = !isOpen"
                                class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 focus:outline-none focus:ring">
                                <svg
                                class="w-6 h-6 text-gray-500"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                </svg>
                            </button>

                            <!-- Dropdown card -->
                            <div
                                @click.away="isOpen = false"
                                x-show.transition.opacity="isOpen"
                                class="absolute z-50 w-40 max-w-sm mt-3 transform bg-white rounded-md shadow-lg -translate-x-3/4 min-w-max">
                                <div class="p-4 font-medium border-b border-gray-200">
                                <span class="text-gray-800">Settings</span>
                                </div>
                                <ul class="flex flex-col p-2 my-2 space-y-1">
                                <li>
                                    <a href="{{ route('users') }}" class="block px-2 py-1 transition rounded-md hover:bg-gray-100">Users</a>
                                </li>
                                <li>
                                    <a href="{{ route('roles') }}" class="block px-2 py-1 transition rounded-md hover:bg-gray-100">Roles & Permissions</a>
                                </li>
                                </ul>
                            </div>
                            </div>
                        </div>

                        <!-- avatar button -->
                        <div class="relative" x-data="{ isOpen: false }">
                            <button @click="isOpen = !isOpen" class="p-1 bg-gray-200 rounded-full focus:outline-none focus:ring">
                            <img
                                class="object-cover w-8 h-8 rounded-full"
                                src="https://avatars0.githubusercontent.com/u/57622665?s=460&u=8f581f4c4acd4c18c33a87b3e6476112325e8b38&v=4"
                                alt="User Profile"/>
                            </button>
                            <!-- green dot -->
                            <div class="absolute right-0 p-1 bg-green-400 rounded-full bottom-3 animate-ping"></div>
                            <div class="absolute right-0 p-1 bg-green-400 border border-white rounded-full bottom-3"></div>

                            <!-- Dropdown card -->
                            <div
                            @click.away="isOpen = false"
                            x-show.transition.opacity="isOpen"
                            class="absolute z-50 mt-3 transform -translate-x-full bg-white rounded-md shadow-lg min-w-max">
                            <div class="flex flex-col p-4 space-y-1 font-medium border-b border-gray-200">
                                <span class="text-gray-800">{{ Auth::user()->name }}</span>
                                <span class="text-sm text-gray-400">{{ Auth::user()->email }}</span>
                            </div>
                            <ul class="flex flex-col p-2 my-2 space-y-1">
                                <li>
                                <a href="{{ route('profile.show') }}" class="block px-2 py-1 transition rounded-md hover:bg-gray-100">{{ __('Profile') }}</a>
                                </li>
                            </ul>
                            <div class="flex items-center justify-center p-4 text-blue-700 underline border-t border-gray-200">
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                                @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-jet-responsive-nav-link>
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </header>
                    <!-- Main content -->
                    <main class="p-4 flex-1 max-h-full overflow-hidden overflow-y-scroll main-bg">
                        <!-- Main content header -->
                        {{-- <div
                            class="mb-4 flex items-start justify-between pb-6 space-y-4 border-b lg:items-center lg:space-y-0 lg:flex-row">
                            <div class="w-full text-2xl font-semibold whitespace-nowrap flex justify-between items-center">{{ $title }}</div>
                        </div> --}}

                        <!-- Page Content -->
                        <!-- dashboard.blade.php -->
                        {{-- <main> --}}
                            {{ $slot }}
                        {{-- </main> --}}
                    </main>
                </div>

                </div>
                <script>
                    const setup = () => {
                        return {
                            loading: true,
                            isSidebarOpen: false,
                            toggleSidbarMenu() {
                                this.isSidebarOpen = !this.isSidebarOpen
                            },
                            isSettingsPanelOpen: false,
                            isSearchBoxOpen: false,
                        }
                    }
                </script>
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
        </div>

        @stack('modals')

        @livewireScripts
        @powerGridScripts

        @stack('scripts')

        <script src="{{ URL::asset('js/filepond.min.js') }}"></script>
        <script src="{{ URL::asset('js/emailsEditor.bundle.js') }}"></script>
        <script src="{{ URL::asset('js/tribute.min.js') }}"></script>
        {{-- <script src="{{ URL::asset('js/pspdfkit.js') }}"></script> --}}
        <script src="https://d3js.org/d3.v6.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/billboard.js/3.5.1/billboard.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>

        <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
        <script src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    </body>
</html>
