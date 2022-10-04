@extends('app.layout')

@section('content')
<div class="card mb-3">
    <div class="card-header">Biodata</div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="datapribadi-tab" data-coreui-toggle="tab" data-coreui-target="#datapribadi"
                    type="button" role="tab" aria-controls="datapribadi" aria-selected="true"><i class="cil-user"></i> Data Pribadi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="alamat-tab" data-coreui-toggle="tab" data-coreui-target="#alamat"
                    type="button" role="tab" aria-controls="alamat" aria-selected="false"><i class="cil-location-pin"></i> Alamat</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="asalsekolah-tab" data-coreui-toggle="tab" data-coreui-target="#asalsekolah"
                    type="button" role="tab" aria-controls="asalsekolah" aria-selected="false"><i class="cil-bank"></i> Asal Sekolah</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="orangtua-tab" data-coreui-toggle="tab" data-coreui-target="#orangtua"
                    type="button" role="tab" aria-controls="orangtua" aria-selected="false"><i class="cil-wc"></i> Orang Tua</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="lampiran-tab" data-coreui-toggle="tab" data-coreui-target="#lampiran"
                    type="button" role="tab" aria-controls="lampiran" aria-selected="false"><i class="cil-note-add"></i> Lampiran</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="prestasi-tab" data-coreui-toggle="tab" data-coreui-target="#prestasi"
                    type="button" role="tab" aria-controls="prestasi" aria-selected="false"><i class="cil-star"></i> Prestasi</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active show" id="datapribadi" role="tabpanel" aria-labelledby="datapribadi-tab">
                <div class="card">
                    <div class="card-header">
                        Perubahan Terakhir: {{ empty($d->updated_at) ? date_format(date_create($d->created_at),"d/m/Y H:i:s") : date_format(date_create($d->updated_at),"d/m/Y H:i:s") }}
                    </div>
                    <div class="card-body">
                        @php
                        if ($d->birthday) {
                            $Birthdayx = date_create($d->birthday);
                            $Birthday = date_format($Birthdayx,"Y-m-d");
                        } else {
                            $Birthday = null;
                        }
                        @endphp
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <dt class="col-sm-4">Nama Lengkap</dt><dd class="col-sm-8">: {{$d->name}}</dd>
                                    <dt class="col-sm-4">Nama Panggilan</dt><dd class="col-sm-8">: {{$d->nickname}}</dd>
                                    <dt class="col-sm-4">Tempat & Tanggal Lahir</dt><dd class="col-sm-8">: {{$d->place}}, {{$Birthday}}</dd>
                                    <dt class="col-sm-4">No. Akta Lahir</dt><dd class="col-sm-8">: {{$d->birthday_id}}</dd>
                                    <dt class="col-sm-4">No. KK</dt><dd class="col-sm-8">: {{$d->family_id}}</dd>
                                    <dt class="col-sm-4">No. NIK</dt><dd class="col-sm-8">: {{$d->id_card}}</dd>
                                    <dt class="col-sm-4">Anak Ke-</dt><dd class="col-sm-8">: {{$d->child_no}}</dd>
                                    <dt class="col-sm-4">Jumlah Saudara</dt><dd class="col-sm-8">: {{$d->child_qty}}</dd>
                                    <dt class="col-sm-4">Tinggi Badan (cm)</dt><dd class="col-sm-8">: {{$d->height}}</dd>
                                    <dt class="col-sm-4">Berat Badan (kg)</dt><dd class="col-sm-8">: {{$d->weight}}</dd>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <dt class="col-sm-5">Lingkar Kepala (cm)</dt><dd class="col-sm-7">: {{$d->head_size}}</dd>
                                    <dt class="col-sm-5">Jarak Tempat Tinggal (km)</dt><dd class="col-sm-7">: {{$d->distance}}</dd>
                                    <dt class="col-sm-5">Waktu Tempuh (jam)</dt><dd class="col-sm-7">: {{$d->time_hh}}</dd>
                                    <dt class="col-sm-5">Waktu Tempuh (menit)</dt><dd class="col-sm-7">: {{$d->time_mm}}</dd>
                                    <dt class="col-sm-5">Agama</dt><dd class="col-sm-7">: {{$d->religion}}</dd>
                                    <dt class="col-sm-5">Jenis Kelamin</dt><dd class="col-sm-7">: {{$d->gender}}</dd>
                                    <dt class="col-sm-5">Kewarganegaraan</dt><dd class="col-sm-7">: {{$d->citizen}}</dd>
                                    <dt class="col-sm-5">Golongan Darah</dt><dd class="col-sm-7">: {{$d->blood}}</dd>
                                    <dt class="col-sm-5">Transportasi</dt><dd class="col-sm-7">: {{$d->transport}}</dd>
                                    <dt class="col-sm-5">Kacamata</dt><dd class="col-sm-7">: {{$d->glass}}</dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
                <div class="card">
                    <div class="card-header">
                        Perubahan Terakhir: {{ empty($d->updated_at) ? date_format(date_create($d->created_at),"d/m/Y H:i:s") : date_format(date_create($d->updated_at),"d/m/Y H:i:s") }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card mb-3">
                                    <div class="card-header">Alamat Tinggal</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <dt class="col-sm-3">Provinsi</dt><dd class="col-sm-9">: {{$d->stay_province}}</dd>
                                            <dt class="col-sm-3">Kota/Kabupaten</dt><dd class="col-sm-9">: {{$d->stay_city}}</dd>
                                            <dt class="col-sm-3">Kecamatan</dt><dd class="col-sm-9">: {{$d->stay_distric}}</dd>
                                            <dt class="col-sm-3">Kelurahan</dt><dd class="col-sm-9">: {{$d->stay_village}}</dd>
                                            <dt class="col-sm-3">RT</dt><dd class="col-sm-9">: {{$d->stay_rt}}</dd>
                                            <dt class="col-sm-3">RW</dt><dd class="col-sm-9">: {{$d->stay_rw}}</dd>
                                            <dt class="col-sm-3">Kode Pos</dt><dd class="col-sm-9">: {{$d->stay_postal}}</dd>
                                            <dt class="col-sm-3">Alamat</dt><dd class="col-sm-9">: {{$d->stay_address}}</dd>
                                            <dt class="col-sm-3">Garis Lintang</dt><dd class="col-sm-9">: {{$d->stay_latitude}}</dd>
                                            <dt class="col-sm-3">Garis Bujur</dt><dd class="col-sm-9">: {{$d->stay_longitude}}</dd>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card mb-3">
                                    <div class="card-header">Alamat Rumah</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <dt class="col-sm-3">Provinsi</dt><dd class="col-sm-9">: {{$d->home_province}}</dd>
                                            <dt class="col-sm-3">Kota/Kabupaten</dt><dd class="col-sm-9">: {{$d->home_city}}</dd>
                                            <dt class="col-sm-3">Kecamatan</dt><dd class="col-sm-9">: {{$d->home_distric}}</dd>
                                            <dt class="col-sm-3">Kelurahan</dt><dd class="col-sm-9">: {{$d->home_village}}</dd>
                                            <dt class="col-sm-3">RT</dt><dd class="col-sm-9">: {{$d->home_rt}}</dd>
                                            <dt class="col-sm-3">RW</dt><dd class="col-sm-9">: {{$d->home_rw}}</dd>
                                            <dt class="col-sm-3">Kode Pos</dt><dd class="col-sm-9">: {{$d->home_postal}}</dd>
                                            <dt class="col-sm-3">Alamat</dt><dd class="col-sm-9">: {{$d->home_address}}</dd>
                                            <dt class="col-sm-3">Garis Lintang</dt><dd class="col-sm-9">: {{$d->home_latitude}}</dd>
                                            <dt class="col-sm-3">Garis Bujur</dt><dd class="col-sm-9">: {{$d->home_longitude}}</dd>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <dt class="col-sm-2">Jenis Tinggal</dt><dd class="col-sm-10">: {{$d->stay}}</dd>
                                            <dt class="col-sm-2">No. HP Siswa</dt><dd class="col-sm-10">: {{$d->hp_student}}</dd>
                                            <dt class="col-sm-2">No. HP Ayah</dt><dd class="col-sm-10">: {{$d->hp_parent}}</dd>
                                            <dt class="col-sm-2">No. HP Ibu</dt><dd class="col-sm-10">: {{$d->hp_parent2}}</dd>
                                            <dt class="col-sm-2">Email Siswa</dt><dd class="col-sm-10">: {{$d->email_student}}</dd>
                                            <dt class="col-sm-2">Email Ayah</dt><dd class="col-sm-10">: {{$d->email_parent}}</dd>
                                            <dt class="col-sm-2">Email Ibu</dt><dd class="col-sm-10">: {{$d->email_parent2}}</dd>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="asalsekolah" role="tabpanel" aria-labelledby="asalsekolah-tab">
                <div class="card">
                    <div class="card-header">
                        Perubahan Terakhir: {{ empty($d->updated_at) ? date_format(date_create($d->created_at),"d/m/Y H:i:s") : date_format(date_create($d->updated_at),"d/m/Y H:i:s") }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <dt class="col-sm-4">Nama Sekolah</dt><dd class="col-sm-8">: {{$d->school_name}}</dd>
                                    <dt class="col-sm-4">Alamat Sekolah</dt><dd class="col-sm-8">: {{$d->school_address}}</dd>
                                    <dt class="col-sm-4">Provinsi</dt><dd class="col-sm-8">: {{$d->school_province}}</dd>
                                    <dt class="col-sm-4">Kota/Kabupaten</dt><dd class="col-sm-8">: {{$d->school_city}}</dd>
                                    <dt class="col-sm-4">Kecamatan</dt><dd class="col-sm-8">: {{$d->school_distric}}</dd>
                                    <dt class="col-sm-4">Keterangan</dt><dd class="col-sm-8">: {{$d->remark}}</dd>
                                    <dt class="col-sm-4">Tahun Lulus</dt><dd class="col-sm-8">: {{$d->school_year}}</dd>
                                    <dt class="col-sm-4">NISN</dt><dd class="col-sm-8">: {{$d->nisn}}</dd>
                                    <dt class="col-sm-4">Nilai Rata2 NEM</dt><dd class="col-sm-8">: {{$d->school_nem_avg}}</dd>
                                    <dt class="col-sm-4">Nilai Rata2 STTB</dt><dd class="col-sm-8">: {{$d->school_sttb_avg}}</dd>
                                    <dt class="col-sm-4">No. Peserta UN</dt><dd class="col-sm-8">: {{$d->exam_un_no}}</dd>
                                    <dt class="col-sm-4">No. SKHUN</dt><dd class="col-sm-8">: {{$d->skhun_no}}</dd>
                                    <dt class="col-sm-4">No. Ijazah</dt><dd class="col-sm-8">: {{$d->certificate_no}}</dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="orangtua" role="tabpanel" aria-labelledby="orangtua-tab">
                <div class="card">
                    <div class="card-body">
                        @foreach($family as $f)
                        <div class="card border-info mb-3">
                            <div class="card-header">
                                {{$f->family_name}} | Perubahan Terakhir: {{ empty($f->updated_at) ? date_format(date_create($f->created_at),"d/m/Y H:i:s") : date_format(date_create($f->updated_at),"d/m/Y H:i:s") }}
                            </div>
                            <div class="card-body">
                                @php
                                if ($f->birthday) {
                                    $Birthdayx_o = date_create($f->birthday);
                                    $Birthday_o = date_format($Birthdayx_o,"Y-m-d");
                                } else {
                                    $Birthday_o = null;
                                }
                                @endphp
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <dt class="col-sm-4">Nama Lengkap</dt><dd class="col-sm-8">: {{$f->name}}</dd>
                                            <dt class="col-sm-4">NIK</dt><dd class="col-sm-8">: {{$f->id_card}}</dd>
                                            <dt class="col-sm-4">Tempat & Tanggal Lahir</dt><dd class="col-sm-8">: {{$f->place}}, {{$Birthday_o}}</dd>
                                            <dt class="col-sm-4">Agama</dt><dd class="col-sm-8">: {{$f->religion}}</dd>
                                            <dt class="col-sm-4">Pendidikan</dt><dd class="col-sm-8">: {{$f->education}}</dd>
                                            <dt class="col-sm-4">Pekerjaan</dt><dd class="col-sm-8">: {{$f->job}}</dd>
                                            <dt class="col-sm-4">Penghasilan /Bulan</dt><dd class="col-sm-8">: {{$f->income}}</dd>
                                            <dt class="col-sm-4">Keterangan</dt><dd class="col-sm-8">: {{$f->remark}}</dd>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="lampiran" role="tabpanel" aria-labelledby="lampiran-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Dokumen</th>
                                        <th>File</th>
                                        <th>Status</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($document as $dc)
                                        <tr>
                                            <td>{{$dc->document_name}}</td>
                                            <td>{{$dc->file_name}}</td>
                                            <td>
                                                @if($dc->status === 'Y')
                                                    <button class="btn btn-sm btn-success"><i class="cil-check"></i></button>
                                                @endif
                                                @if($dc->status === 'N')
                                                    <button class="btn btn-sm btn-danger"><i class="cil-x"></i></button>
                                                @endif
                                            </td>
                                            <td>{{empty($dc->updated_at) ? date_format(date_create($dc->created_at),"d/m/Y H:i:s") : date_format(date_create($dc->updated_at),"d/m/Y H:i:s")}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="prestasi" role="tabpanel" aria-labelledby="prestasi-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Kelompok/Bidang</th>
                                        <th>Perlombaan/Kejuaraan</th>
                                        <th>Peringkat</th>
                                        <th>Tingkat</th>
                                        <th>Tahun</th>
                                        <th>Keterangan</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($achievement as $ac)
                                        <tr>
                                            <td>{{$ac->group}}</td>
                                            <td>{{$ac->name}}</td>
                                            <td>{{$ac->rank}}</td>
                                            <td>{{$ac->level}}</td>
                                            <td>{{$ac->year}}</td>
                                            <td>{{$ac->remark}}</td>
                                            <td>{{empty($ac->updated_at) ? date_format(date_create($ac->created_at),"d/m/Y H:i:s") : date_format(date_create($ac->updated_at),"d/m/Y H:i:s")}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection