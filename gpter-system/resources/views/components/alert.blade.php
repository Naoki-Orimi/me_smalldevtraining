@props(['type' => 'info', 'message' => '', 'dismissible' => true])

@if($message)
    <div class="mb-6 border rounded-lg p-4 
        @if($type === 'success') bg-green-50 border-green-200 text-green-800
        @elseif($type === 'error') bg-red-50 border-red-200 text-red-800
        @elseif($type === 'warning') bg-yellow-50 border-yellow-200 text-yellow-800
        @else bg-blue-50 border-blue-200 text-blue-800
        @endif" 
         @if($dismissible) 
         data-alert-id="{{ uniqid() }}"
         @endif>
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 
                    @if($type === 'success') text-green-400
                    @elseif($type === 'error') text-red-400
                    @elseif($type === 'warning') text-yellow-400
                    @else text-blue-400
                    @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="
                        @if($type === 'success') M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z
                        @elseif($type === 'error') M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z
                        @elseif($type === 'warning') M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z
                        @else M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z
                        @endif"></path>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium">{{ $message }}</p>
            </div>
            @if($dismissible)
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button onclick="closeAlert(this)" 
                                class="inline-flex rounded-md p-1.5 hover:bg-opacity-20 hover:bg-current focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-current focus:ring-current">
                            <span class="sr-only">閉じる</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif

<script>
function closeAlert(button) {
    const alertElement = button.closest('.mb-6');
    if (alertElement) {
        alertElement.style.transition = 'opacity 0.3s ease-out';
        alertElement.style.opacity = '0';
        setTimeout(() => {
            alertElement.remove();
        }, 300);
    }
}
</script>
