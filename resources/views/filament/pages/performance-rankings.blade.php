<x-filament::page>
    {{-- [NEW] Dynamic Header: Shows the currently selected Month & Year --}}
    <div class="mb-2">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Laporan Performa: 
            <span class="text-primary-600 dark:text-primary-400">
                {{ \Carbon\Carbon::createFromDate($selectedYear, $selectedMonth, 1)->locale('id')->translatedFormat('F Y') }}
            </span>
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Hasil kalkulasi ranking performa di periode ini
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- SECTION 1: STAFF RANKINGS (Wrapped in Card) --}}
        <div class="col-span-1">
            <x-filament::card>
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
                    @if(auth()->user()->hasRole('Admin Unit'))
                        Ranking Staff Unit
                    @else
                        Ranking Seluruh Staff
                    @endif
                </h2>
                
                <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-white/10">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-white/5">
                            <tr>
                                <th class="px-4 py-3 font-medium text-gray-950 dark:text-white">Ranking</th>
                                <th class="px-4 py-3 font-medium text-gray-950 dark:text-white">Nama</th>
                                <th class="px-4 py-3 font-medium text-gray-950 dark:text-white text-center">Skor</th>
                                <th class="px-4 py-3 font-medium text-gray-950 dark:text-white text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                            @forelse($staffRanks as $staff)
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                    <td class="px-4 py-3">
                                        @php
                                            // 1. DETERMINE WHICH RANK TO SHOW
                                            $globalRank = (int) $staff['rank'];
                                            
                                            if (auth()->user()->hasRole('Admin Unit')) {
                                                // Admin Unit: Main Rank is Unit Rank (Loop Iteration)
                                                $displayRank = $loop->iteration;
                                                $subText = "#{$globalRank} Umum";
                                            } else {
                                                // Management: Main Rank is Global Rank
                                                $displayRank = $globalRank;
                                                $subText = null;
                                            }

                                            // 2. BADGE COLOR (Based on the Display Rank)
                                            $badgeStyle = match ($displayRank) {
                                                1 => 'background-color: #fef9c3; color: #a16207; border: 1px solid #facc15;', // Gold
                                                2 => 'background-color: #f3f4f6; color: #4b5563; border: 1px solid #9ca3af;', // Silver
                                                3 => 'background-color: #ffedd5; color: #c2410c; border: 1px solid #fb923c;', // Bronze
                                                default => 'background-color: #ffffff; color: #6b7280; border: 1px solid #e5e7eb;', 
                                            };
                                            
                                            // 3. STATUS LOGIC
                                            $score = (float) $staff['saw_score'];
                                            if ($score >= 0.8) {
                                                $statusLabel = 'Sangat Baik'; $statusClass = 'bg-green-100 text-green-700';
                                            } elseif ($score >= 0.6) {
                                                $statusLabel = 'Baik'; $statusClass = 'bg-orange-100 text-orange-700';
                                            } else {
                                                $statusLabel = 'Perlu Peningkatan'; $statusClass = 'bg-red-100 text-red-700';
                                            }
                                        @endphp

                                        <div class="flex flex-col items-start justify-center">
                                            {{-- Main Badge (Unit Rank for Admin, Global for Mgr) --}}
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-xs mb-1" 
                                                  style="{{ $badgeStyle }}">
                                                #{{ $displayRank }}
                                            </span>
                                            
                                            {{-- Subtext (Shows Global Rank if viewing Unit view) --}}
                                            @if($subText)
                                                <span class="block mt-1 text-gray-500 font-mono leading-tight whitespace-nowrap" style="font-size: 9px;">
                                                    {{ $subText }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $staff['staff_name'] }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-center font-mono">{{ number_format($staff['saw_score'], 4) }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-filament::card>
        </div>

        {{-- SECTION 2: UNIT RANKINGS (Wrapped in Card) --}}
        <div class="col-span-1">
            <x-filament::card>
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Ranking Unit</h2>
                
                <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-white/10">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-white/5">
                            <tr>
                                <th class="px-4 py-3 font-medium text-gray-950 dark:text-white">Ranking</th>
                                <th class="px-4 py-3 font-medium text-gray-950 dark:text-white">Unit</th>
                                <th class="px-4 py-3 font-medium text-gray-950 dark:text-white text-center">Skor</th>
                                <th class="px-4 py-3 font-medium text-gray-950 dark:text-white text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                            @forelse($unitRanks as $unit)
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                    <td class="px-4 py-3">
                                        @php
                                            $rank = (int) $unit['rank'];
                                            $style = match ($rank) {
                                                1 => 'background-color: #fef9c3; color: #a16207; border: 1px solid #facc15;',
                                                2 => 'background-color: #f3f4f6; color: #4b5563; border: 1px solid #9ca3af;',
                                                3 => 'background-color: #ffedd5; color: #c2410c; border: 1px solid #fb923c;',
                                                default => 'background-color: #ffffff; color: #6b7280; border: 1px solid #e5e7eb;',
                                            };

                                            $score = (float) $unit['saw_score'];
                                            if ($score >= 0.8) {
                                                $statusLabel = 'Sangat Baik'; $statusClass = 'bg-green-100 text-green-700';
                                            } elseif ($score >= 0.6) {
                                                $statusLabel = 'Baik'; $statusClass = 'bg-orange-100 text-orange-700';
                                            } else {
                                                $statusLabel = 'Perlu Peningkatan'; $statusClass = 'bg-red-100 text-red-700';
                                            }
                                        @endphp

                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-xs" style="{{ $style }}">
                                            #{{ $rank }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $unit['unit_name'] }}</td>
                                    <td class="px-4 py-3 text-center font-mono">{{ number_format($unit['saw_score'], 4) }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-filament::card>
        </div>
    </div>

    {{-- SECTION 3: MONTHLY PERFORMANCE CHART (Manually placed here) --}}
    @if(auth()->user()->hasRole(['Manajemen Rumah Sakit', 'Super Admin']))
        <div class="mt-6">
            @livewire(\App\Filament\Widgets\MonthlyUnitPerformanceChart::class)
        </div>
    @endif

    {{-- Divider for Annual Section --}}
    @if(auth()->user()->hasRole(['Manajemen Rumah Sakit', 'Super Admin']))
        <div class="mt-12 mb-6 border-t border-gray-200 dark:border-gray-700 pt-8">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                Performa Tahunan
            </h2>
            <p class="text-gray-500 text-sm">
                Performa unit pada tahun yang dipilih
            </p>
        </div>
        
        {{-- The Yearly Chart and Annual Table will appear here automatically via getFooterWidgets --}}
    @endif

</x-filament::page>