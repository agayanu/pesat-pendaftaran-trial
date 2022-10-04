<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon','school_year')->first();
        if(Auth::user()->role === '0'){
            $bio = DB::table('registrations as a')
                ->join('tm_statuss as b', 'a.status','=','b.id')
                ->join('tm_grades as c', 'a.grade','=','c.id')
                ->join('tm_majors as d', 'a.major','=','d.id')
                ->join('tm_phase_registrations as e', 'a.phase','=','e.id')
                ->join('tm_religions as f', 'a.religion','=','f.id')
                ->join('tm_genders as g', 'a.major','=','g.id')
                ->select('a.id','a.period','a.no_regist','b.name as status','c.name as grade','d.name as major','e.name as phase','a.name','a.place','a.birthday','f.name as religion','a.gender as gender_id','g.name as gender','a.photo')
                ->where('a.id', Auth::user()->id_regist)
                ->first();
            return view('home',['si'=>$si, 'bio'=>$bio]);
        }
        if(Auth::user()->role === '1' || Auth::user()->role === '2'){
            $thisPeriod = DB::table('tm_periods')->select('period')->where('status','Y')->first();
            $periodSub1 = $thisPeriod->period - 1;
            $periodSub2 = $thisPeriod->period - 2;

            $daftarPeriod = DB::table('registrations')->where('period',$thisPeriod->period)->count();
            $daftarPeriodSub1 = DB::table('registrations')->where('period',$periodSub1)->count();
            $daftarPeriodSub2 = DB::table('registrations')->where('period',$periodSub2)->count();
            $daftarPeriodSub1Diff = $daftarPeriod - $daftarPeriodSub1;
            if($daftarPeriodSub1) {
                $daftarPeriodSub1Per = ($daftarPeriodSub1Diff / $daftarPeriodSub1) * 100;
                if(fmod($daftarPeriodSub1Per, 1) !== 0.00) {
                    $daftarPeriodSub1Per = number_format($daftarPeriodSub1Per, 2);
                }
            } else {
                $daftarPeriodSub1Per = 0;
            }

            $bayarPeriod = DB::table('registrations')->where([['period',$thisPeriod->period],['status',3]])->count();
            $bayarPeriodSub1 = DB::table('registrations')->where([['period',$periodSub1],['status',3]])->count();
            $bayarPeriodSub2 = DB::table('registrations')->where([['period',$periodSub2],['status',3]])->count();
            $bayarPeriodSub1Diff = $bayarPeriod - $bayarPeriodSub1;
            if($bayarPeriodSub1) {
                $bayarPeriodSub1Per = ($bayarPeriodSub1Diff / $bayarPeriodSub1) * 100;
                if(fmod($bayarPeriodSub1Per, 1) !== 0.00) {
                    $bayarPeriodSub1Per = number_format($bayarPeriodSub1Per, 2);
                }
            } else {
                $bayarPeriodSub1Per = 0;
            }

            $diterimaPeriod = DB::table('registrations')->where([['period',$thisPeriod->period],['status','>',1]])->count();
            $diterimaPeriodSub1 = DB::table('registrations')->where([['period',$periodSub1],['status','>',1]])->count();
            $diterimaPeriodSub2 = DB::table('registrations')->where([['period',$periodSub2],['status','>',1]])->count();
            $diterimaPeriodSub1Diff = $diterimaPeriod - $diterimaPeriodSub1;
            if($diterimaPeriodSub1) {
                $diterimaPeriodSub1Per = ($diterimaPeriodSub1Diff / $diterimaPeriodSub1) * 100;
                if(fmod($diterimaPeriodSub1Per, 1) !== 0.00) {
                    $diterimaPeriodSub1Per = number_format($diterimaPeriodSub1Per, 2);
                }
            } else {
                $diterimaPeriodSub1Per = 0;
            }

            $mundurPeriod = DB::table('registrations')->where([['period',$thisPeriod->period],['status',4]])->count();
            $mundurPeriodSub1 = DB::table('registrations')->where([['period',$periodSub1],['status',4]])->count();
            $mundurPeriodSub2 = DB::table('registrations')->where([['period',$periodSub2],['status',4]])->count();
            $mundurPeriodSub1Diff = $mundurPeriod - $mundurPeriodSub1;
            if($mundurPeriodSub1) {
                $mundurPeriodSub1Per = ($mundurPeriodSub1Diff / $mundurPeriodSub1) * 100;
                if(fmod($mundurPeriodSub1Per, 1) !== 0.00) {
                    $mundurPeriodSub1Per = number_format($mundurPeriodSub1Per, 2);
                }
            } else {
                $mundurPeriodSub1Per = 0;
            }

            $jkL = DB::table('registrations')->where([['period',$thisPeriod->period],['gender', 1]])->count();
            $jkP = DB::table('registrations')->where([['period',$thisPeriod->period],['gender', 2]])->count();
            $gradeR = DB::table('registrations')->where([['period',$thisPeriod->period],['grade', 1]])->count();
            $gradeU = DB::table('registrations')->where([['period',$thisPeriod->period],['grade', 2]])->count();
            $majorA = DB::table('registrations')->where([['period',$thisPeriod->period],['major', 1]])->count();
            $majorS = DB::table('registrations')->where([['period',$thisPeriod->period],['major', 2]])->count();
            $school = DB::table('registrations as a')
                        ->join('tm_schools as b', 'a.school','=','b.id')
                        ->selectRaw("a.school, b.name as school_name, SUM(case when a.period='".$thisPeriod->period."' and a.status=3 then 1 else 0 end) as jml")
                        ->where([['a.status',3],['a.period',$thisPeriod->period]])
                        ->groupByRaw('a.school, school_name')
                        ->orderByDesc('jml')
                        ->limit(10)
                        ->get();
            return view('home',['si'=>$si,'period'=>$thisPeriod->period,'periodSub1'=>$periodSub1,'periodSub2'=>$periodSub2,
                'dp'=>$daftarPeriod,'dps1'=>$daftarPeriodSub1,'dps2'=>$daftarPeriodSub2,'dps1p'=>$daftarPeriodSub1Per,
                'bp'=>$bayarPeriod,'bps1'=>$bayarPeriodSub1,'bps2'=>$bayarPeriodSub2,'bps1p'=>$bayarPeriodSub1Per,
                'dtp'=>$diterimaPeriod,'dtps1'=>$diterimaPeriodSub1,'dtps2'=>$diterimaPeriodSub2,'dtps1p'=>$diterimaPeriodSub1Per,
                'mp'=>$mundurPeriod,'mps1'=>$mundurPeriodSub1,'mps2'=>$mundurPeriodSub2,'mps1p'=>$mundurPeriodSub1Per,
                'jkl'=>$jkL,'jkp'=>$jkP,'gradeR'=>$gradeR,'gradeU'=>$gradeU,'majorA'=>$majorA,'majorS'=>$majorS,'school'=>$school]);
        }
    }

    public function change_photo(Request $r)
    {
        $rules = [
            'id_regist' => 'required|integer',
            'photo'     => 'required|image|max:1024',
        ];
    
        $messages = [
            'id_regist.required' => 'ID tidak ditemukan',
            'id_regist.integer'  => 'ID tidak sesuai',
            'photo.required'     => 'Photo wajib diisi',
            'photo.image'        => 'Photo harus berekstensi jpg, jpeg',
            'photo.max'          => 'Photo maksimal 1MB'
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->with('error', 'Photo gagal di upload: '.$validator->errors());
        }

        $idRegist   = $r->input('id_regist');
        $period     = DB::table('tm_periods')->select('period')->where('status', 'Y')->first();
        $No_Daf_str = DB::table('registrations')->select('no_regist')->where('id', $idRegist)->first();

        $photo               = $r->file('photo');
        $nama_photox         = $photo->getClientOriginalName();
        $image_info          = explode(".", $nama_photox); 
        $ext                 = end($image_info);
        $user                = $period->period.$No_Daf_str->no_regist;
        $nama_photo          = $user.".".$ext;
        $tujuan_upload_photo = 'images/photo/'.$period->period;
        if(!file_exists($tujuan_upload_photo)) {
            mkdir($tujuan_upload_photo, 0777, true);
        }
        if(!file_exists($tujuan_upload_photo)) {
            return back()->with('error','Photo gagal di upload! Directory cannot be created! Silahkan hubungi Administrator!'); 
        }
        $photo->move($tujuan_upload_photo,$nama_photo);

        DB::table('registrations')
        ->where('id',$idRegist)
        ->update([
            'photo'      => $nama_photo,
            'user'       => $user,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success','Photo berhasil di upload!');
    }
}
