<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 flex flex-col md:flex-row w-full max-w-4xl">
        <x-auth-session-status class="mb-4" :status="session('status')"/>
        <!-- Formulário -->
        <div class="w-full md:w-1/2 flex flex-col justify-center p-6">
            <div class="flex justify-center mb-4">
                <img src="{{asset('assets/images/logoConvenio.png')}}" alt="Logo" class="w-12 h-12">
            </div>
            <h2 class="text-2xl font-semibold text-center mb-6">Visitas Convênio</h2>
            <form action="{{ route('login.store') }}" class="space-y-4" method="POST">
                @csrf
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('E-mail')" class="block text-gray-700"/>
                    <x-input id="email"
                                  class="block mt-1 w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  type="email" name="email" required autofocus autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Senha')" class="block text-gray-700"/>

                    <x-password wire:model="form.password" name="password" id="password" required autocomplete="current-password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">Acessar
                </button>
            </form>
        </div>
        <!-- Imagem -->
        <div class="hidden md:flex md:w-1/2 items-center justify-center">
            <img src="{{asset('assets/images/visitante.jpg')}}" alt="Ilustração" class="w-full h-full object-cover">
        </div>
    </div>
</div>
</x-guest-layout>
