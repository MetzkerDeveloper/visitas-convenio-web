<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout)
    {
        $logout();

       return redirect()->route('login');
    }

}; ?>

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" wire:navigate>
                        {{ __('Menu') }}
                    </x-nav-link>

                    @can('isAdmin')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" >
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48" >
                    <x-slot:action>
                        <x-avatar  x-on:click="show = !show" :model="auth()->user()" color="fff" sm/>
                    </x-slot:action>
                    <x-slot:header>
                        <div class="flex items-center gap-2">
                            <x-avatar  x-on:click="show = !show" :model="auth()->user()" color="fff" xs/>
                            <span class="text-center font-medium text-base text-gray-600 dark:text-gray-200">{{auth()->user()->name}}</span>
                        </div>

                    </x-slot:header>


                    <x-dropdown.items>
                       <div class="flex items-center gap-2">
                           <span>Theme Mode </span>
                           <x-theme-switch />
                       </div>
                    </x-dropdown.items>


                    <x-dropdown-link :href="route('profile')" wire:navigate>
                            <x-dropdown.items icon="user-circle" text="Perfil" />
                    </x-dropdown-link>

                        @can('isAdmin')

                            <x-dropdown-link :href="route('usuarios')" wire:navigate>
                                <x-dropdown.items icon="user-group" text="Usuários" />
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('parametros')" wire:navigate>
                                <x-dropdown.items icon="cog" text="Parâmetros" />
                            </x-dropdown-link>
                            <hr>
                                <p class="text-center w-full p-2">  <x-dropdown.items  text="Relatórios" /></p>
                            <hr>

                            <x-dropdown-link :href="route('cidade-visitada')" >
                                <x-dropdown.items icon="building-office-2" text="Cidades Visitadas" />
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('recorrencia-visitas')" >
                                <x-dropdown.items icon="document-text" text="Recorrência Visitas" />
                            </x-dropdown-link>


                            <hr>
                        @endcan
                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Sair') }}
                            </x-dropdown-link>
                        </button>

                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
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
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" wire:navigate>
                {{ __('Menu') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="flex items-center gap-2 dark:text-gray-200">
                    <span>Theme Mode </span>
                    <x-theme-switch />
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                @can('isAdmin')
                    <x-responsive-nav-link :href="route('usuarios')" wire:navigate>
                        {{ __('Usuários') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('parametros')" wire:navigate>
                        {{ __('Parâmetros') }}
                    </x-responsive-nav-link>

                    <hr>
                        <p class="text-center w-full p-2">  <x-dropdown.items  text="Relatórios" /></p>
                    <hr>

                    <x-responsive-nav-link :href="route('dashboard')" >
                            {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('cidade-visitada')" wire:navigate>
                        {{ __('Cidades Visitadas') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('recorrencia-visitas')" wire:navigate>
                        {{ __('Recorrência Visitas') }}
                    </x-responsive-nav-link>
                @endcan
                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Sair') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
