<x-owner-layout>
    <div class="space-y-8">
        
        <!-- Top Metrics Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Revenue Card (Primary Dark) -->
            <div class="bg-[#1A1A1A] rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden group">
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-[#E97D5A]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Pendapatan <br>Hari Ini</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-white tracking-tighter mb-2">Rp 0</p>
                        <span class="inline-flex items-center px-2 py-1 bg-emerald-500/20 text-emerald-400 rounded-lg text-[10px] font-black tracking-wider">
                            +0% vs kemarin
                        </span>
                    </div>
                </div>
                <!-- Background decoration -->
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-[#E97D5A] opacity-10 rounded-full blur-3xl group-hover:opacity-20 transition-opacity"></div>
            </div>

            <!-- Transaction Card -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-[#E97D5A]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Total <br>Transaksi</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-slate-800 tracking-tighter mb-2">0</p>
                    <span class="inline-flex items-center px-2 py-1 bg-emerald-50 text-emerald-500 rounded-lg text-[10px] font-black tracking-wider">
                        0 dari kemarin
                    </span>
                </div>
            </div>

            <!-- Attendance Card -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Pegawai <br>Hadir</p>
                </div>
                <div>
                    <div class="flex items-end gap-1 mb-2">
                        <p class="text-3xl font-black text-slate-800 tracking-tighter">0</p>
                        <p class="text-lg font-bold text-slate-400 mb-0.5">/5</p>
                    </div>
                    <span class="text-[10px] font-bold text-slate-400">Semua belum check-in</span>
                </div>
            </div>

            <!-- Low Stock Card -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Stok <br>Menipis</p>
                </div>
                <div>
                    <p class="text-3xl font-black text-rose-600 tracking-tighter mb-2">0</p>
                    <span class="inline-flex items-center px-2 py-1 bg-rose-50 text-rose-500 rounded-lg text-[10px] font-black tracking-wider uppercase">
                        Aman
                    </span>
                </div>
            </div>
        </div>

        <!-- Middle Row: Charts & Top Selling -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Chart Panel -->
            <div class="lg:col-span-8 bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-xl font-extrabold text-slate-800 tracking-tight">Pendapatan 7 hari terakhir</h3>
                    <a href="#" class="text-xs font-black text-[#E97D5A] uppercase tracking-widest hover:underline">Lihat laporan</a>
                </div>
                <!-- Visual Chart Simulation -->
                <div class="flex items-end justify-between h-48 px-2 gap-4">
                    @php $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']; $heights = [45, 60, 80, 50, 70, 90, 40]; @endphp
                    @foreach($days as $idx => $day)
                    <div class="flex-1 flex flex-col items-center gap-4">
                        <div class="w-full bg-slate-100 rounded-full relative group h-full overflow-hidden">
                            <div class="absolute bottom-0 left-0 w-full bg-[#E97D5A]/20 transition-all duration-1000" style="height: {{ $heights[$idx] }}%"></div>
                            <div class="absolute bottom-0 left-0 w-full bg-[#E97D5A] opacity-0 group-hover:opacity-100 transition-all cursor-pointer" style="height: {{ $heights[$idx]-10 }}%"></div>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">{{ $day }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="mt-10 flex gap-6">
                    <div class="flex items-center gap-2">
                         <span class="w-3 h-3 bg-[#E97D5A] rounded-full"></span>
                         <span class="text-[10px] font-black text-slate-600 uppercase">Minggu ini</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-300">
                         <span class="w-3 h-3 bg-slate-100 rounded-full border border-slate-200"></span>
                         <span class="text-[10px] font-black text-slate-400 uppercase">Minggu lalu</span>
                    </div>
                </div>
            </div>

            <!-- Top Selling Panel -->
            <div class="lg:col-span-4 bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-xl font-extrabold text-slate-800 tracking-tight leading-tight">Menu terlaris hari ini</h3>
                    <a href="{{ route('owner.inventory.products') }}" class="text-xs font-black text-[#E97D5A] uppercase tracking-widest text-right hover:underline">Semua menu</a>
                </div>
                <div class="space-y-6">
                    @php $top = [['n'=>'Kopi Susu', 'cnt'=>18, 'c'=>'bg-orange-400'], ['n'=>'Matcha Latte', 'cnt'=>12, 'c'=>'bg-rose-400'], ['n'=>'Americano', 'cnt'=>9, 'c'=>'bg-amber-400'], ['n'=>'Croissant', 'cnt'=>7, 'c'=>'bg-emerald-400']]; @endphp
                    @foreach($top as $item)
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <span class="w-2 h-2 {{ $item['c'] }} rounded-full"></span>
                                <span class="text-xs font-black text-slate-600 uppercase tracking-tight">{{ $item['n'] }}</span>
                            </div>
                            <span class="text-[10px] font-black text-slate-400">{{ $item['cnt'] }}x</span>
                        </div>
                        <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden">
                            <div class="{{ $item['c'] }} h-full rounded-full" style="width: {{ ($item['cnt']/20)*100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Bottom Row: Stock, Presence, Shortcuts -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Ingredient Status -->
            <div class="lg:col-span-4 bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-extrabold text-slate-800 tracking-tight">Status stok bahan</h3>
                    <a href="{{ route('owner.inventory.ingredients') }}" class="text-xs font-black text-[#E97D5A] uppercase tracking-widest hover:underline">Kelola stok</a>
                </div>
                <div class="space-y-4">
                    @php $ing = [['n'=>'Susu segar', 's'=>'Habis', 'q'=>'0 L', 'c'=>'text-rose-600 bg-rose-50'], ['n'=>'Biji kopi', 's'=>'Menipis', 'q'=>'0.5 kg', 'c'=>'text-amber-600 bg-amber-50'], ['n'=>'Matcha powder', 's'=>'Menipis', 'q'=>'1 kg', 'c'=>'text-amber-600 bg-amber-50'], ['n'=>'Gula pasir', 's'=>'Aman', 'q'=>'5 kg', 'c'=>'text-emerald-600 bg-emerald-50']]; @endphp
                    @foreach($ing as $i)
                    <div class="flex items-center justify-between py-2 border-b border-slate-50 last:border-0 border-dashed">
                        <div>
                             <p class="text-xs font-black text-slate-700 uppercase tracking-tighter">{{ $i['n'] }}</p>
                             <p class="text-[10px] font-bold text-slate-400">{{ $i['q'] }}</p>
                        </div>
                        <span class="px-2 py-1 {{ $i['c'] }} rounded-lg text-[9px] font-black uppercase tracking-wider">{{ $i['s'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Presence History -->
            <div class="lg:col-span-4 bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-extrabold text-slate-800 tracking-tight">Presensi hari ini</h3>
                    <a href="{{ route('owner.attendance') }}" class="text-xs font-black text-[#E97D5A] uppercase tracking-widest hover:underline">Semua</a>
                </div>
                <div class="space-y-4">
                    @php $staff = [['n'=>'Andi R.', 't'=>'08:00', 's'=>'On time', 'c'=>'text-emerald-500 bg-emerald-50'], ['n'=>'Siti I.', 't'=>'08:03', 's'=>'On time', 'c'=>'text-emerald-500 bg-emerald-50'], ['n'=>'Budi J.', 't'=>'08:21', 's'=>'Terlambat', 'c'=>'text-rose-500 bg-rose-50']]; @endphp
                    @foreach($staff as $s)
                    <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-[#E97D5A]/10 text-[#E97D5A] flex items-center justify-center text-[10px] font-black uppercase">
                                {{ substr($s['n'], 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-700 leading-none mb-1">{{ $s['n'] }}</p>
                                <p class="text-[10px] font-bold text-slate-400 tracking-tight">{{ $s['t'] }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 {{ $s['c'] }} rounded-lg text-[9px] font-black uppercase tracking-wider leading-none">{{ $s['s'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="lg:col-span-4 bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100">
                <h3 class="text-xl font-extrabold text-slate-800 tracking-tight mb-8">Aksi cepat</h3>
                <div class="grid grid-cols-1 gap-4">
                    @php
                        $acts = [
                            ['l' => 'Tambah stok', 's' => 'Catat barang masuk', 'i' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10', 'href' => route('owner.inventory.ingredients')],
                            ['l' => 'Tambah menu', 's' => 'Produk baru', 'i' => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z', 'href' => route('owner.inventory.products')],
                        ];
                    @endphp
                    @foreach($acts as $a)
                    <a href="{{ $a['href'] }}" class="flex items-center justify-between p-4 bg-white border border-slate-100 rounded-3xl group hover:border-[#E97D5A] hover:bg-orange-50/20 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-50 rounded-2xl border border-slate-100 flex items-center justify-center text-[#E97D5A] group-hover:bg-[#E97D5A] group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="{{ $a['i'] }}"></path></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-black text-slate-800 leading-tight">{{ $a['l'] }}</p>
                                <p class="text-[10px] font-bold text-slate-400 leading-tight uppercase tracking-widest mt-0.5">{{ $a['s'] }}</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-[#E97D5A] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    @endforeach
                    <a href="#" class="flex items-center justify-between p-4 bg-[#1A1A1A] rounded-3xl group shadow-xl hover:scale-[1.02] transition-all">
                        <div class="flex items-center gap-4 text-left">
                            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-[#E97D5A]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-black text-white leading-tight">Export laporan</p>
                                <p class="text-[10px] font-bold text-gray-500 lowercase mt-0.5">PDF / Excel</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-owner-layout>
