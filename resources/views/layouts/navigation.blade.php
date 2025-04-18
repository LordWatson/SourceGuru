<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Dashboard -->
                    <x-nav-link :href="route('dashboard')" :active="request()->is('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <!-- Quotes -->
                    <x-nav-link :href="route('quotes.index')" :active="request()->is('quotes')">
                        {{ __('Quotes') }}
                    </x-nav-link>

                    <!-- Companies -->
                    <x-nav-link :href="route('companies.index')" :active="request()->is('companies')">
                        {{ __('Companies') }}
                    </x-nav-link>

                    @if(Auth::user()->role->level > 2)
                        <!-- Users -->
                        <x-nav-link :href="route('users.index')" :active="request()->is('users')">
                            {{ __('Users') }}
                        </x-nav-link>

                        <!-- Reports -->
                        <x-nav-link :href="route('reports.index')" :active="request()->is('reports')">
                            {{ __('Reports') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">

                @php
                    $searchableRoutes = ['users.index', 'companies.index', 'quotes.index', 'reports.index'];
                @endphp

                @if(in_array(Route::currentRouteName(), $searchableRoutes))
                    <!-- Search Bar -->
                    <div class="relative">
                        <form method="GET" action="{{ route(Route::currentRouteName()) }}">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="h-10 px-4 text-sm leading-5 border rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                style="width: 20rem;"
                                placeholder="Search..."
                            >

                            <button
                                type="submit"
                                class="absolute inset-y-0 right-0 px-3 text-gray-600 hover:text-gray-800"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M11 2a8 8 0 016.32 12.9l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387A8 8 0 1111 2zm-6 8a6 6 0 1012 0 6 6 0 00-12 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Quotes Nav Links -->
                        <x-dropdown-link :href="route('quotes.index')">
                            {{ __('Quotes') }}
                        </x-dropdown-link>

                        <!-- Companies Nav Links -->
                        <x-dropdown-link :href="route('companies.index')">
                            {{ __('Companies') }}
                        </x-dropdown-link>

                        @if(Auth::user()->role->level > 2)
                            <!-- Users Nav Links -->
                            <x-dropdown-link :href="route('users.index')">
                                {{ __('Users') }}
                            </x-dropdown-link>

                            <!-- Reports Nav Links -->
                            <x-dropdown-link :href="route('reports.index')">
                                {{ __('Reports') }}
                            </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
