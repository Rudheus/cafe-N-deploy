<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingredient extends Model
{
    protected $fillable = [
        'supplier_id', 'name', 'unit',
        'stock_qty', 'min_stock', 'cost_per_unit'
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock_qty <= 0) return 'Habis';
        if ($this->stock_qty <= $this->min_stock) return 'Menipis';
        return 'Aman';
    }

    public function logs()
    {
        return $this->hasMany(StockLog::class);
    }
}
