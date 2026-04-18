<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login()
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();

        if (auth()->user()->role === 'owner') {
            return $this->redirect(route('owner.dashboard', absolute: false), navigate: true);
        }

        return $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full max-w-[340px] mx-auto flex flex-col justify-center">
    <!-- Logo & Header -->
    <div class="text-center mb-10 flex flex-col items-center">
        <!-- Optional animated coffee icon to match "Cafe Beans" -->
        <div class="w-16 h-16 flex items-center justify-center mb-2">
            <svg class="text-white w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m0 0l-3-3m3 3l3-3"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3C8.784 3 8 3.784 8 4.75v10.5C8 17.433 9.79 19 12 19s4-1.567 4-3.75V4.75C16 3.784 15.216 3 14.25 3h-4.5zM16 8h2a2 2 0 012 2v2a2 2 0 01-2 2h-2"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-black text-white tracking-tighter mb-4">Northern<br>Cafe</h1>
        
        <h2 class="text-xl font-bold text-gray-200 mt-6 tracking-tight leading-snug max-w-[280px]">
            Welcome Back, Please login to your account
        </h2>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @if(session('error'))
        <div class="mb-4 text-xs font-bold text-rose-500 text-center bg-rose-500/10 p-3 rounded-xl border border-rose-500/20">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div class="space-y-1">
            <label for="email" class="text-[10px] font-bold text-gray-400 pl-1">Email address</label>
            <input wire:model="form.email" id="email" class="w-full px-5 py-4 bg-[#262626] border-0 rounded-xl text-sm font-bold text-white placeholder:text-gray-500 focus:ring-2 focus:ring-white transition-all shadow-inner" type="email" name="email" required autofocus autocomplete="username" placeholder="johndoe@gmail.com">
            <x-input-error :messages="$errors->get('form.email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label for="password" class="text-[10px] font-bold text-gray-400 pl-1">Password</label>
            <div class="relative">
                <input wire:model="form.password" id="password" class="w-full px-5 py-4 bg-[#262626] border-0 rounded-xl text-sm font-bold text-white placeholder:text-gray-500 focus:ring-2 focus:ring-white transition-all shadow-inner" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-1" />
        </div>

        <div class="flex items-center justify-between pt-1 px-1">
            <div class="flex items-center gap-2">
                <div class="relative flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox"
                           class="w-4 h-4 rounded bg-[#262626] border-0 text-white focus:ring-white cursor-pointer appearance-none checked:bg-emerald-500">
                    <svg class="w-3 h-3 text-white absolute left-0.5 pointer-events-none opacity-0 peer-checked:opacity-100" style="opacity: {{ $form->remember ? '1' : '0' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <label for="remember" class="text-[10px] font-bold text-gray-400 cursor-pointer select-none">Remember me</label>
            </div>
            <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-gray-400 hover:text-white transition-colors">Forgot password?</a>
        </div>

        <!-- Submit -->
        <div class="pt-4 flex flex-col items-center">
            <button type="submit"
                    class="w-40 py-3.5 bg-white hover:bg-gray-100 text-[#1A1A1A] font-black rounded-[2rem] shadow-lg active:scale-95 transition-all flex items-center justify-center text-sm">
                Sign In
            </button>
        </div>

        <div class="flex items-center gap-4 py-4 opacity-50">
            <div class="flex-1 h-px bg-gradient-to-r from-transparent to-gray-400"></div>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Or</span>
            <div class="flex-1 h-px bg-gradient-to-l from-transparent to-gray-400"></div>
        </div>

        <div class="flex flex-col items-center space-y-8">
            <a href="{{ route('google.login') }}" class="flex items-center justify-center gap-3 text-sm font-bold text-gray-300 hover:text-white transition-colors group">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Sign in with google
            </a>

            <p class="text-[11px] font-bold text-gray-400">
                Don't have an account? 
                <a href="{{ route('register') }}" wire:navigate class="text-white hover:underline transition-all">Sign up</a>
            </p>
        </div>
    </form>
</div>
