<div class="p-6 bg-white rounded-lg shadow">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Top 5 Teknisi Terbaik</h3>
    
    <div class="space-y-4">
        @forelse($topStaff as $staff)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium text-gray-900">{{ $staff->name }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $staff->responsible_tickets_count }} tiket • 
                        Rating: {{ number_format($staff->ratings_received_avg_rating, 1) }}/5
                    </p>
                </div>
                <div class="text-right">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        #{{ $loop->iteration }}
                    </span>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada data teknisi dengan rating.</p>
        @endforelse
    </div>
</div>
