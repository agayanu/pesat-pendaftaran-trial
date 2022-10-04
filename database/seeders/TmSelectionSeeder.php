<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TmSelectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $selections = [
            [
                'id' => 1,
                'first_nounce' => '1.	Hasil wawancara offline calon siswa dan orang tua/wali
2.	Hasil English Interview dan Tes Potensi Akademik. (Khusus Kelas Unggulan dan Pioneer)
3.	Daya tampung SMA Plus PGRI Cibinong tahun pelajaran 2022/2023, maka nama tersebut diatas dinyatakan  :',
                'last_nounce' => 'Sebagai siswa kelas X (sepuluh) SMA Plus PGRI Cibinong tahun pelajaran 2022/2023, dan bagi yang diterima harus membayar administrasi sekolah paling lambat tanggal  28 Juli 2022  dengan :
1.	Membayar administrasi/keuangan sekolah yang telah ditentukan secara Online atau Offline di sekolah dan apabila melewati batas waktu pembayaran dianggap mengundurkan diri.
2.	Pembayaran Online melalui Nomor Rekening BNI 46 yang di informasikan melalui Whatsapp.
3.	Siswa/i yang sudah diterima harus mengembalikan lembaran hasil seleksi, kepada panitia saat konfirmasi pembayaran administrasi.
4.	Wajib mengisi dan menandatangani surat pernyataan siswa baru SMA Plus PGRI Cibinong bermaterai (Materai 10000).
5.	Bagi siswa baru kelas regular yang memilih Program IPA, untuk melakukan tes peminatan program IPA pada hari Senin, 11 Juli 2022 mulai jam 08.00 – 12.00 WIB secara online.
6.	Bagi siswa/i yang sudah dinyatakan diterima dan sudah melakukan pembayaran administrasi kemudian mengundurkan diri sebelum tanggal 15 Juli 2022, maka keuangan yang telah dibayar akan dikembalikan dengan potongan 25% dari total biaya PPDB. Akan tetapi apabila siswa mengundurkan diri mulai tanggal 15 Juli 2022, maka uang tersebut tidak dapat dikembalikan, karena statusnya telah menjadi siswa SMA Plus PGRI Cibinong.
7.	Kepada siswa yang diterima dan sudah menyelesaikan seluruh administrasi agar datang ke sekolah pada hari Jum’at, 15 Juli 2022  dengan menggunakan seragam sekolah asal. (Jadwal diinformasikan kembali)',
                'created_at' => now()
            ],
        ];

        DB::table('tm_selections')->insert($selections);
    }
}
