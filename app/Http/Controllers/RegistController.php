<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationMail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RegistExport;
use App\Exports\RegistAllExport;
use Maatwebsite\Excel\Facades\Excel;
use Swift_TransportException;
use Exception;

class RegistController extends Controller
{
    public function index(Request $r)
    {
        $si           = DB::table('school_infos')->select('name','icon')->first();
        $period       = DB::table('tm_periods')->select('period')->orderBy('period','desc')->get();
        $periodSelect = $r->input('period_select') ?? null;
        $createdFrom  = $r->input('created_from') ?? now()->format('d-m-Y');
        $createdTo    = $r->input('created_to') ?? now()->format('d-m-Y');

        return view('operator.regist',['si'=>$si,'period'=>$period,'cf'=>$createdFrom,'ct'=>$createdTo,'ps'=>$periodSelect]);
    }

    public function data(Request $r)
    {
        $period         = $r->input('period_select') ?? null;
        $createdFrom    = $r->input('created_from');
        $createdTo      = $r->input('created_to');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        if ($r->ajax()) 
        {
            $data = DB::table('registrations as a')
                ->leftJoin('regist_receives as b', 'a.id','=','b.id_regist')
                ->leftJoin('tm_schools as c', 'a.school','=','c.id')
                ->select('a.id','a.period','a.no_regist','a.status','a.grade','a.major','a.phase','a.name','a.gender',
                    'c.name as school_name','a.user','a.created_at','a.updated_at','b.created_at as receive_created_at');
            if($period) { $data = $data->where('a.period',$period); }
            $data      = $data->whereBetween('a.created_at', [$createdFormFix, $createdToFix]);
            $dataCount = $data->count();
            $data      = $data->get();
            
            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)
                    ->addColumn('action', function($row){
                        $actionBtn = '';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            foreach ( $data as $d ) {
                if(empty($d->updated_at)) {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->created_at));
                } else {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->updated_at));
                }

                $status   = DB::table('tm_statuss')->select('name')->where('id',$d->status)->first();
                $grade    = DB::table('tm_grades')->select('name')->where('id',$d->grade)->first();
                $major    = DB::table('tm_majors')->select('name')->where('id',$d->major)->first();
                $phase    = DB::table('tm_phase_registrations')->select('name')->where('id',$d->phase)->first();
                $gender   = DB::table('tm_genders')->select('name')->where('id',$d->gender)->first();

                $data_fix[] = [
                    'id'           => $d->id,
                    'period'       => $d->period,
                    'no_regist'    => $d->no_regist,
                    'status_id'    => $d->status,
                    'status'       => $status->name,
                    'grade_id'     => $d->grade,
                    'grade'        => $grade->name,
                    'major_id'     => $d->major,
                    'major'        => $major->name,
                    'phase_id'     => $d->phase,
                    'phase'        => $phase->name,
                    'name'         => $d->name,
                    'gender_id'    => $d->gender,
                    'gender'       => $gender->name,
                    'school'       => $d->school_name,
                    'regist_date'  => $d->created_at,
                    'receive_date' => $d->receive_created_at,
                    'user'         => $d->user,
                    'updated_at'   => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = '
                        <a href="'.route('pendaftaran-cek',['id'=>$row['id']]).'" class="btn btn-sm btn-warning"><i class="cil-book" style="font-weight:bold"></i></a>
                        <a href="'.route('pendaftaran-cetak',['period'=>$row['period'],'no_daf'=>$row['no_regist']]).'" class="btn btn-sm btn-info"><i class="cil-print" style="font-weight:bold"></i></a>
                        <a href="'.route('pendaftaran-edit',['id'=>$row['id']]).'" class="btn btn-sm btn-success"><i class="cil-pen" style="font-weight:bold"></i></a>
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name'].'" data-coreui-url="'.url('pendaftaran/'.$row['id']).'"><i class="cil-trash" style="font-weight:bold"></i></button> 
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $si       = DB::table('school_infos')->select('name','icon')->first();
        $phase    = DB::table('tm_phase_registrations')->select('id','name')->where('status','Y')->get();
        $grade    = DB::table('tm_grades')->select('id','name')->get();
        $major    = DB::table('tm_majors')->select('id','name')->get();
        $gender   = DB::table('tm_genders')->select('id','name')->get();
        $religion = DB::table('tm_religions')->select('id','name')->get();

        return view('operator.regist-create',['si'=>$si,'phase'=>$phase,'grade'=>$grade,'major'=>$major,'gender'=>$gender,'religion'=>$religion]);
    }

    public function get_school(Request $r) 
    {
        if($r->ajax())
        {
            $school = DB::table('tm_schools')->select('id','name','address')->where('name','LIKE','%'.$r->term.'%')->paginate(10, ['*'], 'page', $r->page);

            return response()->json([$school]);
        }
    }

    public function store(Request $r)
    {
        $rules = [
            'created_at'   => 'required|date_format:d-m-Y',
            'phase'        => 'required|integer',
            'grade'        => 'required|integer',
            'major'        => 'required|integer',
            'name'         => 'required|string',
            'school'       => 'nullable|integer',
            'remark'       => 'nullable|string',
            'email'        => 'required|email|unique:users',
            'gender'       => 'required|integer',
            'religion'     => 'required|integer',
            'parent'       => 'required|string',
            'hp_parent'    => 'required|string|max:15',
            'hp'           => 'required|string|max:15',
        ];
    
        $messages = [
            'created_at.required'    => 'Tanggal wajib diisi',
            'created_at.date_format' => 'Tanggal harus berformat dd-mm-yyyy',
            'phase.required'         => 'Gelombang wajib diisi',
            'phase.integer'          => 'Gelombang tidak sesuai pilihan',
            'grade.required'         => 'Kelompok wajib diisi',
            'grade.integer'          => 'Kelompok tidak sesuai pilihan',
            'major.required'         => 'Jurusan wajib diisi',
            'major.integer'          => 'Jurusan tidak sesuai pilihan',
            'name.required'          => 'Nama Lengkap wajib diisi',
            'name.string'            => 'Nama Lengkap harus berupa string',
            'school.integer'         => 'Asal Sekolah Cari tidak sesuai pilihan',
            'remark.string'          => 'Asal Sekolah Ketik harus berupa string',
            'email.required'         => 'Email wajib diisi',
            'email.email'            => 'Email tidak sesuai format',
            'email.unique'           => 'Email sudah ada',
            'gender.required'        => 'Jenis Kelamin wajib diisi',
            'gender.integer'         => 'Jenis Kelamin tidak sesuai pilihan',
            'religion.required'      => 'Agama wajib diisi',
            'religion.integer'       => 'Agama tidak sesuai pilihan',
            'parent.required'        => 'Nama Lengkap Orangtua wajib diisi',
            'parent.string'          => 'Nama Lengkap Orangtua harus berupa string',
            'hp_parent.required'     => 'No. HP Orangtua wajib diisi',
            'hp_parent.string'       => 'No. HP Orangtua harus berupa string',
            'hp_parent.max'          => 'No. HP Orangtua maksimal 15 karakter',
            'hp.required'            => 'No. HP Siswa wajib diisi',
            'hp.string'              => 'No. HP Siswa harus berupa string',
            'hp.max'                 => 'No. HP Siswa maksimal 15 karakter',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($r->all);
        }

        $schoolCheck  = $r->input('school_check');
        $school       = $r->input('school') ?? null;
        $remark       = $r->input('remark') ?? null;
        if($schoolCheck && empty($school))
        {
            return redirect()->back()->withInput($r->all)->with('error','Asal Sekolah Cari wajib diisi');
        }
        if(empty($schoolCheck) && empty($remark))
        {
            return redirect()->back()->withInput($r->all)->with('error','Asal Sekolah Ketik wajib diisi');
        }

        $nohp_double = DB::table('registrations')
            ->select('id')
            ->where('hp_student', $r->hp_student)
            ->count();

        if(!empty($nohp_double))
        {
            return back()->with('error','Pendaftaran Gagal! Nomor HP Siswa Sudah Ada!')->withErrors(['hp'=>'No. HP Siswa sudah ada'])->withInput($r->all);
        }

        $dateAt       = $r->input('created_at');
        $timeAt       = now()->format('H:i:s');
        $createdAt    = $dateAt.' '.$timeAt;
        $createdAtFix = date_format(date_create($createdAt), 'Y-m-d H:i:s');
        $phase        = $r->input('phase');
        $grade        = $r->input('grade');
        $major        = $r->input('major');
        $name         = $r->input('name');
        $email        = $r->input('email');
        $gender       = $r->input('gender');
        $religion     = $r->input('religion');
        $parent       = $r->input('parent');
        $hpParent     = $r->input('hp_parent');
        $hp           = $r->input('hp');
        $user         = Auth::user()->email;
        $phaseCost    = DB::table('tm_phase_registrations')->select('cost')->where('id', $phase)->first();
        $phaseAmount  = DB::table('tm_cost_registrations')->select('amount')->where('phase', $phase)->first();

        if($phaseCost->cost === 'Y' && empty($phaseAmount))
        {
            return back()->with('error','Pendaftaran Gagal! Nominal pembayaran Belum di buat! Hubungi Administrator!')->withInput($r->all);
        }

        $period     = DB::table('tm_periods')->select('period')->where('status', 'Y')->first();
        $No_Daf_x   = DB::table('registrations')->where('period', $period->period)->max('no_regist');
        $No_Daf     = $No_Daf_x + 1;
        $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);

        $account = DB::table('tm_noaccounts')
            ->select(
                'account',
                'account_min',
                'account_max',
                'account2',
                'account2_min',
                'account2_max',
            )
            ->first();

        if($phaseCost->cost === 'Y'){
            do {
                $AccountNox = mt_rand($account->account_min, $account->account_max);
            } while (DB::table('registrations')->where('no_account', $AccountNox )->exists());
            
            $AccountNo = $account->account.$AccountNox;
        } else {
            $AccountNo = NULL;
        }

        do {
            $AccountNo2x = mt_rand($account->account2_min, $account->account2_max);
        } while (DB::table('registrations')->where('no_account2', $AccountNo2x )->exists());
        $AccountNo2 = $account->account2.$AccountNo2x;

        DB::table('registrations')->insert([
            'period'        => $period->period,
            'no_regist'     => $No_Daf_str,
            'status'        => 1,
            'grade'         => $grade,
            'major'         => $major,
            'phase'         => $phase,
            'name'          => $name,
            'religion'      => $religion,
            'gender'        => $gender,
            'hp_student'    => $hp,
            'hp_parent'     => $hpParent,
            'email_student' => $email,
            'no_account'    => $AccountNo,
            'no_account2'   => $AccountNo2,
            'school'        => $school,
            'remark'        => $remark,
            'user'          => $user,
            'created_at'    => $createdAtFix,
            'updated_at'    => now()
        ]);

        $regist = DB::table('registrations')
            ->select('id')
            ->where([['period', $period->period],['no_regist', $No_Daf_str],])
            ->first();

        $fams = DB::table('tm_familymembers')->select('id')->get();
        foreach($fams as $f){
            DB::table('familys')->insert([
                'id_regist'     => $regist->id,
                'family_member' => $f->id,
                'user'          => $user,
                'created_at'    => now()
            ]);
        }

        $docs = DB::table('tm_regist_documents')->select('id')->get();
        foreach($docs as $d){
            DB::table('regist_documents')->insert([
                'id_regist'  => $regist->id,
                'document'   => $d->id,
                'status'     => 'N',
                'user'       => $user,
                'created_at' => now()
            ]);
        }

        DB::table('familys')
        ->where([['id_regist', $regist->id], ['family_member', 1],])
        ->update([
            'name'       => $parent,
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'id_regist'  => $regist->id,
            'name'       => $name,
            'email'      => $email,
            'password'   => Hash::make('123456'),
            'created_at' => now()
        ]);

        if($phaseCost->cost === 'Y'){
            DB::table('tr_registrations')->insert([
                'id_regist'  => $regist->id,
                'amount'     => $phaseAmount->amount,
                'user'       => $user,
                'created_at' => now()
            ]);
        }

        $mail_regist = DB::table('registrations as a')
            ->join('tm_grades as b', 'a.grade','=','b.id')
            ->join('tm_majors as c', 'a.major','=','c.id')
            ->join('tm_phase_registrations as d', 'a.phase','=','d.id')
            ->join('tm_religions as e', 'a.religion','=','e.id')
            ->join('tm_genders as f', 'a.gender','=','f.id')
            ->join('familys as g', 'a.id','=','g.id_regist')
            ->leftJoin('tm_jobs as h', 'g.job','=','h.id')
            ->select('a.period','a.no_regist','b.name as grade','c.name as major','d.name as phase','a.name','a.email_student as email','a.place',
                'a.birthday','e.name as religion','f.name as gender','a.stay_address','a.hp_student','a.hp_parent','a.nisn',
                'a.photo','a.remark','g.name as parent_name','h.name as parent_job')
            ->where([['a.id', $regist->id],['g.family_member', 1],])
            ->first();
        $mail_school_info = DB::table('school_infos')
            ->select('name','nickname','slogan','address','school_year','icon','wa_api','wa_api_key','regist_wa_message')
            ->first();
        $mail_hotline = DB::table('tm_hotlines as a')
            ->join('tm_hotline_types as b', 'a.type','=','b.id')
            ->select('a.name','a.lines','b.name as type')
            ->get();
        $wa_hotline = DB::table('tm_hotlines as a')
            ->join('tm_hotline_types as b', 'a.type','=','b.id')
            ->select('a.name','a.lines','b.name as type')
            ->first();
        $schoolName = DB::table('tm_schools')->select('name')->where('id', $school)->first();

        try{
            Mail::to($email)->send(new RegistrationMail($mail_regist, $mail_school_info, $mail_hotline));
        } catch (Swift_TransportException $e) {
            $res = $e->getMessage();
            DB::table('emails')->insert(['id_regist' => $regist->id, 'type' => 'RegistOffline', 'response' => $res, 'created_at' => now()]);
        } catch (Exception $e) {
            $res = $e->getMessage();
            DB::table('emails')->insert(['id_regist' => $regist->id, 'type' => 'RegistOffline', 'response' => $res, 'created_at' => now()]);
        }

        if(!empty($mail_school_info->wa_api)) {
            $accountNo         = $AccountNo;
            $gelombang         = $mail_regist->phase;
            $nama              = $name;
            $smp               = $schoolName->name ?? $remark;
            $kelompok          = $mail_regist->grade;
            $jurusan           = $mail_regist->major;
            $url               = url('login');
            $alamat_sekolah    = $mail_school_info->address;
            $hotline1          = $wa_hotline->name.' : '.$wa_hotline->lines.' ('.$wa_hotline->type.')';
            $regist_wa_message = $mail_school_info->regist_wa_message;
            $regist_wa_message = preg_replace("/%email%/i", $email, $regist_wa_message);
            $regist_wa_message = preg_replace("/%no_rekening_pendaftaran%/i", $accountNo, $regist_wa_message);
            $regist_wa_message = preg_replace("/%gelombang%/i", $gelombang, $regist_wa_message);
            $regist_wa_message = preg_replace("/%no_daftar%/i", $No_Daf_str, $regist_wa_message);
            $regist_wa_message = preg_replace("/%nama%/i", $nama, $regist_wa_message);
            $regist_wa_message = preg_replace("/%nisn%/i", '', $regist_wa_message);
            $regist_wa_message = preg_replace("/%alamat%/i", '', $regist_wa_message);
            $regist_wa_message = preg_replace("/%smp%/i", $smp, $regist_wa_message);
            $regist_wa_message = preg_replace("/%kelompok%/i", $kelompok, $regist_wa_message);
            $regist_wa_message = preg_replace("/%jurusan%/i", $jurusan, $regist_wa_message);
            $regist_wa_message = preg_replace("/%url%/i", $url, $regist_wa_message);
            $regist_wa_message = preg_replace("/%alamat_sekolah%/i", $alamat_sekolah, $regist_wa_message);
            $regist_wa_message = preg_replace("/%hotline1%/i", $hotline1, $regist_wa_message);
            $url = $mail_school_info->wa_api;
            $key = $mail_school_info->wa_api_key;
            $data = array(
            "phone_no" => $hpParent,
            "key"      => $key,
            "message"  => $regist_wa_message,
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
            DB::table('whatsapps')->insert(['id_regist' => $regist->id, 'type' => 'RegistOffline', 'response' => $res, 'created_at' => now()]);
            curl_close($ch);
        }

        return redirect('pendaftaran/'.$period->period.'/'.$No_Daf_str.'/cetak-pdf');
    }

    public function show($id)
    {
        $si   = DB::table('school_infos')->select('name','icon')->first();
        $data = DB::table('registrations as a')
                ->leftJoin('regist_receives as b', 'a.id','=','b.id_regist')
                ->leftJoin('tm_schools as c', 'a.school','=','c.id')
                ->leftJoin('tm_genders as d', 'a.gender','=','d.id')
                ->join('tm_phase_registrations as e', 'a.phase','=','e.id')
                ->join('tm_grades as f', 'a.grade','=','f.id')
                ->join('tm_majors as g', 'a.major','=','g.id')
                ->join('tm_statuss as h', 'a.status','=','h.id')
                ->leftJoin('tm_religions as i', 'a.religion','=','i.id')
                ->leftJoin('tm_citizens as j', 'a.citizen','=','j.id')
                ->leftJoin('tm_familystatuss as k', 'a.family_status','=','k.id')
                ->leftJoin('tm_bloods as l', 'a.blood','=','l.id')
                ->leftJoin('tm_transports as m', 'a.transport','=','m.id')
                ->leftJoin('tm_stays as n', 'a.stay','=','n.id')
                ->leftJoin('tm_districs as o', 'a.stay_distric','=','o.id')
                ->leftJoin('tm_citys as p', 'a.stay_city','=','p.id')
                ->leftJoin('tm_provinces as q', 'a.stay_province','=','q.id')
                ->leftJoin('tm_districs as r', 'a.home_distric','=','r.id')
                ->leftJoin('tm_citys as s', 'a.home_city','=','s.id')
                ->leftJoin('tm_provinces as t', 'a.home_province','=','t.id')
                ->leftJoin('tm_districs as u', 'c.code_distric','=','u.code')
                ->leftJoin('tm_citys as v', 'c.code_city','=','v.code')
                ->leftJoin('tm_provinces as w', 'c.code_province','=','w.code')
                ->select('a.period','a.no_regist','h.name as status','f.name as grade','g.name as major','e.name as phase','a.name','a.nickname','a.place','a.birthday',
                    'i.name as religion','d.name as gender','j.name as citizen','a.birthday_id','a.family_id','a.kip','a.pip','a.kps','a.kps_id','k.name as family_status',
                    'a.child_no','a.child_qty','l.name as blood','a.glass','a.height','a.weight','a.head_size','a.distance','a.time_hh','a.time_mm','m.name as transport',
                    'n.name as stay','a.stay_rt','a.stay_rw','a.stay_village','o.name as stay_distric','p.name as stay_city','q.name as stay_province','a.stay_address',
                    'a.stay_postal','a.stay_latitude','a.stay_longitude','a.home_rt','a.home_rw','a.home_village','r.name as home_distric','s.name as home_city',
                    't.name as home_province','a.home_address','a.home_postal','a.home_latitude','a.home_longitude','a.id_card','a.hp_student','a.hp_parent','a.hp_parent2',
                    'a.email_student','a.email_parent','a.email_parent2','c.name as school_name','c.address as school_address','u.name as school_distric',
                    'v.name as school_city','w.name as school_province','a.school_year','a.school_nem_avg','a.school_sttb_avg','a.nisn','a.exam_un_no',
                    'a.skhun_no','a.certificate_no','a.no_account','a.no_account2','a.remark','a.user','a.created_at','a.updated_at','b.created_at as receive_created_at')
                ->where('a.id',$id)
                ->first();
        $family = DB::table('familys as a')
                ->join('tm_familymembers as b', 'a.family_member','=','b.id')
                ->leftJoin('tm_religions as c', 'a.religion','=','c.id')
                ->leftJoin('tm_educations as d', 'a.education','=','d.id')
                ->leftJoin('tm_jobs as e', 'a.job','=','e.id')
                ->leftJoin('tm_incomes as f', 'a.income','=','f.id')
                ->select('b.name as family_name','a.name','a.place','a.birthday','a.id_card','c.name as religion','d.name as education','e.name as job','f.name as income','a.remark',
                    'a.created_at','a.updated_at')
                ->where('a.id_regist', $id)
                ->get();
        $document = DB::table('regist_documents as a')
                ->join('tm_regist_documents as b', 'a.document','=','b.id')
                ->select('a.name as file_name','b.name as document_name','a.status','a.created_at','a.updated_at')
                ->where('a.id_regist', $id)
                ->get();
        $achievement = DB::table('achievements as a')
                ->join('tm_achievementgroups as b', 'a.group','=','b.id')
                ->join('tm_achievementranks as c', 'a.rank','=','c.id')
                ->join('tm_achievementlevels as d', 'a.level','=','d.id')
                ->select('b.name as group','a.name','c.name as rank','d.name as level','a.year','a.remark','a.created_at','a.updated_at')
                ->where('a.id_regist', $id)
                ->get();

        return view('operator.regist-show',['si'=>$si,'d'=>$data,'family'=>$family,'document'=>$document,'achievement'=>$achievement]);
    }

    public function cetak_pdf($period, $no_daf)
    {
        $school = DB::table('school_infos')
            ->select('name','distric','school_year','letter_head','regist_pdf_message_top','regist_pdf_message_bottom')
            ->first();
        $data_daftar = DB::table('registrations as a')
            ->join('tm_grades as f', 'a.grade','=','f.id')
            ->join('tm_majors as g', 'a.major','=','g.id')
            ->join('tm_phase_registrations as h', 'a.phase','=','h.id')
            ->leftJoin('tm_schools as i', 'a.school','=','i.id')
            ->select('a.email_student as email','a.no_regist','a.name','a.remark','i.name as school_name','a.hp_student','a.hp_parent','f.name as grade','g.name as major','h.name as phase','h.cost as phase_cost')
            ->where([['a.period', $period],['a.no_regist', $no_daf],])
            ->first();
        if($data_daftar->phase_cost == 'Y'){
            $phase_cost = DB::table('tm_cost_registrations')
                ->select('amount')
                ->first();
        }else{
            $phase_cost = null;
        }
        $data_info = DB::table('tm_hotlines as a')
            ->join('tm_hotline_types as b', 'a.type','=','b.id')
            ->select('a.name','b.name as type_name','b.short as type_short','a.lines')
            ->get();
        
        $now = now()->format('Y-m-d');
        $bulan = array (
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
        $pecahkan = explode('-', $now);
        $tanggal = $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];

        $op = Auth::user()->name;

        $pdf = PDF::loadView('operator.regist-pdf',['school'=>$school,'data_daftar'=>$data_daftar,'phase_cost'=>$phase_cost,'data_info'=>$data_info,'tgl'=>$tanggal,'op'=>$op])->setPaper('a5');
        return $pdf->stream('Tanda Terima - '.$data_daftar->no_regist.'.pdf');
        // return view('operator.regist-pdf',['school'=>$school,'data_daftar'=>$data_daftar,'phase_cost'=>$phase_cost,'data_info'=>$data_info]);
    }

    public function edit($id)
    {
        $dataDaftar = DB::table('registrations as a')
                        ->join('familys as b', 'a.id','=','b.id_regist')
                        ->select('a.id','a.email_student as email','a.no_regist','a.name','a.remark','a.school','a.gender','a.religion','a.hp_student as hp','a.hp_parent','b.name as parent','a.grade','a.major','a.phase','a.created_at')
                        ->where('a.id', $id)
                        ->first();
        $si         = DB::table('school_infos')->select('name','icon')->first();
        $phase      = DB::table('tm_phase_registrations')->select('id','name')->where('status','Y')->get();
        $grade      = DB::table('tm_grades')->select('id','name')->get();
        $major      = DB::table('tm_majors')->select('id','name')->get();
        $gender     = DB::table('tm_genders')->select('id','name')->get();
        $religion   = DB::table('tm_religions')->select('id','name')->get();

        return view('operator.regist-edit',['dd'=>$dataDaftar,'si'=>$si,'phase'=>$phase,'grade'=>$grade,'major'=>$major,'gender'=>$gender,'religion'=>$religion]);
    }

    public function update(Request $r)
    {
        $rules = [
            'id'         => 'required|integer',
            'no_regist'  => 'required|string',
            'created_at' => 'required|date_format:d-m-Y',
            'phase'      => 'required|integer',
            'grade'      => 'required|integer',
            'major'      => 'required|integer',
            'name'       => 'required|string',
            'school'     => 'nullable|integer',
            'remark'     => 'nullable|string',
            'email'      => 'required|email',
            'gender'     => 'required|integer',
            'religion'   => 'required|integer',
            'parent'     => 'required|string',
            'hp_parent'  => 'required|string|max:15',
            'hp'         => 'required|string|max:15',
        ];
    
        $messages = [
            'id.required'            => 'ID tidak ada',
            'id.integer'             => 'ID tidak sesuai',
            'no_regist.required'     => 'No. Daftar tidak ada',
            'no_regist.string'       => 'No. Daftar harus berupa string',
            'created_at.required'    => 'Tanggal wajib diisi',
            'created_at.date_format' => 'Tanggal harus berformat dd-mm-yyyy',
            'phase.required'         => 'Gelombang wajib diisi',
            'phase.integer'          => 'Gelombang tidak sesuai pilihan',
            'grade.required'         => 'Kelompok wajib diisi',
            'grade.integer'          => 'Kelompok tidak sesuai pilihan',
            'major.required'         => 'Jurusan wajib diisi',
            'major.integer'          => 'Jurusan tidak sesuai pilihan',
            'name.required'          => 'Nama Lengkap wajib diisi',
            'name.string'            => 'Nama Lengkap harus berupa string',
            'school.integer'         => 'Asal Sekolah Cari tidak sesuai pilihan',
            'remark.string'          => 'Asal Sekolah Ketik harus berupa string',
            'email.required'         => 'Email wajib diisi',
            'email.email'            => 'Email tidak sesuai format',
            'gender.required'        => 'Jenis Kelamin wajib diisi',
            'gender.integer'         => 'Jenis Kelamin tidak sesuai pilihan',
            'religion.required'      => 'Agama wajib diisi',
            'religion.integer'       => 'Agama tidak sesuai pilihan',
            'parent.required'        => 'Nama Lengkap Orangtua wajib diisi',
            'parent.string'          => 'Nama Lengkap Orangtua harus berupa string',
            'hp_parent.required'     => 'No. HP Orangtua wajib diisi',
            'hp_parent.string'       => 'No. HP Orangtua harus berupa string',
            'hp_parent.max'          => 'No. HP Orangtua maksimal 15 karakter',
            'hp.required'            => 'No. HP Siswa wajib diisi',
            'hp.string'              => 'No. HP Siswa harus berupa string',
            'hp.max'                 => 'No. HP Siswa maksimal 15 karakter',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($r->all);
        }

        $id           = $r->input('id');
        $email        = $r->input('email');
        $checkEmail   = DB::table('users')->select('id')->where([['email',$email],['id_regist','!=',$id]])->count();
        if(!empty($checkEmail))
        {
            return redirect()->back()->with('error', 'Email sudah ada');
        }

        $school       = $r->input('school') ?? null;
        $remark       = $r->input('remark') ?? null;

        $noRegist     = $r->input('no_regist');
        $dateAt       = $r->input('created_at');
        $timeAt       = now()->format('H:i:s');
        $createdAt    = $dateAt.' '.$timeAt;
        $createdAtFix = date_format(date_create($createdAt), 'Y-m-d H:i:s');
        $phase        = $r->input('phase');
        $grade        = $r->input('grade');
        $major        = $r->input('major');
        $name         = $r->input('name');
        $gender       = $r->input('gender');
        $religion     = $r->input('religion');
        $parent       = $r->input('parent');
        $hpParent     = $r->input('hp_parent');
        $hp           = $r->input('hp');
        $user         = Auth::user()->email;

        DB::table('registrations')
        ->where('id',$id)
        ->update([
            'grade'         => $grade,
            'major'         => $major,
            'phase'         => $phase,
            'name'          => $name,
            'religion'      => $religion,
            'gender'        => $gender,
            'hp_student'    => $hp,
            'hp_parent'     => $hpParent,
            'email_student' => $email,
            'school'        => $school,
            'remark'        => $remark,
            'user'          => $user,
            'created_at'    => $createdAtFix,
            'updated_at'    => now()
        ]);

        DB::table('familys')
        ->where([['id_regist', $id], ['family_member', 1],])
        ->update([
            'name'       => $parent,
            'updated_at' => now()
        ]);

        DB::table('users')
        ->where('id_regist', $id)
        ->update([
            'id_regist'  => $id,
            'name'       => $name,
            'email'      => $email,
            'updated_at' => now()
        ]);

        return redirect()->route('pendaftaran')->with('success', 'No. Daftar '.$noRegist.' berhasil diperbarui');
    }

    public function destroy($id)
    {
        $rg = DB::table('registrations')->select('no_regist')->where('id', $id)->first();
        DB::table('registrations')->where('id', $id)->delete();
        DB::table('familys')->where('id_regist', $id)->delete();
        DB::table('regist_documents')->where('id_regist', $id)->delete();
        DB::table('users')->where('id_regist', $id)->delete();
        DB::table('tr_registrations')->where('id_regist', $id)->delete();
        DB::table('whatsapps')->where('id_regist', $id)->delete();

        return redirect()->back()->with('success', 'No. Daftar '.$rg->no_regist.' berhasil di hapus');
    }

    public function download(Request $r)
    {
        $period         = $r->input('period_select_d') ?? null;
        $createdFrom    = $r->input('created_from_d');
        $createdTo      = $r->input('created_to_d');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        $data = DB::table('registrations as a')
                ->leftJoin('regist_receives as b', 'a.id','=','b.id_regist')
                ->leftJoin('tm_schools as c', 'a.school','=','c.id')
                ->join('tm_genders as d', 'a.gender','=','d.id')
                ->join('tm_phase_registrations as e', 'a.phase','=','e.id')
                ->join('tm_grades as f', 'a.grade','=','f.id')
                ->join('tm_majors as g', 'a.major','=','g.id')
                ->join('tm_statuss as h', 'a.status','=','h.id')
                ->select('a.period','a.no_regist','h.name as status','f.name as grade','g.name as major','e.name as phase','a.name','d.name as gender',
                    'c.name as school_name','a.user','a.created_at','a.updated_at','b.created_at as receive_created_at');
        if($period) 
        {
            $data = $data->where('a.period',$period);    
        }
        $data = $data->whereBetween('a.created_at', [$createdFormFix, $createdToFix])->get();

        return Excel::download(new RegistExport($data,$createdFrom,$createdTo), 'Pendaftaran_'.$createdFrom.'_'.$createdTo.'.xlsx');
    }

    public function download_all(Request $r)
    {
        $period         = $r->input('period_select_d') ?? null;
        $createdFrom    = $r->input('created_from_d');
        $createdTo      = $r->input('created_to_d');
        $createdFormFix = date_format(date_create($createdFrom), 'Y-m-d');
        $createdToFix   = date_format(date_create($createdTo), 'Y-m-d');

        $data = DB::table('registrations as a')
                ->leftJoin('regist_receives as b', 'a.id','=','b.id_regist')
                ->leftJoin('tm_schools as c', 'a.school','=','c.id')
                ->leftJoin('tm_genders as d', 'a.gender','=','d.id')
                ->join('tm_phase_registrations as e', 'a.phase','=','e.id')
                ->join('tm_grades as f', 'a.grade','=','f.id')
                ->join('tm_majors as g', 'a.major','=','g.id')
                ->join('tm_statuss as h', 'a.status','=','h.id')
                ->leftJoin('tm_religions as i', 'a.religion','=','i.id')
                ->leftJoin('tm_citizens as j', 'a.citizen','=','j.id')
                ->leftJoin('tm_familystatuss as k', 'a.family_status','=','k.id')
                ->leftJoin('tm_bloods as l', 'a.blood','=','l.id')
                ->leftJoin('tm_transports as m', 'a.transport','=','m.id')
                ->leftJoin('tm_stays as n', 'a.stay','=','n.id')
                ->leftJoin('tm_districs as o', 'a.stay_distric','=','o.id')
                ->leftJoin('tm_citys as p', 'a.stay_city','=','p.id')
                ->leftJoin('tm_provinces as q', 'a.stay_province','=','q.id')
                ->leftJoin('tm_districs as r', 'a.home_distric','=','r.id')
                ->leftJoin('tm_citys as s', 'a.home_city','=','s.id')
                ->leftJoin('tm_provinces as t', 'a.home_province','=','t.id')
                ->select('a.period','a.no_regist','h.name as status','f.name as grade','g.name as major','e.name as phase','a.name','a.nickname','a.place','a.birthday',
                    'i.name as religion','d.name as gender','j.name as citizen','a.birthday_id','a.family_id','a.kip','a.pip','a.kps','a.kps_id','k.name as family_status',
                    'a.child_no','a.child_qty','l.name as blood','a.glass','a.height','a.weight','a.head_size','a.distance','a.time_hh','a.time_mm','m.name as transport',
                    'n.name as stay','a.stay_rt','a.stay_rw','a.stay_village','o.name as stay_distric','p.name as stay_city','q.name as stay_province','a.stay_address',
                    'a.stay_postal','a.stay_latitude','a.stay_longitude','a.home_rt','a.home_rw','a.home_village','r.name as home_distric','s.name as home_city',
                    't.name as home_province','a.home_address','a.home_postal','a.home_latitude','a.home_longitude','a.id_card','a.hp_student','a.hp_parent','a.hp_parent2',
                    'a.email_student','a.email_parent','a.email_parent2','c.name as school_name','a.school_year','a.school_nem_avg','a.school_sttb_avg','a.nisn','a.exam_un_no',
                    'a.skhun_no','a.certificate_no','a.no_account','a.no_account2','a.remark','a.user','a.created_at','a.updated_at','b.created_at as receive_created_at');
        if($period) 
        {
            $data = $data->where('a.period',$period);    
        }
        $data = $data->whereBetween('a.created_at', [$createdFormFix, $createdToFix])->get();

        return Excel::download(new RegistAllExport($data,$createdFrom,$createdTo), 'Pendaftaran_All_'.$createdFrom.'_'.$createdTo.'.xlsx');
    }
}
