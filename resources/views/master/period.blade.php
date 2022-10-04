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
                            <label class="form-label">Periode <div class="required">*</div></label>
                            <input type="number" class="form-control" name="period" min="{{$periode}}" value="{{$periode}}" required>
                            <div class="invalid-feedback">Periode Wajib Diisi! atau minimal {{$periode}}!!</div>
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
                <form action="{{ route('periode-perbarui') }}" method="post" class="validation-update" novalidate>
                @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Periode <div class="required">*</div></label>
                            <input type="number" class="form-control" name="period" id="period" min="2022" required>
                            <div class="invalid-feedback">Periode Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Aktif <div class="required">*</div></label>
                            <select name="status" id="status" class="form-select" required>
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
        ajax: "{{ route('periode-data') }}",
        columns: [
            {data: 'period', name: 'period'},
            {data: 'stats', name: 'stats'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true,
        order: [[ 0, 'desc' ]]
    });
});
</script>
<script>
var edit = document.getElementById('edit');
edit.addEventListener('show.coreui.modal', function (event) {
  var button = event.relatedTarget;
  var id = button.getAttribute('data-coreui-id');
  var periode = button.getAttribute('data-coreui-periode');
  var status = button.getAttribute('data-coreui-status');
  var modalTitle = edit.querySelector('.modal-title');
  var modalBodyID = edit.querySelector('.modal-body #id');
  var modalBodyPeriode = edit.querySelector('.modal-body #period');
  var modalBodyStatus = edit.querySelector('.modal-body #status');

  modalTitle.textContent = 'Edit ' + periode;
  modalBodyID.value = id;
  modalBodyPeriode.value = periode;
  modalBodyStatus.value = status;
});

var hapus = document.getElementById('hapus');
hapus.addEventListener('show.coreui.modal', function (event) {
  var button = event.relatedTarget;
  var nama = button.getAttribute('data-coreui-period');
  var url = button.getAttribute('data-coreui-url');
  var modalTitle = hapus.querySelector('.modal-title');
  var modalBodyTanya = hapus.querySelector('.modal-body #tanya');
  var modalBodyHapus = hapus.querySelector('.modal-body #form-hapus');

  modalTitle.textContent = 'Hapus Periode ' + nama;
  modalBodyTanya.textContent = 'Yakin menghapus periode ' + nama + '?';
  modalBodyHapus.action = url;
});
</script>
@endsection