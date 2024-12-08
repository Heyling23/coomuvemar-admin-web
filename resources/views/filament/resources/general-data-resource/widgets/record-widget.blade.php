<x-filament-widgets::widget>
    <x-filament::link
        href="{{ $action }}"
        class="w-full p-4 bg-gradient-to-r from-green-600 via-green-500 to-green-400 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out"
        size="xs"
        color="gray"
    >
        <div class="flex items-center gap-4">
            <!-- Icon Section -->
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <x-filament::icon
                    icon="heroicon-o-rectangle-stack"
                    class="h-8 w-8 text-white"
                />
            </div>

            <!-- Content Section -->
            <div class="flex flex-col">
                <h2 class="text-lg font-semibold text-white">
                    {{ $title }}
                </h2>
                <p class="text-sm text-white text-opacity-80">
                    {{ $description ?? 'Click para explorar mas detalles.' }}
                </p>
            </div>
        </div>
    </x-filament::link>
</x-filament-widgets::widget>
