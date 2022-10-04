@extends('app.layout')

@section('header')
@include('app.header')
@include('app.header-datatable')
@endsection

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-header">
        <button class="btn btn-sm btn-primary" type="button" data-coreui-toggle="modal" data-coreui-target="#tambah"><i class="cil-plus" style="font-weight:bold"></i> Tambah</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="display nowrap" id="datatable" style="width:100%">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kabupaten/Kota</th>
                        <th>Provinsi</th>
                        <th>Aktif</th>
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
                            <label class="form-label">Kode <div class="required">*</div></label>
                            <input type="text" class="form-control" name="code" maxlength="8" required>
                            <div class="invalid-feedback">Kode Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Nama <div class="required">*</div></label>
                            <input type="text" class="form-control" name="name" required>
                            <div class="invalid-feedback">Nama Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Provinsi <div class="required">*</div></label>
                            <select name="province" class="form-select" id="province" required>
                                <option value="">--pilih--</option>
                                @foreach ($province as $pvc)
                                <option value="{{$pvc->code}}">{{$pvc->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Provinsi Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Kabupaten/Kota <div class="required">*</div></label>
                            <select name="city" class="form-select" id="city" required>
                                <option value="" disable="true" selected="true">--pilih--</option>
                            </select>
                            <div class="invalid-feedback">Kabupaten/Kota Wajib Diisi!</div>
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
                <form action="{{ route('kecamatan-perbarui') }}" method="post" class="validation-update" novalidate>
                @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Kode <div class="required">*</div></label>
                            <input type="text" class="form-control" name="code" id="code" maxlength="8" required>
                            <div class="invalid-feedback">Kode Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Nama <div class="required">*</div></label>
                            <input type="text" class="form-control" name="name" id="name" required>
                            <div class="invalid-feedback">Nama Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Provinsi <div class="required">*</div></label>
                            <select name="province" class="form-select" id="province-edit" required>
                                <option value="">--pilih--</option>
                                @foreach ($province as $pvc)
                                <option value="{{$pvc->code}}">{{$pvc->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Provinsi Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Kabupaten/Kota <div class="required">*</div></label>
                            <select name="city" class="form-select" id="city-edit" required>
                                <option value="" disable="true" selected="true">--pilih--</option>
                            </select>
                            <div class="invalid-feedback">Kabupaten/Kota Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Aktif <div class="required">*</div></label>
                            <select name="active" id="active" class="form-select" required>
                                <option value="">--pilih--</option>
                                <option value="Y">Ya</option>
                                <option value="N">Tidak</option>
                            </select>
                            <div class="invalid-feedback">Aktif Wajib Diisi!</div>
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
        ajax: "{{ route('kecamatan-data') }}",
        columns: [
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'name_city', name: 'name_city'},
            {data: 'name_province', name: 'name_province'},
            {data: 'active', name: 'active'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true
    });
});
</script>
<script>
baseUrl = "{{url('/')}}";
$('#province').on('change', function(e){
    var prov = e.target.value;
    $.get(baseUrl + '/kabkot-json/' + prov, function(data){
        $('#city').empty();
        $('#city').append('<option value="" disable="true" selected="true">--pilih--</option>');

        $.each(data, function(index, kabkotObj){
            $('#city').append('<option value="'+ kabkotObj.code +'">'+ kabkotObj.name +'</option>');
        });
    });
});
$('#province-edit').on('change', function(e){
    var prov = e.target.value;
    $.get(baseUrl + '/kabkot-json/' + prov, function(data){
        $('#city-edit').empty();
        $('#city-edit').append('<option value="" disable="true" selected="true">--pilih--</option>');

        $.each(data, function(index, kabkotObj){
            $('#city-edit').append('<option value="'+ kabkotObj.code +'">'+ kabkotObj.name +'</option>');
        });
    });
});
</script>
<script>
var edit = document.getElementById('edit');
edit.addEventListener('show.coreui.modal', function (event) {
  var button = event.relatedTarget;
  var id = button.getAttribute('data-coreui-id');
  var kode = button.getAttribute('data-coreui-kode');
  var nama = button.getAttribute('data-coreui-nama');
  var kodeprov = button.getAttribute('data-coreui-kodeprov');
  var kodekabkot = button.getAttribute('data-coreui-kodekabkot');
  var namakabkot = button.getAttribute('data-coreui-namakabkot');
  var aktif = button.getAttribute('data-coreui-aktif');
  var modalTitle = edit.querySelector('.modal-title');
  var modalBodyID = edit.querySelector('.modal-body #id');
  var modalBodyKode = edit.querySelector('.modal-body #code');
  var modalBodyNama = edit.querySelector('.modal-body #name');
  var modalBodyProv = edit.querySelector('.modal-body #province-edit');
  var modalBodyCity = edit.querySelector('.modal-body #city-edit');
  var modalBodyAktif = edit.querySelector('.modal-body #active');
  var option = document.createElement("option");
  option.text = namakabkot;
  option.value = kodekabkot;
  modalBodyCity.appendChild(option);

  modalTitle.textContent = 'Edit ' + nama;
  modalBodyID.value = id;
  modalBodyKode.value = kode;
  modalBodyNama.value = nama;
  modalBodyProv.value = kodeprov;
  modalBodyCity.value = kodekabkot;
  modalBodyAktif.value = aktif;
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