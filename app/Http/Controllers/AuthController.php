<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{

    public function loginPage(){
        
        return view('auth.login');
    }
    public function registerPage(){
        
        return view('auth.register');
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request['user_name'], 'password' => $request['password']])) {
            $user = User::where('email', $request['user_name'])->first();
            Auth::login($user);
            return redirect()->route('dashboard');

  
        } 
            elseif(Auth::attempt(['user_name' => $request['user_name'], 'password' => $request['password']])){
                $user = User::where('user_name', $request['user_name'])->first();
                Auth::login($user);
                return redirect()->route('dashboard');

            }
        else {
            return back()->withErrors([
                'loginError' =>  'Email or password is incorrect',
            ]);
        }
             
        } 

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login-page');
    }
    public function register(Request $request){
        $request->validate([
            'name'              => "required",
            'user_name'         => "required|unique:users",
            'password'          => "required",
        ],[
            'name.required'         => "الحقل مطلوب",
            'user_name.required'         => "الحقل مطلوب",
            'user_name.unique'         => "تم حجز اسم المستخدم مسبقا",
            'password.required'         => "الحقل مطلوب",
        ]);
        // if($request->image){
            
        //     $file = uploadImage($request , "users" , "image");
        // }        
        // $user_name = Str::slug($request->name.rand(100 , 635635) , '-');
        $user = User::create([
            'name' => $request->name,
            'user_name' =>  $request->user_name,
            'role_name' => 'user',
            'role_id' => 1,
            'email' => $request->email ?? null,
            'password' => Hash::make($request->password),
            // 'image' => $file ?? null,

        ]);
        Auth::login($user);
        return redirect()->route('dashboard');
    }

}
