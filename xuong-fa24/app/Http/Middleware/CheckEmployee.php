<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('user')) {  
            $user = session('user');  
            // dd($user); // Kiểm tra xem người dùng có được lấy chính xác không  
            
            if ($user->role == 0 || $user->role == 1) {  
                return $next($request);  
            }else{
                session()->flash('message', 'Bạn cần là admin hoặc nhân viên để truy cập.'); 
                return redirect()->route('welecome'); 
            }
        }  
        
        // dd('Chuyển hướng đến login'); // Kiểm tra điểm này  
        return redirect()->route('login'); 
    }
}
