<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Northern Cafe') }} — Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Outfit', sans-serif; }
        </style>
    </head>
    <body class="antialiased overflow-hidden">
        <div class="flex min-h-screen">

            <!-- Left Panel: Dark Sidebar Style -->
            <div class="hidden lg:flex lg:w-5/12 bg-[#111111] flex-col justify-between p-16 relative overflow-hidden">

                <!-- Decorative Circles -->
                <div class="absolute -top-32 -left-32 w-96 h-96 bg-[#E97D5A] opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-32 -right-16 w-80 h-80 bg-[#E97D5A] opacity-5 rounded-full blur-3xl"></div>

                <!-- Logo -->
                <div class="relative z-10 flex items-center gap-3">
                    <div class="w-12 h-12 bg-[#E97D5A] rounded-2xl flex items-center justify-center shadow-lg shadow-orange-900/50">
                        <svg class="text-white w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </div>
                    <span class="text-3xl font-extrabold text-white tracking-tighter">Northern<span class="text-[#E97D5A]">.</span></span>
                </div>

                <!-- Main Copy -->
                <div class="relative z-10 space-y-6">
                    <div class="inline-flex items-center px-3 py-1.5 bg-[#E97D5A]/10 border border-[#E97D5A]/20 rounded-xl">
                        <span class="text-[#E97D5A] text-xs font-black uppercase tracking-widest">Cafe Management System</span>
                    </div>
                    <h1 class="text-5xl font-black text-white leading-tight tracking-tighter">
                        Kelola Cafe <br>
                        <span class="text-[#E97D5A]">Lebih Efisien.</span>
                    </h1>
                    <p class="text-gray-400 font-medium text-lg leading-relaxed max-w-xs">
                        Satu platform untuk mengelola stok, penjualan, pegawai, dan laporan bisnis cafe Anda.
                    </p>
                </div>

                <!-- Stats Row -->
                <div class="relative z-10 flex gap-8">
                    <div>
                        <p class="text-3xl font-black text-white">100%</p>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1">Data Aman</p>
                    </div>
                    <div class="w-px bg-gray-800"></div>
                    <div>
                        <p class="text-3xl font-black text-white">Real-time</p>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1">Monitoring</p>
                    </div>
                    <div class="w-px bg-gray-800"></div>
                    <div>
                        <p class="text-3xl font-black text-white">RBAC</p>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1">Role Based</p>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Login Form -->
            <div class="w-full lg:w-7/12 bg-[#F8F9FB] flex items-center justify-center px-8 sm:px-16 lg:px-24 relative">

                <!-- Mobile Logo -->
                <div class="absolute top-8 left-8 lg:hidden flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#E97D5A] rounded-xl flex items-center justify-center">
                        <svg class="text-white w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </div>
                    <span class="text-xl font-extrabold text-slate-900 tracking-tighter">Northern<span class="text-[#E97D5A]">.</span></span>
                </div>

                <!-- Background Orbs -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-[#E97D5A] opacity-[0.04] rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-500 opacity-[0.04] rounded-full blur-3xl -ml-20 -mb-20"></div>

                <div class="w-full max-w-md relative z-10">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <p class="absolute bottom-8 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                    © {{ date('Y') }} Northern Cafe System
                </p>
            </div>

        </div>
    </body>
</html>
