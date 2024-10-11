<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 100 ; $i++) { 
            DB::table('accounts')->insert([
                'account_number'    => fake()->unique()->bankAccountNumber,
                'account_name'      => fake()->name,
                'balance'           => fake()->randomFloat(2, 0, 10000), // Số dư từ 0 đến 10000
                'account_type'      => fake()->randomElement(['savings', 'checking', 'creadit']),
                'is_active'         => fake()->boolean,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}
