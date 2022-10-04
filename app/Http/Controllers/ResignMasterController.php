<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResignMasterController extends Controller
{
    public function index()
    {
        $si  = DB::table('school_infos')->select('name','icon')->first();
        $trs = DB::table('tm_resigns')->select('discount','created_at','updated_at')->first();

        return view('master.resign',['si'=>$si,'trs'=>$trs]);
    }

    public function update(Request $r)
    {
        $rules = [
            'discount' => 'required|numeric|max:100',
        ];
    
        $messages = [
            'discount.required' => 'Potongan wajib diisi',
            'discount.numeric'  => 'Potongan harus angka',
            'discount.max'      => 'Potongan maksimal 100',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $discount = $r->input('discount');

        $cek = DB::table('tm_resigns')->count();

        if(empty($cek)){
            DB::table('tm_resigns')
            ->insert([
                'discount'   => $discount,
                'created_at' => now()
            ]);
        } else {
            DB::table('tm_resigns')
            ->update([
                'discount'   => $discount,
                'updated_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil Disimpan');
    }
}
