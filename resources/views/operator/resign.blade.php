@extends('app.layout')

@section('header')
@include('app.header')
@include('app.tooltips')
@include('app.header-datatable')
@endsection

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-header">
        <a href="{{route('mundur-create')}}" class="btn btn-sm btn-primary"><i class="cil-plus" style="font-weight:bold"></i> Tambah</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-10">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-sm-2 mb-3">
                            <label class="form-label">Periode</label>
                            <select name="period_select" class="form-select @error('period') is-invalid @enderror">
                                <option value="">--pilih--</option>
                                @foreach ($period as $p)
                                    <option value="{{$p->period}}" {{$p->period == $ps ? 'selected' : ''}}>{{$p->period}}</option>
                                @endforeach
                            </select>
                            @error('period')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-2 mb-3 align-self-end">
                            <button class="btn btn-sm btn-primary">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="display nowrap" id="datatable" style="width:100%">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Periode</th>
                        <th>Gelombang</th>
                        <th>Nama</th>
                        <th>Kelompok</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>User</th>
                        <th>Update</th>
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
        ajax: "{{ route('mundur-data', ['period_select'=>$ps]) }}".replace(/&amp;/g, "&"),
        columns: [
            {data: 'no_regist', name: 'no_regist'},
            {data: 'period', name: 'period'},
            {data: 'phase', name: 'phase'},
            {data: 'name', name: 'name'},
            {data: 'grade', name: 'grade'},
            {data: 'major', name: 'major'},
            {data: 'status', name: 'status'},
            {data: 'remark', name: 'remark'},
            {data: 'user', name: 'user'},
            {data: 'update', name: 'update'},
        ],
        responsive: true
    });
});
</script>
@endsection