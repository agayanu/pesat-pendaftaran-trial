<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ReceiveMail;
use Swift_TransportException;
use Exception;

class SelectionController extends Controller
{
    public function index(Request $r)
    {
        $si           = DB::table('school_infos')->select('name','icon')->first();
        $period       = DB::table('tm_periods')->select('period')->orderBy('period','desc')->get();
        $periodSelect = $r->input('period_select') ?? now()->format('Y');
        $grade        = DB::table('tm_grades')->select('id','name')->get();
        $gradeSelect  = $r->input('grade_select') ?? null;
        $major        = DB::table('tm_majors')->select('id','name')->get();
        $majorSelect  = $r->input('major_select') ?? null;
        $noRegist     = $r->input('no_regist') ?? null;

        return view('operator.selection',['si'=>$si,'period'=>$period,'ps'=>$periodSelect,'grade'=>$grade,'gs'=>$gradeSelect,'major'=>$major,'ms'=>$majorSelect,'no_regist'=>$noRegist]);
    }

    public function data(Request $r)
    {
        $period   = $r->input('period_select');
        $grade    = $r->input('grade_select') ?? null;
        $major    = $r->input('major_select') ?? null;
        $noRegist = $r->input('no_regist') ?? null;

        if ($r->ajax()) {
            $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->leftJoin('tm_schools as e', 'a.school','=','e.id')
                ->select('a.id','a.no_regist','a.name','b.name as grade','c.name as major','d.name as phase','e.name as school','a.remark','a.created_at','a.updated_at')
                ->where([['a.period',$period],['a.status',1]]);
            if(!empty($grade)) { $data = $data->where('a.grade',$grade); }
            if(!empty($major)) { $data = $data->where('a.major',$major); }
            if(!empty($noRegist)) { $data = $data->where('a.no_regist',$noRegist); }
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                $data_fix[] = [ 
                    'id'         => $d->id,
                    'no_regist'  => $d->no_regist,
                    'name'       => $d->name,
                    'created_at' => $d->created_at,
                    'grade'      => $d->grade,
                    'major'      => $d->major,
                    'phase'      => $d->phase,
                    'school'     => $d->school ?? $d->remark
                ];
            }

            return DataTables::of($data_fix)->make(true);
        }
    }

    public function data_receive(Request $r)
    {
        $period   = $r->input('period_select');
        $grade    = $r->input('grade_select') ?? null;
        $major    = $r->input('major_select') ?? null;
        $noRegist = $r->input('no_regist') ?? null;

        if ($r->ajax()) {
            $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->leftJoin('tm_schools as e', 'a.school','=','e.id')
                ->select('a.id','a.no_regist','a.name','b.name as grade','c.name as major','d.name as phase','e.name as school','a.remark','a.created_at','a.updated_at')
                ->where([['a.period',$period],['a.status',2]]);
            if(!empty($grade)) { $data = $data->where('a.grade',$grade); }
            if(!empty($major)) { $data = $data->where('a.major',$major); }
            if(!empty($noRegist)) { $data = $data->where('a.no_regist',$noRegist); }
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                $data_fix[] = [ 
                    'id'         => $d->id,
                    'no_regist'  => $d->no_regist,
                    'name'       => $d->name,
                    'created_at' => $d->created_at,
                    'grade'      => $d->grade,
                    'major'      => $d->major,
                    'phase'      => $d->phase,
                    'school'     => $d->school ?? $d->remark
                ];
            }

            return DataTables::of($data_fix)->make(true);
        }
    }

    public function data_pay(Request $r)
    {
        $period   = $r->input('period_select');
        $grade    = $r->input('grade_select') ?? null;
        $major    = $r->input('major_select') ?? null;
        $noRegist = $r->input('no_regist') ?? null;

        if ($r->ajax()) {
            $data = DB::table('registrations as a')
                ->join('tm_grades as b', 'a.grade','=','b.id')
                ->join('tm_majors as c', 'a.major','=','c.id')
                ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
                ->leftJoin('tm_schools as e', 'a.school','=','e.id')
                ->select('a.id','a.no_regist','a.name','b.name as grade','c.name as major','d.name as phase','e.name as school','a.remark','a.created_at','a.updated_at')
                ->where([['a.period',$period],['a.status',3]]);
            if(!empty($grade)) { $data = $data->where('a.grade',$grade); }
            if(!empty($major)) { $data = $data->where('a.major',$major); }
            if(!empty($noRegist)) { $data = $data->where('a.no_regist',$noRegist); }
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }
            
            foreach ( $data as $d ) {
                $data_fix[] = [ 
                    'id'         => $d->id,
                    'no_regist'  => $d->no_regist,
                    'name'       => $d->name,
                    'created_at' => $d->created_at,
                    'grade'      => $d->grade,
                    'major'      => $d->major,
                    'phase'      => $d->phase,
                    'school'     => $d->school ?? $d->remark
                ];
            }

            return DataTables::of($data_fix)->make(true);
        }
    }

    public function store(Request $r)
    {
        if ($r->ajax())
        {
            $name = $r->input('json');
            $data = json_decode($name,true);
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
            foreach ($data as $d) {
                $cdrc = DB::table('regist_receives')->select('id')->where('id_regist',$d['id'])->count();
                $cdr = DB::table('registrations')->select('id')->where([['id',$d['id']],['status',2]])->count();
                if(empty($cdrc)) {
                    DB::table('regist_receives')
                        ->insert([
                            'id_regist'  => $d['id'],
                            'user'       => Auth::user()->email,
                            'created_at' => now()
                        ]);
                }
                if(empty($cdr)) {
                    DB::table('registrations')
                        ->where('id',$d['id'])
                        ->update([
                            'status'     => 2,
                            'user'       => Auth::user()->email,
                            'updated_at' => now()
                        ]);
                }

                $da = DB::table('registrations as a')
                    ->leftJoin('tm_schools as b', 'a.school','=','b.id')
                    ->join('tm_grades as c', 'a.grade','=','c.id')
                    ->join('tm_majors as d', 'a.major','=','d.id')
                    ->join('tm_phase_registrations as e', 'a.phase','=','e.id')
                    ->select('a.no_regist','a.email_student as email','e.name as phase','a.name','a.place','a.birthday','b.name as school','c.name as grade','d.name as major','a.nisn','a.remark','a.stay_address','a.home_address','a.hp_parent','a.hp_parent2','a.no_account2')
                    ->where('a.id',$d['id'])
                    ->first();
                $daDad = DB::table('familys as a')
                    ->leftJoin('tm_jobs as b', 'a.job','=','b.id')
                    ->select('a.name','b.name as job')
                    ->where([['a.id_regist',$d['id']],['a.family_member',1]])
                    ->first();
                $daMom = DB::table('familys as a')
                    ->leftJoin('tm_jobs as b', 'a.job','=','b.id')
                    ->select('a.name','b.name as job')
                    ->where([['a.id_regist',$d['id']],['a.family_member',2]])
                    ->first();
                if(!empty($da->birthday)) {
                    $exp = explode('-', $da->birthday);
                    $birthday = $exp[2] . ' ' . $month[ (int)$exp[1] ] . ' ' . $exp[0];
                } else {
                    $birthday = null;
                }
                
                $dataPdf[] = [
                    'id'             => $d['id'],
                    'no_regist'      => $da->no_regist,
                    'email'          => $da->email,
                    'phase'          => $da->phase,
                    'name'           => $da->name,
                    'place'          => $da->place,
                    'birthday'       => $birthday,
                    'school'         => $da->school ?? $da->remark,
                    'grade'          => $da->grade,
                    'major'          => $da->major,
                    'nisn'           => $da->nisn,
                    'parent_dad'     => $daDad->name,
                    'parent_dad_job' => $daDad->job,
                    'parent_mom'     => $daMom->name,
                    'parent_mom_job' => $daMom->job,
                    'address'        => $da->stay_address ?? $da->home_address,
                    'parent_dad_hp'  => $da->hp_parent,
                    'parent_mom_hp'  => $da->hp_parent2,
                    'no_account2'    => $da->no_account2,
                ];
            }
            $now = now()->format('Y-m-d');
            $expNow = explode('-', $now);
            $tgl = $expNow[2] . ' ' . $month[ (int)$expNow[1] ] . ' ' . $expNow[0];
            
            $school = DB::table('school_infos')
                ->select('name','address','icon','distric','school_year','chairman','letter_head','wa_api','wa_api_key','receive_wa_message')
                ->first();
            $selection = DB::table('tm_selections')
                ->select('first_nounce','last_nounce')
                ->first();
            $hotline = DB::table('tm_hotlines as a')
                ->join('tm_hotline_types as b', 'a.type','=','b.id')
                ->select('a.name','a.lines','b.name as type')
                ->get();
            $wa_hotline = DB::table('tm_hotlines as a')
                ->join('tm_hotline_types as b', 'a.type','=','b.id')
                ->select('a.name','a.lines','b.name as type')
                ->first();
            $hotline1 = $wa_hotline->name.' : '.$wa_hotline->lines.' ('.$wa_hotline->type.')';
            if(!empty($school->wa_api)) {
                $key='2434bd87a6b88e902ac086bdcb9fde85ec637f2d1db7180f';
                $url='http://116.203.191.58/api/send_message';
            }

            foreach ($dataPdf as $dp) {
                try{
                    Mail::to($dp['email'])->send(new ReceiveMail($dp, $school, $hotline, $selection));
                } catch (Swift_TransportException $e) {
                    $res = $e->getMessage();
                    DB::table('emails')->insert(['id_regist' => $dp['id'], 'type' => 'Receive', 'response' => $res, 'created_at' => now()]);
                } catch (Exception $e) {
                    $res = $e->getMessage();
                    DB::table('emails')->insert(['id_regist' => $dp['id'], 'type' => 'Receive', 'response' => $res, 'created_at' => now()]);
                }
                
                if(!empty($school->wa_api)) {
                    $receive_wa_message = $school->receive_wa_message;
                    $receive_wa_message = preg_replace("/%email%/i", $dp['email'], $receive_wa_message);
                    $receive_wa_message = preg_replace("/%no_rekening_pembayaran%/i", $dp['no_account2'], $receive_wa_message);
                    $receive_wa_message = preg_replace("/%gelombang%/i", $dp['phase'], $receive_wa_message);
                    $receive_wa_message = preg_replace("/%no_daftar%/i", $dp['no_regist'], $receive_wa_message);
                    $receive_wa_message = preg_replace("/%nama%/i", $dp['name'], $receive_wa_message);
                    $receive_wa_message = preg_replace("/%nisn%/i", $dp['nisn'], $receive_wa_message);
                    $receive_wa_message = preg_replace("/%alamat%/i", $dp['address'], $receive_wa_message);
                    $receive_wa_message = preg_replace("/%smp%/i", $dp['school'], $receive_wa_message);
                    $receive_wa_message = preg_replace("/%kelompok%/i", $dp['grade'], $receive_wa_message);
                    $receive_wa_message = preg_replace("/%jurusan%/i", $dp['major'], $receive_wa_message);
                    $receive_wa_message = preg_replace("/%alamat_sekolah%/i", $school->address, $receive_wa_message);
                    $receive_wa_message = preg_replace("/%hotline1%/i", $hotline1, $receive_wa_message);
                    $data = array(
                    "phone_no" => $dp['parent_dad_hp'],
                    "key"      => $key,
                    "message"  => $receive_wa_message,
                    );
                    $data_string = json_encode($data);
        
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_VERBOSE, 0);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 360);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
                    );
                    echo $res=curl_exec($ch);
                    DB::table('whatsapps')->insert(['id_regist' => $dp['id'], 'type' => 'Receive', 'response' => $res, 'created_at' => now()]);
                    curl_close($ch);
                }
            }

            $pdf = PDF::loadView('operator.selection-pdf',['school'=>$school,'sel'=>$selection,'data_pdf'=>$dataPdf,'tgl'=>$tgl])->setPaper('folio');
            return $pdf->stream('Diterima.pdf');
        }
    }

    public function reprint(Request $r)
    {
        if ($r->ajax())
        {
            $name = $r->input('json');
            $data = json_decode($name,true);
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
            foreach ($data as $d) {
                $da = DB::table('registrations as a')
                    ->leftJoin('tm_schools as b', 'a.school','=','b.id')
                    ->select('a.no_regist','a.name','a.place','a.birthday','b.name as school','a.remark','a.stay_address','a.home_address','a.hp_parent','a.hp_parent2')
                    ->where('a.id',$d['id'])
                    ->first();
                $daDad = DB::table('familys as a')
                    ->leftJoin('tm_jobs as b', 'a.job','=','b.id')
                    ->select('a.name','b.name as job')
                    ->where([['a.id_regist',$d['id']],['a.family_member',1]])
                    ->first();
                $daMom = DB::table('familys as a')
                    ->leftJoin('tm_jobs as b', 'a.job','=','b.id')
                    ->select('a.name','b.name as job')
                    ->where([['a.id_regist',$d['id']],['a.family_member',2]])
                    ->first();
                if(!empty($da->birthday)) {
                    $exp = explode('-', $da->birthday);
                    $birthday = $exp[2] . ' ' . $month[ (int)$exp[1] ] . ' ' . $exp[0];
                } else {
                    $birthday = null;
                }
                
                $dataPdf[] = [ 
                    'no_regist'      => $da->no_regist,
                    'name'           => $da->name,
                    'place'          => $da->place,
                    'birthday'       => $birthday,
                    'school'         => $da->school ?? $da->remark,
                    'parent_dad'     => $daDad->name,
                    'parent_dad_job' => $daDad->job,
                    'parent_mom'     => $daMom->name,
                    'parent_mom_job' => $daMom->job,
                    'address'        => $da->stay_address ?? $da->home_address,
                    'parent_dad_hp'  => $da->hp_parent,
                    'parent_mom_hp'  => $da->hp_parent2,
                ];
            }
            $now = now()->format('Y-m-d');
            $expNow = explode('-', $now);
            $tgl = $expNow[2] . ' ' . $month[ (int)$expNow[1] ] . ' ' . $expNow[0];
            
            $school = DB::table('school_infos')
                ->select('name','distric','school_year','chairman','letter_head')
                ->first();
            $selection = DB::table('tm_selections')
                ->select('first_nounce','last_nounce')
                ->first();

            $pdf = PDF::loadView('operator.selection-pdf',['school'=>$school,'sel'=>$selection,'data_pdf'=>$dataPdf,'tgl'=>$tgl])->setPaper('folio');
            return $pdf->stream('Diterima.pdf');
        }
    }
}
