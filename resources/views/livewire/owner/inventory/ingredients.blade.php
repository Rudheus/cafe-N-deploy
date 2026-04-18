<?php

use App\Models\Ingredient;
use App\Models\Supplier;
use function Livewire\Volt\{state, layout, rules, computed};

layout('layouts.owner');

state([
    'search' => '',
    'name' => '',
    'unit' => 'Kg',
    'stock_qty' => 0,
    'min_stock' => 0,
    'cost_per_unit' => 0,
    'supplier_id' => '',
    'editingIngredientId' => null,
    'showForm' => false,
    'change_reason' => 'Update Stok Manual', // Added reason
]);

rules([
    'name' => 'required|min:2',
    'unit' => 'required',
    'stock_qty' => 'required|numeric|min:0',
    'min_stock' => 'required|numeric|min:0',
    'cost_per_unit' => 'required|numeric|min:0',
    'supplier_id' => 'nullable|exists:suppliers,id',
]);

$ingredients = computed(fn () =>
    Ingredient::with('supplier')
        ->where('name', 'like', '%' . $this->search . '%')
        ->latest()
        ->get()
);

$suppliers = computed(fn () => Supplier::orderBy('name')->get());

$save = function () {
    $this->validate();

    $data = [
        'name' => $this->name,
        'unit' => $this->unit,
        'stock_qty' => $this->stock_qty,
        'min_stock' => $this->min_stock,
        'cost_per_unit' => $this->cost_per_unit,
        'supplier_id' => $this->supplier_id ?: null,
    ];

    if ($this->editingIngredientId) {
        $ingredient = Ingredient::find($this->editingIngredientId);
        $oldStock = $ingredient->stock_qty;
        $ingredient->update($data);

        // Log if stock changed
        if ($oldStock != $this->stock_qty) {
            App\Models\StockLog::create([
                'ingredient_id' => $ingredient->id,
                'type' => $this->stock_qty > $oldStock ? 'in' : 'out',
                'qty' => abs($this->stock_qty - $oldStock),
                'recorded_by' => auth()->id(),
                'reason' => $this->change_reason,
            ]);
        }
    } else {
        $ingredient = Ingredient::create($data);
        // Log initial stock
        if ($this->stock_qty > 0) {
            App\Models\StockLog::create([
                'ingredient_id' => $ingredient->id,
                'type' => 'in',
                'qty' => $this->stock_qty,
                'recorded_by' => auth()->id(),
                'reason' => 'Stok Awal / Input Baru',
            ]);
        }
    }

    $this->reset('name', 'unit', 'stock_qty', 'min_stock', 'cost_per_unit', 'supplier_id', 'editingIngredientId', 'showForm', 'change_reason');
    $this->unit = 'Kg';
    $this->change_reason = 'Update Stok Manual';
};

$edit = function ($id) {
    $i = Ingredient::find($id);
    $this->editingIngredientId = $id;
    $this->name = $i->name;
    $this->unit = $i->unit;
    $this->stock_qty = $i->stock_qty;
    $this->min_stock = $i->min_stock;
    $this->cost_per_unit = $i->cost_per_unit;
    $this->supplier_id = $i->supplier_id;
    $this->showForm = true;
};

$delete = function ($id) {
    Ingredient::find($id)->delete();
};

$cancel = function () {
    $this->reset('name', 'unit', 'stock_qty', 'min_stock', 'cost_per_unit', 'supplier_id', 'editingIngredientId', 'showForm');
    $this->unit = 'Kg';
};

?>

<div class="space-y-8 pb-20">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tighter">Bahan Baku</h1>
            <p class="text-slate-400 font-bold mt-1 uppercase text-[10px] tracking-[0.2em]">Inventori / Bahan Baku</p>
        </div>
        <button wire:click="$toggle('showForm')"
                class="px-6 py-3 bg-[#E97D5A] text-white rounded-2xl font-black text-sm shadow-lg shadow-orange-100/50 hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            {{ $showForm ? 'Tutup Form' : 'Tambah Bahan Baku' }}
        </button>
    </div>

    @if($showForm)
    <!-- Form Panel -->
    <div class="bg-white rounded-[2.5rem] p-10 shadow-xl border border-orange-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 opacity-5 p-10">
            <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path><path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
        </div>

        <h2 class="text-2xl font-black text-slate-800 mb-8 relative z-10">
            {{ $editingIngredientId ? 'Ubah Data Bahan Baku' : 'Tambah Bahan Baku Baru' }}
        </h2>

        <form wire:submit="save" class="relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Nama -->
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Bahan</label>
                    <input wire:model="name" type="text" placeholder="Contoh: Biji Kopi Arabika"
                           class="w-full px-6 py-4 bg-slate-50 border-0 rounded-2xl text-slate-800 font-bold focus:ring-2 focus:ring-[#E97D5A] transition-all">
                    @error('name') <span class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Satuan -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Satuan</label>
                    <select wire:model="unit"
                            class="w-full px-6 py-4 bg-slate-50 border-0 rounded-2xl text-slate-800 font-bold focus:ring-2 focus:ring-[#E97D5A] transition-all appearance-none">
                        @foreach(['Kg', 'Gram', 'Liter', 'Ml', 'Pcs', 'Pak', 'Botol', 'Karton'] as $u)
                            <option value="{{ $u }}">{{ $u }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Stok -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Stok Saat Ini</label>
                    <input wire:model="stock_qty" type="number" step="0.01" min="0" placeholder="0"
                           class="w-full px-6 py-4 bg-slate-50 border-0 rounded-2xl text-slate-800 font-bold focus:ring-2 focus:ring-[#E97D5A] transition-all">
                    @error('stock_qty') <span class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Min Stok -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Stok Minimum (Alert)</label>
                    <input wire:model="min_stock" type="number" step="0.01" min="0" placeholder="0"
                           class="w-full px-6 py-4 bg-slate-50 border-0 rounded-2xl text-slate-800 font-bold focus:ring-2 focus:ring-[#E97D5A] transition-all">
                    @error('min_stock') <span class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Harga / unit -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Harga per Satuan (Rp)</label>
                    <input wire:model="cost_per_unit" type="number" step="100" min="0" placeholder="0"
                           class="w-full px-6 py-4 bg-slate-50 border-0 rounded-2xl text-slate-800 font-bold focus:ring-2 focus:ring-[#E97D5A] transition-all">
                    @error('cost_per_unit') <span class="text-rose-500 text-xs font-bold mt-1 ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Supplier -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Supplier (Opsional)</label>
                    <select wire:model="supplier_id"
                            class="w-full px-6 py-4 bg-slate-50 border-0 rounded-2xl text-slate-800 font-bold focus:ring-2 focus:ring-[#E97D5A] transition-all appearance-none">
                        <option value="">— Pilih Supplier —</option>
                        @foreach($this->suppliers as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Reason for update -->
                <div class="md:col-span-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alasan Perubahan Stok (Opsional)</label>
                    <input wire:model="change_reason" type="text" placeholder="Contoh: Barang Masuk (Restock), Rusak, dll"
                           class="w-full px-6 py-4 bg-slate-50 border-0 rounded-2xl text-slate-800 font-bold focus:ring-2 focus:ring-[#E97D5A] transition-all">
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-slate-50">
                <button type="button" wire:click="cancel" class="px-8 py-4 bg-slate-100 text-slate-500 rounded-2xl font-black text-sm hover:bg-slate-200 transition-all">Batal</button>
                <button type="submit" class="px-8 py-4 bg-[#1A1A1A] text-white rounded-2xl font-black text-sm shadow-xl hover:scale-105 active:scale-95 transition-all">
                    {{ $editingIngredientId ? 'Perbarui Bahan' : 'Simpan Bahan' }}
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-xl font-black text-slate-800 tracking-tight">Daftar Bahan Baku</h3>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input wire:model.live="search" type="text" placeholder="Cari nama bahan..."
                       class="pl-12 pr-6 py-3 bg-slate-50 border-0 rounded-2xl w-full md:w-72 text-sm font-bold placeholder:text-slate-300 focus:ring-2 focus:ring-[#E97D5A] transition-all">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Bahan</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Stok</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Min. Stok</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Harga/Unit</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Supplier</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($this->ingredients as $i)
                    @php
                        $status = $i->stock_status;
                        $statusStyle = match($status) {
                            'Habis'   => 'text-rose-600 bg-rose-50',
                            'Menipis' => 'text-amber-600 bg-amber-50',
                            default   => 'text-emerald-600 bg-emerald-50',
                        };
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 bg-[#111111] rounded-2xl flex items-center justify-center text-white font-black text-sm group-hover:bg-[#E97D5A] transition-colors">
                                    {{ substr($i->name, 0, 1) }}
                                </div>
                                <span class="font-black text-slate-700">{{ $i->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="font-black text-slate-800 tabular-nums">{{ number_format($i->stock_qty, 2) }}</span>
                            <span class="ml-1 text-[10px] font-bold text-slate-400 uppercase">{{ $i->unit }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="font-bold text-slate-500 tabular-nums">{{ number_format($i->min_stock, 2) }} {{ $i->unit }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="font-bold text-slate-600 tabular-nums">Rp {{ number_format($i->cost_per_unit, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-8 py-6">
                            @if($i->supplier)
                                <span class="text-sm font-bold text-slate-500">{{ $i->supplier->name }}</span>
                            @else
                                <span class="text-sm font-bold text-slate-300 italic">—</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1.5 {{ $statusStyle }} rounded-xl text-[10px] font-black uppercase tracking-wider">{{ $status }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="edit({{ $i->id }})" class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button wire:confirm="Hapus bahan baku ini?" wire:click="delete({{ $i->id }})" class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4 border border-slate-100">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path></svg>
                                </div>
                                <p class="text-slate-400 font-bold italic mb-4">Belum ada bahan baku tercatat.</p>
                                <button wire:click="$set('showForm', true)" class="text-sm font-black text-[#E97D5A] uppercase tracking-widest border-b-2 border-orange-100 hover:border-orange-400 transition-colors">Klik untuk tambah</button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
