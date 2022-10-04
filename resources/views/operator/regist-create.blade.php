@extends('app.layout')

@section('header')
@include('app.header')
@include('app.datetimepicker')
@include('app.select2')
@include('app.switch-button')
@endsection

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-header">
        <a class="btn btn-sm btn-secondary" href="{{route('pendaftaran')}}">Kembali</a>
    </div>
    <div class="card-body">
        <form action="" method="post" class="validation-create" novalidate>
        @csrf
            <div class="row">
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Tanggal <div class="required">*</div></label>
                    <input type="text" class="form-control @error('created_at') is-invalid @enderror" name="created_at" id="created_at" placeholder="dd-mm-yyyy" value="{{old('created_at') ?? now()->format('d-m-Y')}}" required>
                    @error('created_at')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Tanggal Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Gelombang <div class="required">*</div></label>
                    <select name="phase" class="form-select @error('phase') is-invalid @enderror" required>
                        @foreach($phase as $p)
                            <option value="{{$p->id}}" {{old('phase') == $p->id ? 'selected' : ''}}>{{$p->name}}</option>
                        @endforeach
                    </select>
                    @error('phase')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Gelombang Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Kelompok <div class="required">*</div></label>
                    <select name="grade" class="form-select @error('grade') is-invalid @enderror" required>
                        <option value="">--pilih--</option>
                        @foreach($grade as $g)
                            <option value="{{$g->id}}" {{old('grade') == $g->id ? 'selected' : ''}}>{{$g->name}}</option>
                        @endforeach
                    </select>
                    @error('grade')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Kelompok Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Jurusan <div class="required">*</div></label>
                    <select name="major" class="form-select @error('major') is-invalid @enderror" required>
                        <option value="">--pilih--</option>
                        @foreach($major as $m)
                            <option value="{{$m->id}}" {{old('major') == $m->id ? 'selected' : ''}}>{{$m->name}}</option>
                        @endforeach
                    </select>
                    @error('major')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Jurusan Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label class="form-label">Nama Lengkap <div class="required">*</div></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Nama Lengkap Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-6 mb-3">
                    <label class="form-label">Asal Sekolah</label>
                    <label class="switch">
                        <input type="checkbox" name="school_check" id="school_check" checked>
                        <span class="slider round"></span>
                    </label>
                    <select name="school" id="school" class="form-select @error('school') is-invalid @enderror">
                        <option value="">Cari Sekolah</option>
                    </select>
                    @error('school')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <input type="text" class="form-control @error('remark') is-invalid @enderror" name="remark" id="remark" value="{{old('remark')}}" placeholder="Nama Sekolah">
                    <div id="remark_help" class="form-text">Ketik Nama Sekolah beserta daerahnya</div>
                    @error('remark')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label class="form-label">Email <div class="required">*</div></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Email Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Jenis Kelamin <div class="required">*</div></label>
                    <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                        <option value="">--pilih--</option>
                        @foreach($gender as $gn)
                            <option value="{{$gn->id}}" {{old('gender') == $gn->id ? 'selected' : ''}}>{{$gn->name}}</option>
                        @endforeach
                    </select>
                    @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Jenis Kelamin Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Agama <div class="required">*</div></label>
                    <select name="religion" class="form-select @error('religion') is-invalid @enderror" required>
                        <option value="">--pilih--</option>
                        @foreach($religion as $r)
                            <option value="{{$r->id}}" {{old('religion') == $r->id ? 'selected' : ''}}>{{$r->name}}</option>
                        @endforeach
                    </select>
                    @error('religion')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Agama Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label class="form-label">Nama Lengkap Orangtua <div class="required">*</div></label>
                    <input type="text" class="form-control @error('parent') is-invalid @enderror" name="parent" value="{{old('parent')}}" required>
                    @error('parent')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Nama Lengkap Orangtua Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">No. HP Orangtua <div class="required">*</div></label>
                    <input type="text" class="form-control @error('hp_parent') is-invalid @enderror" name="hp_parent" maxlength="15" value="{{old('hp_parent')}}" required>
                    @error('parent')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">No. HP Orangtua Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">No. HP Siswa <div class="required">*</div></label>
                    <input type="text" class="form-control @error('hp') is-invalid @enderror" name="hp" maxlength="15" value="{{old('hp')}}" required>
                    @error('hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">No. HP Siswa Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
        <img src="{{asset('images/load.gif')}}" id="spinner-create" class="spin">
    </div>
</div>
@endsection

@section('footer')
<script>
$('#created_at').datetimepicker({
    locale: 'id',
    format: 'DD-MM-YYYY'
});

$(document).ready(function () {
    $('#remark').hide();
    $('#remark_help').hide();
    $('#school_check').click(function () {
        var check = $(this).is(':checked');
        var checkValue = $(this).val();
        if(check === false)
        {
            $('#school').next('.select2-container').hide();
            $('#remark').show();
            $('#remark_help').show();
        }
        else
        {
            $('#remark').hide();
            $('#remark_help').hide();
            $('#school').next(".select2-container").show();
        }
    });

    $("#school").select2({
        ajax: {
            url: "{{url('pendaftaran/school')}}",
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    _token: "{{ csrf_token() }}",
                    term: params.term,
                    page: params.current_page
                };
            },
            processResults: function(data, params) {
                params.current_page = params.current_page || 1;
                return {
                    results: data[0].data,
                    pagination: {
                        more: (params.current_page * 30) < data[0].total
                    }
                };
            },
            autoWidth: true,
            cache: true
        },
        minimumInputLength: 1,
        templateResult: formatSchool,
        templateSelection: formatSchoolSelection
    });

    function formatSchool(school) {
        if (school.loading) {
            return school.text;
        }

        var $container = $(
            "<div class='select2-result-school clearfix'>" +
            "<div class='select2-result-school__title'></div>" +
            "<div class='select2-result-school__description'></div>" +
            "</div>" +
            "</div>" +
            "</div>"
        );

        $container.find(".select2-result-school__title").text(school.name);
        $container.find(".select2-result-school__description").text(school.address);

        return $container;
    }

    function formatSchoolSelection(school) {
        return school.name || school.text;
    }
});

(function() {
    'use strict';
    window.addEventListener('load', function() {
    var formsCreate = document.getElementsByClassName('validation-create');
    const spinnerCreate = document.getElementById('spinner-create');
    var validationCreate = Array.prototype.filter.call(formsCreate, function(form) {
        form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        if (form.checkValidity()) {
            spinnerCreate.classList.toggle('show-spin');
        }
        form.classList.add('was-validated');
        }, false);
    });
    }, false);
})();
</script>
@endsection