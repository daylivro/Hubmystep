@php
    use Filament\Support\Enums\MaxWidth;
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
    @props([
        'after' => null,
        'heading' => null,
        'subheading' => null,
    ])

    <div class="relative w-full h-screen overflow-hidden flex">
        <!-- Image de fond -->
        <div class="w-1/2 bg-cover bg-center bg-no-repeat" style="background-image: url('https://emi.parkview.com/media/Image/Dashboard_952_The-many-health-benefits-of-regular-exercise_11_20.jpg');"></div>

        <!-- Conteneur du formulaire -->
        <div class="w-1/2 bg-white flex items-center justify-center">
            <main class="w-full max-w-md px-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @if (($hasTopbar ?? true) && filament()->auth()->check())
        <div class="absolute top-0 right-0 flex h-16 items-center gap-x-4 pe-4 md:pe-6 lg:pe-8">
            @if (filament()->hasDatabaseNotifications())
                @livewire(Filament\Livewire\DatabaseNotifications::class, ['lazy' => true])
            @endif

            <x-filament-panels::user-menu />
        </div>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::FOOTER, scopes: $livewire->getRenderHookScopes()) }}
</x-filament-panels::layout.base>
