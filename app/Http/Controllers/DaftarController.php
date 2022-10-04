<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;    
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Swift_TransportException;
use Exception;

class DaftarController extends Controller
{
    public function index()
    {
        $jobs      = DB::table('tm_jobs')->select('id','name')->get();
        $religions = DB::table('tm_religions')->select('id','name')->get();
        $grades    = DB::table('tm_grades')->select('id','name')->get();
        $majors    = DB::table('tm_majors')->select('id','name')->get();
        $genders   = DB::table('tm_genders')->select('id','name')->get();
        $si        = DB::table('school_infos')->select('name','icon')->first();
        $sisosmed  = DB::table('school_info_sosmeds')->select('name','url','icon')->get();
        return view('daftar',['jobs' => $jobs, 'religions' => $religions, 'grades' => $grades, 'majors' => $majors, 'genders' => $genders, 'si' => $si, 'sisosmed' => $sisosmed]);
    }

    public function store(Request $r)
    {
        if($r->hasFile('photo')){
            if($r->file('photo')->isValid()){
                $rules = [
                    'email'        => 'required|email|unique:users',
                    'password'     => 'required|min:6',
                    'name'         => 'required|string',
                    'nisn'         => 'required|string',
                    'place'        => 'required|string',
                    'birthday'     => 'required|string',
                    'gender'       => 'required|string',
                    'religion'     => 'required|string',
                    'parent_name'  => 'required|string',
                    'parent_job'   => 'required|string',
                    'stay_address' => 'required|string',
                    'remark'       => 'required|string',
                    'hp_student'   => 'required|string',
                    'hp_parent'    => 'required|string',
                    'grade'        => 'required|string',
                    'major'        => 'required|string',
                    'photo'        => 'required|image|max:1024',
                ];            
                $messages = [
                    'email.required'        => 'Email wajib diisi',
                    'email.email'           => 'Format email tidak sesuai',
                    'email.unique'          => 'Email sudah ada',
                    'password.required'     => 'Password wajib diisi',
                    'password.min'          => 'Password minimal 6 huruf/digit',
                    'name.required'         => 'Nama Lengkap wajib diisi',
                    'name.string'           => 'Nama Lengkap harus berupa string',
                    'nisn.required'         => 'NISN wajib diisi',
                    'nisn.string'           => 'NISN harus berupa string',
                    'place.required'        => 'Tempat Lahir wajib diisi',
                    'place.string'          => 'Tempat Lahir harus berupa string',
                    'birthday.required'     => 'Tanggal Lahir wajib diisi',
                    'birthday.string'       => 'Tanggal Lahir harus berupa string',
                    'gender.required'       => 'Jenis Kelamin wajib diisi',
                    'gender.string'         => 'Jenis Kelamin harus berupa string',
                    'religion.required'     => 'Agama wajib diisi',
                    'religion.string'       => 'Agama harus berupa string',
                    'parent_name.required'  => 'Nama Lengkap Orangtua wajib diisi',
                    'parent_name.string'    => 'Nama Lengkap Orangtua harus berupa string',
                    'parent_job.required'   => 'Pekerjaan Orangtua wajib diisi',
                    'parent_job.string'     => 'Pekerjaan Orangtua harus berupa string',
                    'stay_address.required' => 'Alamat Tinggal wajib diisi',
                    'stay_address.string'   => 'Alamat Tinggal harus berupa string',
                    'remark.required'       => 'Asal Sekolah wajib diisi',
                    'remark.string'         => 'Asal Sekolah harus berupa string',
                    'hp_student.required'   => 'No. HP Siswa wajib diisi',
                    'hp_student.string'     => 'No. HP Siswa harus berupa string',
                    'hp_parent.required'    => 'No. HP Orangtua wajib diisi',
                    'hp_parent.string'      => 'No. HP Orangtua harus berupa string',
                    'grade.required'        => 'Kelompok wajib diisi',
                    'grade.string'          => 'Kelompok harus berupa string',
                    'major.required'        => 'Program Peminatan wajib diisi',
                    'major.string'          => 'Program Peminatan harus berupa string',
                    'photo.required'        => 'Photo wajib diisi',
                    'photo.image'           => 'Photo harus berekstensi jpg, jpeg',
                    'photo.max'             => 'Photo maksimal 1MB'
                ];
          
                $validator = Validator::make($r->all(), $rules, $messages);

                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput($r->all);
                }

                $nohp_double = DB::table('registrations')
                    ->select('id')
                    ->where('hp_student', $r->hp_student)
                    ->count();

                if($nohp_double===0){
                    $phase      = DB::table('tm_phase_registrations')->select('id','cost')->where('status', 'Y')->first();
                    $phase_amount = DB::table('tm_cost_registrations')->select('amount')->where('phase', $phase->id)->first();
                    if($phase->cost === 'Y' && empty($phase_amount)){
                        return back()->with('error','Pendaftaran Gagal! Nominal pembayaran Belum di buat! Hubungi Administrator!')->withInput($r->all);
                    }
                    $period     = DB::table('tm_periods')->select('period')->where('status', 'Y')->first();
                    $No_Daf_x   = DB::table('registrations')->where('period', $period->period)->max('no_regist');
                    $No_Daf     = $No_Daf_x + 1;
                    $No_Daf_str = str_pad($No_Daf, 4, "0", STR_PAD_LEFT);
                    
                    $photo               = $r->file('photo');
                    $nama_photox         = $photo->getClientOriginalName();
                    $image_info          = explode(".", $nama_photox); 
                    $ext                 = end($image_info);
                    $user                = $period->period.$No_Daf_str;
                    $nama_photo          = $user.".".$ext;
                    $tujuan_upload_photo = 'images/photo/'.$period->period;
                    if(!file_exists($tujuan_upload_photo)) {
                        mkdir($tujuan_upload_photo, 0777, true);
                    }
                    if(!file_exists($tujuan_upload_photo)) {
                        return back()->with('error','Pendaftaran Gagal! Directory cannot be created! Silahkan hubungi Administrator!'); 
                    }
                    $photo->move($tujuan_upload_photo,$nama_photo);
                    
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

                    if($phase->cost === 'Y'){
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
                        'grade'         => $r->grade,
                        'major'         => $r->major,
                        'phase'         => $phase->id,
                        'name'          => $r->name,
                        'place'         => $r->place,
                        'birthday'      => $r->birthday,
                        'religion'      => $r->religion,
                        'gender'        => $r->gender,
                        'stay_address'  => $r->stay_address,
                        'hp_student'    => $r->hp_student,
                        'hp_parent'     => $r->hp_parent,
                        'email_student' => $r->email,
                        'nisn'          => $r->nisn,
                        'photo'         => $nama_photo,
                        'no_account'    => $AccountNo,
                        'no_account2'   => $AccountNo2,
                        'remark'        => $r->remark,
                        'user'          => $user,
                        'created_at'    => now()
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
                            'name'       => $r->parent_name,
                            'job'        => $r->parent_job,
                            'updated_at' => now()
                        ]);

                    DB::table('users')->insert([
                        'id_regist'  => $regist->id,
                        'name'       => $r->name,
                        'email'      => $r->email,
                        'password'   => Hash::make($r->password),
                        'created_at' => now()
                    ]);

                    if($phase->cost === 'Y'){
                        DB::table('tr_registrations')->insert([
                            'id_regist'  => $regist->id,
                            'amount'     => $phase_amount->amount,
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
                        ->join('tm_jobs as h', 'g.job','=','h.id')
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

                    try{
                        Mail::to($r->email)->send(new RegistrationMail($mail_regist, $mail_school_info, $mail_hotline));
                    } catch (Swift_TransportException $e) {
                        $res = $e->getMessage();
                        DB::table('emails')->insert(['id_regist' => $regist->id, 'type' => 'RegistOnline', 'response' => $res, 'created_at' => now()]);
                    } catch (Exception $e) {
                        $res = $e->getMessage();
                        DB::table('emails')->insert(['id_regist' => $regist->id, 'type' => 'RegistOnline', 'response' => $res, 'created_at' => now()]);
                    }

                    if(!empty($mail_school_info->wa_api)) {
                        $email             = $r->email;
                        $accountNo         = $AccountNo;
                        $gelombang         = $mail_regist->phase;
                        $nama              = $r->name;
                        $nisn              = $r->nisn;
                        $alamat            = $r->stay_address;
                        $smp               = $r->remark;
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
                        $regist_wa_message = preg_replace("/%nisn%/i", $nisn, $regist_wa_message);
                        $regist_wa_message = preg_replace("/%alamat%/i", $alamat, $regist_wa_message);
                        $regist_wa_message = preg_replace("/%smp%/i", $smp, $regist_wa_message);
                        $regist_wa_message = preg_replace("/%kelompok%/i", $kelompok, $regist_wa_message);
                        $regist_wa_message = preg_replace("/%jurusan%/i", $jurusan, $regist_wa_message);
                        $regist_wa_message = preg_replace("/%url%/i", $url, $regist_wa_message);
                        $regist_wa_message = preg_replace("/%alamat_sekolah%/i", $alamat_sekolah, $regist_wa_message);
                        $regist_wa_message = preg_replace("/%hotline1%/i", $hotline1, $regist_wa_message);
                        $url = $mail_school_info->wa_api;
                        $key = $mail_school_info->wa_api_key;
                        $data = array(
                        "phone_no" => $r->hp_parent,
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
                        DB::table('whatsapps')->insert(['id_regist' => $regist->id, 'type' => 'RegistOnline', 'response' => $res, 'created_at' => now()]);
                        curl_close($ch);
                    }
                    
                    $cryptPeriod = Crypt::encryptString($period->period);
                    $cryptNoDaf  = Crypt::encryptString($No_Daf_str);
                    return redirect('cetak-pdf/'.$cryptPeriod.'/'.$cryptNoDaf);
                }else{
                    return back()->with('error','Pendaftaran Gagal! Nomor HP Siswa Sudah Ada!')->withErrors(['hp_student'=>'No. HP Siswa sudah ada'])->withInput($r->all);
                }
            }else{
                return back()->with('error','Pendaftaran Gagal! File Corrupt! Silahkan ganti file photo anda!')->withErrors(['photo'=>'Silahkan ganti file photo anda'])->withInput($r->all);
            }
        }else{
            return back()->with('error','Pendaftaran Gagal! Silahkan Upload ulang Photo Anda!')->withErrors(['photo'=>'Silahkan upload ulang photo anda'])->withInput($r->all);
        }
    }

    public function cetak_pdf($crypt_period, $crypt_no_daf)
    {
        try {
            $period = Crypt::decryptString($crypt_period);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Periode Tidak Sesuai');
        }
        try {
            $no_daf = Crypt::decryptString($crypt_no_daf);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Nomor Daftar Tidak Sesuai');
        }
        $school = DB::table('school_infos')
            ->select('name','school_year','letter_head','regist_pdf_message_top','regist_pdf_message_bottom')
            ->first();
        $data_daftar = DB::table('registrations as a')
            ->join('tm_genders as b', 'a.gender','=','b.id')
            ->join('tm_religions as c', 'a.religion','=','c.id')
            ->join('familys as d', 'a.id','=','d.id_regist')
            ->join('tm_jobs as e', 'd.job','=','e.id')
            ->join('tm_grades as f', 'a.grade','=','f.id')
            ->join('tm_majors as g', 'a.major','=','g.id')
            ->join('tm_phase_registrations as h', 'a.phase','=','h.id')
            ->select('a.email_student as email','a.period','a.no_regist','a.name','a.nisn','a.place','a.birthday','b.name as gender','c.name as religion','d.name as parent_name','e.name as parent_job','a.stay_address','a.remark','a.school','a.hp_student','a.hp_parent','f.name as grade','g.name as major','h.name as phase','h.cost as phase_cost','h.id as phase_id','a.photo','a.no_account')
            ->where([['a.period', $period],['a.no_regist', $no_daf],['d.family_member', 1],])
            ->first();
        if($data_daftar->phase_cost == 'Y'){
            $phase_cost = DB::table('tm_cost_registrations')
                ->select('amount')
                ->first();
            $startDate = time();
            $date_day  = date('Y-m-d', strtotime('+1 day', $startDate));
            $date_hour = date('H:i', strtotime('+1 day', $startDate));
        }else{
            $phase_cost = null;
            $date_day   = null;
            $date_hour  = null;
        }
        $data_info = DB::table('tm_hotlines as a')
            ->join('tm_hotline_types as b', 'a.type','=','b.id')
            ->select('a.name','b.name as type_name','b.short as type_short','a.lines')
            ->get();
        $data_info1 = DB::table('tm_hotlines as a')
            ->join('tm_hotline_types as b', 'a.type','=','b.id')
            ->select('a.name','b.name as type_name','b.short as type_short','a.lines')
            ->first();
        $pdf = PDF::loadView('daftar_pdf',['school'=>$school,'data_daftar'=>$data_daftar,'data_info'=>$data_info,'data_info1'=>$data_info1,'phase_cost'=>$phase_cost,'date_day'=>$date_day,'date_hour'=>$date_hour]);
        return $pdf->stream('Bukti Daftar - '.$data_daftar->no_regist.'.pdf');
    }
}
