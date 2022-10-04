<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BiodataController extends Controller
{
    public function index()
    {
        $si               = DB::table('school_infos')->select('name','icon')->first();
        $religion         = DB::table('tm_religions')->select('id','name')->get();
        $gender           = DB::table('tm_genders')->select('id','name')->get();
        $citizen          = DB::table('tm_citizens')->select('id','name')->get();
        $blood            = DB::table('tm_bloods')->select('id','name')->get();
        $transport        = DB::table('tm_transports')->select('id','name')->get();
        $stay             = DB::table('tm_stays')->select('id','name')->get();
        $education        = DB::table('tm_educations')->select('id','name')->get();
        $job              = DB::table('tm_jobs')->select('id','name')->get();
        $income           = DB::table('tm_incomes')->select('id','name')->get();
        $dead             = DB::table('tm_deads')->select('id_job')->first();
        $achievementGroup = DB::table('tm_achievementgroups')->select('id','name')->get();
        $achievementRank  = DB::table('tm_achievementranks')->select('id','name')->get();
        $achievementLevel = DB::table('tm_achievementlevels')->select('id','name')->get();
        $datapribadi      = DB::table('registrations')
                            ->select('name','nickname','place','birthday','birthday_id','family_id','id_card','child_no','child_qty','height','weight',
                                'head_size','distance','time_hh','time_mm','religion','gender','citizen','blood','transport','glass','created_at','updated_at')
                            ->where('id', Auth::user()->id_regist)
                            ->first();
        $alamat           = DB::table('registrations as a')
                            ->leftJoin('tm_provinces as b', 'a.stay_province','=','b.id')
                            ->leftJoin('tm_provinces as c', 'a.home_province','=','c.id')
                            ->leftJoin('tm_citys as d', 'a.stay_city','=','d.id')
                            ->leftJoin('tm_citys as e', 'a.home_city','=','e.id')
                            ->leftJoin('tm_districs as f', 'a.stay_distric','=','f.id')
                            ->leftJoin('tm_districs as g', 'a.home_distric','=','g.id')
                            ->select('b.name as stay_province_desc','c.name as home_province_desc','d.name as stay_city_desc','e.name as home_city_desc',
                                'f.name as stay_distric_desc','g.name as home_distric_desc','a.stay_village','a.home_village','a.stay_rt','a.home_rt',
                                'a.stay_rw','a.home_rw','a.stay_postal','a.home_postal','a.stay','a.stay_address','a.home_address','a.stay_latitude','a.home_latitude',
                                'a.stay_longitude','a.home_longitude','a.hp_student','a.hp_parent','a.hp_parent2','a.email_student','a.email_parent','a.email_parent2')
                            ->where('a.id', Auth::user()->id_regist)
                            ->first();
        $asalsekolah      = DB::table('registrations as a')
                            ->leftJoin('tm_schools as b', 'a.school','=','b.id')
                            ->leftJoin('tm_provinces as c', 'b.code_province','=','c.code')
                            ->leftJoin('tm_citys as d', 'b.code_city','=','d.code')
                            ->leftJoin('tm_districs as e', 'b.code_distric','=','e.code')
                            ->select('b.name as school_name', 'b.address as school_address', 'b.status as school_status', 'c.name as school_province', 
                                'd.name as school_city', 'e.name as school_distric', 'a.remark', 'a.school_year', 'a.nisn', 'a.school_nem_avg', 'a.school_sttb_avg', 
                                'a.exam_un_no', 'a.skhun_no', 'a.certificate_no')
                            ->where('a.id', Auth::user()->id_regist)
                            ->first();
        $orangtua         = DB::table('familys as a')
                            ->join('registrations as b', 'a.id_regist','=','b.id')
                            ->join('tm_familymembers as c', 'a.family_member','=','c.id')
                            ->select('a.id', 'c.name as family_name', 'a.name', 'a.place', 'a.birthday', 'a.id_card', 'a.religion', 'a.education', 'a.job', 
                                'a.income', 'a.remark', 'a.created_at', 'a.updated_at')
                            ->where('b.id', Auth::user()->id_regist)
                            ->get();
        $lampiran         = DB::table('regist_documents as a')
                            ->join('registrations as b', 'a.id_regist','=','b.id')
                            ->join('tm_regist_documents as c', 'a.document','=','c.id')
                            ->select('a.id', 'a.name', 'b.period', 'c.name as document_name', 'a.status', 'a.updated_at')
                            ->where('b.id', Auth::user()->id_regist)
                            ->get();
        $prestasi         = DB::table('achievements as a')
                            ->join('registrations as b', 'a.id_regist','=','b.id')
                            ->join('tm_achievementgroups as c', 'a.group','=','c.id')
                            ->join('tm_achievementranks as d', 'a.rank','=','d.id')
                            ->join('tm_achievementlevels as e', 'a.level','=','e.id')
                            ->select('a.id', 'a.group', 'c.name as group_name', 'a.name', 'a.rank', 'd.name as rank_name', 'a.level', 'e.name as level_name', 
                            'a.year', 'a.remark', 'a.created_at', 'a.updated_at')
                            ->where('b.id', Auth::user()->id_regist)
                            ->get();
                        
        return view('student.biodata',['si'=>$si, 'religion'=>$religion, 'gender'=>$gender, 'citizen'=>$citizen, 'blood'=>$blood, 
            'transport'=>$transport, 'stay'=>$stay, 'education'=>$education, 'job'=>$job, 'income'=>$income, 'dead'=>$dead, 'achievementGroup'=>$achievementGroup, 
            'achievementRank'=>$achievementRank, 'achievementLevel'=>$achievementLevel, 'dp'=>$datapribadi, 'al'=>$alamat, 'as'=>$asalsekolah, 'orangtua'=>$orangtua, 
            'lampiran'=>$lampiran, 'prestasi'=>$prestasi]);
    }

    public function personaldata_store(Request $r)
    {
        $rules = [
            'name'        => 'required|string',
            'nickname'    => 'nullable|string|max:50',
            'place'       => 'required|string|max:150',
            'birthday'    => 'required|date_format:Y-m-d',
            'birthday_id' => 'nullable|string|max:50',
            'family_id'   => 'nullable|string|max:50',
            'id_card'     => 'nullable|string|max:50',
            'child_no'    => 'nullable|integer',
            'child_qty'   => 'nullable|integer',
            'height'      => 'nullable|integer',
            'weight'      => 'nullable|integer',
            'head_size'   => 'nullable|integer',
            'distance'    => 'nullable|numeric',
            'time_hh'     => 'nullable|integer',
            'time_mm'     => 'nullable|integer',
            'religion'    => 'required|integer',
            'gender'      => 'required|integer',
            'citizen'     => 'nullable|integer',
            'blood'       => 'nullable|integer',
            'transport'   => 'nullable|integer',
            'glass'       => 'nullable|in:Y,N',
        ];
    
        $messages = [
            'name.required'        => 'Nama Lengkap wajib diisi',
            'name.string'          => 'Nama Lengkap harus berupa string',
            'nickname.string'      => 'Nama Panggilan harus berupa string',
            'nickname.max'         => 'Nama Panggilan maksimal 50 karakter',
            'place.required'       => 'Tempat Lahir wajib diisi',
            'place.string'         => 'Tempat Lahir harus berupa string',
            'place.max'            => 'Tempat Lahir maksimal 150 karakter',
            'birthday.required'    => 'Tanggal Lahir wajib diisi',
            'birthday.date_format' => 'Tanggal Lahir harus berformat yyyy-mm-dd',
            'birthday_id.string'   => 'No. Akta Lahir harus berupa string',
            'birthday_id.max'      => 'No. Akta Lahir maksimal 50 karakter',
            'family_id.string'     => 'No. KK harus berupa string',
            'family_id.max'        => 'No. KK maksimal 50 karakter',
            'id_card.string'       => 'No. NIK harus berupa string',
            'id_card.max'          => 'No. NIK maksimal 50 karakter',
            'child_no.integer'     => 'Anak Ke- harus berupa bilangan bulat',
            'child_qty.integer'    => 'Jumlah Saudara harus berupa bilangan bulat',
            'height.integer'       => 'Tinggi Badan harus berupa bilangan bulat',
            'weight.integer'       => 'Berat Badan harus berupa bilangan bulat',
            'head_size.integer'    => 'Lingkar Kepala harus berupa bilangan bulat',
            'distance.numeric'     => 'Jarak Tempat Tinggal harus berupa angka',
            'time_hh.integer'      => 'Waktu Tempuh (jam) harus berupa bilangan bulat',
            'time_mm.integer'      => 'Waktu Tempuh (menit) harus berupa bilangan bulat',
            'religion.required'    => 'Agama wajib diisi',
            'religion.integer'     => 'Agama harus sesuai list pilihan',
            'gender.required'      => 'Jenis Kelamin wajib diisi',
            'gender.integer'       => 'Jenis Kelamin harus sesuai list pilihan',
            'citizen.integer'      => 'Kewarganegaraan harus sesuai list pilihan',
            'blood.integer'        => 'Golongan Darah harus sesuai list pilihan',
            'transport.integer'    => 'Transportasi harus sesuai list pilihan',
            'glass.integer'        => 'Kacamata harus sesuai list pilihan',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $name        = $r->input('name');
        $nickname    = $r->input('nickname');
        $place       = $r->input('place');
        $birthday    = $r->input('birthday');
        $birthday_id = $r->input('birthday_id');
        $family_id   = $r->input('family_id');
        $id_card     = $r->input('id_card');
        $child_no    = $r->input('child_no');
        $child_qty   = $r->input('child_qty');
        $height      = $r->input('height');
        $weight      = $r->input('weight');
        $head_size   = $r->input('head_size');
        $distance    = $r->input('distance');
        $time_hh     = $r->input('time_hh');
        $time_mm     = $r->input('time_mm');
        $religion    = $r->input('religion');
        $gender      = $r->input('gender');
        $citizen     = $r->input('citizen');
        $blood       = $r->input('blood');
        $transport   = $r->input('transport');
        $glass       = $r->input('glass');

        $user = DB::table('registrations')
                ->select('period','no_regist')
                ->where('id_regist', Auth::user()->id_regist)
                ->first();

        DB::table('registrations')
        ->where('id', Auth::user()->id_regist)
        ->update([
            'name'        => $name,
            'nickname'    => $nickname,
            'place'       => $place,
            'birthday'    => $birthday,
            'birthday_id' => $birthday_id,
            'family_id'   => $family_id,
            'id_card'     => $id_card,
            'child_no'    => $child_no,
            'child_qty'   => $child_qty,
            'height'      => $height,
            'weight'      => $weight,
            'head_size'   => $head_size,
            'distance'    => $distance,
            'time_hh'     => $time_hh,
            'time_mm'     => $time_mm,
            'religion'    => $religion,
            'gender'      => $gender,
            'citizen'     => $citizen,
            'blood'       => $blood,
            'transport'   => $transport,
            'glass'       => $glass,
            'user'        => $user->period.$user->no_regist,
            'updated_at'  => now()
        ]);
        
        return redirect()->back()->with('success', 'Data Pribadi berhasil di update');
    }

    public function address_store(Request $r)
    {
        $rules = [
            'stay_village'   => 'nullable|string',
            'stay_rt'        => 'nullable|string',
            'stay_rw'        => 'nullable|string',
            'stay_postal'    => 'nullable|string',
            'stay_address'   => 'required|string',
            'stay_latitude'  => 'nullable|string',
            'stay_longitude' => 'nullable|string',
            'home_village'   => 'nullable|string',
            'home_rt'        => 'nullable|string',
            'home_rw'        => 'nullable|string',
            'home_postal'    => 'nullable|string',
            'home_address'   => 'nullable|string',
            'home_latitude'  => 'nullable|string',
            'home_longitude' => 'nullable|string',
            'stay'           => 'nullable|integer',
            'hp_student'     => 'required|string|max:20',
            'hp_parent'      => 'required|string|max:20',
            'hp_parent2'     => 'nullable|string|max:20',
            'email_parent'   => 'nullable|string',
            'email_parent2'  => 'nullable|string',
        ];
    
        $messages = [
            'stay_village.string'   => 'Kelurahan (Alamat Tinggal) harus berupa string',
            'stay_rt.string'        => 'RT (Alamat Tinggal) harus berupa string',
            'stay_rw.string'        => 'RW (Alamat Tinggal) harus berupa string',
            'stay_postal.string'    => 'Kode Pos (Alamat Tinggal) harus berupa string',
            'stay_address.required' => 'Alamat (Alamat Tinggal) wajib diisi',
            'stay_address.string'   => 'Alamat (Alamat Tinggal) harus berupa string',
            'stay_latitude.string'  => 'Garis Lintang (Alamat Tinggal) harus berupa string',
            'stay_longitude.string' => 'Garis Bujur (Alamat Tinggal) harus berupa string',
            'home_village.string'   => 'Kelurahan (Alamat Rumah) harus berupa string',
            'home_rt.string'        => 'RT (Alamat Rumah) harus berupa string',
            'home_rw.string'        => 'RW (Alamat Rumah) harus berupa string',
            'home_postal.string'    => 'Kode Pos (Alamat Rumah) harus berupa string',
            'home_address.string'   => 'Alamat (Alamat Rumah) harus berupa string',
            'home_latitude.string'  => 'Garis Lintang (Alamat Rumah) harus berupa string',
            'home_longitude.string' => 'Garis Bujur (Alamat Rumah) harus berupa string',
            'stay.integer'          => 'Jenis Tinggal harus sesuai list pilihan',
            'hp_student.required'   => 'No. HP Siswa wajib diisi',
            'hp_student.string'     => 'No. HP Siswa harus berupa string',
            'hp_student.max'        => 'No. HP Siswa maksimal 20 karakter',
            'hp_parent.required'    => 'No. HP Ayah wajib diisi',
            'hp_parent.string'      => 'No. HP Ayah harus berupa string',
            'hp_parent.max'         => 'No. HP Ayah maksimal 20 karakter',
            'hp_parent2.string'     => 'No. HP Ibu harus berupa string',
            'hp_parent2.max'        => 'No. HP Ibu maksimal 20 karakter',
            'email_parent.string'   => 'Email Ayah harus berupa string',
            'email_parent2.string'  => 'Email Ibu harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('biodatatab', 'address');
        }

        $stay_village   = $r->input('stay_village');
        $stay_rt        = $r->input('stay_rt');
        $stay_rw        = $r->input('stay_rw');
        $stay_postal    = $r->input('stay_postal');
        $stay_address   = $r->input('stay_address');
        $stay_latitude  = $r->input('stay_latitude');
        $stay_longitude = $r->input('stay_longitude');
        $home_village   = $r->input('home_village');
        $home_rt        = $r->input('home_rt');
        $home_rw        = $r->input('home_rw');
        $home_postal    = $r->input('home_postal');
        $home_address   = $r->input('home_address');
        $home_latitude  = $r->input('home_latitude');
        $home_longitude = $r->input('home_longitude');
        $stay           = $r->input('stay');
        $hp_student     = $r->input('hp_student');
        $hp_parent      = $r->input('hp_parent');
        $hp_parent2     = $r->input('hp_parent2');
        $email_parent   = $r->input('email_parent');
        $email_parent2  = $r->input('email_parent2');

        $user = DB::table('registrations')
                ->select('period','no_regist')
                ->where('id_regist', Auth::user()->id_regist)
                ->first();

        DB::table('registrations')
        ->where('id', Auth::user()->id_regist)
        ->update([
            'stay_village'   => $stay_village,
            'stay_rt'        => $stay_rt,
            'stay_rw'        => $stay_rw,
            'stay_postal'    => $stay_postal,
            'stay_address'   => $stay_address,
            'stay_latitude'  => $stay_latitude,
            'stay_longitude' => $stay_longitude,
            'home_village'   => $home_village,
            'home_rt'        => $home_rt,
            'home_rw'        => $home_rw,
            'home_postal'    => $home_postal,
            'home_address'   => $home_address,
            'home_latitude'  => $home_latitude,
            'home_longitude' => $home_longitude,
            'stay'           => $stay,
            'hp_student'     => $hp_student,
            'hp_parent'      => $hp_parent,
            'hp_parent2'     => $hp_parent2,
            'email_parent'   => $email_parent,
            'email_parent2'  => $email_parent2,
            'user'           => $user->period.$user->no_regist,
            'updated_at'     => now()
        ]);

        return redirect()->back()->with('success', 'Alamat berhasil di update')->with('biodatatab', 'address');
    }

    public function school_store(Request $r)
    {
        $rules = [
            'remark'          => 'nullable|string',
            'school_year'     => 'nullable|integer',
            'nisn'            => 'required|string|max:20',
            'school_nem_avg'  => 'nullable|numeric',
            'school_sttb_avg' => 'nullable|numeric',
            'exam_un_no'      => 'nullable|string|max:30',
            'skhun_no'        => 'nullable|string|max:30',
            'certificate_no'  => 'nullable|string|max:30',
        ];
    
        $messages = [
            'remark.string'           => 'Keterangan harus berupa string',
            'school_year.integer'     => 'Penulisan Tahun tidak sesuai',
            'nisn.required'           => 'NISN wajib diisi',
            'nisn.string'             => 'NISN harus berupa string',
            'nisn.max'                => 'NISN maksimal 20 karakter',
            'school_nem_avg.numeric'  => 'Nilai Rata2 NEM harus berupa angka',
            'school_sttb_avg.numeric' => 'Nilai Rata2 STTB harus berupa angka',
            'exam_un_no.string'       => 'No. Peserta UN harus berupa string',
            'exam_un_no.max'          => 'No. Peserta UN maksimal 30 karakter',
            'skhun_no.string'         => 'No. SKHUN harus berupa string',
            'skhun_no.max'            => 'No. SKHUN maksimal 30 karakter',
            'certificate_no.string'   => 'No. Ijazah harus berupa string',
            'certificate_no.max'      => 'No. Ijazah maksimal 30 karakter',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('biodatatab', 'school');
        }

        $remark          = $r->input('remark');
        $school_year     = $r->input('school_year');
        $nisn            = $r->input('nisn');
        $school_nem_avg  = $r->input('school_nem_avg');
        $school_sttb_avg = $r->input('school_sttb_avg');
        $exam_un_no      = $r->input('exam_un_no');
        $skhun_no        = $r->input('skhun_no');
        $certificate_no  = $r->input('certificate_no');

        $user = DB::table('registrations')
                ->select('period','no_regist')
                ->where('id_regist', Auth::user()->id_regist)
                ->first();

        DB::table('registrations')
        ->where('id', Auth::user()->id_regist)
        ->update([
            'remark'          => $remark,
            'school_year'     => $school_year,
            'nisn'            => $nisn,
            'school_nem_avg'  => $school_nem_avg,
            'school_sttb_avg' => $school_sttb_avg,
            'exam_un_no'      => $exam_un_no,
            'skhun_no'        => $skhun_no,
            'certificate_no'  => $certificate_no,
            'user'            => $user->period.$user->no_regist,
            'updated_at'      => now()
        ]);
        
        return redirect()->back()->with('success', 'Asal Sekolah berhasil di update')->with('biodatatab', 'school');
    }

    public function parent_store(Request $r)
    {
        $family_id = $r->input('family_id');
        if(empty($family_id)){
            return redirect()->back()->with('error', 'Terdapat Kesalahan')->with('biodatatab', 'parent');
        }

        $name_f      = 'name_'.$family_id;
        $place_f     = 'place_'.$family_id;
        $birthday_f  = 'birthday_'.$family_id;
        $id_card_f   = 'id_card_'.$family_id;
        $religion_f  = 'religion_'.$family_id;
        $education_f = 'education_'.$family_id;
        $job_f       = 'job_'.$family_id;
        $income_f    = 'income_'.$family_id;
        $remark_f    = 'remark_'.$family_id;

        $rules = [
            $name_f      => 'nullable|string',
            $place_f     => 'nullable|string|max:150',
            $birthday_f  => 'nullable|date_format:Y-m-d',
            $id_card_f   => 'nullable|string|max:100',
            $religion_f  => 'nullable|integer',
            $education_f => 'nullable|integer',
            $job_f       => 'nullable|integer',
            $income_f    => 'nullable|integer',
            $remark_f    => 'nullable|string',
        ];
    
        $messages = [
            $name_f.'.string'          => 'Nama Lengkap harus berupa string',
            $place_f.'.string'         => 'Tempat Lahir harus berupa string',
            $place_f.'.max'            => 'Tempat Lahir maksimal 150 karakter',
            $birthday_f.'.date_format' => 'Tanggal Lahir harus berformat yyyy-mm-dd',
            $id_card_f.'.string'       => 'NIK harus berupa string',
            $id_card_f.'.max'          => 'NIK maksimal 100 karakter',
            $religion_f.'.integer'     => 'Agama harus sesuai list pilihan',
            $education_f.'.integer'    => 'Pendidikan harus sesuai list pilihan',
            $job_f.'.integer'          => 'Pekerjaan harus sesuai list pilihan',
            $income_f.'.integer'       => 'Penghasilan harus sesuai list pilihan',
            $remark_f.'.string'        => 'Keterangan harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('biodatatab', 'parent');
        }

        $name      = $r->input($name_f);
        $place     = $r->input($place_f);
        $birthday  = $r->input($birthday_f);
        $id_card   = $r->input($id_card_f);
        $religion  = $r->input($religion_f);
        $education = $r->input($education_f);
        $job       = $r->input($job_f);
        $income    = $r->input($income_f);
        $remark    = $r->input($remark_f);

        $dead = DB::table('tm_deads')
                ->select('id_job')
                ->first();
        $fm   = DB::table('familys as a')
                ->join('tm_familymembers as b', 'a.family_member','=','b.id')
                ->select('b.name as family_name')
                ->where('a.id', $family_id)
                ->first();
        $user = DB::table('registrations')
                ->select('period','no_regist')
                ->where('id_regist', Auth::user()->id_regist)
                ->first();

        if($dead->id_job === $job){
            DB::table('familys')
            ->where('id', $family_id)
            ->update([
                'name'       => $name,
                'place'      => $place,
                'birthday'   => $birthday,
                'id_card'    => '',
                'religion'   => $religion,
                'education'  => $education,
                'job'        => $job,
                'income'     => '',
                'remark'     => $remark,
                'user'       => $user->period.$user->no_regist,
                'updated_at' => now()
            ]);
            
            return redirect()->back()->with('success', 'Orang Tua ('.$fm->family_name.') berhasil di update')->with('biodatatab', 'parent');
        }

        DB::table('familys')
        ->where('id', $family_id)
        ->update([
            'name'       => $name,
            'place'      => $place,
            'birthday'   => $birthday,
            'id_card'    => $id_card,
            'religion'   => $religion,
            'education'  => $education,
            'job'        => $job,
            'income'     => $income,
            'remark'     => $remark,
            'user'       => $user->period.$user->no_regist,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Orang Tua ('.$fm->family_name.') berhasil di update')->with('biodatatab', 'parent');
    }

    public function file_store(Request $r)
    {
        $rules = [
            'id'   => 'required|integer',
            'name' => 'required|mimes:jpg,bmp,png,pdf|max:2048',
        ];
    
        $messages = [
            'id.required'   => 'ID tidak ditemukan',
            'id.integer'    => 'ID tidak sesuai',
            'name.required' => 'File wajib diisi',
            'name.mimes'    => 'File harus berformat (JPG,PNG,BMP,PDF)',
            'name.max'      => 'File maksimal 2MB',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('biodatatab', 'file');
        }

        $id   = $r->input('id');
        $name = $r->input('name');

        $user = DB::table('registrations')
                ->select('period','no_regist')
                ->where('id', Auth::user()->id_regist)
                ->first();
        $ln   = DB::table('regist_documents as a')
                ->join('tm_regist_documents as b', 'a.document','=','b.id')
                ->select('b.name as document_name')
                ->where('a.id', $id)
                ->first();

        if($r->hasFile('name')){
            $photo = $r->file('name');
            $nama_photox = $photo->getClientOriginalName();
            $image_info = explode(".", $nama_photox); 
            $ext = end($image_info);
            $username = $user->period.$user->no_regist.'-'.$id;
            $nama_photo = $username.".".$ext;
            $tujuan_upload_photo = 'documents/'.$user->period;
            if(!file_exists($tujuan_upload_photo)) {
                mkdir($tujuan_upload_photo, 0777, true);
            }
            if(!file_exists($tujuan_upload_photo)) {
                return redirect()->back()->with('error','Update Gagal! Directory cannot be created! Silahkan hubungi Administrator!')->with('biodatatab', 'file'); 
            }
            $photo->move($tujuan_upload_photo,$nama_photo);
        }else{
            return redirect()->back()->with('error', 'Lampiran '.$ln->document_name.' GAGAL di update')->with('biodatatab', 'file');
        }

        DB::table('regist_documents')
        ->where('id', $id)
        ->update([
            'status'     => 'Y',
            'name'       => $nama_photo,
            'user'       => $user->period.$user->no_regist,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Lampiran '.$ln->document_name.' berhasil di update')->with('biodatatab', 'file');
    }

    public function achievement_store(Request $r)
    {
        $rules = [
            'group'  => 'required|integer',
            'name'   => 'required|string',
            'rank'   => 'required|integer',
            'level'  => 'required|integer',
            'year'   => 'required|integer',
            'remark' => 'nullable|string',
        ];
    
        $messages = [
            'group.required'  => 'Kelompok/Bidang wajib diisi',
            'group.integer'   => 'Kelompok/Bidang tidak sesuai pilihan',
            'name.required'   => 'Perlombaan/Kejuaraan wajib diisi',
            'name.string'     => 'Perlombaan/Kejuaraan harus berupa string',
            'rank.required'   => 'Peringkat wajib diisi',
            'rank.integer'    => 'Peringkat tidak sesuai pilihan',
            'level.required'  => 'Tingkat wajib diisi',
            'level.integer'   => 'Tingkat tidak sesuai pilihan',
            'year.required'   => 'Tahun wajib diisi',
            'year.integer'    => 'Tahun harus berupa angka',
            'remark.string'   => 'Keterangan harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->with('error', 'Terdapat kesalahan: '.$validator->errors())->with('biodatatab', 'achievement');
        }

        $idRegist = Auth::user()->id_regist;
        $group    = $r->input('group');
        $name     = $r->input('name');
        $rank     = $r->input('rank');
        $level    = $r->input('level');
        $year     = $r->input('year');
        $remark   = $r->input('remark');

        $user = DB::table('registrations')
                ->select('period','no_regist')
                ->where('id', $idRegist)
                ->first();

        DB::table('achievements')
        ->insert([
            'id_regist'  => $idRegist,
            'group'      => $group,
            'name'       => $name,
            'rank'       => $rank,
            'level'      => $level,
            'year'       => $year,
            'remark'     => $remark,
            'user'       => $user->period.$user->no_regist,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Prestasi berhasil ditambahkan')->with('biodatatab', 'achievement');
    }

    public function achievement_update(Request $r)
    {
        $rules = [
            'id'     => 'required|integer',
            'group'  => 'required|integer',
            'name'   => 'required|string',
            'rank'   => 'required|integer',
            'level'  => 'required|integer',
            'year'   => 'required|integer',
            'remark' => 'nullable|string',
        ];
    
        $messages = [
            'id.required'     => 'ID tidak ditemukan',
            'id.integer'      => 'ID tidak sesuai',
            'group.required'  => 'Kelompok/Bidang wajib diisi',
            'group.integer'   => 'Kelompok/Bidang tidak sesuai pilihan',
            'name.required'   => 'Perlombaan/Kejuaraan wajib diisi',
            'name.string'     => 'Perlombaan/Kejuaraan harus berupa string',
            'rank.required'   => 'Peringkat wajib diisi',
            'rank.integer'    => 'Peringkat tidak sesuai pilihan',
            'level.required'  => 'Tingkat wajib diisi',
            'level.integer'   => 'Tingkat tidak sesuai pilihan',
            'year.required'   => 'Tahun wajib diisi',
            'year.integer'    => 'Tahun harus berupa angka',
            'remark.string'   => 'Keterangan harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->with('error', 'Terdapat kesalahan: '.$validator->errors())->with('biodatatab', 'achievement');
        }

        $idRegist = Auth::user()->id_regist;
        $id       = $r->input('id');
        $group    = $r->input('group');
        $name     = $r->input('name');
        $rank     = $r->input('rank');
        $level    = $r->input('level');
        $year     = $r->input('year');
        $remark   = $r->input('remark');

        $user = DB::table('registrations')
                ->select('period','no_regist')
                ->where('id', $idRegist)
                ->first();
        $ac   = DB::table('achievements')
                ->select('name')
                ->where('id', $id)
                ->first();

        DB::table('achievements')
        ->where('id', $id)
        ->update([
            'group'      => $group,
            'name'       => $name,
            'rank'       => $rank,
            'level'      => $level,
            'year'       => $year,
            'remark'     => $remark,
            'user'       => $user->period.$user->no_regist,
            'created_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Prestasi '.$ac->name.' berhasil di update')->with('biodatatab', 'achievement');
    }

    public function achievement_destroy($id)
    {
        $ac = DB::table('achievements')
                ->select('name')
                ->where('id', $id)
                ->first();

        DB::table('achievements')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Prestasi '.$ac->name.' berhasil di hapus')->with('biodatatab', 'achievement');
    }
}
