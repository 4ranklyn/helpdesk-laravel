<div class="overflow-hidden bg-white shadow sm:rounded-md">
    @if($tickets->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($tickets as $ticket)
                <li class="hover:bg-gray-50">
                    <a href="{{ route('filament.resources.tickets.view', $ticket) }}" class="block">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-blue-600 truncate">
                                    {{ $ticket->title }}
                                </p>
                                <div class="flex flex-shrink-0 ml-2">
                                    <p class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $ticket->ticketStatus->id == 1 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $ticket->ticketStatus->name }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-2 sm:flex sm:justify-between">
                                <div class="sm:flex">
                                    <p class="flex items-center text-sm text-gray-500">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $ticket->created_at->format('d M Y') }}
                                    </p>
                                    <p class="flex items-center mt-2 text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $ticket->problemCategory->name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="p-4 text-center text-gray-500">
            <p>Tidak ada tiket yang sedang berlangsung</p>
        </div>
    @endif
    
    @if($tickets->count() > 0)
        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
            <a href="{{ route('filament.resources.tickets.index', ['responsible_id' => $tickets->first()->responsible_id, 'tableFilters' => ['ticket_statuses_id' => ['values' => [1,2]]]]) }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                Lihat semua tiket berlangsung
            </a>
        </div>
    @endif
</div>
