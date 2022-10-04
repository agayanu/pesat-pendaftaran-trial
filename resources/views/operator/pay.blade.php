@extends('app.layout')

@section('header')
@include('app.header-datatable')
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
                        <th>Nama</th>
                        <th>Tgl Diterima</th>
                        <th>Kelompok</th>
                        <th>Jurusan</th>
                        <th>Gelombang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('footer')
@include('app.footer-datatable')
<script>
$(function () {        
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('bayar-data') }}",
        columns: [
            {data: 'no_regist', name: 'no_regist'},
            {data: 'name', name: 'name'},
            {data: 'receive_date', name: 'receive_date'},
            {data: 'grade', name: 'grade'},
            {data: 'major', name: 'major'},
            {data: 'phase', name: 'phase'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true
    });
});
</script>
@endsection