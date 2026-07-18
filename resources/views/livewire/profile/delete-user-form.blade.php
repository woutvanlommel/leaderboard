<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section>
    <h2 class="text-base font-semibold text-gray-900">Account verwijderen</h2>
    <p class="mt-1 text-sm text-gray-500">
        Eenmaal verwijderd zijn alle gegevens permanent gewist. Download eerst wat je wil bewaren.
    </p>

    <div class="mt-6">
        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-700 hover:bg-red-100 hover:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition"
        >
            Account verwijderen
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">

            <h2 class="text-base font-semibold text-gray-900">Weet je het zeker?</h2>
            <p class="mt-2 text-sm text-gray-500">
                Je account en alle bijhorende gegevens worden permanent verwijderd. Vul je wachtwoord in ter bevestiging.
            </p>

            <div class="mt-5">
                <label for="delete_password" class="sr-only">Wachtwoord</label>
                <input
                    wire:model="password"
                    id="delete_password"
                    name="password"
                    type="password"
                    class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-xs transition focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500/20"
                    placeholder="Wachtwoord"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition"
                >
                    Annuleren
                </button>

                <button
                    type="submit"
                    class="flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition"
                >
                    <span wire:loading.remove wire:target="deleteUser">Definitief verwijderen</span>
                    <span wire:loading wire:target="deleteUser" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Bezig...
                    </span>
                </button>
            </div>

        </form>
    </x-modal>
</section>
