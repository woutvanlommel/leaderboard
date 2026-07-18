<x-layouts.app>
    <div class="min-h-[calc(100vh-4rem)] bg-gray-50 px-4 py-12">
        <div class="max-w-2xl mx-auto space-y-6">

            <div>
                <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Profiel</h1>
                <p class="mt-1 text-sm text-gray-500">Beheer je accountinstellingen</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 px-8 py-8">
                <livewire:profile.update-profile-information-form />
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 px-8 py-8">
                <livewire:profile.update-password-form />
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 px-8 py-8">
                <livewire:profile.delete-user-form />
            </div>

        </div>
    </div>
</x-layouts.app>
