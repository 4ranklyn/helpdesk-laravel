<x-filament::widget>
    <x-filament::card>
        <div class="flex items-center justify-between">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Want to see the detailed breakdown?
            </div>
            
            {{-- [FIX] Use heroicon-o- (outline) or heroicon-s- (solid) for v2 --}}
            <x-filament::button
                tag="a"
                href="/admin/staff-unit-rankings"
                icon="heroicon-o-arrow-right" 
                icon-position="after"
                size="md"
            >
                View Full Performance Rankings
            </x-filament::button>
        </div>
    </x-filament::card>
</x-filament::widget>