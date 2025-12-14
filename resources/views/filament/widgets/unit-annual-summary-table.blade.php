<x-filament::widget>
    <x-filament::card>
        {{-- 1. Header Section (Inside Card) --}}
        {{-- Added 'mb-6' to create the gap between the header and the table --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                Annual Summary Table
            </h2>

            <select wire:model="selectedYear" 
                    class="text-sm border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @foreach($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>

        {{-- 2. The Table Container --}}
        <div class="overflow-hidden bg-white dark:bg-gray-900 rounded-lg shadow ring-1 ring-gray-950/5 dark:ring-white/10">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-white/5">
                    <tr>
                        <th class="px-4 py-3 font-medium text-gray-950 dark:text-white">Rank</th>
                        <th class="px-4 py-3 font-medium text-gray-950 dark:text-white">Unit Name</th>
                        <th class="px-4 py-3 font-medium text-gray-950 dark:text-white text-center">Avg Score</th>
                        <th class="px-4 py-3 font-medium text-gray-950 dark:text-white text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                    @forelse($reportData as $index => $row)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                            <td class="px-4 py-3">
                                @php
                                    $rank = $index + 1;
                                    $style = match ($rank) {
                                        1 => 'background-color: #fef9c3; color: #a16207; border: 1px solid #facc15;',
                                        2 => 'background-color: #f3f4f6; color: #4b5563; border: 1px solid #9ca3af;',
                                        3 => 'background-color: #ffedd5; color: #c2410c; border: 1px solid #fb923c;',
                                        default => 'background-color: #ffffff; color: #6b7280; border: 1px solid #e5e7eb;',
                                    };
                                @endphp
                                 <span class="inline-flex items-center justify-center w-8 h-8 rounded-full font-bold text-xs"
                                       style="{{ $style }}">
                                    #{{ $rank }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $row['name'] }}</div>
                            </td>
                            <td class="px-4 py-3 text-center font-mono text-gray-600 dark:text-gray-300">
                                {{ $row['avg_score'] }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $row['status_color'] }}">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                No units found for this year.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::card>
</x-filament::widget>