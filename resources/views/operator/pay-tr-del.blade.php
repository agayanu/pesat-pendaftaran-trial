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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Metode</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Transfer</th>
                                        <th>Nomor Transfer</th>
                                        <th>Keterangan</th>
                                        <th>User</th>
                                        <th>Update</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payment as $p)
                                    <tr>
                                        <td>{{date('d-m-Y', strtotime($p->tr_at))}}</td>
                                        <td>{{$p->name}}</td>
                                        <td>{{number_format($p->amount)}}</td>
                                        <td>{{$p->transfer_date}}</td>
                                        <td>{{$p->transfer_no}}</td>
                                        <td>{{$p->remark}}</td>
                                        <td>{{$p->user}}</td>
                                        <td>{{date('d-m-Y H:i:s', strtotime($p->updated_at ?? $p->created_at))}}</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger" type="button" data-coreui-toggle="modal" data-coreui-target="#hapus" data-coreui-nama="{{$p->name.' '.date('d-m-Y', strtotime($p->tr_at)).' '.number_format($p->amount)}}" data-coreui-url="{{route('lunas-hapus-transaksi',['id'=>$p->id])}}">
                                                <i class="cil-trash" style="font-weight:bold"></i>
                                            </button>
                                            <a href="{{route('bayar-pdf',['id'=>$d->id,'id_payment'=>$p->id])}}" class="btn btn-sm btn-info"><i class="cil-print" style="font-weight:bold"></i></a>
                                        </td>
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
@include('app.footer-validation-spinner')
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