<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CitizenController extends Controller
{
    public function index()
    {
        $si    = DB::table('school_infos')->select('name','icon')->first();
        $citizen = DB::table('tm_citizens')->get();

        return view('master.citizen',['si'=>$si,'citizen'=>$citizen]);
    }

    public function store(Request $r)
    {
        $rules = [
            'name' => 'required|string',
        ];
    
        $messages = [
            'name.required' => 'Nama wajib diisi',
            'name.string'   => 'Nama harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $name = $r->input('name');

        DB::table('tm_citizens')
        ->insert([
            'name'       => $name,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Kewarganegaraan berhasil di tambah');
    }

    public function update(Request $r)
    {
        $rules = [
            'id'   => 'required|integer',
            'name' => 'required|string',
        ];
    
        $messages = [
            'id.required'   => 'ID tidak ditemukan',
            'id.integer'    => 'ID tidak sesuai',
            'name.required' => 'Nama wajib diisi',
            'name.string'   => 'Nama harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $id   = $r->input('id');
        $name = $r->input('name');

        $ctz  = DB::table('tm_citizens')->select('name')->where('id', $id)->first();

        DB::table('tm_citizens')
        ->where('id', $id)
        ->update([
            'name'       => $name,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Kewarganegaraan '.$ctz->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $ctz = DB::table('tm_citizens')->select('name')->where('id', $id)->first();
        DB::table('tm_citizens')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Kewarganegaraan '.$ctz->name.' berhasil di hapus');
    }
}
