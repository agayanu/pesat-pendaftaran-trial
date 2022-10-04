@extends('app.layout')

@section('header')
@include('app.header')
@include('app.tooltips')
@include('app.header-datatable')
@include('app.datetimepicker')
@endsection

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-10">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-sm-2 mb-3">
                            <label class="form-label">Dari Tanggal <div class="required">*</div></label>
                            <input type="text" class="form-control @error('created_from') is-invalid @enderror" name="created_from" id="created_from" placeholder="dd-mm-yyyy" value="{{$cf}}" required>
                            @error('created_from')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                            <div class="invalid-feedback">Dari Tanggal Wajib Diisi!</div>
                            @enderror
                        </div>
                        <div class="col-sm-2 mb-3">
                            <label class="form-label">Sampai Tanggal <div class="required">*</div></label>
                            <input type="text" class="form-control @error('created_to') is-invalid @enderror" name="created_to" id="created_to" placeholder="dd-mm-yyyy" value="{{$ct}}" required>
                            @error('created_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                            <div class="invalid-feedback">Sampai Tanggal Wajib Diisi!</div>
                            @enderror
                        </div>
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
            <div class="col-sm-2 align-self-end" style="text-align: right;">
                <form action="{{route('report-daftar-bayar-download')}}" method="get" class="mb-3">
                    <input type="hidden" name="created_from_d" value="{{$cf}}">
                    <input type="hidden" name="created_to_d" value="{{$ct}}">
                    <input type="hidden" name="period_select_d" value="{{$ps}}">
                    <button class="btn btn-sm btn-success tooltips" type="submit">
                        <i class="cil-cloud-download" style="font-weight: bold;font-size: 20px;"></i> Excel
                        <span class="tooltiptext">Download Excel</span>
                    </button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="display nowrap" id="datatable" style="width:100%">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Gelombang</th>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Kelompok</th>
                        <th>Jurusan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align:right">Total:</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
$('#created_from').datetimepicker({
    locale: 'id',
    format: 'DD-MM-YYYY'
});
$('#created_to').datetimepicker({
    locale: 'id',
    format: 'DD-MM-YYYY'
});
</script>
@include('app.footer-datatable')
<script>
$(function () {        
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('report-daftar-bayar-data', ['period_select'=>$ps,'created_from'=>$cf,'created_to'=>$ct]) }}".replace(/&amp;/g, "&"),
        columns: [
            {data: 'period', name: 'period'},
            {data: 'phase', name: 'phase'},
            {data: 'no_regist', name: 'no_regist'},
            {data: 'name', name: 'name'},
            {data: 'grade', name: 'grade'},
            {data: 'major', name: 'major'},
            {data: 'amount', name: 'amount', render: DataTable.render.number()},
        ],
        responsive: true,
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
            var numFormat = DataTable.render.number().display;

            total = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            $(api.column(6).footer()).html('Rp ' + numFormat(total));
        }
    });
});
</script>
@endsection