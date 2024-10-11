<?php

namespace Database\Seeders;

use App\Models\Currencies;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 100 ; $i++) { 
            DB::table('currencies')->insert([
                'currency_code' => fake()->currency_code,
                'exchange_rate' => fake()->numberBetween(1.0000,4000)
            ]);
        }

        // $currencies = [
        //     ['currency_code' => 'USD', 'exchange_rate' => 1.0000],
        //     ['currency_code' => 'EUR', 'exchange_rate' => 0.8500],
        //     ['currency_code' => 'VND', 'exchange_rate' => 23000.0000],
        //     ['currency_code' => 'JPY', 'exchange_rate' => 110.0000],
        //     ['currency_code' => 'GBP', 'exchange_rate' => 0.7400],
        // ];

        // DB::table('currencies')->insert($currencies);
    }
}
