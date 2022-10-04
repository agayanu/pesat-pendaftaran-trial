<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function distric_search(Request $r)
    {
        $output='';
        if($r->ajax())
        {
            if($r->address === 'stay' || $r->address === 'home')
            {
                $carialamat = DB::table('tm_districs as a')
                            ->join('tm_citys as b', 'a.code_city','=','b.code')
                            ->join('tm_provinces as c', 'a.code_province','=','c.code')
                            ->select('c.id as id_province', 'c.name as name_province', 'b.id as id_city', 'b.name as name_city', 
                                'a.id as id_distric', 'a.name as name_distric')
                            ->where('a.name', 'like', '%'.$r->search.'%')
                            ->limit(10)
                            ->get();
                if(empty($carialamat))
                {
                    return Response($output);
                }
                foreach($carialamat as $ca)
                {
                    if($r->address === 'stay')
                    {
                        $output.='<tr><td>'.$ca->name_province.'</td>
                                <td>'.$ca->name_city.'</td>
                                <td>'.$ca->name_distric.'</td>
                                <td><form action="'.url('pilih-kec').'" method="GET">
                                <input type="hidden" name="id_province" value="'.$ca->id_province.'">
                                <input type="hidden" name="id_city" value="'.$ca->id_city.'">
                                <input type="hidden" name="id_distric" value="'.$ca->id_distric.'">
                                <input type="hidden" name="address" value="stay">
                                <input type="submit" class="btn btn-success text-white" value="Pilih"></form></td>
                                </tr>';
                    }
                    else
                    {
                        $output.='<tr><td>'.$ca->name_province.'</td>
                                <td>'.$ca->name_city.'</td>
                                <td>'.$ca->name_distric.'</td>
                                <td><form action="'.url('pilih-kec').'" method="GET">
                                <input type="hidden" name="id_province" value="'.$ca->id_province.'">
                                <input type="hidden" name="id_city" value="'.$ca->id_city.'">
                                <input type="hidden" name="id_distric" value="'.$ca->id_distric.'">
                                <input type="hidden" name="address" value="home">
                                <input type="submit" class="btn btn-success text-white" value="Pilih"></form></td>
                                </tr>';
                    }
                }
                return Response($output);
            }
        }
    }

    public function distric_choose(Request $r)
    {
        $address = $r->input('address');
        $id_province = $r->input('id_province');
        $id_city = $r->input('id_city');
        $id_distric = $r->input('id_distric');

        if($address === 'stay')
        {
            DB::table('registrations')
                ->where('id', Auth::user()->id_regist)
                ->update([
                    'stay_province' => $id_province,
                    'stay_city'     => $id_city,
                    'stay_distric'  => $id_distric,
                    'updated_at'    => now()
                ]);

            return redirect()->back()->with('success', 'Kecamatan Alamat Tinggal berhasil di update')->with('biodatatab', 'address');
        }

        if($address === 'home')
        {
            DB::table('registrations')
                ->where('id', Auth::user()->id_regist)
                ->update([
                    'home_province' => $id_province,
                    'home_city'     => $id_city,
                    'home_distric'  => $id_distric,
                    'updated_at'    => now()
                ]);

            return redirect()->back()->with('success', 'Kecamatan Alamat Rumah berhasil di update')->with('biodatatab', 'address');
        }
    }

    public function school_search(Request $r)
    {
        $output='';
        if($r->ajax())
        {
            $carismp = DB::table('tm_schools as a')
                        ->join('tm_provinces as b', 'a.code_province','=','b.code')
                        ->join('tm_citys as c', 'a.code_city','=','c.code')
                        ->join('tm_districs as d', 'a.code_distric','=','d.code')
                        ->select('a.id', 'a.name', 'a.address', 'a.status', 'b.name as name_province', 'c.name as name_city', 'd.name as name_distric')
                        ->where('a.name', 'like', '%'.$r->search.'%')
                        ->limit(10)
                        ->get();
            if(empty($carismp))
            {
                return Response($output);
            }
            foreach($carismp as $cs)
            {
                $output.='<tr><td>'.$cs->name.'</td>
                        <td>'.$cs->address.'</td>
                        <td>'.$cs->status.'</td>
                        <td>'.$cs->name_province.'</td>
                        <td>'.$cs->name_city.'</td>
                        <td>'.$cs->name_distric.'</td>
                        <td><form action="'.url('pilih-smp').'" method="GET">
                        <input type="hidden" name="id_school" value="'.$cs->id.'">
                        <input type="submit" class="btn btn-success text-white" value="Pilih"></form></td>
                        </tr>';
            }
            return Response($output);
        }
    }

    public function school_choose(Request $r)
    {
        $id_school = $r->input('id_school');

        DB::table('registrations')
            ->where('id', Auth::user()->id_regist)
            ->update([
                'school' => $id_school,
                'updated_at'    => now()
            ]);

        return redirect()->back()->with('success', 'Sekolah berhasil di update')->with('biodatatab', 'school');
    }
}
