<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full max-w-[340px] mx-auto flex flex-col justify-center">
    <!-- Header -->
    <div class="text-center mb-10 flex flex-col items-center">
        <div class="w-16 h-16 flex items-center justify-center mb-2">
            <svg class="text-white w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m0 0l-3-3m3 3l3-3"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3C8.784 3 8 3.784 8 4.75v10.5C8 17.433 9.79 19 12 19s4-1.567 4-3.75V4.75C16 3.784 15.216 3 14.25 3h-4.5zM16 8h2a2 2 0 012 2v2a2 2 0 01-2 2h-2"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-black text-white tracking-tighter mb-4">Northern<br>Cafe</h1>
        
        <h2 class="text-xl font-bold text-gray-200 mt-6 tracking-tight leading-snug">
            Create an Account
        </h2>
        <p class="text-[11px] font-bold text-gray-400 mt-2">Daftar sebagai pegawai baru.</p>
    </div>

    <form wire:submit="register" class="space-y-5">
        <!-- Name -->
        <div class="space-y-1">
            <label for="name" class="text-[10px] font-bold text-gray-400 pl-1">Full Name</label>
            <input wire:model="name" id="name" class="w-full px-5 py-4 bg-[#262626] border-0 rounded-xl text-sm font-bold text-white placeholder:text-gray-500 focus:ring-2 focus:ring-white transition-all shadow-inner" type="text" name="name" required autofocus autocomplete="name" placeholder="John Doe">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div class="space-y-1">
            <label for="email" class="text-[10px] font-bold text-gray-400 pl-1">Email address</label>
            <input wire:model="email" id="email" class="w-full px-5 py-4 bg-[#262626] border-0 rounded-xl text-sm font-bold text-white placeholder:text-gray-500 focus:ring-2 focus:ring-white transition-all shadow-inner" type="email" name="email" required autocomplete="username" placeholder="johndoe@gmail.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label for="password" class="text-[10px] font-bold text-gray-400 pl-1">Password</label>
            <input wire:model="password" id="password" class="w-full px-5 py-4 bg-[#262626] border-0 rounded-xl text-sm font-bold text-white placeholder:text-gray-500 focus:ring-2 focus:ring-white transition-all shadow-inner" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1">
            <label for="password_confirmation" class="text-[10px] font-bold text-gray-400 pl-1">Confirm Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" class="w-full px-5 py-4 bg-[#262626] border-0 rounded-xl text-sm font-bold text-white placeholder:text-gray-500 focus:ring-2 focus:ring-white transition-all shadow-inner" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Submit -->
        <div class="pt-6 flex flex-col items-center">
            <button type="submit"
                    class="w-40 py-3.5 bg-white hover:bg-gray-100 text-[#1A1A1A] font-black rounded-[2rem] shadow-lg active:scale-95 transition-all flex items-center justify-center text-sm">
                Sign Up
            </button>
        </div>

        <div class="flex flex-col items-center pt-6">
            <p class="text-[11px] font-bold text-gray-400">
                Already registered? 
                <a href="{{ route('login') }}" wire:navigate class="text-white hover:underline transition-all">Sign in</a>
            </p>
        </div>
    </form>
</div>
