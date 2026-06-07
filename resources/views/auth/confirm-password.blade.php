<x-app-layout>
    <section class="max-w-2xl mx-auto p-4 mt-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Confirm Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </header>

    <form action="{{ route('password.confirm.store') }}" method="POST" class="mt-6 space-y-6">
        @csrf
        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-password wire:model="password" 
                        id="password" 
                        class="block mt-1 w-full"
                        name="password"
                        required autocomplete="off"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-button color="primary" type="submit">
                {{ __('Confirm') }}
            </x-button>
        </div>
    </form>
</section>
</x-app-layout>