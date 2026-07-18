<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold">{{ __('Heyyyy, :name!', ['name' => auth()->user()->name]) }}</h1>
    </div>
</x-layouts.app>
