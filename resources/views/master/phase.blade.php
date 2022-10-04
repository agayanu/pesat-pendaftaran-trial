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
                        <th>Periode</th>
                        <th>Nama</th>
                        <th>Aktif</th>
                        <th>Biaya</th>
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
                            <label class="form-label">Periode <div class="required">*</div></label>
                            <select name="period" class="form-select" required>
                                <option value="">--pilih--</option>
                                <option value="{{$period->id}}" selected>{{$period->period}}</option>
                            </select>
                            <div class="invalid-feedback">Periode Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Nama <div class="required">*</div></label>
                            <input type="text" class="form-control" name="name" maxlength="100" required>
                            <div class="invalid-feedback">Nama Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Biaya <div class="required">*</div></label>
                            <select name="cost" class="form-select" required>
                                <option value="">--pilih--</option>
                                <option value="Y">Ya</option>
                                <option value="N">Tidak</option>
                            </select>
                            <div class="invalid-feedback">Biaya Wajib Diisi!</div>
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
                <form action="{{ route('gelombang-perbarui') }}" method="post" class="validation-update" novalidate>
                @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Periode <div class="required">*</div></label>
                            <select name="period" id="period" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ($periodList as $pl)
                                <option value="{{$pl->id}}">{{$pl->period}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Periode Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Nama <div class="required">*</div></label>
                            <input type="text" class="form-control" name="name" id="name" maxlength="100" required>
                            <div class="invalid-feedback">Nama Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Aktif <div class="required">*</div></label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="">--pilih--</option>
                                <option value="Y">Ya</option>
                                <option value="N">Tidak</option>
                            </select>
                            <div class="invalid-feedback">Biaya Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Biaya <div class="required">*</div></label>
                            <select name="cost" id="cost" class="form-select" required>
                                <option value="">--pilih--</option>
                                <option value="Y">Ya</option>
                                <option value="N">Tidak</option>
                            </select>
                            <div class="invalid-feedback">Biaya Wajib Diisi!</div>
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
        ajax: "{{ route('gelombang-data') }}",
        columns: [
            {data: 'name_period', name: 'name_period'},
            {data: 'name', name: 'name'},
            {data: 'stats', name: 'stats'},
            {data: 'name_cost', name: 'name_cost'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true,
        order: [[ 0, 'desc' ],[ 1, 'asc' ]]
    });
});
</script>
<script>
var edit = document.getElementById('edit');
edit.addEventListener('show.coreui.modal', function (event) {
  var button = event.relatedTarget;
  var id = button.getAttribute('data-coreui-id');
  var periode = button.getAttribute('data-coreui-periode');
  var namaPeriode = button.getAttribute('data-coreui-namaperiode');
  var nama = button.getAttribute('data-coreui-nama');
  var status = button.getAttribute('data-coreui-status');
  var biaya = button.getAttribute('data-coreui-biaya');
  var modalTitle = edit.querySelector('.modal-title');
  var modalBodyID = edit.querySelector('.modal-body #id');
  var modalBodyPeriode = edit.querySelector('.modal-body #period');
  var modalBodyNama = edit.querySelector('.modal-body #name');
  var modalBodyStatus = edit.querySelector('.modal-body #status');
  var modalBodyBiaya = edit.querySelector('.modal-body #cost');

  modalTitle.textContent = 'Edit ' + nama + ' Periode ' + namaPeriode;
  modalBodyID.value = id;
  modalBodyPeriode.value = periode;
  modalBodyNama.value = nama;
  modalBodyStatus.value = status;
  modalBodyBiaya.value = biaya;
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