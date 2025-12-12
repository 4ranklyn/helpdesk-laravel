<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- SECTION 1: STAFF RANKINGS --}}
        <div class="col-span-1">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
                @if(auth()->user()->hasRole('Admin Unit'))
                    My Unit's Staff Rankings
                @else
                    All Staff Rankings
                @endif
            </h2>
            
            <div class="overflow-hidden bg-white dark:bg-gray-900 rounded-lg shadow ring-1 ring-gray-950/5 dark:ring-white/10">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-white/5">
                        <tr>
                            <th class="px-4 py-3 font-medium text-gray-950 dark:text-white">Rank</th>
                            <th class="px-4 py-3 font-medium text-gray-950 dark:text-white">Name</th>
                            <th class="px-4 py-3 font-medium text-gray-950 dark:text-white text-center">Score</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                        @forelse($staffRanks as $staff)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-4 py-3">
                                    @php
                                        $rank = (int) $staff['rank'];
                                        // Force colors using inline styles to bypass Tailwind cache issues
                                        $style = match ($rank) {
                                            1 => 'background-color: #fef9c3; color: #a16207; border: 1px solid #facc15;', // Gold
                                            2 => 'background-color: #f3f4f6; color: #4b5563; border: 1px solid #9ca3af;', // Silver
                                            3 => 'background-color: #ffedd5; color: #c2410c; border: 1px solid #fb923c;', // Bronze
                                            default => 'background-color: #ffffff; color: #6b7280; border: 1px solid #e5e7eb;', // Default
                                        };
                                    @endphp

                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-xs"
                                          style="{{ $style }}">
                                        #{{ $rank }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $staff['staff_name'] }}</div>
                                </td>
                                <td class="px-4 py-3 text-center font-mono">{{ number_format($staff['saw_score'], 4) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                                    No rankings found for this period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- SECTION 2: UNIT RANKINGS --}}
        <div class="col-span-1">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Unit Rankings</h2>
            
            <div class="overflow-hidden bg-white dark:bg-gray-900 rounded-lg shadow ring-1 ring-gray-950/5 dark:ring-white/10">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-white/5">
                        <tr>
                            <th class="px-4 py-3 font-medium text-gray-950 dark:text-white">Rank</th>
                            <th class="px-4 py-3 font-medium text-gray-950 dark:text-white">Unit</th>
                            <th class="px-4 py-3 font-medium text-gray-950 dark:text-white text-center">Score</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                        @forelse($unitRanks as $unit)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-4 py-3">
                                    @php
                                        $rank = (int) $unit['rank'];
                                        $style = match ($rank) {
                                            1 => 'background-color: #fef9c3; color: #a16207; border: 1px solid #facc15;', // Gold
                                            2 => 'background-color: #f3f4f6; color: #4b5563; border: 1px solid #9ca3af;', // Silver
                                            3 => 'background-color: #ffedd5; color: #c2410c; border: 1px solid #fb923c;', // Bronze
                                            default => 'background-color: #ffffff; color: #6b7280; border: 1px solid #e5e7eb;', // Default
                                        };
                                    @endphp

                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-xs"
                                          style="{{ $style }}">
                                        #{{ $rank }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $unit['unit_name'] }}</td>
                                <td class="px-4 py-3 text-center font-mono">{{ number_format($unit['saw_score'], 4) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                                    No unit rankings found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-filament::page>