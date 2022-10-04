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
                        <th>Gelombang</th>
                        <th>Dari</th>
                        <th>Menjadi</th>
                        <th>Dari Biaya</th>
                        <th>Menjadi Biaya</th>
                        <th>Perubahan</th>
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
                            <label class="form-label">Gelombang <div class="required">*</div></label>
                            <select name="phase" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ($phase as $phs)
                                <option value="{{$phs->id}}">{{$phs->name}} Periode {{$phs->name_period}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Gelombang Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Dari <div class="required">*</div></label>
                            <select name="from" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ($payment as $py)
                                <option value="{{$py->id}}">{{$py->name_phase}} Periode {{$py->name_period}}, {{$py->grade}} {{$py->major}} ({{number_format($py->amount)}})</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Dari Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Menjadi <div class="required">*</div></label>
                            <select name="to" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ($payment as $py)
                                <option value="{{$py->id}}">{{$py->name_phase}} Periode {{$py->name_period}}, {{$py->grade}} {{$py->major}} ({{number_format($py->amount)}})</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Menjadi Wajib Diisi!</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
                <img src="{{asset('images/load.gif')}}" id="spinner-create" class="spin hide">
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
        ajax: "{{ route('rubah-biaya-pembayaran-data') }}",
        columns: [
            {data: 'name_phase', name: 'name_phase'},
            {data: 'from', name: 'from'},
            {data: 'to', name: 'to'},
            {data: 'amount_from', name: 'amount_from', render: DataTable.render.number( null, null, null, 'Rp ' )},
            {data: 'amount_to', name: 'amount_to', render: DataTable.render.number( null, null, null, 'Rp ' )},
            {data: 'change_amount', name: 'change_amount', render: DataTable.render.number()},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true
    });
});
</script>
<script>
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