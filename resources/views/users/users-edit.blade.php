<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User - ') . $user->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('users.partials.update-user-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('users.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // a user can't change the role of a user ranked higher than them
    @if(Auth::user()->role->level < $user->role->level)
        // apply readonly to all inputs
        document.querySelectorAll('select').forEach(el => el.disabled = true);
    @endif
</script>
