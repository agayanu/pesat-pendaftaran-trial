@extends('app.layout')

@section('header')
@include('app.header')
@include('app.header-datatable')
@include('app.tooltips')
@endsection

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-header">
        <a href="{{route('rubah-bayar-tambah')}}" class="btn btn-sm btn-primary"><i class="cil-plus" style="font-weight:bold"></i> Tambah</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-2 align-self-end">
                <div class="row justify-content-end">
                    <div class="col-12 mb-3">
                        <form action="{{route('report-mundur-download')}}" method="get" style="display: inline-block;">
                            <input type="hidden" name="period_select_d" value="{{$ps}}">
                            <button class="btn btn-sm btn-success tooltips" type="submit">
                                <i class="cil-cloud-download" style="font-weight: bold;font-size: 20px;"></i> Excel
                                <span class="tooltiptext">Download Excel</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="display nowrap" id="datatable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Gelombang</th>
                        <th>Nama</th>
                        <th>Kelompok</th>
                        <th>Jurusan</th>
                        <th>Dikembalikan</th>
                        <th>Keterangan</th>
                        <th>User</th>
                        <th>Update</th>
                    </tr>
                </thead>
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
            ajax: "{{ route('report-mundur-data', ['period'=>$ps]) }}".replace(/&amp;/g, "&"),
            columns: [
                {data: 'no_regist', name: 'no_regist'},
                {data: 'phase', name: 'phase'},
                {data: 'name', name: 'name'},
                {data: 'grade', name: 'grade'},
                {data: 'major', name: 'major'},
                {data: 'amount', name: 'amount'},
                {data: 'remark', name: 'remark'},
                {data: 'user', name: 'user'},
                {data: 'created_at', name: 'created_at'},
        ],
        responsive: true
    });
});
</script>
@endsection