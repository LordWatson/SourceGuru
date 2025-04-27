<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 10000)"
    class="fixed top-4 right-4 max-w-sm bg-white border border-{{ session('status')['colour'] }}-600 shadow-xl rounded-lg px-5 py-4 z-50 flex items-start space-x-4"
>
    <!-- Icon Section -->
    <div class="text-{{ session('status')['colour'] }}-600">
        @if(session('status')['type'] == 'delete')
            X
        @else
            &check;
        @endif
    </div>

    <!-- Message Content -->
    <div class="flex-grow">
        <strong class="text-lg border-b border-{{ session('status')['colour'] }}-600 font-semibold text-{{ session('status')['colour'] }}-600">
            {{ ucfirst(session('status')['type']) }}
        </strong>
        <ul class="mt-2 text-sm text-gray-600">
            <li>{{ session('status')['message'] }}</li>
        </ul>
    </div>

    <!-- Close Button -->
    <button
        @click="show = false"
        class="text-gray-400 hover:text-gray-600"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>
</div>
