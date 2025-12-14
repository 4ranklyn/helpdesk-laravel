<x-filament::page>
    <x-slot name="header">
        <div class="flex flex-col space-y-2 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center space-x-2">
                <a href="{{ url('/admin/staff-list') }}" class="text-sm font-medium text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Daftar Staff
                </a>
                <span class="text-sm text-gray-400">/</span>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $this->staff->name }}</span>
            </div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                {{ $this->staff->name }}
            </h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Staff Information Card -->
        <div class="p-6 rounded-lg shadow bg-white dark:bg-gray-800">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:truncate">
                        {{ $this->staff->name }}
                    </h2>
                    <div class="flex flex-col mt-1 sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="flex items-center mt-2 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $this->staff->email }}
                        </div>
                        <div class="flex items-center mt-2 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            {{ $this->staff->unit->name ?? 'No Unit' }}
                        </div>
                        @if($this->staff->identity)
                        <div class="flex items-center mt-2 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            {{ $this->staff->identity }}
                        </div>
                        @endif
                        @if($this->staff->phone)
                        <div class="flex items-center mt-2 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $this->staff->phone }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full">
            <!-- Stats Cards -->
        <div class="w-full mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                @include('filament.components.staff-stats', [
                    'completedTickets' => $this->completedTicketsCount,
                    'ongoingTickets' => $this->ongoingTicketsCount,
                    'averageRating' => $this->averageRating,
                    'totalRatings' => $this->totalRatings,
                ])
            </div>
        </div>

            <!-- Ticket Sections Container -->
            <div class="flex flex-col w-full gap-6 md:flex-row">
                <!-- Ongoing Tickets -->
                <div class="flex-1 overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg dark:ring-white/10">
                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-white">Tiket Berlangsung</h3>
                    </div>
                    <div class="w-full overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Judul</th>
                                <th scope="col" class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Status</th>
                                <th scope="col" class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Prioritas</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @php
                                $ongoingTickets = \App\Models\Ticket::query()
                                    ->with(['ticketStatus', 'priority'])
                                    ->where('responsible_id', $this->staff->id)
                                    ->whereIn('ticket_statuses_id', [1, 2, 3]) // Open, Assigned, In Progress
                                    ->latest()
                                    ->limit(5)
                                    ->get();
                            @endphp
                            
                            @forelse($ongoingTickets as $ticket)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white line-clamp-1">
                                        {{ $ticket->title }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $ticket->created_at->format('d M') }}
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            1 => ['bg' => 'bg-yellow-100 dark:bg-yellow-900', 'text' => 'text-yellow-800 dark:text-yellow-200'],
                                            2 => ['bg' => 'bg-blue-100 dark:bg-blue-900', 'text' => 'text-blue-800 dark:text-blue-200'],
                                        ][$ticket->ticket_statuses_id] ?? ['bg' => 'bg-gray-100 dark:bg-gray-700', 'text' => 'text-gray-800 dark:text-gray-200'];
                                    @endphp
                                    <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full {{ $statusColors['bg'] }} {{ $statusColors['text'] }}">
                                        {{ $ticket->ticketStatus->name }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    @php
                                        $priorityColors = [
                                            'low' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'high' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        ][$ticket->priority->slug ?? 'medium'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $priorityColors }}">
                                        {{ $ticket->priority->name ?? 'Normal' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-3 py-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                    <div class="py-2">
                                        <p class="text-sm">Tidak ada tiket</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                </div>

                <!-- Completed Tickets -->
                <div class="flex-1 overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg dark:ring-white/10">
                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-white">Tiket Selesai</h3>
                    </div>
                    <div class="w-full overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Judul</th>
                                <th scope="col" class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Status</th>
                                <th scope="col" class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">Selesai</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @php
                                $completedTickets = \App\Models\Ticket::query()
                                    ->with(['ticketStatus'])
                                    ->where('responsible_id', $this->staff->id)
                                    ->where('ticket_statuses_id', 6) // Resolved status
                                    ->latest()
                                    ->limit(5)
                                    ->get();
                            @endphp
                            
                            @forelse($completedTickets as $ticket)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white line-clamp-1">
                                        {{ $ticket->title }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $ticket->created_at->format('d M') }}
                                    </div>
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ $ticket->ticketStatus->name }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $ticket->completed_at ? $ticket->completed_at->format('d M') : '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-3 py-2 text-sm text-center text-gray-500 dark:text-gray-400">
                                    <div class="py-2">
                                        <p class="text-sm">Tidak ada tiket</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-filament::page>
