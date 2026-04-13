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

<div class="space-y-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-[#E97D5A]/10 border border-[#E97D5A]/20 rounded-xl mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-[#E97D5A]"></span>
            <span class="text-[#E97D5A] text-[10px] font-black uppercase tracking-widest">Sistem Manajemen Cafe</span>
        </div>
        <h2 class="text-4xl font-black text-slate-900 tracking-tighter leading-none mb-3">Selamat Datang</h2>
        <p class="text-slate-400 font-bold">Masuk untuk mengelola operasional Northern Cafe.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Email -->
        <div class="space-y-2">
            <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email</label>
            <input wire:model="form.email" id="email" type="email" name="email"
                   class="block w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl text-slate-900 font-bold placeholder:text-slate-300 focus:ring-2 focus:ring-[#E97D5A] focus:border-transparent transition-all shadow-sm"
                   placeholder="nama@cafe.com" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-1 ml-1" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-black text-[#E97D5A] hover:text-orange-600 uppercase tracking-widest transition-colors"
                       href="{{ route('password.request') }}" wire:navigate>
                        Lupa Password?
                    </a>
                @endif
            </div>
            <input wire:model="form.password" id="password" type="password" name="password"
                   class="block w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl text-slate-900 font-bold placeholder:text-slate-300 focus:ring-2 focus:ring-[#E97D5A] focus:border-transparent transition-all shadow-sm"
                   placeholder="••••••••" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-1 ml-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center gap-3 py-2">
            <input wire:model="form.remember" id="remember" type="checkbox"
                   class="w-5 h-5 rounded-lg border-slate-200 text-[#E97D5A] shadow-sm focus:ring-[#E97D5A] cursor-pointer">
            <label for="remember" class="text-sm font-bold text-slate-500 cursor-pointer select-none">Biarkan saya tetap masuk</label>
        </div>

        <!-- Submit -->
        <div class="pt-2">
            <button type="submit"
                    class="w-full py-4 px-6 bg-[#111111] hover:bg-[#1a1a1a] text-white font-black rounded-2xl shadow-xl active:scale-[0.98] transition-all flex items-center justify-center gap-3 text-base group">
                <span>Masuk ke Sistem</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </button>
        </div>

        <!-- Divider & Role Description -->
        <div class="pt-4 border-t border-slate-100">
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-sm">
                    <div class="w-8 h-8 bg-[#E97D5A]/10 rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-4 h-4 text-[#E97D5A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <p class="text-xs font-black text-slate-800 leading-none mb-1">Owner</p>
                    <p class="text-[10px] font-bold text-slate-400 leading-tight">Akses penuh ke semua fitur.</p>
                </div>
                <div class="p-4 bg-white rounded-2xl border border-slate-100 shadow-sm">
                    <div class="w-8 h-8 bg-indigo-50 rounded-xl flex items-center justify-center mb-3">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <p class="text-xs font-black text-slate-800 leading-none mb-1">Pegawai</p>
                    <p class="text-[10px] font-bold text-slate-400 leading-tight">Kasir & absensi saja.</p>
                </div>
            </div>
        </div>
    </form>
</div>
