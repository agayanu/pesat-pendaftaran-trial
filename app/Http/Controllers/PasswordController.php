<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();

        return view('pass',['si'=>$si]);
    }

    public function update(Request $r)
    {
        $rules = [
            'pass-old'    => 'required|string',
            'pass-new'    => 'required|string',
            'pass-new-re' => 'required|string|same:pass-new',
        ];
    
        $messages = [
            'pass-old.required'    => 'Password Lama wajib diisi',
            'pass-old.string'      => 'Password Lama harus berupa string',
            'pass-new.required'    => 'Password Baru wajib diisi',
            'pass-new.string'      => 'Password Baru harus berupa string',
            'pass-new-re.required' => 'Ketik Ulang Password Baru wajib diisi',
            'pass-new-re.string'   => 'Ketik Ulang Password Baru harus berupa string',
            'pass-new-re.same'     => 'Ketik Ulang Password Baru tidak sama dengan Password Baru',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($r->all);
        }

        $id = Auth::user()->id;
        $passLama = DB::table('users')->select('password')->where('id', $id)->first();
        $passOld = $r->input('pass-old');

        if(Hash::check($passOld, $passLama->password)){
            $passNew = $r->input('pass-new');
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'password'   => Hash::make($passNew),
                    'updated_at' => now()
                ]);

            return redirect()->back()->with('success', 'Password berhasil di update');
        }

        return redirect()->back()->with('error', 'Gagal merubah password !!! Password Lama tidak sesuai');
    }

    public function update_email(Request $r)
    {
        $rules = [
            'email_old' => 'required|email',
            'email_new' => 'required|email|unique:users,email',
            'password'  => 'required|string',
        ];
    
        $messages = [
            'email_old.required' => 'Email Lama wajib diisi',
            'email_old.email'    => 'Email Lama harus berupa email',
            'email_new.required' => 'Email Baru wajib diisi',
            'email_new.email'    => 'Email Baru harus berupa email',
            'email_new.unique'   => 'Email sudah ada',
            'password.required'  => 'Password wajib diisi',
            'password.string'    => 'Password harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Email gagal diganti: '.$validator->errors());
        }

        $id        = Auth::user()->id;
        $role      = Auth::user()->role;
        $old       = DB::table('users')->select('email','password','id_regist')->where('id', $id)->first();
        $emailOld  = $r->input('email_old');
        $emailNew  = $r->input('email_new');
        $pass      = $r->input('password');

        if($old->email != $emailOld)
        {
            return redirect()->back()->with('error', 'Email gagal diganti: Email Lama tidak sesuai');
        }

        if(Hash::check($pass, $old->password)){
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'email'   => $emailNew,
                    'updated_at' => now()
                ]);

            if($role === '0')
            {
                DB::table('registrations')
                ->where('id', $old->id_regist)
                ->update([
                    'email_student'   => $emailNew,
                    'updated_at' => now()
                ]);
            }

            return redirect()->back()->with('success', 'Email berhasil di update');
        }

        return redirect()->back()->with('error', 'Email gagal diganti: Password tidak sesuai');
    }
}
