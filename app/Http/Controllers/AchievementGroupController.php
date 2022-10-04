<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AchievementGroupController extends Controller
{
    public function index()
    {
        $si               = DB::table('school_infos')->select('name','icon')->first();
        $achievementGroup = DB::table('tm_achievementgroups')->get();

        return view('master.achievement-group',['si'=>$si,'agroup'=>$achievementGroup]);
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

        DB::table('tm_achievementgroups')
        ->insert([
            'name'       => $name,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Grup Prestasi berhasil di tambah');
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

        $agp  = DB::table('tm_achievementgroups')->select('name')->where('id', $id)->first();

        DB::table('tm_achievementgroups')
        ->where('id', $id)
        ->update([
            'name'       => $name,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Grup Prestasi '.$agp->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $agp = DB::table('tm_achievementgroups')->select('name')->where('id', $id)->first();
        DB::table('tm_achievementgroups')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Grup Prestasi '.$agp->name.' berhasil di hapus');
    }
}
