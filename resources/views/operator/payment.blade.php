@extends('app.layout')

@section('header')
@include('app.header')
<link rel="stylesheet" href="{{ asset('datetimepicker/css/bootstrap-datetimepicker.css') }}">
<style>
@font-face{
    font-family:'Glyphicons Halflings';
    src:url({{url('fonts/glyphicons-halflings-regular.woff')}}) format('woff'),url({{url('fonts/glyphicons-halflings-regular.ttf')}}) format('truetype')
}
.glyphicon{
    position:relative;
    top:1px;
    display:inline-block;
    font-family:'Glyphicons Halflings';
    font-style:normal;
    font-weight:400;
    line-height:1;
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale
}
.glyphicon-time:before {content:"\e023"}
.glyphicon-chevron-left:before{content:"\e079"}
.glyphicon-chevron-right:before{content:"\e080"}
.glyphicon-calendar:before {content: "\e109"}
.glyphicon-chevron-up:before {content: "\e113"}
.glyphicon-chevron-down:before {content: "\e114"}
.collapse.in {
    display: block;
    visibility: visible
}
.table-condensed>thead>tr>th,
.table-condensed>tbody>tr>th,
.table-condensed>tfoot>tr>th,
.table-condensed>thead>tr>td,
.table-condensed>tbody>tr>td,
.table-condensed>tfoot>tr>td {
    padding: 5px
}
.rqd {
    font-weight: bold;
    color: red;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #768192 !important;
}
.select2-container .select2-selection--single {
    height: calc(1.5em + 0.75rem + 2px) !important;
}
.select2-container .select2-selection--single .select2-selection__rendered {
    padding-left: 12px !important;
    padding-right: 12px !important;
}
.select2-container--default .select2-selection--single {
    border: 1px solid #d8dbe0 !important;
}

.fs-6 {
    font-size: 0.8rem !important;
}

.spin {
    display: none;
    position: fixed;
    height: 4rem;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.show-spin{
  display: block;
}
</style>
<script src="{{ asset('jquery/2.1.1.min.js') }}"></script>
<script src="{{ asset('jquery/moment-with-locales-2.9.0.js') }}"></script>
<script src="{{ asset('datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
@endsection

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-2">Nomor - Nama</dt><dd class="col-sm-10">: {{$d->no_regist}} - {{$d->name}}</dd>
            <dt class="col-sm-2">Gelombang</dt><dd class="col-sm-10">: {{$d->phase}}</dd>
            <dt class="col-sm-2">Kelompok</dt><dd class="col-sm-10">: {{$d->grade}}</dd>
            <dt class="col-sm-2">Jurusan</dt><dd class="col-sm-10">: {{$d->major}}</dd>
        </dl>
        <form action="{{ route('bayar-tagihan') }}" class="validation-create" method="post">
        @csrf
            <input type="hidden" name="id" value="{{$d->id}}">
            <div class="row">
                <div class="col-sm-3 mb-3">
                    @php
                    $bill = number_format($d->bill);
                    @endphp
                    <label class="form-label">Total Tagihan</label>
                    <input type="text" class="form-control" value="{{$bill}}" disabled>
                </div>
                <div class="col-sm-3 mb-3">
                    @php
                    $amount = number_format($d->amount);
                    @endphp
                    <label class="form-label">Sudah Terbayar</label>
                    <input type="text" class="form-control" value="{{$amount}}" disabled>
                </div>
                <div class="col-sm-3 mb-3">
                    @php
                    if($d->balance < 0) {
                        $pbalance  = $d->balance * -1;
                        $pfbalance = number_format($pbalance);
                        $balance   = '(+)'.$pfbalance;
                    } else {
                        $balance = number_format($d->balance);
                    }
                    @endphp
                    <label class="form-label">Kekurangan</label>
                    <input type="text" class="form-control" value="{{$balance}}" disabled>
                </div>
                <div class="col-sm-3 mb-3 align-self-end">
                    @if (empty($d->bill))
                    <button type="submit" class="btn btn-primary">Buat Tagihan</button>
                    @endif
                    @if (!empty($d->bill))
                    <a href="{{route('bayar-detail',['id'=>$d->id])}}" class="btn btn-info">Rincian</a>
                    <a href="{{route('lunas-hapus-transaksi',['id'=>$d->id])}}" class="btn btn-warning">Transaksi</a>
                    @endif
                </div>
            </div>
            <img src="{{asset('images/load.gif')}}" id="spinner-create" class="spin hide">
        </form>
        <form action="{{ url('bayar') }}" method="post" class="validation-update" novalidate>
        @csrf
            <input type="hidden" name="id" value="{{$d->id}}">
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label class="form-label">Petugas</label>
                    <input type="text" class="form-control" value="{{$d->user}}" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label class="form-label">Metode</label>
                    <select name="pay_method" class="form-select @error('pay_method') is-invalid @enderror">
                        @foreach ($payMethod as $pm)
                        <option value="{{$pm->id}}" {{$pm->id == old('pay_method') ? 'selected' : ''}}>{{$pm->name}}</option>
                        @endforeach
                    </select>
                    @error('pay_method')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6 mb-3">
                    <label class="form-label">Tanggal</label>
                    <div class="input-group">
                        <input type='text' class="form-control @error('tr_at') is-invalid @enderror" placeholder="yyyy-mm-dd" name="tr_at" id="Tr_at" value="{{old('tr_at')}}"/>
                        <span class="input-group-text">
                            <i class="icon cil-calendar"></i>
                        </span>
                        @error('tr_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label">Tanggal Transfer</label>
                                    <div class="input-group">
                                        <input type='text' class="form-control @error('transfer_date') is-invalid @enderror" placeholder="yyyy-mm-dd" name="transfer_date" id="Transfer_date" value="{{old('transfer_date')}}"/>
                                        <span class="input-group-text">
                                            <i class="icon cil-calendar"></i>
                                        </span>
                                        @error('transfer_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="form-label">Nomor Transfer</label>
                                    <input type="text" class="form-control" name="transfer_no" value="{{old('transfer_no')}}">
                                    @error('transfer_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label class="form-label">Jumlah <div class="required">*</div></label>
                    <input type="text" class="form-control" name="amount" value="{{old('amount')}}" required>
                    @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Jumlah Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-6 mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" class="form-control" name="remark" value="{{old('remark')}}">
                    @error('remark')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Bayar</button>
            <img src="{{asset('images/load.gif')}}" id="spinner-update" class="spin hide">
        </form>
    </div>
</div>
@endsection

@section('footer')
@include('app.footer-validation-spinner')
<script>
$('#Tr_at').datetimepicker({
    locale: 'id',
    format: 'YYYY-MM-DD'
});
$('#Transfer_date').datetimepicker({
    locale: 'id',
    format: 'YYYY-MM-DD'
});
</script>
@endsection