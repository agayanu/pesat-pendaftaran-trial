<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InfoController extends Controller
{
    public function index()
    {
        $si = DB::table('school_infos')->select('name','icon')->first();
        $schoolInfo = DB::table('school_infos')->first();

        return view('master.info',['si'=>$si,'sinfo'=>$schoolInfo]);
    }

    public function update(Request $r)
    {
        $rules = [
            'id'                        => 'required|integer',
            'name'                      => 'required|string',
            'url'                       => 'required|string',
            'nickname'                  => 'required|string',
            'slogan'                    => 'required|string',
            'address'                   => 'required|string',
            'school_year'               => 'required|string',
            'icon'                      => 'nullable|mimes:png|max:1024',
            'letter_head'               => 'nullable|mimes:jpg|max:1024',
            'background'                => 'nullable|mimes:jpg|max:1024',
            'regist_pdf_message_top'    => 'required|string',
            'regist_pdf_message_bottom' => 'required|string',
            'wa_api'                    => 'nullable|string',
            'wa_api_key'                => 'nullable|string',
            'regist_wa_message'         => 'required|string',
            'receive_wa_message'        => 'required|string',
            'pay_wa_message'            => 'required|string',
        ];
    
        $messages = [
            'id.required'                        => 'ID tidak ditemukan',
            'id.integer'                         => 'ID tidak sesuai',
            'name.required'                      => 'Nama wajib diisi',
            'name.string'                        => 'Nama harus berupa string',
            'url.required'                       => 'URL wajib diisi',
            'url.string'                         => 'URL harus berupa string',
            'nickname.required'                  => 'Nama Panggilan wajib diisi',
            'nickname.string'                    => 'Nama Panggilan harus berupa string',
            'slogan.required'                    => 'Slogan wajib diisi',
            'slogan.string'                      => 'Slogan harus berupa string',
            'address.required'                   => 'Alamat wajib diisi',
            'address.string'                     => 'Alamat harus berupa string',
            'school_year.required'               => 'Tahun Ajaran wajib diisi',
            'school_year.string'                 => 'Tahun Ajaran harus berupa string',
            'icon.mimes'                         => 'Icon harus berformat PNG',
            'icon.max'                           => 'Icon maksimal 1MB',
            'letter_head.mimes'                  => 'Kop Surat harus berformat JPG',
            'letter_head.max'                    => 'Kop Surat maksimal 1MB',
            'background.mimes'                   => 'Background harus berformat JPG',
            'background.max'                     => 'Background maksimal 1MB',
            'regist_pdf_message_top.required'    => 'Redaksi PDF (awal) wajib diisi',
            'regist_pdf_message_top.string'      => 'Redaksi PDF (awal) harus berupa string',
            'regist_pdf_message_bottom.required' => 'Redaksi PDF (bawah) wajib diisi',
            'regist_pdf_message_bottom.string'   => 'Redaksi PDF (bawah) harus berupa string',
            'wa_api.string'                      => 'Whatsapp API harus berupa string',
            'wa_api_key.string'                  => 'Whatsapp API Key harus berupa string',
            'regist_wa_message.required'         => 'Redaksi Whatsapp Registrasi wajib diisi',
            'regist_wa_message.string'           => 'Redaksi Whatsapp Registrasi harus berupa string',
            'receive_wa_message.required'        => 'Redaksi Whatsapp Diterima wajib diisi',
            'receive_wa_message.string'          => 'Redaksi Whatsapp Diterima harus berupa string',
            'pay_wa_message.required'            => 'Redaksi Whatsapp Pembayaran wajib diisi',
            'pay_wa_message.string'              => 'Redaksi Whatsapp Pembayaran harus berupa string',
        ];
  
        $validator = Validator::make($r->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $id                     = $r->input('id');
        $name                   = $r->input('name');
        $url                    = $r->input('url');
        $nickname               = $r->input('nickname');
        $slogan                 = $r->input('slogan');
        $address                = $r->input('address');
        $schoolYear             = $r->input('school_year');
        $registPdfMessageTop    = $r->input('regist_pdf_message_top');
        $registPdfMessageBottom = $r->input('regist_pdf_message_bottom');
        $waApi                  = $r->input('wa_api');
        $waApiKey               = $r->input('wa_api_key');
        $registWaMessage        = $r->input('regist_wa_message');
        $receiveWaMessage       = $r->input('receive_wa_message');
        $payWaMessage           = $r->input('pay_wa_message');

        if($r->hasFile('icon')){
            $icon             = $r->file('icon');
            $namaIcon         = "favicon.png";
            $tujuanUploadIcon = 'images/icons';
            if(!file_exists($tujuanUploadIcon)) {
                mkdir($tujuanUploadIcon, 0777, true);
            }
            if(!file_exists($tujuanUploadIcon)) {
                return redirect()->back()->with('error','Gagal! Directory cannot be created! Silahkan hubungi Administrator!'); 
            }
            $icon->move($tujuanUploadIcon,$namaIcon);
        }

        if($r->hasFile('letter_head')){
            $letHead             = $r->file('letter_head');
            $namaLetHead         = "KopSurat.jpg";
            $tujuanUploadLetHead = 'images';
            if(!file_exists($tujuanUploadLetHead)) {
                mkdir($tujuanUploadLetHead, 0777, true);
            }
            if(!file_exists($tujuanUploadLetHead)) {
                return redirect()->back()->with('error','Gagal! Directory cannot be created! Silahkan hubungi Administrator!'); 
            }
            $letHead->move($tujuanUploadLetHead,$namaLetHead);
        }

        if($r->hasFile('background')){
            $background             = $r->file('background');
            $namaBackground         = "bg.jpg";
            $tujuanUploadBackground = 'images';
            if(!file_exists($tujuanUploadBackground)) {
                mkdir($tujuanUploadBackground, 0777, true);
            }
            if(!file_exists($tujuanUploadBackground)) {
                return redirect()->back()->with('error','Gagal! Directory cannot be created! Silahkan hubungi Administrator!'); 
            }
            $background->move($tujuanUploadBackground,$namaBackground);
        }

        DB::table('school_infos')
        ->where('id', $id)
        ->update([
            'name'                      => $name,
            'url'                       => $url,
            'nickname'                  => $nickname,
            'slogan'                    => $slogan,
            'address'                   => $address,
            'school_year'               => $schoolYear,
            'regist_pdf_message_top'    => $registPdfMessageTop,
            'regist_pdf_message_bottom' => $registPdfMessageBottom,
            'wa_api'                    => $waApi,
            'wa_api_key'                => $waApiKey,
            'regist_wa_message'         => $registWaMessage,
            'receive_wa_message'        => $receiveWaMessage,
            'pay_wa_message'            => $payWaMessage,
            'updated_at'                => now()
        ]);
        
        return redirect()->back()->with('success', 'Info berhasil di update');
    }
}
