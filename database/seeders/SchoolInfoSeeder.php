<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schoolinfos = [
            [
                'id' => 1, 
                'name' => 'SMA Plus PGRI Cibinong',
                'url' => 'https://smapluspgri.info/',
                'nickname' => 'PESAT',
                'slogan' => 'Sekolahnya Para Kader Bangsa',
                'address' => 'Jl. Golf, Kp. Lingkungan 2 Citatah Dalam No.3 Ciriung, Kec. Cibinong, Kab. Bogor',
                'distric' => 'Cibinong', 
                'school_year' => 'Tahun Pelajaran 2022/2023',
                'chairman' => 'Iwan Gunawan, S.Pd.',
                'icon' => 'favicon.png',
                'letter_head' => 'KopSurat.jpg',
                'background' => 'bg.jpg',
                'regist_pdf_message_top' => 'Silahkan Menghubungi Hotline 1 (WA: 081388127557) untuk Konfirmasi Pendaftaran',
                'regist_pdf_message_bottom' => '*** Terimakasih telah melakukan Pendaftaran ***',
                'regist_wa_message' => 'Pendaftaran atas nama %nama%, telah berhasil dengan detail sebagai berikut:

Gelombang : %gelombang%
Nomor Pendaftaran : %no_daftar%
Nama Lengkap : %nama%
NISN : %nisn%
Alamat Tinggal : %alamat%
SMP : %smp%
Kelompok : %kelompok%
Jurusan : %jurusan%
                
Akses Kelengkapan Data
Gunakan informasi berikut untuk mengakses kelengkapan data anda.
                
Alamat Kelengkapan Data : 
%url%
Email : %email%
Password : [disembunyikan]
                
Terimakasih,
SMA Plus PGRI Cibinong
                
%alamat_sekolah%
%hotline1%',
                'receive_wa_message' => 'Selamat kepada,

Nomor Pendaftaran : %no_daftar%
Nama Lengkap : %nama%
Email : %email%
NISN : %nisn%
Alamat Tinggal : %alamat%
SMP : %smp%
Gelombang : %gelombang%

Dinyatakan DITERIMA di kelas %kelompok% %jurusan% di SMA Plus PGRI Cibinong, Tahun Pelajaran 2022/2023.

Dimohon Bapak/Ibu segera menyelesaikan biaya administrasi PPDB ke No.Rek. %no_rekening_pembayaran% BNI 46 atau datang langsung ke SMA Plus PGRI Cibinong maksimal tgl 28 Juli 2022, bersamaan dengan penandatanganan surat pernyataan bermaterai oleh calon siswa dan orang tua.

Terimakasih,
SMA Plus PGRI Cibinong

%alamat_sekolah%
%hotline1%',
                'pay_wa_message' => 'Terimakasih kepada,  

Nomor Pendaftaran : %no_daftar% 
Nama Lengkap : %nama% 
Email : %email% 
Alamat Tinggal : %alamat% 
SMP : %smp% 
Gelombang : %gelombang% 
Kelompok : %kelompok% 
Jurusan : %jurusan%  

Telah melakukan administrasi sekolah dengan rincian sebagai berikut: 
Bayar : %bayar% 
Total Tagihan : %tagihan% 
Kekurangan : %kurang%  

Terimakasih, 
Panitia PPDB - SMA Plus PGRI Cibinong 

%hotline1%',
                'created_at' => now()
            ],
        ];

        DB::table('school_infos')->insert($schoolinfos);
    }
}
