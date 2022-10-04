<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\InfoSosmedController;
use App\Http\Controllers\AchievementGroupController;
use App\Http\Controllers\AchievementLevelController;
use App\Http\Controllers\AchievementRankController;
use App\Http\Controllers\BloodController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DistricController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PhaseController;
use App\Http\Controllers\CostRegistrationController;
use App\Http\Controllers\CostPaymentController;
use App\Http\Controllers\CostPaymentDetailController;
use App\Http\Controllers\CostPaymentDetailMasterController;
use App\Http\Controllers\ChangeCostPaymentController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\FamilyStatusController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\HotlineController;
use App\Http\Controllers\HotlineTypeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\NoAccountController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\StayController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\SelectionMasterController;
use App\Http\Controllers\PayMethodController;
use App\Http\Controllers\ResignMasterController;
use App\Http\Controllers\RegistController;
use App\Http\Controllers\SelectionController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\PayBalanceController;
use App\Http\Controllers\PayFinishController;
use App\Http\Controllers\ChangePayController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResignController;

Route::get('/', [DaftarController::class, 'index'])->name('index');
Route::post('simpan', [DaftarController::class, 'store'])->name('simpan_pendaftaran');
Route::get('cetak-pdf/{crypt_period}/{crypt_no_daf}', [DaftarController::class, 'cetak_pdf']);

Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::post('home', [HomeController::class, 'change_photo']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('gantipass', [PasswordController::class, 'index'])->name('gantipass');
    Route::post('gantipass', [PasswordController::class, 'update'])->name('gantipass');
    Route::post('ganti-email', [PasswordController::class, 'update_email'])->name('ganti-email');

    Route::get('operator', [OperatorController::class, 'index'])->name('operator');
    Route::get('operator-data', [OperatorController::class, 'data'])->name('operator-data');
    Route::post('operator', [OperatorController::class, 'store']);
    Route::post('operator/perbarui', [OperatorController::class, 'update'])->name('operator-perbarui');
    Route::post('operator/{id}', [OperatorController::class, 'reset']);
    Route::delete('operator/{id}', [OperatorController::class, 'destroy']);

    Route::get('biodata', [BiodataController::class, 'index'])->name('biodata');
    Route::post('datapribadi', [BiodataController::class, 'personaldata_store'])->name('datapribadi');
    Route::post('alamat', [BiodataController::class, 'address_store'])->name('alamat');
    Route::post('asalsekolah', [BiodataController::class, 'school_store'])->name('asalsekolah');
    Route::post('orangtua', [BiodataController::class, 'parent_store'])->name('orangtua');
    Route::post('lampiran', [BiodataController::class, 'file_store'])->name('lampiran');
    Route::post('prestasi', [BiodataController::class, 'achievement_store'])->name('prestasi');
    Route::post('prestasi/perbarui', [BiodataController::class, 'achievement_update'])->name('prestasi-perbarui');
    Route::delete('prestasi/{id}', [BiodataController::class, 'achievement_destroy']);
    Route::get('cari-kec', [SearchController::class, 'distric_search']);
    Route::get('pilih-kec', [SearchController::class, 'distric_choose']);
    Route::get('cari-smp', [SearchController::class, 'school_search']);
    Route::get('pilih-smp', [SearchController::class, 'school_choose']);

    Route::get('info', [InfoController::class, 'index'])->name('info');
    Route::post('info', [InfoController::class, 'update']);

    Route::get('info-sosmed', [InfoSosmedController::class, 'index'])->name('info-sosmed');
    Route::post('info-sosmed', [InfoSosmedController::class, 'store']);
    Route::post('info-sosmed/perbarui', [InfoSosmedController::class, 'update'])->name('info-sosmed-perbarui');
    Route::delete('info-sosmed/{id}', [InfoSosmedController::class, 'destroy']);

    Route::get('prestasi-group', [AchievementGroupController::class, 'index'])->name('prestasi-group');
    Route::post('prestasi-group', [AchievementGroupController::class, 'store']);
    Route::post('prestasi-group/perbarui', [AchievementGroupController::class, 'update'])->name('prestasi-group-perbarui');
    Route::delete('prestasi-group/{id}', [AchievementGroupController::class, 'destroy']);

    Route::get('prestasi-level', [AchievementLevelController::class, 'index'])->name('prestasi-level');
    Route::post('prestasi-level', [AchievementLevelController::class, 'store']);
    Route::post('prestasi-level/perbarui', [AchievementLevelController::class, 'update'])->name('prestasi-level-perbarui');
    Route::delete('prestasi-level/{id}', [AchievementLevelController::class, 'destroy']);

    Route::get('prestasi-rank', [AchievementRankController::class, 'index'])->name('prestasi-rank');
    Route::post('prestasi-rank', [AchievementRankController::class, 'store']);
    Route::post('prestasi-rank/perbarui', [AchievementRankController::class, 'update'])->name('prestasi-rank-perbarui');
    Route::delete('prestasi-rank/{id}', [AchievementRankController::class, 'destroy']);

    Route::get('golongan-darah', [BloodController::class, 'index'])->name('golongan-darah');
    Route::post('golongan-darah', [BloodController::class, 'store']);
    Route::post('golongan-darah/perbarui', [BloodController::class, 'update'])->name('golongan-darah-perbarui');
    Route::delete('golongan-darah/{id}', [BloodController::class, 'destroy']);

    Route::get('kewarganegaraan', [CitizenController::class, 'index'])->name('kewarganegaraan');
    Route::post('kewarganegaraan', [CitizenController::class, 'store']);
    Route::post('kewarganegaraan/perbarui', [CitizenController::class, 'update'])->name('kewarganegaraan-perbarui');
    Route::delete('kewarganegaraan/{id}', [CitizenController::class, 'destroy']);

    Route::get('provinsi', [ProvinceController::class, 'index'])->name('provinsi');
    Route::get('provinsi-data', [ProvinceController::class, 'data'])->name('provinsi-data');
    Route::post('provinsi', [ProvinceController::class, 'store']);
    Route::post('provinsi/perbarui', [ProvinceController::class, 'update'])->name('provinsi-perbarui');
    Route::delete('provinsi/{id}', [ProvinceController::class, 'destroy']);

    Route::get('kabkot', [CityController::class, 'index'])->name('kabkot');
    Route::get('kabkot-data', [CityController::class, 'data'])->name('kabkot-data');
    Route::get('kabkot-json/{province}', [CityController::class, 'json']);
    Route::post('kabkot', [CityController::class, 'store']);
    Route::post('kabkot/perbarui', [CityController::class, 'update'])->name('kabkot-perbarui');
    Route::delete('kabkot/{id}', [CityController::class, 'destroy']);

    Route::get('kecamatan', [DistricController::class, 'index'])->name('kecamatan');
    Route::get('kecamatan-data', [DistricController::class, 'data'])->name('kecamatan-data');
    Route::get('kecamatan-json/{city}', [DistricController::class, 'json']);
    Route::post('kecamatan', [DistricController::class, 'store']);
    Route::post('kecamatan/perbarui', [DistricController::class, 'update'])->name('kecamatan-perbarui');
    Route::delete('kecamatan/{id}', [DistricController::class, 'destroy']);

    Route::get('periode', [PeriodController::class, 'index'])->name('periode');
    Route::get('periode-data', [PeriodController::class, 'data'])->name('periode-data');
    Route::post('periode', [PeriodController::class, 'store']);
    Route::post('periode/perbarui', [PeriodController::class, 'update'])->name('periode-perbarui');
    Route::delete('periode/{id}', [PeriodController::class, 'destroy']);

    Route::get('gelombang', [PhaseController::class, 'index'])->name('gelombang');
    Route::get('gelombang-data', [PhaseController::class, 'data'])->name('gelombang-data');
    Route::post('gelombang', [PhaseController::class, 'store']);
    Route::post('gelombang/perbarui', [PhaseController::class, 'update'])->name('gelombang-perbarui');
    Route::delete('gelombang/{id}', [PhaseController::class, 'destroy']);

    Route::get('biaya-pendaftaran', [CostRegistrationController::class, 'index'])->name('biaya-pendaftaran');
    Route::get('biaya-pendaftaran-data', [CostRegistrationController::class, 'data'])->name('biaya-pendaftaran-data');
    Route::post('biaya-pendaftaran', [CostRegistrationController::class, 'store']);
    Route::post('biaya-pendaftaran/perbarui', [CostRegistrationController::class, 'update'])->name('biaya-pendaftaran-perbarui');
    Route::delete('biaya-pendaftaran/{id}', [CostRegistrationController::class, 'destroy']);

    Route::get('biaya-pembayaran-rincian-master', [CostPaymentDetailMasterController::class, 'index'])->name('biaya-pembayaran-rincian-master');
    Route::get('biaya-pembayaran-rincian-master-data', [CostPaymentDetailMasterController::class, 'data'])->name('biaya-pembayaran-rincian-master-data');
    Route::post('biaya-pembayaran-rincian-master', [CostPaymentDetailMasterController::class, 'store']);
    Route::post('biaya-pembayaran-rincian-master/perbarui', [CostPaymentDetailMasterController::class, 'update'])->name('biaya-pembayaran-rincian-master-perbarui');
    Route::delete('biaya-pembayaran-rincian-master/{id}', [CostPaymentDetailMasterController::class, 'destroy']);

    Route::get('biaya-pembayaran', [CostPaymentController::class, 'index'])->name('biaya-pembayaran');
    Route::get('biaya-pembayaran-data', [CostPaymentController::class, 'data'])->name('biaya-pembayaran-data');
    Route::post('biaya-pembayaran', [CostPaymentController::class, 'store']);
    Route::delete('biaya-pembayaran/{id}', [CostPaymentController::class, 'destroy']);

    Route::get('biaya-pembayaran/{id_pay}/rincian', [CostPaymentDetailController::class, 'index'])->name('biaya-pembayaran-rincian');
    Route::get('biaya-pembayaran-rincian-data', [CostPaymentDetailController::class, 'data'])->name('biaya-pembayaran-rincian-data');
    Route::post('biaya-pembayaran/{id_pay}/rincian', [CostPaymentDetailController::class, 'store']);
    Route::post('biaya-pembayaran-rincian/perbarui', [CostPaymentDetailController::class, 'update'])->name('biaya-pembayaran-rincian-perbarui');
    Route::delete('biaya-pembayaran/{id}/hapus', [CostPaymentDetailController::class, 'destroy']);

    Route::get('rubah-biaya-pembayaran', [ChangeCostPaymentController::class, 'index'])->name('rubah-biaya-pembayaran');
    Route::get('rubah-biaya-pembayaran-data', [ChangeCostPaymentController::class, 'data'])->name('rubah-biaya-pembayaran-data');
    Route::get('rubah-biaya-pembayaran/{id}/rincian', [ChangeCostPaymentController::class, 'show'])->name('rubah-biaya-pembayaran-rincian');
    Route::post('rubah-biaya-pembayaran', [ChangeCostPaymentController::class, 'store']);
    Route::delete('rubah-biaya-pembayaran/{id}', [ChangeCostPaymentController::class, 'destroy']);

    Route::get('pekerjaan', [JobController::class, 'index'])->name('pekerjaan');
    Route::get('pekerjaan-data', [JobController::class, 'data'])->name('pekerjaan-data');
    Route::post('pekerjaan', [JobController::class, 'store']);
    Route::post('pekerjaan/perbarui', [JobController::class, 'update'])->name('pekerjaan-perbarui');
    Route::post('pekerjaan/meninggal', [JobController::class, 'dead'])->name('pekerjaan-meninggal');
    Route::delete('pekerjaan/{id}', [JobController::class, 'destroy']);

    Route::get('pendidikan', [EducationController::class, 'index'])->name('pendidikan');
    Route::get('pendidikan-data', [EducationController::class, 'data'])->name('pendidikan-data');
    Route::post('pendidikan', [EducationController::class, 'store']);
    Route::post('pendidikan/perbarui', [EducationController::class, 'update'])->name('pendidikan-perbarui');
    Route::delete('pendidikan/{id}', [EducationController::class, 'destroy']);

    Route::get('keluarga', [FamilyMemberController::class, 'index'])->name('keluarga');
    Route::get('keluarga-data', [FamilyMemberController::class, 'data'])->name('keluarga-data');
    Route::post('keluarga', [FamilyMemberController::class, 'store']);
    Route::post('keluarga/perbarui', [FamilyMemberController::class, 'update'])->name('keluarga-perbarui');
    Route::delete('keluarga/{id}', [FamilyMemberController::class, 'destroy']);

    Route::get('keluarga-status', [FamilyStatusController::class, 'index'])->name('keluarga-status');
    Route::get('keluarga-status-data', [FamilyStatusController::class, 'data'])->name('keluarga-status-data');
    Route::post('keluarga-status', [FamilyStatusController::class, 'store']);
    Route::post('keluarga-status/perbarui', [FamilyStatusController::class, 'update'])->name('keluarga-status-perbarui');
    Route::delete('keluarga-status/{id}', [FamilyStatusController::class, 'destroy']);

    Route::get('jenis-kelamin', [GenderController::class, 'index'])->name('jenis-kelamin');
    Route::get('jenis-kelamin-data', [GenderController::class, 'data'])->name('jenis-kelamin-data');
    Route::post('jenis-kelamin', [GenderController::class, 'store']);
    Route::post('jenis-kelamin/perbarui', [GenderController::class, 'update'])->name('jenis-kelamin-perbarui');
    Route::delete('jenis-kelamin/{id}', [GenderController::class, 'destroy']);

    Route::get('kelompok', [GradeController::class, 'index'])->name('kelompok');
    Route::get('kelompok-data', [GradeController::class, 'data'])->name('kelompok-data');
    Route::post('kelompok', [GradeController::class, 'store']);
    Route::post('kelompok/perbarui', [GradeController::class, 'update'])->name('kelompok-perbarui');
    Route::delete('kelompok/{id}', [GradeController::class, 'destroy']);

    Route::get('jurusan', [MajorController::class, 'index'])->name('jurusan');
    Route::get('jurusan-data', [MajorController::class, 'data'])->name('jurusan-data');
    Route::post('jurusan', [MajorController::class, 'store']);
    Route::post('jurusan/perbarui', [MajorController::class, 'update'])->name('jurusan-perbarui');
    Route::delete('jurusan/{id}', [MajorController::class, 'destroy']);

    Route::get('hotline', [HotlineController::class, 'index'])->name('hotline');
    Route::get('hotline-data', [HotlineController::class, 'data'])->name('hotline-data');
    Route::post('hotline', [HotlineController::class, 'store']);
    Route::post('hotline/perbarui', [HotlineController::class, 'update'])->name('hotline-perbarui');
    Route::delete('hotline/{id}', [HotlineController::class, 'destroy']);

    Route::get('hotline-tipe', [HotlineTypeController::class, 'index'])->name('hotline-tipe');
    Route::get('hotline-tipe-data', [HotlineTypeController::class, 'data'])->name('hotline-tipe-data');
    Route::post('hotline-tipe', [HotlineTypeController::class, 'store']);
    Route::post('hotline-tipe/perbarui', [HotlineTypeController::class, 'update'])->name('hotline-tipe-perbarui');
    Route::delete('hotline-tipe/{id}', [HotlineTypeController::class, 'destroy']);

    Route::get('penghasilan', [IncomeController::class, 'index'])->name('penghasilan');
    Route::get('penghasilan-data', [IncomeController::class, 'data'])->name('penghasilan-data');
    Route::post('penghasilan', [IncomeController::class, 'store']);
    Route::post('penghasilan/perbarui', [IncomeController::class, 'update'])->name('penghasilan-perbarui');
    Route::delete('penghasilan/{id}', [IncomeController::class, 'destroy']);

    Route::get('rekening', [NoAccountController::class, 'index'])->name('rekening');
    Route::post('rekening', [NoAccountController::class, 'update']);

    Route::get('dokumen', [DocumentController::class, 'index'])->name('dokumen');
    Route::get('dokumen-data', [DocumentController::class, 'data'])->name('dokumen-data');
    Route::post('dokumen', [DocumentController::class, 'store']);
    Route::post('dokumen/perbarui', [DocumentController::class, 'update'])->name('dokumen-perbarui');
    Route::delete('dokumen/{id}', [DocumentController::class, 'destroy']);

    Route::get('agama', [ReligionController::class, 'index'])->name('agama');
    Route::get('agama-data', [ReligionController::class, 'data'])->name('agama-data');
    Route::post('agama', [ReligionController::class, 'store']);
    Route::post('agama/perbarui', [ReligionController::class, 'update'])->name('agama-perbarui');
    Route::delete('agama/{id}', [ReligionController::class, 'destroy']);

    Route::get('sekolah', [SchoolController::class, 'index'])->name('sekolah');
    Route::get('sekolah-data', [SchoolController::class, 'data'])->name('sekolah-data');
    Route::post('sekolah', [SchoolController::class, 'store']);
    Route::post('sekolah/upload', [SchoolController::class, 'upload'])->name('sekolah-upload');
    Route::post('sekolah/perbarui', [SchoolController::class, 'update'])->name('sekolah-perbarui');
    Route::delete('sekolah/{id}', [SchoolController::class, 'destroy']);

    Route::get('status', [StatusController::class, 'index'])->name('status');
    Route::get('status-data', [StatusController::class, 'data'])->name('status-data');
    Route::post('status', [StatusController::class, 'store']);
    Route::post('status/perbarui', [StatusController::class, 'update'])->name('status-perbarui');
    Route::delete('status/{id}', [StatusController::class, 'destroy']);

    Route::get('tinggal', [StayController::class, 'index'])->name('tinggal');
    Route::get('tinggal-data', [StayController::class, 'data'])->name('tinggal-data');
    Route::post('tinggal', [StayController::class, 'store']);
    Route::post('tinggal/perbarui', [StayController::class, 'update'])->name('tinggal-perbarui');
    Route::delete('tinggal/{id}', [StayController::class, 'destroy']);

    Route::get('kendaraan', [TransportationController::class, 'index'])->name('kendaraan');
    Route::get('kendaraan-data', [TransportationController::class, 'data'])->name('kendaraan-data');
    Route::post('kendaraan', [TransportationController::class, 'store']);
    Route::post('kendaraan/perbarui', [TransportationController::class, 'update'])->name('kendaraan-perbarui');
    Route::delete('kendaraan/{id}', [TransportationController::class, 'destroy']);

    Route::get('metode-bayar', [PayMethodController::class, 'index'])->name('metode-bayar');
    Route::get('metode-bayar-data', [PayMethodController::class, 'data'])->name('metode-bayar-data');
    Route::post('metode-bayar', [PayMethodController::class, 'store']);
    Route::post('metode-bayar/perbarui', [PayMethodController::class, 'update'])->name('metode-bayar-perbarui');
    Route::delete('metode-bayar/{id}', [PayMethodController::class, 'destroy']);

    Route::get('seleksi-master', [SelectionMasterController::class, 'index'])->name('seleksi-master');
    Route::post('seleksi-master', [SelectionMasterController::class, 'update']);
    Route::get('seleksi-master/cetak-pdf', [SelectionMasterController::class, 'cetak_pdf'])->name('seleksi-master-cetak');

    Route::get('mundur-master', [ResignMasterController::class, 'index'])->name('mundur-master');
    Route::post('mundur-master', [ResignMasterController::class, 'update']);
    
    Route::get('pendaftaran', [RegistController::class, 'index'])->name('pendaftaran');
    Route::get('pendaftaran-data', [RegistController::class, 'data'])->name('pendaftaran-data');
    Route::get('pendaftaran/{id}/cek', [RegistController::class, 'show'])->name('pendaftaran-cek');
    Route::get('pendaftaran/tambah', [RegistController::class, 'create'])->name('pendaftaran-tambah');
    Route::get('pendaftaran/download', [RegistController::class, 'download'])->name('pendaftaran-download');
    Route::get('pendaftaran/download/all', [RegistController::class, 'download_all'])->name('pendaftaran-download-all');
    Route::post('pendaftaran/school', [RegistController::class, 'get_school']);
    Route::post('pendaftaran/tambah', [RegistController::class, 'store']);
    Route::get('pendaftaran/{period}/{no_daf}/cetak-pdf', [RegistController::class, 'cetak_pdf'])->name('pendaftaran-cetak');
    Route::get('pendaftaran/{id}/edit', [RegistController::class, 'edit'])->name('pendaftaran-edit');
    Route::post('pendaftaran/perbarui', [RegistController::class, 'update'])->name('pendaftaran-perbarui');
    Route::delete('pendaftaran/{id}', [RegistController::class, 'destroy']);

    Route::get('seleksi', [SelectionController::class, 'index'])->name('seleksi');
    Route::get('seleksi-data', [SelectionController::class, 'data'])->name('seleksi-data');
    Route::get('seleksi-data/diterima', [SelectionController::class, 'data_receive'])->name('seleksi-data-diterima');
    Route::get('seleksi-data/bayar', [SelectionController::class, 'data_pay'])->name('seleksi-data-bayar');
    Route::post('seleksi', [SelectionController::class, 'store']);
    Route::post('seleksi/cetak-ulang', [SelectionController::class, 'reprint']);
    Route::post('seleksi/perbarui', [SelectionController::class, 'update'])->name('seleksi-perbarui');
    Route::delete('seleksi/{id}', [SelectionController::class, 'destroy']);

    Route::get('bayar', [PayController::class, 'index'])->name('bayar');
    Route::get('bayar-data', [PayController::class, 'data'])->name('bayar-data');
    Route::get('bayar/{id}/show', [PayController::class, 'show'])->name('bayar-show');
    Route::post('bayar/tagihan', [PayController::class, 'bill'])->name('bayar-tagihan');
    Route::post('bayar', [PayController::class, 'store']);
    Route::get('bayar/{id}/{id_payment}/pdf', [PayController::class, 'pdf'])->name('bayar-pdf');
    Route::get('bayar/{id}/rincian', [PayController::class, 'detail'])->name('bayar-detail');
    Route::post('bayar/perbarui', [PayController::class, 'update'])->name('bayar-perbarui');
    Route::delete('bayar/{id}', [PayController::class, 'destroy']);

    Route::get('selisih', [PayBalanceController::class, 'index'])->name('selisih');
    Route::get('selisih-data', [PayBalanceController::class, 'data'])->name('selisih-data');
    Route::get('selisih/{id}/keluarkan', [PayBalanceController::class, 'out'])->name('selisih-out');
    Route::post('selisih/{id}/keluarkan', [PayBalanceController::class, 'out_store']);

    Route::get('lunas', [PayFinishController::class, 'index'])->name('lunas');
    Route::get('lunas-data', [PayFinishController::class, 'data'])->name('lunas-data');
    Route::get('lunas/{id}/hapus-transaksi', [PayFinishController::class, 'tr_del'])->name('lunas-hapus-transaksi');
    Route::delete('lunas/{id}/hapus-transaksi', [PayFinishController::class, 'destroy'])->name('lunas-hapus-transaksi');
    Route::delete('lunas/{id}/hapus-tagihan', [PayFinishController::class, 'bill_del'])->name('lunas-hapus-tagihan');

    Route::get('rubah-bayar', [ChangePayController::class, 'index'])->name('rubah-bayar');
    Route::get('rubah-bayar-data', [ChangePayController::class, 'data'])->name('rubah-bayar-data');
    Route::get('rubah-bayar/tambah', [ChangePayController::class, 'create'])->name('rubah-bayar-tambah');
    Route::post('rubah-bayar/search', [ChangePayController::class, 'search'])->name('rubah-bayar-search');
    Route::post('rubah-bayar/tambah', [ChangePayController::class, 'store']);
    Route::get('rubah-bayar/download', [ChangePayController::class, 'download'])->name('rubah-bayar-download');

    Route::get('report/daftar-bayar', [ReportController::class, 'pay_regist'])->name('report-daftar-bayar');
    Route::get('report/daftar-bayar-data', [ReportController::class, 'pay_regist_data'])->name('report-daftar-bayar-data');
    Route::get('report/daftar-bayar/download', [ReportController::class, 'pay_regist_download'])->name('report-daftar-bayar-download');
    Route::get('report/bayar', [ReportController::class, 'pay'])->name('report-bayar');
    Route::get('report/bayar-data', [ReportController::class, 'pay_data'])->name('report-bayar-data');
    Route::get('report/bayar/download', [ReportController::class, 'pay_download'])->name('report-bayar-download');
    Route::get('report/bayar/rincian/download', [ReportController::class, 'pay_detail_download'])->name('report-bayar-rincian-download');
    Route::get('report/bayar-transaksi', [ReportController::class, 'pay_tr'])->name('report-bayar-transaksi');
    Route::get('report/bayar-transaksi-data', [ReportController::class, 'pay_tr_data'])->name('report-bayar-transaksi-data');
    Route::get('report/bayar-transaksi/download', [ReportController::class, 'pay_tr_download'])->name('report-bayar-transaksi-download');
    Route::get('report/mundur', [ReportController::class, 'resign'])->name('report-mundur');
    Route::get('report/mundur-data', [ReportController::class, 'resign_data'])->name('report-mundur-data');
    Route::get('report/mundur/download', [ReportController::class, 'resign_download'])->name('report-mundur-download');
    Route::get('report/whatsapp', [ReportController::class, 'wa'])->name('report-wa');
    Route::get('report/whatsapp-data', [ReportController::class, 'wa_data'])->name('report-wa-data');
    Route::get('report/whatsapp/download', [ReportController::class, 'wa_download'])->name('report-wa-download');
    Route::get('report/email', [ReportController::class, 'mail'])->name('report-email');
    Route::get('report/email-data', [ReportController::class, 'mail_data'])->name('report-email-data');
    Route::get('report/email/download', [ReportController::class, 'mail_download'])->name('report-email-download');

    Route::get('mundur', [ResignController::class, 'index'])->name('mundur');
    Route::get('mundur-data', [ResignController::class, 'data'])->name('mundur-data');
    Route::get('mundur/create', [ResignController::class, 'create'])->name('mundur-create');
    Route::post('mundur/search', [ResignController::class, 'search'])->name('mundur-search');
    Route::post('mundur/create', [ResignController::class, 'store']);
    Route::get('mundur/{id}/{id_tr_resign}/pdf', [ResignController::class, 'pdf'])->name('mundur-pdf');
});