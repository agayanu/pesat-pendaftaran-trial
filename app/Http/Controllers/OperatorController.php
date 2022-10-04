<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class OperatorController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();

        return view('master.operator',['si'=>$si]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $data = DB::table('users')->select('id','name','email','created_at','updated_at')->where('role','2')->get();

            foreach ( $data as $d ) {
                if(empty($d->updated_at)) {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->created_at));
                } else {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->updated_at));
                }

                $data_fix[] = [
                    'id'         => $d->id,
                    'name'       => $d->name,
                    'email'      => $d->email,
                    'updated_at' => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = '
                        <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#edit" data-coreui-id="'.$row['id'].'" data-coreui-nama="'.$row['name'].'"><i class="cil-pen" style="font-weight:bold"></i></button>
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name'].'" data-coreui-url="'.url('operator/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
                        <button class="btn btn-sm btn-warning" type="button" data-coreui-toggle="modal" data-coreui-target="#reset" data-coreui-nama="'.$row['name'].'" data-coreui-url="'.url('operator/'.$row['id']).'"><i class="cil-lock-locked" style="font-weight:bold"></i></button>
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $r)
    {
        $rules = [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
        ];
    
        $messages = [
            'name.required'     => 'Nama wajib diisi',
            'name.string'       => 'Nama harus berupa string',
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Email harus berupa email',
            'email.unique'      => 'Email sudah ada',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Operator gagal di tambah: '.$validator->errors());
        }

        $name     = $r->input('name');
        $email    = $r->input('email');

        DB::table('users')
        ->insert([
            'role'       => '2',
            'name'       => $name,
            'email'      => $email,
            'password'   => Hash::make('123456'),
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Operator berhasil di tambah');
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
            return redirect()->back()->withErrors($validator)->with('error', 'Operator gagal di update: '.$validator->errors());
        }
        
        $id   = $r->input('id');
        $name = $r->input('name');

        $us = DB::table('users')->select('name')->where('id', $id)->first();

        DB::table('users')
        ->where('id', $id)
        ->update([
            'name'       => $name,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Operator '.$us->name.' berhasil di update');
    }

    public function reset($id)
    {
        $us = DB::table('users')->select('name')->where('id', $id)->first();
        DB::table('users')
        ->where('id', $id)
        ->update([
            'password'   => Hash::make('123456'),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Password Operator '.$us->name.' berhasil di reset');
    }

    public function destroy($id)
    {
        $us = DB::table('users')->select('name')->where('id', $id)->first();
        DB::table('users')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Operator '.$us->name.' berhasil di hapus');
    }
}
