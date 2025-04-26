<div x-data="{ show: true }" 
     x-show="show" 
     x-transition 
     x-init="setTimeout(() => show = false, 3000)"
     class="fixed top-4 right-4 px-4 py-2 rounded-lg shadow-lg {{ $classes }} z-50">
    <div class="flex items-center">
        <span class="mr-2">
            @if($type === 'success')
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            @endif
        </span>
        <p>{{ $message }}</p>
    </div>
</div>
