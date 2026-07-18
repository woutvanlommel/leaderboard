<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component
{
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12 bg-gray-50">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <a href="{{ route('home') }}" wire:navigate class="inline-block">
                <img src="{{ asset('logo/jrk_logo.svg') }}" alt="JRK" class="h-16 w-auto mx-auto sm:h-20">
            </a>
            <h1 class="mt-6 text-3xl font-semibold text-gray-900 tracking-tight">Wachtwoord vergeten</h1>
            <p class="mt-2 text-sm text-gray-500">We sturen je een herstelmail</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 px-8 py-10">

            <p class="text-sm text-gray-600 mb-6">
                Geef je e-mailadres op en we sturen je een link waarmee je een nieuw wachtwoord kunt instellen.
            </p>

            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form wire:submit="sendPasswordResetLink" class="space-y-5">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">E-mailadres</label>
                    <input
                        wire:model="email"
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-xs transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                        placeholder="jij@voorbeeld.be"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>

                <button
                    type="submit"
                    class="w-full flex justify-center items-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-primary-hover active:bg-primary-active focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition"
                >
                    <span wire:loading.remove wire:target="sendPasswordResetLink">Stuur herstelmail</span>
                    <span wire:loading wire:target="sendPasswordResetLink" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Bezig...
                    </span>
                </button>

            </form>
        </div>

        <p class="mt-6 text-center text-sm text-gray-500">
            Toch nog je wachtwoord?
            <a href="{{ route('login') }}" wire:navigate class="font-medium text-primary hover:text-primary-hover transition">
                Terug naar inloggen
            </a>
        </p>

    </div>
</div>
