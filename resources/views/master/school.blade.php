@extends('app.layout')

@section('header')
@include('app.header')
@include('app.header-datatable')
@endsection

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-primary" type="button" data-coreui-toggle="modal" data-coreui-target="#tambah"><i class="cil-plus" style="font-weight:bold"></i> Tambah</button>
            <button class="btn btn-sm btn-primary" type="button" data-coreui-toggle="modal" data-coreui-target="#upload"><i class="cil-cloud-upload" style="font-weight:bold"></i> Upload</button>
        </div>
    </div>
    <div class="card-body">
        <form action="" method="get">
            <div class="row">
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Provinsi <div class="required">*</div></label>
                    <select name="f_province" id="f_province" class="form-select" required>
                        <option value="">--pilih--</option>
                        @foreach ($province as $pv)
                        <option value="{{$pv->code}}">{{$pv->name}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Provinsi Wajib Diisi!</div>
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Kabupaten/Kota <div class="required">*</div></label>
                    <select name="f_city" id="f_city" class="form-select" required>
                        <option value="">--pilih--</option>
                    </select>
                    <div class="invalid-feedback">Kabupaten/Kota Wajib Diisi!</div>
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Kecamatan <div class="required">*</div></label>
                    <select name="f_distric" id="f_distric" class="form-select" required>
                        <option value="">--pilih--</option>
                    </select>
                    <div class="invalid-feedback">Kecamatan Wajib Diisi!</div>
                </div>
                <div class="col-sm-3 mb-3 align-self-end">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
        <hr/>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Menampilkan data Provinsi: {{$name_province->name}}, Kabupaten/Kota: {{$name_city->name}}, Kecamatan: {{$name_distric->name}}</strong>
            <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="table-responsive">
            <table class="display nowrap" id="datatable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NPSN</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Provinsi</th>
                        <th>Kabupaten/Kota</th>
                        <th>Kecamatan</th>
                        <th>Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sekolah-upload') }}" method="post" enctype="multipart/form-data" class="validation-upload" novalidate>
                @csrf
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Provinsi <div class="required">*</div></label>
                            <select name="fu_province" id="fu_province" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ($province as $pv)
                                <option value="{{$pv->code}}">{{$pv->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Provinsi Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Kabupaten/Kota <div class="required">*</div></label>
                            <select name="fu_city" id="fu_city" class="form-select" required>
                                <option value="">--pilih--</option>
                            </select>
                            <div class="invalid-feedback">Kabupaten/Kota Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Kecamatan <div class="required">*</div></label>
                            <select name="fu_distric" id="fu_distric" class="form-select" required>
                                <option value="">--pilih--</option>
                            </select>
                            <div class="invalid-feedback">Kecamatan Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Upload <div class="required">*</div></label>
                            <input type="file" class="form-control" name="upload" required>
                            <div class="invalid-feedback">Upload Wajib Diisi!</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <a href="{{asset('template/instansi.xlsx')}}" download="Template Instansi.xlsx" class="btn btn-secondary">Download Template</a>
                    </div>
                </form>
                <img src="{{asset('images/load.gif')}}" id="spinner-upload" class="spin hide">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="validation-create" novalidate>
                @csrf
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Nama <div class="required">*</div></label>
                            <input type="text" class="form-control" name="name" required>
                            <div class="invalid-feedback">Nama Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">NPSN <div class="required">*</div></label>
                            <input type="text" class="form-control" name="code" required>
                            <div class="invalid-feedback">NPSN Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Alamat <div class="required">*</div></label>
                            <textarea class="form-control" rows="3" name="address" required></textarea>
                            <div class="invalid-feedback">Alamat Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Status <div class="required">*</div></label>
                            <select name="status" class="form-select" required>
                                <option value="">--pilih--</option>
                                <option value="NEGERI">NEGERI</option>
                                <option value="SWASTA">SWASTA</option>
                            </select>
                            <div class="invalid-feedback">Status Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Provinsi <div class="required">*</div></label>
                            <select name="province" id="create_province" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ($province as $pv)
                                <option value="{{$pv->code}}">{{$pv->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Provinsi Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Kabupaten/Kota <div class="required">*</div></label>
                            <select name="city" id="create_city" class="form-select" required>
                                <option value="">--pilih--</option>
                            </select>
                            <div class="invalid-feedback">Kabupaten/Kota Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Kecamatan <div class="required">*</div></label>
                            <select name="distric" id="create_distric" class="form-select" required>
                                <option value="">--pilih--</option>
                            </select>
                            <div class="invalid-feedback">Kecamatan Wajib Diisi!</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
                <img src="{{asset('images/load.gif')}}" id="spinner-create" class="spin hide">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sekolah-perbarui') }}" method="post" class="validation-update" novalidate>
                @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Nama <div class="required">*</div></label>
                            <input type="text" class="form-control" name="name" id="name" required>
                            <div class="invalid-feedback">Nama Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">NPSN <div class="required">*</div></label>
                            <input type="text" class="form-control" name="code" id="code" required>
                            <div class="invalid-feedback">NPSN Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Alamat <div class="required">*</div></label>
                            <textarea class="form-control" rows="3" name="address" id="address" required></textarea>
                            <div class="invalid-feedback">Alamat Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Status <div class="required">*</div></label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="">--pilih--</option>
                                <option value="NEGERI">NEGERI</option>
                                <option value="SWASTA">SWASTA</option>
                            </select>
                            <div class="invalid-feedback">Status Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Provinsi <div class="required">*</div></label>
                            <select name="province" id="edit_province" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ($province as $pv)
                                <option value="{{$pv->code}}">{{$pv->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Provinsi Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Kabupaten/Kota <div class="required">*</div></label>
                            <select name="city" id="edit_city" class="form-select" required>
                                <option value="">--pilih--</option>
                            </select>
                            <div class="invalid-feedback">Kabupaten/Kota Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Kecamatan <div class="required">*</div></label>
                            <select name="distric" id="edit_distric" class="form-select" required>
                                <option value="">--pilih--</option>
                            </select>
                            <div class="invalid-feedback">Kecamatan Wajib Diisi!</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
                <img src="{{asset('images/load.gif')}}" id="spinner-update" class="spin hide">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="lead" id="tanya"></p>
                <form action="" method="post" id="form-hapus" class="validation-delete" novalidate>
                @csrf
                @method('delete')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Batal</button>
                </form>
                <img src="{{asset('images/load.gif')}}" id="spinner-delete" class="spin hide">
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@include('app.footer-datatable')
@include('app.footer-validation-spinner')
<script>
$(function () {        
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('sekolah-data', ['f_province'=>$c_province,'f_city'=>$c_city,'f_distric'=>$c_distric]) }}".replace(/&amp;/g, "&"),
        columns: [
            {data: 'name', name: 'name'},    
            {data: 'code', name: 'code'},
            {data: 'address', name: 'address'},
            {data: 'status', name: 'status'},
            {data: 'province', name: 'province'},
            {data: 'city', name: 'city'},
            {data: 'distric', name: 'distric'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true
    });
});
</script>
<script>
baseurl='{{ url('/') }}';
$('#f_province').on('change', function(e){
    var kdProp = e.target.value;
    $.get(baseurl + '/kabkot-json/' + kdProp, function(data){
        $('#f_city').empty();
	    $('#f_city').append('<option value="">--pilih--</option>');

        $.each(data, function(index, kabObj){
            $('#f_city').append('<option value="'+ kabObj.code +'">'+ kabObj.name +'</option>');
        });
    });
});
$('#f_city').on('change', function(e){
    var kdKab = e.target.value;
    $.get(baseurl + '/kecamatan-json/' + kdKab, function(data){
        $('#f_distric').empty();
	    $('#f_distric').append('<option value="">--pilih--</option>');

        $.each(data, function(index, kecObj){
            $('#f_distric').append('<option value="'+ kecObj.code +'">'+ kecObj.name +'</option>');
        });
    });
});
$('#fu_province').on('change', function(e){
    var kdProp = e.target.value;
    $.get(baseurl + '/kabkot-json/' + kdProp, function(data){
        $('#fu_city').empty();
	    $('#fu_city').append('<option value="">--pilih--</option>');

        $.each(data, function(index, kabObj){
            $('#fu_city').append('<option value="'+ kabObj.code +'">'+ kabObj.name +'</option>');
        });
    });
});
$('#fu_city').on('change', function(e){
    var kdKab = e.target.value;
    $.get(baseurl + '/kecamatan-json/' + kdKab, function(data){
        $('#fu_distric').empty();
	    $('#fu_distric').append('<option value="">--pilih--</option>');

        $.each(data, function(index, kecObj){
            $('#fu_distric').append('<option value="'+ kecObj.code +'">'+ kecObj.name +'</option>');
        });
    });
});
$('#create_province').on('change', function(e){
    var kdProp = e.target.value;
    $.get(baseurl + '/kabkot-json/' + kdProp, function(data){
        $('#create_city').empty();
	    $('#create_city').append('<option value="">--pilih--</option>');

        $.each(data, function(index, kabObj){
            $('#create_city').append('<option value="'+ kabObj.code +'">'+ kabObj.name +'</option>');
        });
    });
});
$('#create_city').on('change', function(e){
    var kdKab = e.target.value;
    $.get(baseurl + '/kecamatan-json/' + kdKab, function(data){
        $('#create_distric').empty();
	    $('#create_distric').append('<option value="">--pilih--</option>');

        $.each(data, function(index, kecObj){
            $('#create_distric').append('<option value="'+ kecObj.code +'">'+ kecObj.name +'</option>');
        });
    });
});
$('#edit_province').on('change', function(e){
    var kdProp = e.target.value;
    $.get(baseurl + '/kabkot-json/' + kdProp, function(data){
        $('#edit_city').empty();
	    $('#edit_city').append('<option value="">--pilih--</option>');

        $.each(data, function(index, kabObj){
            $('#edit_city').append('<option value="'+ kabObj.code +'">'+ kabObj.name +'</option>');
        });
    });
});
$('#edit_city').on('change', function(e){
    var kdKab = e.target.value;
    $.get(baseurl + '/kecamatan-json/' + kdKab, function(data){
        $('#edit_distric').empty();
	    $('#edit_distric').append('<option value="">--pilih--</option>');

        $.each(data, function(index, kecObj){
            $('#edit_distric').append('<option value="'+ kecObj.code +'">'+ kecObj.name +'</option>');
        });
    });
});
</script>
<script>
(function() {
    'use strict';
    window.addEventListener('load', function() {
    var formsUpload = document.getElementsByClassName('validation-upload');
    const spinnerUpload = document.getElementById('spinner-upload');
    var validationUpload = Array.prototype.filter.call(formsUpload, function(form) {
        form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        if (form.checkValidity()) {
            spinnerUpload.classList.toggle('show-spin');
        }
        form.classList.add('was-validated');
        }, false);
    });
    }, false);
})();
</script>
<script>
var edit = document.getElementById('edit');
edit.addEventListener('show.coreui.modal', function (event) {
  var button = event.relatedTarget;
  var id = button.getAttribute('data-coreui-id');
  var nama = button.getAttribute('data-coreui-nama');
  var kode = button.getAttribute('data-coreui-kode');
  var alamat = button.getAttribute('data-coreui-alamat');
  var status = button.getAttribute('data-coreui-status');
  var provinsi = button.getAttribute('data-coreui-provinsi');
  var kabkot = button.getAttribute('data-coreui-kabkot');
  var kabkotDes = button.getAttribute('data-coreui-kabkot-des');
  var kecamatan = button.getAttribute('data-coreui-kecamatan');
  var kecamatanDes = button.getAttribute('data-coreui-kecamatan-des');
  var modalTitle = edit.querySelector('.modal-title');
  var modalBodyID = edit.querySelector('.modal-body #id');
  var modalBodyNama = edit.querySelector('.modal-body #name');
  var modalBodyKode = edit.querySelector('.modal-body #code');
  var modalBodyAlamat = edit.querySelector('.modal-body #address');
  var modalBodyStatus = edit.querySelector('.modal-body #status');
  var modalBodyProvinsi = edit.querySelector('.modal-body #edit_province');
  var modalBodyKabkot = edit.querySelector('.modal-body #edit_city');
  var modalBodyKecamatan = edit.querySelector('.modal-body #edit_distric');
  var optionKabkot = document.createElement("option");
  optionKabkot.text = kabkotDes;
  optionKabkot.value = kabkot;
  modalBodyKabkot.appendChild(optionKabkot);
  var optionKecamatan = document.createElement("option");
  optionKecamatan.text = kecamatanDes;
  optionKecamatan.value = kecamatan;
  modalBodyKecamatan.appendChild(optionKecamatan);

  modalTitle.textContent = 'Edit ' + nama;
  modalBodyID.value = id;
  modalBodyNama.value = nama;
  modalBodyKode.value = kode;
  modalBodyAlamat.value = alamat;
  modalBodyStatus.value = status;
  modalBodyProvinsi.value = provinsi;
  modalBodyKabkot.value = kabkot;
  modalBodyKecamatan.value = kecamatan;
});

var hapus = document.getElementById('hapus');
hapus.addEventListener('show.coreui.modal', function (event) {
  var button = event.relatedTarget;
  var nama = button.getAttribute('data-coreui-nama');
  var url = button.getAttribute('data-coreui-url');
  var modalTitle = hapus.querySelector('.modal-title');
  var modalBodyTanya = hapus.querySelector('.modal-body #tanya');
  var modalBodyHapus = hapus.querySelector('.modal-body #form-hapus');

  modalTitle.textContent = 'Hapus ' + nama;
  modalBodyTanya.textContent = 'Yakin menghapus ' + nama + '?';
  modalBodyHapus.action = url;
});
</script>
@endsection