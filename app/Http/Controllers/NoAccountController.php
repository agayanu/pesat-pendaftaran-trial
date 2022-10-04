<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NoAccountController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $noAccount = DB::table('tm_noaccounts')->first();

        return view('master.no-account',['si'=>$si,'na'=>$noAccount]);
    }

    public function update(Request $r)
    {
        $rules = [
            'id'             => 'required|integer',
            'account'        => 'required|string|max:20',
            'account_digit'  => 'required|integer|max:127',
            'account_min'    => 'required|string|max:50',
            'account_max'    => 'required|string|max:50',
            'account2'       => 'required|string|max:20',
            'account2_digit' => 'required|integer|max:127',
            'account2_min'   => 'required|string|max:50',
            'account2_max'   => 'required|string|max:50',
        ];
    
        $messages = [
            'id.required'             => 'ID tidak ditemukan',
            'id.integer'              => 'ID tidak sesuai',
            'account.required'        => 'Pendaftaran wajib diisi',
            'account.string'          => 'Pendaftaran harus berupa string',
            'account.max'             => 'Pendaftaran maksimal 20 karakter',
            'account_digit.required'  => 'Jumlah Digit wajib diisi',
            'account_digit.string'    => 'Jumlah Digit harus berupa bilangan bulat',
            'account_digit.max'       => 'Jumlah Digit maksimal 127',
            'account_min.required'    => 'Minimal Acak wajib diisi',
            'account_min.string'      => 'Minimal Acak harus berupa string',
            'account_min.max'         => 'Minimal Acak maksimal 50 karakter',
            'account_max.required'    => 'Maksimal Acak wajib diisi',
            'account_max.string'      => 'Maksimal Acak harus berupa string',
            'account_max.max'         => 'Maksimal Acak maksimal 50 karakter',
            'account2.required'       => 'Pembayaran wajib diisi',
            'account2.string'         => 'Pembayaran harus berupa string',
            'account2.max'            => 'Pembayaran maksimal 20 karakter',
            'account2_digit.required' => 'Jumlah Digit wajib diisi',
            'account2_digit.string'   => 'Jumlah Digit harus berupa bilangan bulat',
            'account2_digit.max'      => 'Jumlah Digit maksimal 127',
            'account2_min.required'   => 'Minimal Acak wajib diisi',
            'account2_min.string'     => 'Minimal Acak harus berupa string',
            'account2_min.max'        => 'Minimal Acak maksimal 50 karakter',
            'account2_max.required'   => 'Maksimal Acak wajib diisi',
            'account2_max.string'     => 'Maksimal Acak harus berupa string',
            'account2_max.max'        => 'Maksimal Acak maksimal 50 karakter',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $id            = $r->input('id');
        $account       = $r->input('account');
        $accountDigit  = $r->input('account_digit');
        $accountMin    = $r->input('account_min');
        $accountMax    = $r->input('account_max');
        $account2      = $r->input('account2');
        $account2Digit = $r->input('account2_digit');
        $account2Min   = $r->input('account2_min');
        $account2Max   = $r->input('account2_max');

        $accountMinLen = strlen($accountMin);
        if($accountMinLen != $accountDigit){
            return redirect()->back()->with('error', 'Pendaftaran - Minimal Acak tidak sesuai Jumlah Digit');
        }
        $accountMaxLen = strlen($accountMax);
        if($accountMaxLen != $accountDigit){
            return redirect()->back()->with('error', 'Pendaftaran - Maksimal Acak tidak sesuai Jumlah Digit');
        }
        $account2MinLen = strlen($account2Min);
        if($account2MinLen != $account2Digit){
            return redirect()->back()->with('error', 'Pembayaran - Minimal Acak tidak sesuai Jumlah Digit');
        }
        $account2MaxLen = strlen($account2Max);
        if($account2MaxLen != $account2Digit){
            return redirect()->back()->with('error', 'Pembayaran - Maksimal Acak tidak sesuai Jumlah Digit');
        }

        DB::table('tm_noaccounts')
        ->where('id', $id)
        ->update([
            'account'        => $account,
            'account_digit'  => $accountDigit,
            'account_min'    => $accountMin,
            'account_max'    => $accountMax,
            'account2'       => $account2,
            'account2_digit' => $account2Digit,
            'account2_min'   => $account2Min,
            'account2_max'   => $account2Max,
            'updated_at'     => now()
        ]);
        
        return redirect()->back()->with('success', 'Rekening berhasil di update');
    }
}
