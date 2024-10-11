<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testing', function () {
    $sql1 = DB::table('sales')
        ->selectRaw('SUM(total) as total_sales')
        ->selectRaw('MONTH(sale_date) as month')
        ->selectRaw('YEAR(sale_date) as year')
        ->groupByRaw('MONTH(sale_date), YEAR(sale_date)')
        ->get();

    $sql2 = DB::table('expenses')
        ->selectRaw('SUM(amount) as total_expenses')
        ->selectRaw('MONTH(expense_date) as month')
        ->selectRaw('YEAR(expense_date) as year')
        ->groupByRaw('MONTH(expense_date), YEAR(expense_date)')
        ->get();

    $sql3 = DB::table('financal_reports')->insert([
        'month' => 9,
        'year' => 2024,
        'total_sales' => DB::table('sales')
            ->whereRaw('MONTH(sale_date) = 9')
            ->whereRaw('YEAR(sale_date) = 2024')
            ->sum('total'),
        'total_expenses' => DB::table('expenses')
            ->whereRaw('MONTH(expense_date) = 9')
            ->whereRaw('YEAR(expense_date) = 2024')
            ->sum('amount'),
        'profit_before_tax' => DB::raw('total_sales - total_expenses'),
        'tax_amount' => DB::raw('total_sales * (SELECT rate FROM taxes WHERE tax_name = "VAT")'),
        'profit_after_tax' => DB::raw('profit_before_tax - tax_amount'),
    ]);

    dd($sql1, $sql2);

});
