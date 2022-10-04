<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class SelectionMasterController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $s = DB::table('tm_selections')->select('first_nounce','last_nounce','created_at','updated_at')->first();

        return view('master.selection',['si'=>$si,'s'=>$s]);
    }

    public function update(Request $r)
    {
        $rules = [
            'first_nounce' => 'required|string',
            'last_nounce'  => 'required|string',
        ];
    
        $messages = [
            'first_nounce.required' => 'Setelah memperhatikan wajib diisi',
            'first_nounce.string'   => 'Setelah memperhatikan harus berupa string',
            'last_nounce.required'  => 'Keterangan wajib diisi',
            'last_nounce.string'    => 'Keterangan harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Seleksi gagal di update: '.$validator->errors());
        }
        
        $firstNounce = $r->input('first_nounce');
        $lastNounce  = $r->input('last_nounce');

        DB::table('tm_selections')
        ->update([
            'first_nounce' => $firstNounce,
            'last_nounce'  => $lastNounce,
            'updated_at'   => now()
        ]);
        
        return redirect()->back()->with('success', 'Seleksi berhasil di update');
    }

    public function cetak_pdf(Request $r)
    {
        $month = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $now    = now()->format('Y-m-d');
        $expNow = explode('-', $now);
        $tgl    = $expNow[2] . ' ' . $month[ (int)$expNow[1] ] . ' ' . $expNow[0];

        $school = DB::table('school_infos')
            ->select('name','distric','school_year','chairman','letter_head')
            ->first();
        $selection = DB::table('tm_selections')
            ->select('first_nounce','last_nounce')
            ->first();

        $pdf = PDF::loadView('master.selection-pdf',['school'=>$school,'s'=>$selection,'tgl'=>$tgl])->setPaper('folio');
        return $pdf->stream('Preview Diterima.pdf');
    }
}
