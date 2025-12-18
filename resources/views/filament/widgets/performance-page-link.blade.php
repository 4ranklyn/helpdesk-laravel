<x-filament::widget>
    <x-filament::card>
        <div class="flex items-center justify-between">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Ingin melihat laporan lebih lanjut?
            </div>
            
            {{-- [FIX] Use heroicon-o- (outline) or heroicon-s- (solid) for v2 --}}
            <x-filament::button
                tag="a"
                href="/admin/ranking-staff-unit"
                icon="heroicon-o-arrow-right" 
                icon-position="after"
                size="md"
            >
                Lihat Detail Performa
            </x-filament::button>
        </div>
    </x-filament::card>
</x-filament::widget>