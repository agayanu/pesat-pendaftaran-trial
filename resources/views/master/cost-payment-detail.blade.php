@extends('app.layout')

@section('header')
@include('app.header')
@include('app.header-datatable')
<link rel="stylesheet" href="{{asset('datatable/2.2.3-buttons.dataTables.min.css')}}">
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
                        <th>No Urut</th>
                        <th>Jenis Pembayaran</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" style="text-align:right">Jumlah:</th>
                        <th colspan="4"></th>
                    </tr>
                </tfoot>
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
                            <label class="form-label">No Urut <div class="required">*</div></label>
                            <input type="number" name="order" class="form-control" required>
                            <div class="invalid-feedback">No Urut Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Jenis Pembayaran <div class="required">*</div></label>
                            <select name="name" class="form-select" required>
                                <option value="">--pilih--</option>
                                @foreach ($detailMaster as $dm)
                                <option value="{{$dm->id}}">{{$dm->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Jenis Pembayaran Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Biaya <div class="required">*</div></label>
                            <input type="number" name="amount" class="form-control" required>
                            <div class="invalid-feedback">Biaya Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="description" class="form-control">
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
                <form action="{{ route('biaya-pembayaran-rincian-perbarui') }}" method="post" class="validation-update" novalidate>
                @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">No Urut <div class="required">*</div></label>
                            <input type="number" name="order" id="order" class="form-control" required>
                            <div class="invalid-feedback">No Urut Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Jenis Pembayaran</label>
                            <input type="text" id="name" class="form-control" disabled>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Biaya <div class="required">*</div></label>
                            <input type="number" name="amount" id="amount" class="form-control" required>
                            <div class="invalid-feedback">Biaya Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="description" id="description" class="form-control">
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
<script src="{{asset('datatable/2.2.3-dataTables.buttons.min.js')}}"></script>
<script src="{{asset('datatable/3.1.3-jszip.min.js')}}"></script>
<script src="{{asset('datatable/2.2.3-buttons.html5.min.js')}}"></script>
<script>
$(function () {        
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('biaya-pembayaran-rincian-data',['id_pay'=>$id_pay]) }}".replace(/&amp;/g, "&"),
        columns: [
            {data: 'order', name: 'order'},
            {data: 'name', name: 'name'},
            {data: 'amount', name: 'amount', render: DataTable.render.number( null, null, null, 'Rp ' )},
            {data: 'description', name: 'description'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true,
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            total = api
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            pageTotal = api
                .column(2, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            $(api.column(2).footer()).html('Rp ' + pageTotal);
        },
        dom: 'Blfrtip',
        buttons: [
            'excel'
        ]
    });
});
</script>
<script>
var edit = document.getElementById('edit');
edit.addEventListener('show.coreui.modal', function (event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-coreui-id');
    var nama = button.getAttribute('data-coreui-nama');
    var urutan = button.getAttribute('data-coreui-urutan');
    var biaya = button.getAttribute('data-coreui-biaya');
    var deskripsi = button.getAttribute('data-coreui-deskripsi');
    var modalTitle = edit.querySelector('.modal-title');
    var modalBodyID = edit.querySelector('.modal-body #id');
    var modalBodyNama = edit.querySelector('.modal-body #name');
    var modalBodyurutan = edit.querySelector('.modal-body #order');
    var modalBodyBiaya = edit.querySelector('.modal-body #amount');
    var modalBodyDeskripsi = edit.querySelector('.modal-body #description');

    modalTitle.textContent = 'Edit ' + nama;
    modalBodyID.value = id;
    modalBodyNama.value = nama;
    modalBodyurutan.value = urutan;
    modalBodyBiaya.value = biaya;
    modalBodyDeskripsi.value = deskripsi;
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