<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use TallStackUi\Traits\Interactions;


new #[Layout('layouts.guest')]
class extends Component {
    use Interactions;
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login()
    {
        try {
            $this->validate();

            $this->form->authenticate();

            Session::regenerate();

            if (auth()->user()->two_factor_confirmed_at) {
                return redirect()->route('two-factor.login');
            }

            return redirect()->route('home');
        }catch (\Illuminate\Validation\ValidationException $e){
            $errors = $e->validator->errors();

            if ($errors->has('form.email')) {
                $this->dialog()->warning('Atenção',implode(' ', $errors->get('form.email')))->send();
            }
            if ($errors->has('form.password')) {
                $this->dialog()->warning('Atenção',implode(' ', $errors->get('form.password')))->send();
            }
            if ($errors->has('acesso')) {
                $this->dialog()->error('Acesso Negado',implode(' ', $errors->get('acesso')))->send();
            }

            return;
        }

    }
}; ?>


<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 flex flex-col md:flex-row w-full max-w-4xl">
        <x-auth-session-status class="mb-4" :status="session('status')"/>
        <!-- Formulário -->
        <div class="w-full md:w-1/2 flex flex-col justify-center p-6">
            <div class="flex justify-center mb-4">
                <img src="{{asset('assets/images/logoConvenio.png')}}" alt="Logo" class="w-12 h-12">
            </div>
            <h2 class="text-2xl font-semibold text-center mb-6">Visitas Convênio</h2>
            <form wire:submit="login" class="space-y-4">
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('E-mail')" class="block text-gray-700"/>
                    <x-input wire:model="form.email" id="email"
                                  class="block mt-1 w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  type="email" name="email" required autofocus autocomplete="username"/>
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2"/>
                </div>
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Senha')" class="block text-gray-700"/>

                    <x-password wire:model="form.password" id="password" required autocomplete="current-password"/>

                    <x-input-error :messages="$errors->get('form.password')" class="mt-2"/>
                </div>

                <button class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">Acessar
                </button>
            </form>
        </div>
        <!-- Imagem -->
        <div class="hidden md:flex md:w-1/2 items-center justify-center">
            <img src="{{asset('assets/images/visitante.jpg')}}" alt="Ilustração" class="w-full h-full object-cover">
        </div>
    </div>
</div>
