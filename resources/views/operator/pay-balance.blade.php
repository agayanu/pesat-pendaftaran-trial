@extends('app.layout')

@section('header')
@include('app.header')
@include('app.header-datatable')
<link rel="stylesheet" href="{{asset('datatable/2.2.3-buttons.dataTables.min.css')}}">
@endsection

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="display nowrap" id="datatable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Gelombang</th>
                        <th>Nama</th>
                        <th>Kelompok</th>
                        <th>Jurusan</th>
                        <th>Tagihan</th>
                        <th>Dibayar</th>
                        <th>Selisih</th>
                        <th>User</th>
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
<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="lead" id="tanya"></p>
                <p>Seluruh Transaksi juga akan terhapus</p>
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
        ajax: "{{ route('selisih-data') }}",
        columns: [
            {data: 'no_regist', name: 'no_regist'},
            {data: 'phase', name: 'phase'},
            {data: 'name', name: 'name'},
            {data: 'grade', name: 'grade'},
            {data: 'major', name: 'major'},
            {data: 'bill', name: 'bill'},
            {data: 'amount', name: 'amount'},
            {data: 'balance', name: 'balance'},
            {data: 'user', name: 'user'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true,
        dom: 'Blfrtip',
        buttons: [
            'excelHtml5',
        ],
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

    modalTitle.textContent = 'Hapus Tagihan ' + nama;
    modalBodyTanya.textContent = 'Yakin menghapus Tagihan ' + nama + '?';
    modalBodyHapus.action = url;
});
</script>
@endsection