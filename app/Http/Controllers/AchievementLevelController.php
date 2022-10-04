<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AchievementLevelController extends Controller
{
    public function index()
    {
        $si               = DB::table('school_infos')->select('name','icon')->first();
        $achievementLevel = DB::table('tm_achievementlevels')->get();

        return view('master.achievement-level',['si'=>$si,'alevel'=>$achievementLevel]);
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

        DB::table('tm_achievementlevels')
        ->insert([
            'name'       => $name,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Tingkat Prestasi berhasil di tambah');
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

        $alv  = DB::table('tm_achievementlevels')->select('name')->where('id', $id)->first();

        DB::table('tm_achievementlevels')
        ->where('id', $id)
        ->update([
            'name'       => $name,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Tingkat Prestasi '.$alv->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $alv = DB::table('tm_achievementlevels')->select('name')->where('id', $id)->first();
        DB::table('tm_achievementlevels')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Tingkat Prestasi '.$alv->name.' berhasil di hapus');
    }
}
