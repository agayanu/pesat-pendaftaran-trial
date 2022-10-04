<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showFormLogin()
    {
        if (Auth::check()) { 
            return redirect()->route('home');
        }
        $si = DB::table('school_infos')->select('nickname','slogan','icon','background')->first();
        return view('auth.login',['si'=>$si]);
    }

    public function login(Request $request)
    {
        $rules = [
            'email'              => 'required|email',
            'password'           => 'required|string'
        ];
  
        $messages = [
            'email.required'     => 'Email wajib diisi',
            'email.email'        => 'Format Email tidak sesuai',
            'password.required'  => 'Password wajib diisi',
            'password.string'    => 'Password harus berupa string'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];
  
        Auth::attempt($data, $request->get('remember'));
  
        if (Auth::check()) {
            return redirect()->route('home');
        } else { 
            Session::flash('error', 'Username atau password salah');
            return redirect()->route('login');
        }
    }
  
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
