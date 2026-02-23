<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;
use TallStackUi\Traits\Interactions;

new class extends Component
{
    use Interactions;

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */

    
    public function updatePassword(): void
    {

        $this->dialog()
        ->question('Attention!', 'Are you sure that you want to update your password?')
        ->confirm('Confirm', 'updatePasswordConfirmed', 'Confirmed Successfully')
        ->cancel('Cancel', 'cancelled', 'Cancelled Successfully')
        ->send();
        
    }

    public function cancelled(string $message): void
    {
        $this->dialog()->error('Cancelled', $message)->send();
    }

    public function updatePasswordConfirmed(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            $errors = $e->validator->errors();

            if ($errors->has('current_password')) {
                $this->dialog()->error('Error', implode(', ', $errors->get('current_password')))->send();
                return;
            }

            if ($errors->has('password')) {
                $this->dialog()->error('Error', implode(', ', $errors->get('password')))->send();
                return;
            }

            if ($errors->has('password_confirmation')) {
                $this->dialog()->error('Error', implode(', ', $errors->get('password_confirmation')))->send();
                return;
            }
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dialog()->success('Success','Password updated successfully.')->send();
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit.prevent="updatePassword" class="mt-6 space-y-6">
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-password wire:model.live="current_password" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-password wire:model.live="password" id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-password wire:model.live="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-button type="submit">{{ __('Save') }}</x-button>
        </div>
    </form>
</section>
