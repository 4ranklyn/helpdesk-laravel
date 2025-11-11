@php
    $ticketId = $ticketId ?? $ticket->id;
@endphp

<div class="space-y-4" x-data="{
    rating: 5,
    comment: '',
    showSuccess: false,
    errorMessage: null,
    submitting: false,
    
    init() {
        // Listen for browser events
        window.addEventListener('rating-submitted', () => {
            this.showSuccess = true;
        });
        
        // Debug log
        this.$watch('rating', value => {
            console.log('Rating changed to:', value);
        });
    },
    
    setRating(value) {
        this.rating = value;
        console.log('Setting rating to:', value);
    },
    
    async submitRating() {
        this.submitting = true;
        this.errorMessage = null;
        
        try {
            // Ensure rating is an integer
            const rating = parseInt(this.rating, 10);
            
            const response = await fetch('{{ route('tickets.rate', $ticketId) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    rating: rating,
                    comment: this.comment
                })
            });
            
            const data = await response.json();
            
            if (response.ok) {
                this.showSuccess = true;
                // Reload the page after a short delay to show the success message
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                this.errorMessage = data.message || 'Failed to submit rating. Please try again.';
            }
        } catch (error) {
            console.error('Error submitting rating:', error);
            this.errorMessage = 'An error occurred. Please try again.';
        } finally {
            this.submitting = false;
        }
    }
}">
    <!-- Success Message -->
    <div x-show="showSuccess" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" 
         role="alert">
        {{ __('Thank you for your rating! The ticket has been marked as resolved.') }}
    </div>

    <!-- Error Message -->
    <div x-show="errorMessage" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" 
         role="alert">
        <span x-text="errorMessage"></span>
    </div>

    <!-- Rating Form -->
    <form @submit.prevent="submitRating" class="space-y-4" x-show="!showSuccess">
        <!-- Number Rating -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ __('Rate your experience (1-5):') }}
            </label>
            <div class="flex space-x-2">
                @for($i = 1; $i <= 5; $i++)
                    <button 
                        type="button"
                        @click="rating = {{ $i }}"
                        x-bind:class="{{ $i }} <= rating ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
                        class="w-10 h-10 rounded-full flex items-center justify-center text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors"
                        :aria-label="'Rate {{ $i }} out of 5'"
                    >
                        {{ $i }}
                    </button>
                @endfor
            </div>
            <div class="flex justify-between text-xs text-gray-500 mt-1">
                <span>{{ __('Poor') }}</span>
                <span>{{ __('Excellent') }}</span>
            </div>
            @error('rating')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Comment -->
        <div>
            <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Additional Comments (Optional)') }}
            </label>
            <div class="mt-1">
                <textarea
                    id="comment"
                    x-model="comment"
                    x-model="comment"
                    rows="4"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                    placeholder="{{ __('Let us know how we did...') }}"
                ></textarea>
            </div>
            @error('comment')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button
                type="submit"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                :disabled="submitting"
                x-bind:class="{ 'opacity-75 cursor-not-allowed': submitting }"
            >
                <template x-if="submitting">
                    <svg class="w-5 h-5 mr-2 -ml-1 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </template>
                <span x-text="submitting ? '{{ __('Submitting...') }}' : '{{ __('Submit Rating') }}'"></span>
            </button>
        </div>
    </form>
</div>
