<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 flex flex-col md:flex-row w-full max-w-4xl">
        <!-- Formulário -->
        <div class="w-full md:w-1/2 flex flex-col justify-center p-6">
            

            <section class="max-w-2xl mx-auto p-4 mt-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex justify-center mb-4">
                <img src="{{asset('assets/images/logoConvenio.png')}}" alt="Logo" class="w-12 h-12">
            </div>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Two Factor Authentication') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                    </p>
                </header>

                <form method="POST" action="{{ route('two-factor.login') }}" class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <x-pin id="code" name="code" length="6" label="Code" hint="We sent a 6-digit code to your authenticator app." />
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-button type="submit">{{ __('Log in') }}</x-button>
                    </div>  
                </form>
            </section>
        </div>
        <!-- Imagem -->
        <div class="hidden md:flex md:w-1/2 items-center justify-center">
            <img src="{{asset('assets/images/2fa.jpg')}}" alt="Ilustração" class="w-full h-full object-cover">
        </div>
    </div>
</div>
</x-guest-layout>
