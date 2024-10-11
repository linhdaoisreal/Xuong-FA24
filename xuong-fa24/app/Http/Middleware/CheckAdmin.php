<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {  
            $user = Auth::user();  
            // dd($user); // Kiểm tra xem người dùng có được lấy chính xác không  
            
            if ($user->role == 0) {  
                return $next($request);  
            }else{
                session()->flash('message', 'Bạn cần là admin để truy cập.'); 
                return redirect()->route('welecome'); 
            }
        }  
        
        // dd('Chuyển hướng đến login'); // Kiểm tra điểm này  
        return redirect()->route('login'); 
    }
}
