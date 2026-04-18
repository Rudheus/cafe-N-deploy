<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Demo Products if they don't exist
        $products = [
            ['name' => 'Kopi Susu Gula Aren', 'category' => 'Coffee', 'price' => 25000],
            ['name' => 'Americano Hot', 'category' => 'Coffee', 'price' => 18000],
            ['name' => 'Matcha Latte', 'category' => 'Non-Coffee', 'price' => 28000],
            ['name' => 'Croissant Almond', 'category' => 'Snack', 'price' => 22000],
            ['name' => 'Nasi Goreng Special', 'category' => 'Meal', 'price' => 35000],
            ['name' => 'Earl Grey Tea', 'category' => 'Tea', 'price' => 15000],
        ];

        $createdProducts = [];
        foreach ($products as $p) {
            $createdProducts[] = Product::updateOrCreate(['name' => $p['name']], $p);
        }

        // 1.5 Create Demo Ingredients
        $ingredients = [
            ['name' => 'Biji Kopi Arabika', 'unit' => 'Gram', 'stock_qty' => 5000, 'min_stock' => 500],
            ['name' => 'Susu Full Cream', 'unit' => 'Liter', 'stock_qty' => 20, 'min_stock' => 5],
            ['name' => 'Gula Aren Cair', 'unit' => 'ML', 'stock_qty' => 2000, 'min_stock' => 200],
        ];
        
        $ingModels = [];
        foreach ($ingredients as $ing) {
            $ingModels[] = Ingredient::updateOrCreate(['name' => $ing['name']], $ing);
        }

        // Link Kopi Susu Gula Aren to ingredients
        $kopiSusu = Product::where('name', 'Kopi Susu Gula Aren')->first();
        if ($kopiSusu) {
            $kopiSusu->ingredients()->sync([
                $ingModels[0]->id => ['qty_used' => 18], // 18g coffee
                $ingModels[1]->id => ['qty_used' => 0.15], // 150ml milk
                $ingModels[2]->id => ['qty_used' => 20], // 20ml sugar
            ]);
        }

        $cashier = User::where('role', 'pegawai')->first();
        if (!$cashier) return;

        // 2. Clear existing demo transactions to avoid duplication
        // Transaction::truncate(); // be careful with truncate if there are foreign keys

        // 3. Generate Transactions for the last 30 days
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays($i);
            
            // Random number of transactions per day (5 to 15)
            $numTransactions = rand(5, 15);
            
            for ($j = 0; $j < $numTransactions; $j++) {
                $transactionTime = $date->copy()->setHour(rand(8, 22))->setMinute(rand(0, 59));
                
                $transaction = Transaction::create([
                    'transaction_code' => 'TRX-' . strtoupper(Str::random(8)),
                    'cashier_id' => $cashier->id,
                    'total_amount' => 0, // calculated later
                    'payment_method' => collect(['cash', 'qris', 'transfer'])->random(),
                    'status' => 'completed',
                    'created_at' => $transactionTime,
                    'updated_at' => $transactionTime,
                ]);

                $totalAmount = 0;
                // Random items per transaction (1 to 4)
                $numItems = rand(1, 4);
                $selectedProducts = collect($createdProducts)->random($numItems);

                foreach ($selectedProducts as $prod) {
                    $qty = rand(1, 3);
                    $priceAtSale = $prod->price;
                    
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $prod->id,
                        'qty' => $qty,
                        'price_at_sale' => $priceAtSale,
                        'created_at' => $transactionTime,
                    ]);

                    $totalAmount += ($qty * $priceAtSale);
                }

                $transaction->update(['total_amount' => $totalAmount]);
            }
        }
    }
}
