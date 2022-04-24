<aside class="z-20 hidden w-64 overflow-y-auto bg-white md:block flex-shrink-0">
    <div class="py-4 text-gray-500">
        <a class="ml-6 text-lg font-bold text-gray-800" href="{{ route('dashboard') }}">
            {{ config('app.name', 'Windmill') }}
        </a>

        <ul class="mt-6">
            <li class="relative px-6 py-3">
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <x-slot name="icon">
                        <x-icons.home />
                    </x-slot>
                    {{ __('Dashboard') }}
                </x-nav-link>
            </li>

            <li class="relative px-6 py-3">
                <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
                    <x-slot name="icon">
                        <x-icons.users />
                    </x-slot>
                    {{ __('Users') }}
                </x-nav-link>
            </li>

            <li class="relative px-6 py-3">
                <x-nav-link href="{{ route('pending-users.index') }}" :active="request()->routeIs('pending-users.index')">
                    <x-slot name="icon">
                        <x-icons.user-add />
                    </x-slot>
                    {{ __('Pending Users') }}
                </x-nav-link>
            </li>

            <li class="relative px-6 py-3">
                <x-nav-link href="{{ route('notes.index') }}" :active="request()->routeIs('notes.index')">
                    <x-slot name="icon">
                        <x-icons.clipboard-list />
                    </x-slot>
                    {{ __('My Notes') }}
                </x-nav-link>
            </li>

            <li class="relative px-6 py-3">
                <x-nav-link href="{{ route('notes-tree.index') }}" :active="request()->routeIs('notes-tree.index')">
                    <x-slot name="icon">
                        <x-icons.clipboard-list-solid />
                    </x-slot>
                    {{ __('Notes Tree') }}
                </x-nav-link>
            </li>

            <li class="relative px-6 py-3">
                <x-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">
                    <x-slot name="icon">
                        <x-icons.template />
                    </x-slot>
                    {{ __('About us') }}
                </x-nav-link>
            </li>

{{--
            <li class="relative px-6 py-3">
                <button class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                        @click="toggleMultiLevelMenu" aria-haspopup="true">
                <span class="inline-flex items-center">
                    <x-icons.view-list />
                    <span class="ml-4">Two-level menu</span>
                </span>
                    <x-icons.chevron-down />
                </button>
                <template x-if="isMultiLevelMenuOpen">
                    <ul x-transition:enter="transition-all ease-in-out duration-300"
                        x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl"
                        x-transition:leave="transition-all ease-in-out duration-300"
                        x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                            <a class="w-full" href="#">Child menu</a>
                        </li>
                    </ul>
                </template>
            </li>
--}}
        </ul>
    </div>
</aside>
