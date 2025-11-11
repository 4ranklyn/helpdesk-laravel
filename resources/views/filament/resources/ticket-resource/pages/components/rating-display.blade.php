<div class="space-y-4">
    <div>
        <div class="flex items-center space-x-2">
            @for($i = 1; $i <= 5; $i++)
                <span class="flex items-center justify-center w-8 h-8 rounded-full text-sm font-medium {{ $i <= $rating->rating ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ $i }}
                </span>
            @endfor
            <span class="ml-2 text-sm text-gray-500">{{ $rating->rating }}/5</span>
        </div>
        @if($rating->comment)
            <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-800 rounded-md">
                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $rating->comment }}</p>
            </div>
        @endif
        <p class="mt-1 text-sm text-gray-500">
            Rated by {{ $rating->user->name }} on {{ $rating->created_at->format('M d, Y H:i') }}
        </p>
    </div>
</div>
