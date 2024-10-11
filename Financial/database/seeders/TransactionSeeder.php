<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for ($i=0; $i < 100 ; $i++) { 
        //     DB::table('transactions')->insert([
        //         'account_id'        => fake()->numberBetween(1, 99), // Giả định có 10 tài khoản trong bảng accounts
        //         'currencie_id'      => fake()->numberBetween(1, int2: 5), 
        //         'transaction_type'  => fake()->randomElement(['deposit', 'withdrawal', 'transfer']),
        //         'amount'            => fake()->randomFloat(2, 1, 1000), // Số tiền từ 1 đến 1000
        //         'currency'          => fake()->currencyCode, // Mã tiền tệ ngẫu nhiên
        //         'transaction_date'  => fake()->dateTimeThisYear,
        //         'description'       => fake()->sentence(10),
        //         'status'            => fake()->randomElement(['pending', 'completed', 'failed']),
        //         'created_at'        => now(),
        //         'updated_at'        => now(),
        //     ]);
        // }

        $startTime = microtime(true);

        $currencyCodes = DB::table('currencies')->pluck('currency_code')->all();
        $transitionType = ['deposit', 'withdrawal', 'transfer'];
        $statuses = ['pending', 'completed', 'failed'];
        $now = now();
        $description = fake()->text();

        for ($i = 1; $i < 1000; $i++) {
            $data[] = [
                'account_id'        => rand(1, 20),
                'currencie_id'      => rand(1, 5),
                'transaction_type'  => $transitionType[$i % 3],
                'amount'            => $i,
                'currency'          => $currencyCodes[$i % 3],
                'transaction_date'  => $now,
                'description'       => $description,
                'status'            => $statuses[$i % 3]
            ];

            if ($i % 500 == 0) {
                DB::table('transactions')->insert($data);

                $data = [];
            }

            echo 'THÊM MỚI BẢN GHI SỐ' . $i . PHP_EOL;
        }

        $endTime = microtime(true);

        echo 'TỔNG THỜI GIAN' . $endTime - $startTime;
    }
}
