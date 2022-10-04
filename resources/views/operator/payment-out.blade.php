@extends('app.layout')

@section('header')
@include('app.header')
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
        <form action="" class="validation-create" method="post">
        @csrf
            <div class="row">
                <div class="col-sm-2 mb-3">
                    @php
                    $bill = number_format($d->bill);
                    @endphp
                    <label class="form-label">Total Tagihan</label>
                    <input type="text" class="form-control" value="{{$bill}}" disabled>
                </div>
                <div class="col-sm-2 mb-3">
                    @php
                    $amount = number_format($d->amount);
                    @endphp
                    <label class="form-label">Sudah Terbayar</label>
                    <input type="text" class="form-control" value="{{$amount}}" disabled>
                </div>
                <div class="col-sm-2 mb-3">
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
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Petugas</label>
                    <input type="text" class="form-control" value="{{$d->user}}" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8 mb-3">
                    <label for="" class="form-label">Keterangan</label>
                    <input type="text" name="remark" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <button type="submit" class="btn btn-primary">Keluarkan</button>
                </div>
            </div>
            <img src="{{asset('images/load.gif')}}" id="spinner-create" class="spin hide">
        </form>
    </div>
</div>
@endsection

@section('footer')
@include('app.footer-validation-spinner')
@endsection