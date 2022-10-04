<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CostPaymentDetailController extends Controller
{
    public function index($idPay)
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $detailMaster = DB::table('tm_cost_payment_detail_masters')->select('id','name')->get();

        return view('master.cost-payment-detail',['si'=>$si,'id_pay'=>$idPay,'detailMaster'=>$detailMaster]);
    }

    public function data(Request $r)
    {
        if ($r->ajax()) {
            $idPay = $r->input('id_pay');
            $data = DB::table('tm_cost_payment_details as a')
                ->join('tm_cost_payment_detail_masters as b', 'a.id_detail_master','=','b.id')
                ->select('a.id','a.id_detail_master','b.name','a.myorder','a.amount','a.description','a.created_at','a.updated_at')
                ->where('id_payment',$idPay);
            $dataCount = $data->count();
            $data = $data->get();

            if(empty($dataCount))
            {
                $data_fix = [];
                return DataTables::of($data_fix)->make(true);
            }

            foreach ( $data as $d ) {
                if(empty($d->updated_at)) {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->created_at));
                } else {
                    $updated_at = date('d-m-Y H:i:s', strtotime($d->updated_at));
                }

                $data_fix[] = [ 
                    'id'               => $d->id,
                    'id_detail_master' => $d->id_detail_master,
                    'name'             => $d->name,
                    'order'            => $d->myorder,
                    'amount'           => $d->amount,
                    'description'      => $d->description,
                    'updated_at'       => $updated_at
                ];
            }

            return DataTables::of($data_fix)
                ->addColumn('action', function($row){
                    $actionBtn = '
                        <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#edit" data-coreui-id="'.$row['id'].'" data-coreui-nama="'.$row['name'].'" data-coreui-urutan="'.$row['order'].'" data-coreui-biaya="'.$row['amount'].'" data-coreui-deskripsi="'.$row['description'].'"><i class="cil-pen" style="font-weight:bold"></i></button>
                        <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="'.$row['name'].'" data-coreui-url="'.url('biaya-pembayaran/'.$row['id'].'/hapus').'"><i class="cil-trash" style="font-weight:bold"></i></button> 
                        ';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store($idPay, Request $r)
    {
        $rules = [
            'order'       => 'required|integer',
            'name'        => 'required|integer',
            'amount'      => 'required|integer',
            'description' => 'nullable|string',
        ];
    
        $messages = [
            'order.required'    => 'No Urut wajib diisi',
            'order.integer'     => 'No Urut harus berupa angka',
            'name.required'      => 'Jenis Pembayaran wajib diisi',
            'name.integer'       => 'Jenis Pembayaran tidak sesuai',
            'amount.required'    => 'Biaya wajib diisi',
            'amount.integer'     => 'Biaya harus berupa angka',
            'description.string' => 'Keterangan harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Jenis Pembayaran gagal di tambah: '.$validator->errors());
        }

        $myOrder = $r->input('order');
        $name    = $r->input('name');
        $amount  = $r->input('amount');
        $desc    = $r->input('description');

        $pay = DB::table('tm_cost_payments')->select('amount')->where('id',$idPay)->first();
        $paySum = $pay->amount + $amount;

        DB::table('tm_cost_payment_details')
        ->insert([
            'id_payment'       => $idPay,
            'id_detail_master' => $name,
            'myorder'          => $myOrder,
            'amount'           => $amount,
            'description'      => $desc,
            'created_at'       => now()
        ]);

        DB::table('tm_cost_payments')
        ->where('id',$idPay)
        ->update([
            'amount' => $paySum,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Jenis Pembayaran berhasil di tambah');
    }

    public function update(Request $r)
    {
        $rules = [
            'id'          => 'required|integer',
            'order'       => 'required|integer',
            'amount'      => 'required|integer',
            'description' => 'nullable|string',
        ];
    
        $messages = [
            'id.required'        => 'ID tidak ditemukan',
            'id.integer'         => 'ID tidak sesuai',
            'order.required'     => 'No Urut wajib diisi',
            'order.integer'      => 'No Urut harus berupa bilangan bulat',
            'amount.required'    => 'Biaya wajib diisi',
            'amount.integer'     => 'Biaya harus berupa bilangan bulat',
            'description.string' => 'Keterangan harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with('error', 'Jenis Pembayaran gagal di update: '.$validator->errors());
        }
        
        $id      = $r->input('id');
        $myOrder = $r->input('order');
        $amount  = $r->input('amount');
        $desc    = $r->input('description');

        $cr = DB::table('tm_cost_payment_details as a')
            ->join('tm_cost_payment_detail_masters as b', 'a.id_detail_master','=','b.id')
            ->select('a.id_payment','b.name','a.amount')
            ->where('a.id', $id)
            ->first();
        $pay = DB::table('tm_cost_payments')->select('amount')->where('id',$cr->id_payment)->first();
        $payMin = $pay->amount - $cr->amount;
        $paySum = $payMin + $amount;

        DB::table('tm_cost_payment_details')
        ->where('id', $id)
        ->update([
            'myorder'     => $myOrder,
            'amount'      => $amount,
            'description' => $desc,
            'updated_at'  => now()
        ]);

        DB::table('tm_cost_payments')
        ->where('id',$cr->id_payment)
        ->update([
            'amount' => $paySum,
            'updated_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Jenis Pembayaran '.$cr->name.' berhasil di update');
    }

    public function destroy($id)
    {
        $cr = DB::table('tm_cost_payment_details as a')
            ->join('tm_cost_payment_detail_masters as b', 'a.id_detail_master','=','b.id')
            ->select('a.id_payment','b.name','a.amount')
            ->where('a.id', $id)
            ->first();
        $pay = DB::table('tm_cost_payments')->select('amount')->where('id',$cr->id_payment)->first();
        $payMin = $pay->amount - $cr->amount;

        DB::table('tm_cost_payment_details')->where('id', $id)->delete();
        DB::table('tm_cost_payments')
        ->where('id',$cr->id_payment)
        ->update([
            'amount' => $payMin,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Jenis Pembayaran '.$cr->name.' berhasil di hapus');
    }
}
