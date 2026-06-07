<x-app-layout>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Two Factor Authentication') }}
        </h2>
    </header>

    @if (session('status') == 'two-factor-authentication-enabled')
        <div class="mb-4 font-medium text-sm">
            Please finish configuring two factor authentication below.
        </div>

        <div class="mt-4 mb-4">
            {!! auth()->user()->twoFactorQrCodeSvg() !!}
        </div>

        <div>
            <form method="POST" action="{{ route('two-factor.confirm') }}" class="mt-6 space-y-6">
                @csrf
                <div class="flex items-center gap-4">
                    <x-pin id="code" name="code" length="6" label="Code" hint="We sent a 6-digit code to your authenticator app." />
                    {{-- <x-input  type="text" 
                    class="block mt-1 w-full" autofocus autocomplete="one-time-code" /> --}}
                    <x-button type="submit">{{ __('Confirm') }}</x-button>
            </form>
        </div>

    @endif

    @if (session('status') == 'two-factor-authentication-confirmed')
        <div class="mb-4 font-medium text-sm">
            Two factor authentication confirmed and enabled successfully.
        </div>
    @endif

    @if(auth()->user()->two_factor_confirmed_at)
        <div class="mt-4">
            <form method="POST" action="{{ route('two-factor.disable') }}" class="mt-6 space-y-6">
                @csrf
                @method('DELETE')
                <div class="flex items-center gap-4">
                    <x-button color="red" type="submit">{{ __('Disable Two-Factor Authentication') }}</x-button>
                </div>
            </form>
        </div>
    @else
    <form  action="{{ route('two-factor.enable') }}" method="post"  class="mt-6 space-y-6">
        @csrf
        <div class="flex items-center gap-4">
            <x-button type="submit">{{ __('Activate Two-Factor Authentication') }}</x-button>
        </div>
    </form>
    @endif
</section>

</x-app-layout>