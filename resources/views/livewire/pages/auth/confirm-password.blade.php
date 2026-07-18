<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component
{
    public string $password = '';

    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12 bg-gray-50">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <a href="{{ route('home') }}" wire:navigate class="inline-block">
                <img src="{{ asset('logo/jrk_logo.svg') }}" alt="JRK" class="h-16 w-auto mx-auto sm:h-20">
            </a>
            <h1 class="mt-6 text-3xl font-semibold text-gray-900 tracking-tight">Bevestig je wachtwoord</h1>
            <p class="mt-2 text-sm text-gray-500">Dit is een beveiligd gedeelte van de applicatie</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 px-8 py-10">

            <p class="text-sm text-gray-600 mb-6">
                Bevestig je wachtwoord voor je verdergaat.
            </p>

            <form wire:submit="confirmPassword" class="space-y-5">

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Wachtwoord</label>
                    <input
                        wire:model="password"
                        id="password"
                        type="password"
                        name="password"
                        required
                        autofocus
                        autocomplete="current-password"
                        class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-xs transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                </div>

                <button
                    type="submit"
                    class="w-full flex justify-center items-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-primary-hover active:bg-primary-active focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition"
                >
                    <span wire:loading.remove wire:target="confirmPassword">Bevestigen</span>
                    <span wire:loading wire:target="confirmPassword" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Bezig...
                    </span>
                </button>

            </form>
        </div>

    </div>
</div>
