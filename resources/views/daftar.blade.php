@extends('layout')

@section('header')
<link rel="stylesheet" href="{{ asset('datetimepicker/css/bootstrap-datetimepicker.css') }}">
<style>
@font-face{
    font-family:'Glyphicons Halflings';
    src:url(fonts/glyphicons-halflings-regular.woff) format('woff'),url(fonts/glyphicons-halflings-regular.ttf) format('truetype')
}
.glyphicon{
    position:relative;
    top:1px;
    display:inline-block;
    font-family:'Glyphicons Halflings';
    font-style:normal;
    font-weight:400;
    line-height:1;
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale
}
.glyphicon-time:before {content:"\e023"}
.glyphicon-chevron-left:before{content:"\e079"}
.glyphicon-chevron-right:before{content:"\e080"}
.glyphicon-calendar:before {content: "\e109"}
.glyphicon-chevron-up:before {content: "\e113"}
.glyphicon-chevron-down:before {content: "\e114"}
.collapse.in {
    display: block;
    visibility: visible
}
.table-condensed>thead>tr>th,
.table-condensed>tbody>tr>th,
.table-condensed>tfoot>tr>th,
.table-condensed>thead>tr>td,
.table-condensed>tbody>tr>td,
.table-condensed>tfoot>tr>td {
    padding: 5px
}
.rqd {
    font-weight: bold;
    color: red;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #768192 !important;
}
.select2-container .select2-selection--single {
    height: calc(1.5em + 0.75rem + 2px) !important;
}
.select2-container .select2-selection--single .select2-selection__rendered {
    padding-left: 12px !important;
    padding-right: 12px !important;
}
.select2-container--default .select2-selection--single {
    border: 1px solid #d8dbe0 !important;
}

.fs-6 {
    font-size: 0.8rem !important;
}

.spin {
    display: none;
    position: fixed;
    height: 4rem;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.show-spin{
  display: block;
}
</style>
<script src="{{ asset('jquery/2.1.1.min.js') }}"></script>
<script src="{{ asset('jquery/moment-with-locales-2.9.0.js') }}"></script>
<script src="{{ asset('datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('sweetalert2/9.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="card mb-3">
        <div class="card-body">
            @include('flash-message')
            <div class="alert alert-warning" role="alert">
                <ul>
                    <li>Semua yang diberi tanda bintang (*), Wajib di isi</li>
                    <li>Hotline 1 : 081388127557 (Whatsapp)</li>
                    <li>Hotline 2 : (021) 8753773 (Telpon)</li>
                </ul>
            </div>
            <form method="POST" action="{{ route('simpan_pendaftaran') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-info" role="alert">
                            Buat akun untuk login
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Email <font class="rqd">*</font></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Email Wajib Diisi!</div>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Password <font class="rqd">*</font></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="myPassword" value="{{ old('password') }}" required>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" onclick="checkPass()">
                                    <label class="form-check-label fs-6">Show Password</label>
                                </div>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Password Wajib Diisi!</div>
                                @enderror
                            </div>
                        </div>
                        <div class="alert alert-info" role="alert">
                            Nama Lengkap, Tempat Lahir, Tanggal Lahir mengikuti Akta Lahir
                        </div>
                        <div class="row">
                            <div class="col-sm-8 mb-3">
                                <label class="form-label">Nama Lengkap <font class="rqd">*</font></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Nama Wajib Diisi!</div>
                                @enderror
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label">NISN <font class="rqd">*</font></label>
                                <input type="text" class="form-control @error('nisn') is-invalid @enderror" name="nisn" value="{{ old('nisn') }}" required>
                                @error('nisn')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">NISN Wajib Diisi!</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mb-3">
                                <label class="form-label">Tempat Lahir <font class="rqd">*</font></label>
                                <input type="text" class="form-control @error('place') is-invalid @enderror" name="place" value="{{ old('place') }}" required>
                                @error('place')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Tempat Lahir Wajib Diisi!</div>
                                @enderror
                            </div>
                            <div class="col-sm-2 mb-3 align-self-end">
                                <label class="form-label">Tanggal Lahir <font class="rqd">*</font></label>
                                <div class="input-group">
                                    <input type='text' class="form-control @error('birthday') is-invalid @enderror" placeholder="yyyy-mm-dd" name="birthday" id="Birthday" value="{{ old('birthday') }}" required/>
                                    <span class="input-group-text">
                                        <i class="icon cil-calendar"></i>
                                    </span>
                                    @error('birthday')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Tanggal Lahir Wajib Diisi!</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-2 mb-3">
                                <label class="form-label">Jenis Kelamin <font class="rqd">*</font></label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                    <option value="">--pilih--</option>
                                    @foreach($genders as $gen)
                                        <option value="{{$gen->id}}" {{ old('gender') == $gen->id ? "selected" : "" }}>{{$gen->name}}</option>
                                    @endforeach
                                </select>
                                @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Jenis Kelamin Wajib Diisi!</div>
                                @enderror
                            </div>
                            <div class="col-sm-2 mb-3">
                                <label class="form-label">Agama <font class="rqd">*</font></label>
                                <select name="religion" class="form-select @error('religion') is-invalid @enderror" required>
                                    <option value="">--pilih--</option>
                                    @foreach($religions as $r)
                                        <option value="{{$r->id}}" {{ old('religion') === $r->id ? "selected" : "" }}>{{$r->name}}</option>
                                    @endforeach
                                </select>
                                @error('religion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Agama Wajib Diisi!</div>
                                @enderror
                            </div>
                        </div>
                        <div class="alert alert-info" role="alert">
                            <ul>
                                <li>Nama Lengkap Orangtua mengikuti KTP</li>
                                <li>Pekerjaan Orangtua diisi pekerjaan saat ini</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 mb-3">
                                <label class="form-label">Nama Lengkap Orangtua<font class="rqd">*</font></label>
                                <input type="text" class="form-control @error('parent_name') is-invalid @enderror" name="parent_name" value="{{ old('parent_name') }}" required>
                                @error('parent_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Nama Lengkap Orangtua Wajib Diisi!</div>
                                @enderror
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label">Pekerjaan Orangtua <font class="rqd">*</font></label>
                                <select name="parent_job" class="form-select @error('parent_job') is-invalid @enderror" required>
                                    <option value="">--pilih--</option>
                                    @foreach($jobs as $j)
                                        <option value="{{$j->id}}" {{ old('parent_job') == $j->id ? "selected" : "" }}>{{$j->name}}</option>
                                    @endforeach
                                </select>
                                @error('parent_job')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Pekerjaan Orangtua Wajib Diisi!</div>
                                @enderror
                            </div>
                        </div>
                        <div class="alert alert-info" role="alert">
                            Data Alamat mengikuti Alamat Tinggal saat ini
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <label class="form-label">Alamat Tinggal <font class="rqd">*</font></label>
                                <textarea name="stay_address" rows="3" class="form-control @error('stay_address') is-invalid @enderror" required>{{ old('parent_name') }}</textarea>
                                @error('stay_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Alamat Tinggal Wajib Diisi!</div>
                                @enderror
                            </div>
                        </div>
                        <div class="alert alert-info" role="alert">
                        Silahkan masukkan pada kolom Asal Sekolah meliputi:
                            <ul>
                                <li>Nama Sekolah</li>
                                <li>Swasta/Negeri</li>
                                <li>Alamat</li>
                                <li>Kecamatan</li>
                                <li>Kota/Kabupaten</li>
                                <li>Provinsi</li>
                            </ul>
                        Contoh: SMA Plus PGRI Cibinong, Swasta, Jl. Raya Ciriung, Cibinong, Kab.Bogor, Jawa Barat
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <label class="form-label">Asal Sekolah <font class="rqd">*</font></label>
                                <textarea name="remark" rows="3" class="form-control @error('remark') is-invalid @enderror" required>{{ old('remark') }}</textarea>
                                @error('remark')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Asal Sekolah Wajib Diisi!</div>
                                @enderror
                            </div>
                        </div>
                        <div class="alert alert-info" role="alert">
                            Pastikan No. HP Orang Tua terdaftar di Whatsapp (Untuk mendapatkan Info Pengumuman dan Lain-lain dari Sistem Sekolah)
                        </div>
                        <div class="row">
                            <div class="col-sm-4 mb-3">
                                <label class="form-label">No. HP Siswa <font class="rqd">*</font></label>
                                <input type="text" class="form-control @error('hp_student') is-invalid @enderror" name="hp_student" maxlength="15" value="{{ old('hp_student') }}" required>
                                @error('hp_student')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">HP Siswa Wajib Diisi!</div>
                                @enderror
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label">No. HP Orang Tua <font class="rqd">*</font></label>
                                <input type="text" class="form-control @error('hp_parent') is-invalid @enderror" name="hp_parent" maxlength="15" value="{{ old('hp_parent') }}" required>
                                @error('hp_parent')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">HP Ayah Wajib Diisi!</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Kelompok <font class="rqd">*</font></label>
                                <select name="grade" class="form-select @error('grade') is-invalid @enderror" required>
                                    <option value="">--pilih--</option>
                                    @foreach($grades as $g)
                                        <option value="{{$g->id}}" {{ old('grade') == $g->id ? "selected" : "" }}>{{$g->name}}</option>
                                    @endforeach
                                </select>
                                @error('grade')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Kelompok Kelas Wajib Diisi!</div>
                                @enderror
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Program Peminatan <font class="rqd">*</font></label>
                                <select name="major" class="form-select @error('major') is-invalid @enderror" required>
                                    <option value="">--pilih--</option>
                                    @foreach($majors as $m)
                                        <option value="{{$m->id}}" {{ old('major') == $m->id ? "selected" : "" }}>{{$m->name}}</option>
                                    @endforeach
                                </select>
                                @error('major')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Jurusan Kelas Wajib Diisi!</div>
                                @enderror
                            </div>
                        </div>
                        <div class="alert alert-info" role="alert">
                            <ul>
                                <li>Photo 3x4</li>
                                <li>Menggunakan Baju Seragam Asal SMP</li>
                                <li>Maksimal file 1MB</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <label class="form-label">Photo <font class="rqd">*</font></label>
                                <input type="file" id="photo" name="photo" class="form-control @error('photo') is-invalid @enderror" required>
                                @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Photo Wajib Diisi!</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<img src="{{asset('images/load.gif')}}" id="spinner" class="spin hide">
@endsection

@section('footer')
<script>
$('#Birthday').datetimepicker({
    locale: 'id',
    format: 'YYYY-MM-DD'
});
function checkPass() {
  var x = document.getElementById("myPassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        const spinner = document.getElementById('spinner');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Silahkan Lengkapi Semua Form',
                        icon: 'error',
                        confirmButtonText: 'Mengerti'
                    });
                }
                if (form.checkValidity()) {
                    spinner.classList.toggle('show-spin');
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
$('#photo').bind('change', function() {
    var ext = $('#photo').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['jpg','jpeg']) == -1) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'File upload bukan jpg atau jpeg!'
        });
        $('#photo').val('');
    }
    else{
        var ufile = this.files[0].size;
        if(ufile > 1097152){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'File Photo Anda Melebihi 2MB!'
            });
            $('#photo').val('');
        }
    }
});
</script>
@endsection