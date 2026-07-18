<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 relative z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Logo + links --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" wire:navigate class="shrink-0">
                    <img src="{{ asset('logo/jrk_logo.svg') }}" alt="JRK" class="h-11 w-auto sm:h-13">
                </a>

                @auth
                    <div class="hidden sm:flex items-center gap-1">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')" wire:navigate>
                            Home
                        </x-nav-link>
                    </div>
                @endauth
            </div>

            {{-- Rechts --}}
            <div class="flex items-center gap-3">
                @auth
                    <div class="hidden sm:block">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition">
                                    @if(auth()->user()->hasMedia('profile_photo'))
                                        <img src="{{ auth()->user()->getFirstMediaUrl('profile_photo') }}" class="h-7 w-7 rounded-full object-cover ring-2 ring-gray-200">
                                    @else
                                        <span class="h-7 w-7 rounded-full bg-primary flex items-center justify-center text-white text-xs font-semibold">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </span>
                                    @endif
                                    <span x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></span>
                                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile')" wire:navigate>
                                    Profiel
                                </x-dropdown-link>
                                <button wire:click="logout" class="w-full text-start">
                                    <x-dropdown-link>
                                        Uitloggen
                                    </x-dropdown-link>
                                </button>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="hidden sm:flex items-center gap-2">
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')" wire:navigate>
                            Inloggen
                        </x-nav-link>
                        <a href="{{ route('register') }}" wire:navigate class="rounded-lg bg-primary px-3.5 py-2 text-sm font-semibold text-white hover:bg-primary-hover transition">
                            Registreren
                        </a>
                    </div>
                @endauth

                {{-- Hamburger --}}
                <button @click="open = !open" class="sm:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Mobile overlay --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        @click.outside="open = false"
        class="sm:hidden absolute top-full left-0 right-0 bg-white border-b border-gray-200 shadow-lg z-50"
        style="display: none;"
    >
        @auth
            <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-3">
                @if(auth()->user()->hasMedia('profile_photo'))
                    <img src="{{ auth()->user()->getFirstMediaUrl('profile_photo') }}" class="h-9 w-9 rounded-full object-cover ring-2 ring-gray-200">
                @else
                    <span class="h-9 w-9 rounded-full bg-primary flex items-center justify-center text-white text-sm font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                @endif
                <div>
                    <div class="text-sm font-medium text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                    <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <div class="py-2 space-y-0.5 px-2">
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" wire:navigate>
                    Home
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    Profiel
                </x-responsive-nav-link>
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        Uitloggen
                    </x-responsive-nav-link>
                </button>
            </div>
        @else
            <div class="py-2 space-y-0.5 px-2">
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')" wire:navigate>
                    Inloggen
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')" wire:navigate>
                    Registreren
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>
