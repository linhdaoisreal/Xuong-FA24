<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Email không được trùng lặp
            'password' => 'required|string|min:8|confirmed', // Yêu cầu xác nhận mật khẩu
        ]);

        try {
            User::create($data);

            return back()
                ->with('success', true);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        try {
            // Tìm người dùng với email đã nhập
            $user = User::where('email', $data['email'])->first();

            // Kiểm tra người dùng và mật khẩu có chính xác không
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return back()->withErrors([
                    'email' => 'Email hoặc mật khẩu không chính xác',
                ])->onlyInput('email'); // Chỉ giữ lại giá trị email trong form khi redirect
            }
            // Lưu thông tin người dùng vào session
            session(['user' => $user]);

            // Chuyển hướng đến trang dashboard
            return redirect()->route('welecome')->with('success', 'Đăng nhập thành công!');
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    public function logout()
    {
        // Xóa thông tin người dùng khỏi session
        session()->forget('user');

        session()->invalidate();
        session()->regenerateToken();

        // Chuyển hướng về trang đăng nhập
        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }

    public function sendMail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Gửi link đặt lại mật khẩu qua email
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status)); // Trở lại với thông báo rằng email đã được gửi  
        } else {
            return back()->withErrors(['email' => __($status)]); // Thông báo lỗi  
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([  
            'token' => 'required',  
            'email' => 'required|email',  
            'password' => 'required|string|min:8|confirmed',  
        ]);  
    
        try {  
            // Đặt lại mật khẩu  
            // \Log::info('Attempting to reset password for email: ' . $request->email);  
            
            $status = Password::reset(  
                $request->only('email', 'password', 'password_confirmation', 'token'),  
                function ($user, $password) {  
                    $user->forceFill([  
                        'password' => Hash::make($password)  
                    ])->save();  
                }  
            );  
    
            // \Log::info('Password reset status: ' . $status);  
    
            // Nếu đặt lại mật khẩu thành công  
                return redirect()->route('login')  
                    ->with('success', true)  
                    ->with('status', 'Mật khẩu đã được thay đổi thành công!');  
 
        } catch (\Throwable $th) {  
            // \Log::error('Error resetting password: ' . $th->getMessage());  
    
            return back()  
                ->with('success', false)  
                ->with('error', $th->getMessage());  
        } 
    }
}
