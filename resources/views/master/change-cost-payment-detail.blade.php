@extends('app.layout')

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-2">Gelombang</dt><dd class="col-sm-10">: {{$d->name_phase}} Periode {{$d->name_period}}</dd>
            <dt class="col-sm-2">Dari</dt><dd class="col-sm-10">: {{$d->name_grade_from}} {{$d->name_major_from}}</dd>
            <dt class="col-sm-2">Menjadi</dt><dd class="col-sm-10">: {{$d->name_grade_to}} {{$d->name_major_to}}</dd>
            <dt class="col-sm-2">Dari Biaya</dt><dd class="col-sm-10">: {{number_format($d->amount_from)}}</dd>
            <dt class="col-sm-2">Menjadi Biaya</dt><dd class="col-sm-10">: {{number_format($d->amount_to)}}</dd>
            <dt class="col-sm-2">Perubahan</dt><dd class="col-sm-10">: {{number_format($d->change_amount)}}</dd>
            <dt class="col-sm-2">Update</dt><dd class="col-sm-10">: {{date('d-m-Y H:i:s', strtotime($d->updated_at ?? $d->created_at))}}</dd>
        </dl>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Jenis Pembayaran</th>
                        <th>Dari</th>
                        <th>Menjadi</th>
                        <th>Perubahan</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataDetail as $dd)
                        <tr>
                            <td>{{$dd->myorder}}</td>
                            <td>{{$dd->name}}</td>
                            <td>{{number_format($dd->amount_from)}}</td>
                            <td>{{number_format($dd->amount_to)}}</td>
                            <td>{{number_format($dd->change_amount)}}</td>
                            <td>{{date('d-m-Y H:i:s', strtotime($dd->created_at))}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection