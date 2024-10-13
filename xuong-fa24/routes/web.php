<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use App\Models\Comment;
use App\Models\Employee;
use App\Models\Phone;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
    // dd(session('user'));
    return view('welcome');
})->name('welecome');

Route::get('/18-check', function () {
    return view('18check');
})->middleware('checkAge');

Route::get('/sql-example', function () {

    $sql1 = DB::table('users', 'u')
        ->join('orders as o', 'o.user_id', '=', 'u.id')
        ->select([
            'u.name as u_name',
            DB::raw('SUM(o.amount) as total_spent')
        ])
        ->groupBy('u.name')
        ->having('total_spent', '>', 1000);

    $sql2 = DB::table('orders', 'o')
        ->select([
            DB::raw('DATE(order_date) as date'),
            DB::raw('COUNT(*) as orders-count'),
            DB::raw('SUM(total_amount) as total_sales')
        ])
        ->whereBetween('order_date', ['2024-01-01', '2024-09-39'])
        ->groupByRaw('DATE(order_date)');

    $sql3 = DB::table('products', 'p')
        ->select('product_name')
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('orders as o')
                ->whereColumb('o.priduct_id', 'p.id');
        });

    $subSql4 = DB::table('sales')
        ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
        ->groupBy('product_id');

    $sql4 = DB::table('products', 'p')
        ->joinSub($subSql4, 's', function ($join) {
            $join->on('p.id', '=', 's.product_id');
        })
        ->select([
            'p.product_name as p_name',
            's.total_sold'
        ])
        ->where('s.total_sold', '>', 100);

    $sql5 = DB::table('users', 'u')
        ->join('orders as o', 'o.user_id', '=', 'u.id')
        ->join('order_item as oi', 'o.id', '=', 'oi.order_id')
        ->join('products as p', 'oi.product_id', '=', 'p.id')
        ->select([
            'u.name as u_name',
            'p.product_name as p_name',
            'o.order_date'
        ])
        ->where('o.order_date', '>=', DB::raw('NOW() - INTERVAL 30 DAY'));

    $sql6 = DB::table('orders', 'o')
        ->join('order_item as oi', 'oi.order_id', '=', 'o.id')
        ->select([
            DB::raw('DATE_FORMAT(o.order_date, "%Y-%m") AS order_month'),
            DB::raw('SUM(oi.quantity * oi.price) AS total_revenue')
        ])
        ->where('o.status', '=', 'completed')
        ->groupBy('order_month')
        ->orderByDesc('order_month');

    $sql7 = DB::table('products', 'p')
        ->leftJoin('order_item as oi', 'p.id', '=', 'oi.product_id')
        ->select('p.product_name')
        ->whereNull('oi.product_id');

    $subSql8 = DB::table('order_items')
        ->select('product_id', DB::raw('SUM(quantity * price) as total'))
        ->groupBy('product_id');

    $sql8 = DB::table('products as p')
        ->joinSub($subSql8, 'oi', function ($join) {
            $join->on('p.id', '=', 'oi.product_id');
        })
        ->select('p.category_id', 'p.product_name', DB::raw('MAX(oi.total) as max_revenue'))
        ->groupBy('p.category_id', 'p.product_name')
        ->orderBy('max_revenue', 'desc');

    $subSql9 = DB::table('order_items')
        ->select(DB::raw('SUM(quantity * price) AS total'))
        ->groupBy('order_id');

    $sql9 = DB::table('orders')
        ->join('users', 'users.id', '=', 'orders.user_id')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->select('orders.id', 'users.name', DB::raw('SUM(order_items.quantity * order_items.price) AS total_value'))
        ->groupBy('orders.id', 'users.name', 'orders.order_date')
        ->havingRaw('total_value > (SELECT AVG(total) FROM (' . $subSql9->toSql() . ') AS avg_order_value)');

    $subSql10 = DB::table('order_items')
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->select('product_name', DB::raw('SUM(order_items.quantity) as total_sold'), 'products.category_id')
        ->groupBy('product_name', 'products.category_id');

    $sql10 = DB::table('products as p')
        ->join('order_items as oi', 'p.id', '=', 'oi.product_id')
        ->select('p.category_id', 'p.product_name', DB::raw('SUM(oi.quantity) as total_sold'))
        ->groupBy('p.category_id', 'p.product_name')
        ->havingRaw('SUM(oi.quantity) = (SELECT MAX(sub.total_sold) FROM (' . $subSql10->toSql() . ') as sub WHERE sub.category_id = p.category_id)');

    dd(
        $sql1->toRawSql(),
        $sql2->toRawSql(),
        $sql3->toRawSql(),
        $sql4->toRawSql(),
        $sql5->toRawSql(),
        $sql6->toRawSql(),
        $sql7->toRawSql(),
        $sql8->toRawSql(),
        $sql9->toRawSql(),
        $sql10->toRawSql(),
    );
});

Route::resource('customers', CustomerController::class);
Route::delete('customers/{customer}/forceDestroy', [CustomerController::class, 'forceDestroy'])
    ->name('customers.forceDestroy');

Route::resource('employees', EmployeeController::class)->middleware('checkAdmin');
Route::delete('employees/{employee}/forceDestroy', [EmployeeController::class, 'forceDestroy'])
    ->name('employees.forceDestroy');


// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('session', function () {
    session()->put('order', []);

    session()->put('order.101', [
        'name'  =>  'Product 1',
        'price' =>  1000000
    ]);

    session(['order.102' => [
        'name'  =>  'Product 2',
        'price' =>  1000000
    ]]);

    //Xoa sesssion
    // session()->forget('ahihi');

    // session()->invalidate();

    //Thong bao
    // session()->flash('news', 'That gud right now lil bro !');

    // echo session('news');

    return session()->all();
});

//Relationship
Route::get('/user-list', function () {
    $data = User::with('phone')->paginate(10);

    return view('user-list', compact('data'));
});

Route::get('/phones/{id}', function ($id) {
    $data = Phone::with(['user'])->find($id);

    dd($data);
});

Route::get('/posts/{id}', function ($id) {
    $data = Post::with(['comments'])->find($id);

    dd($data->toArray());
});

Route::get('/users/{id}/add-role', function ($id) {
    $roles = [1, 5, 6, 8];

    $data = User::find($id);

    $data->roles()->attach($roles);

    dd($data->load(['roles'])->toArray());
});

Route::get('/users/{id}/remove-role', function ($id) {
    $rolesRemove = [5, 6];

    $data = User::find($id);

    $data->roles()->detach($rolesRemove);

    dd($data->load(['roles'])->toArray());
});

Route::get('/users/{id}/sync-role', function ($id) {
    $rolesRemove = [3, 6, 9, 10];

    $data = User::find($id);

    $data->roles()->sync($rolesRemove);

    dd($data->load(['roles'])->toArray());
});

Route::resource('students', StudentController::class);

Route::get('students/{student}/addPassport', [StudentController::class, 'addPassport'])
    ->name('students.addPassport');
Route::post('students/storePassport', [StudentController::class, 'storePassport'])
    ->name('students.storePassport');

Route::get('students/{student}/addSubjects', [StudentController::class, 'addSubjects'])
    ->name('students.addSubjects');
Route::post('students/{student}/storeSubjects', [StudentController::class, 'storeSubjects'])
    ->name('students.storeSubjects');
Route::get('students/{student}/unsubmitSubjects', [StudentController::class, 'unsubmitSubjects'])
    ->name('students.unsubmitSubjects');
Route::post('students/{student}/confirmUnsubmitSubjects', [StudentController::class, 'confirmUnsubmitSubjects'])
    ->name('students.confirmUnsubmitSubjects');


Route::get('/login', function () {
    return view('login.login');
})->name('login');

Route::post('/loginConfirm', [LoginController::class, 'login'])->name('loginConfirm');

Route::get('/register', function () {
    return view('login.register');
})->name('register');

Route::post('/registerConfirm', [LoginController::class, 'register'])->name('registerConfirm');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Hiển thị form yêu cầu nhập email
Route::get('/forgot-password', function () {
    return view('login.forgot');
})->middleware('guest')->name('password.forgot');

// Xử lý yêu cầu đặt lại mật khẩu (gửi email chứa link đổi mật khẩu)
Route::post('/forgot-password', [LoginController::class, 'sendMail'])->middleware('guest')->name('password.email');

// Hiển thị form nhập mật khẩu mới
Route::get('/reset-password/{token}', function ($token) {
    return view('login.resetpass', ['token' => $token, 'email' => request('email')]);
})->middleware('guest')->name('password.reset');

// Xử lý việc đặt lại mật khẩu sau khi người dùng nhập mật khẩu mới
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->middleware('guest')->name('password.update');
