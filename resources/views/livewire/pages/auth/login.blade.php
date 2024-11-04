<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
};
?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-center text-teal-600" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="font-semibold text-gray-700" />
            <x-text-input
                wire:model="form.email"
                id="email"
                type="email"
                name="email"
                required
                autofocus
                autocomplete="username"
                class="block mt-1 w-full px-4 py-3 border rounded-lg focus:ring-teal-500 focus:border-teal-500"
            />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-red-600" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="font-semibold text-gray-700" />
            <x-text-input
                wire:model="form.password"
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="block mt-1 w-full px-4 py-3 border rounded-lg focus:ring-teal-500 focus:border-teal-500"
            />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-red-600" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember" class="inline-flex items-center text-gray-700">
                <input
                    wire:model="form.remember"
                    id="remember"
                    type="checkbox"
                    class="rounded border-gray-300 text-teal-600 focus:ring-teal-500"
                />
                <span class="ml-2">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Forgot Password and Submit Button -->
        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="text-sm text-teal-600 hover:underline">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="px-6 py-3 rounded-lg text-white bg-teal-600 hover:bg-teal-700">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
