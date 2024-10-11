<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function create(Request $request){
        // Validate dữ liệu  
        $request->validate([  
            'receiver_account' => 'required|numeric',  
            'amount' => 'required|numeric|min:1|max:99999999999999999.99',  
        ]);  

        // Tạo transaction_id  
        $date = now()->format('dmy'); // Lấy ngày tháng theo định dạng ddmmyy  
        $randomNumber = rand(100000, 999999); // Tạo số ngẫu nhiên 6 chữ số  
        $timeSuffix = now()->format('A'); // Lấy AM hoặc PM  

        // Tạo transaction_id theo định dạng yêu cầu  
        $transactionId = 'TS' . $date . $randomNumber . $timeSuffix;  

        // dd($transactionId);

        // Lưu thông tin vào session  
        $request->session()->put('transaction', [  
            'transaction_id' => $transactionId, 
            'receiver_account' => $request->receiver_account,  
            'amount' => $request->amount,  
            'status' => 'pending',  
        ]);  

        // Redirect với thông báo thành công  
        return redirect()->route('transaction.confirm')->with('success', 'Transaction created successfully!'); 
    }

    public function store(){
        try {
            session()->put('transaction.status', 'confirmed');

            DB::table('transactions')->insert([
                'transaction_id' => session('transaction.transaction_id'),
                'receiver_account' => session('transaction.receiver_account'),
                'amount' => session('transaction.amount'),
                'status' => 'Success'
            ]);

            session()->forget('transaction');

            return redirect()->route('transaction.index')->with('success', 'Transaction successfully!'); 
        } catch (\Throwable $th) {
            echo $th->getMessage();
            // die;
            return redirect()->route('transaction.confirm')
                ->with('failed', 'Transaction failed!'); 
        }
        
    }

    public function delete_headback(){
        try {
            session()->forget('transaction');

            return redirect()->route('transaction.index')->with('success', 'Transaction Deleted successfully!'); 
        } catch (\Throwable $th) {
            return redirect()->route('transaction.confirm')->with('failed', 'Transaction Deleted failed!'); 
        }
        
    }
}
