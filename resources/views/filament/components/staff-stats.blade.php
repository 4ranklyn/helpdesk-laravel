<div class="w-full flex flex-col sm:flex-row gap-4">
    <!-- Ongoing Tickets -->
    <div class="flex-1 p-6 rounded-lg shadow bg-white dark:bg-gray-800">
        <div class="flex items-center">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:bg-blue-900 dark:bg-opacity-30">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Tiket Berlangsung</p>
                <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $ongoingTickets }}</p>
            </div>
        </div>
    </div>

    <!-- Completed Tickets -->
    <div class="flex-1 p-6 rounded-lg shadow bg-white dark:bg-gray-800">
        <div class="flex items-center">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:bg-green-900 dark:bg-opacity-30">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Tiket Selesai</p>
                <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $completedTickets }}</p>
            </div>
        </div>
    </div>

    <!-- Rating -->
    <div class="flex-1 p-6 rounded-lg shadow bg-white dark:bg-gray-800">
        <div class="flex items-center">
            <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:bg-opacity-30">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Rating Rata-rata</p>
                <div class="flex items-center">
                    <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $averageRating ?? 0 }}</p>
                    <span class="ml-1 text-sm text-gray-500 dark:text-gray-400">/ 5</span>
                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">({{ $totalRatings ?? 0 }} ulasan)</span>
                </div>
                @if(isset($averageRating) && $averageRating > 0)
                <div class="flex mt-1">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($averageRating))
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <defs>
                                    <linearGradient id="half-star" x1="0" x2="50%" y1="0" y2="0" gradientUnits="objectBoundingBox">
                                        <stop offset="0.5" stop-color="currentColor" />
                                        <stop offset="0.5" stop-color="#D1D5DB" />
                                    </linearGradient>
                                </defs>
                                <path fill="url(#half-star)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        @endif
                    @endfor
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
