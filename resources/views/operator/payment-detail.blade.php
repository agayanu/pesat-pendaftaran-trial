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
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Urutan</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Tagihan</th>
                                        <th>Bayar</th>
                                        <th>Kekurangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataPay as $dp)
                                    <tr>
                                        <td>{{$dp->myorder}}</td>
                                        <td>{{$dp->name}}</td>
                                        <td>{{number_format($dp->bill)}}</td>
                                        <td>{{number_format($dp->amount)}}</td>
                                        <td>{{number_format($dp->balance)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@include('app.footer-validation-spinner')
@endsection