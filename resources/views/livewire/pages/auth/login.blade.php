<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12 bg-gray-50">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <a href="{{ route('home') }}" wire:navigate class="inline-block">
                <img src="{{ asset('logo/jrk_logo.svg') }}" alt="JRK" class="h-16 w-auto mx-auto sm:h-20">
            </a>
            <h1 class="mt-6 text-3xl font-semibold text-gray-900 tracking-tight">Welkom terug</h1>
            <p class="mt-2 text-sm text-gray-500">Log in op je account</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 px-8 py-10">

            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form wire:submit="login" class="space-y-5">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">E-mailadres</label>
                    <input
                        wire:model="form.email"
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        autocomplete="username"
                        class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-xs transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        placeholder="jij@voorbeeld.be"
                    />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-1.5" />
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700">Wachtwoord</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" wire:navigate class="text-xs text-primary hover:text-primary-hover transition">
                                Wachtwoord vergeten?
                            </a>
                        @endif
                    </div>
                    <input
                        wire:model="form.password"
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-xs transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('form.password')" class="mt-1.5" />
                </div>

                <div class="flex items-center gap-2">
                    <input
                        wire:model="form.remember"
                        id="remember"
                        type="checkbox"
                        name="remember"
                        class="h-4 w-4 rounded border-gray-300 text-primary shadow-xs focus:ring-primary/20 cursor-pointer"
                    />
                    <label for="remember" class="text-sm text-gray-600 cursor-pointer select-none">Onthoud mij</label>
                </div>

                <button
                    type="submit"
                    class="w-full flex justify-center items-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-primary-hover active:bg-primary-active focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition"
                >
                    <span wire:loading.remove wire:target="login">Inloggen</span>
                    <span wire:loading wire:target="login" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Bezig...
                    </span>
                </button>

            </form>
        </div>

        @if (Route::has('register'))
            <p class="mt-6 text-center text-sm text-gray-500">
                Nog geen account?
                <a href="{{ route('register') }}" wire:navigate class="font-medium text-primary hover:text-primary-hover transition">
                    Registreer je hier
                </a>
            </p>
        @endif

    </div>
</div>
