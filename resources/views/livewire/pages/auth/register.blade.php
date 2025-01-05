<?php


use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads; // Import the WithFileUploads trait

new #[Layout('layouts.guest')] class extends Component
{
    use WithFileUploads; // Include the trait for file uploads
    public string $age = '';
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $contact_number = ''; // Add contact number
    public $photo; // Declare as a public property without type hint

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        // Validate input data, including the new fields
        $validated = $this->validate([
            'age' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'contact_number' => ['required', 'string', 'max:15'], // Validate contact number
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validate photo upload
        ]);

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Handle the photo upload if a photo was provided
        if ($this->photo) {
            // Store the photo in the desired directory, e.g., 'photos/'
            $validated['photo'] = $this->photo->store('photos', 'public');
        }

        // Create the user and trigger the Registered event
        event(new Registered($user = User::create($validated)));

        // Log the user in
        Auth::login($user);

        // Redirect to the dashboard
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}
?>

<div class="w-full mx-auto bg-white rounded-lg shadow-lg p-8">
    <form wire:submit="register" class="space-y-6">
        <div class="grid grid-cols-2 gap-4">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="font-semibold text-gray-700" />
                <x-text-input
                    wire:model="name"
                    id="name"
                    type="text"
                    name="name"
                    required
                    autofocus
                    autocomplete="name"
                    class="block mt-1 w-full px-4 py-3 border rounded-lg focus:ring-teal-500 focus:border-teal-500"
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
            </div>
            <div>
                <x-input-label for="age" :value="__('Age')" class="font-semibold text-gray-700" />
                <x-text-input
                    wire:model="age"
                    id="age"
                    type="age"
                    name="age"
                    required
                    autofocus
                    autocomplete="age"
                    class="block mt-1 w-full px-4 py-3 border rounded-lg focus:ring-teal-500 focus:border-teal-500"
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
            </div>
            <!-- Contact Number -->
            <div>
                <x-input-label for="contact_number" :value="__('Contact Number')" class="font-semibold text-gray-700" />
                <x-text-input
                    wire:model="contact_number"
                    id="contact_number"
                    type="text"
                    name="contact_number"
                    required
                    class="block mt-1 w-full px-4 py-3 border rounded-lg focus:ring-teal-500 focus:border-teal-500"
                />
                <x-input-error :messages="$errors->get('contact_number')" class="mt-2 text-red-600" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="font-semibold text-gray-700" />
                <x-text-input
                    wire:model="email"
                    id="email"
                    type="email"
                    name="email"
                    required
                    autocomplete="username"
                    class="block mt-1 w-full px-4 py-3 border rounded-lg focus:ring-teal-500 focus:border-teal-500"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
            </div>

            <!-- Photo -->
            <div>
                <x-input-label for="photo" :value="__('Photo')" class="font-semibold text-gray-700" />
                <input
                    wire:model="photo"
                    id="photo"
                    type="file"
                    name="photo"
                    class="block mt-1 w-full px-4 py-3 border rounded-lg focus:ring-teal-500 focus:border-teal-500"
                />
                <x-input-error :messages="$errors->get('photo')" class="mt-2 text-red-600" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="font-semibold text-gray-700" />
                <x-text-input
                    wire:model="password"
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="block mt-1 w-full px-4 py-3 border rounded-lg focus:ring-teal-500 focus:border-teal-500"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="font-semibold text-gray-700" />
                <x-text-input
                    wire:model="password_confirmation"
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="block mt-1 w-full px-4 py-3 border rounded-lg focus:ring-teal-500 focus:border-teal-500"
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
            </div>
        </div>

        <!-- Submit and Link -->
        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" wire:navigate class="text-sm text-teal-600 hover:underline">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="px-6 py-3 rounded-lg text-white bg-teal-600 hover:bg-teal-700">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>

