<x-guest-layout>
    @section('title', 'Reset Password')
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="tw-block tw-mt-1 tw-w-full" type="email" name="email" :value="old('email', $request->email)"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="tw-mt-2" />
        </div>

        <div class="tw-mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="tw-block tw-mt-1 tw-w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="tw-mt-2" />
        </div>

        <div class="tw-mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="tw-block tw-mt-1 tw-w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="tw-mt-2" />
        </div>

        <div class="tw-flex tw-items-center tw-justify-end tw-mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
