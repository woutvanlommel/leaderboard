<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Spatie\Image\Image;

new class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $photo = null;

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:5120'],
        ]);

        $user->fill(['name' => $validated['name'], 'email' => $validated['email']]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($this->photo) {
            $webpPath = tempnam(sys_get_temp_dir(), 'profile-photo').'.webp';

            Image::load($this->photo->getRealPath())->format('webp')->save($webpPath);

            $user->addMedia($webpPath)->usingFileName('profile-photo.webp')->toMediaCollection('profile_photo');

            $this->photo = null;
        }

        $this->dispatch('profile-updated', name: $user->name);
    }

    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('home', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <h2 class="text-base font-semibold text-gray-900">Profielinformatie</h2>
    <p class="mt-1 text-sm text-gray-500">Pas je naam, e-mailadres en profielfoto aan.</p>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-5">

        {{-- Profielfoto --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Profielfoto</label>
            <div class="flex items-center gap-4">
                @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}" class="w-14 h-14 rounded-full object-cover ring-2 ring-gray-200">
                @elseif (auth()->user()->hasMedia('profile_photo'))
                    <img src="{{ auth()->user()->getFirstMediaUrl('profile_photo') }}" class="w-14 h-14 rounded-full object-cover ring-2 ring-gray-200">
                @else
                    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                @endif

                <label for="photo" class="cursor-pointer rounded-lg border border-gray-300 px-3.5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    Foto kiezen
                    <input type="file" wire:model="photo" id="photo" accept="image/jpeg,image/png" class="sr-only">
                </label>
            </div>
            <p class="mt-1.5 text-xs text-gray-400">JPG of PNG, max 5MB</p>
            <x-input-error class="mt-1.5" :messages="$errors->get('photo')" />
        </div>

        {{-- Naam --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Naam</label>
            <input
                wire:model="name"
                id="name"
                name="name"
                type="text"
                required
                autofocus
                autocomplete="name"
                class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-xs transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
            />
            <x-input-error class="mt-1.5" :messages="$errors->get('name')" />
        </div>

        {{-- E-mail --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">E-mailadres</label>
            <input
                wire:model="email"
                id="email"
                name="email"
                type="email"
                required
                autocomplete="username"
                class="block w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-xs transition focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
            />
            <x-input-error class="mt-1.5" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <p class="mt-2 text-sm text-gray-600">
                    Je e-mailadres is niet geverifieerd.
                    <button wire:click.prevent="sendVerification" class="text-primary underline hover:text-primary-hover transition">
                        Stuur verificatiemail opnieuw.
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm text-green-600 font-medium">Verificatiemail verstuurd.</p>
                @endif
            @endif
        </div>

        <div class="flex items-center gap-4 pt-1">
            <button
                type="submit"
                class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-primary-hover active:bg-primary-active focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition"
            >
                <span wire:loading.remove wire:target="updateProfileInformation">Opslaan</span>
                <span wire:loading wire:target="updateProfileInformation" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Bezig...
                </span>
            </button>

            <x-action-message class="text-sm text-green-600 font-medium" on="profile-updated">
                Opgeslagen.
            </x-action-message>
        </div>

    </form>
</section>
