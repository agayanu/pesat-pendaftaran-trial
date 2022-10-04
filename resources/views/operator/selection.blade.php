@extends('app.layout')

@section('header')
@include('app.header')
@include('app.header-datatable')
<link rel="stylesheet" href="{{asset('datatable/1.4.0-dataTables.select.min.css')}}">
<link rel="stylesheet" href="{{asset('datatable/2.2.3-buttons.dataTables.min.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
.dt-button.primary {
    color: white;
    background-color: #321fdb;
}
.dt-button.primary:hover {
    color: white !important;
    background-color: #5141e0 !important;
}
</style>
@endsection

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-header">
        <button class="btn btn-sm btn-primary" type="button" data-coreui-toggle="modal" data-coreui-target="#tambah"><i class="cil-plus" style="font-weight:bold"></i> Tambah</button>
    </div>
    <div class="card-body">
        <form action="" method="get">
            <div class="row">
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Periode</label>
                    <select name="period_select" class="form-select">
                        @foreach ($period as $p)
                            <option value="{{$p->period}}" {{$p->period == $ps ? 'selected' : ''}}>{{$p->period}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Kelompok</label>
                    <select name="grade_select" class="form-select">
                        <option value="">--pilih--</option>
                        @foreach ($grade as $g)
                            <option value="{{$g->id}}" {{$g->id == $gs ? 'selected' : ''}}>{{$g->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Jurusan</label>
                    <select name="major_select" class="form-select">
                        <option value="">--pilih--</option>
                        @foreach ($major as $m)
                            <option value="{{$m->id}}" {{$m->id == $ms ? 'selected' : ''}}>{{$m->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2 mb-3">
                    <label class="form-label">Nomor</label>
                    <input type="text" class="form-control" name="no_regist" value="{{$no_regist}}">
                </div>
                <div class="col-sm-2 mb-3 align-self-end">
                    <button class="btn btn-sm btn-primary">Cari</button>
                </div>
            </div>
        </form>
        <hr>
        <ul class="nav nav-tabs" id="myTab">
            <li class="nav-item">
                <button class="nav-link active" id="seleksi-tab" data-coreui-toggle="tab" data-coreui-target="#seleksi" type="button" role="tab" aria-controls="seleksi" aria-selected="true">Belum Seleksi</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="diterima-tab" data-coreui-toggle="tab" data-coreui-target="#diterima" type="button" role="tab" aria-controls="diterima" aria-selected="false">Diterima</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="sudah-bayar-tab" data-coreui-toggle="tab" data-coreui-target="#sudah-bayar" type="button" role="tab" aria-controls="sudah-bayar" aria-selected="false">Sudah Bayar</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="seleksi" role="tabpanel" aria-labelledby="seleksi-tab" tabindex="0">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display nowrap" id="datatable-seleksi" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        <th>Tgl Daftar</th>
                                        <th>Kelompok</th>
                                        <th>Jurusan</th>
                                        <th>Gelombang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="diterima" role="tabpanel" aria-labelledby="diterima-tab" tabindex="0">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display nowrap" id="datatable-diterima" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        <th>Tgl Daftar</th>
                                        <th>Kelompok</th>
                                        <th>Jurusan</th>
                                        <th>Gelombang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="sudah-bayar" role="tabpanel" aria-labelledby="sudah-bayar-tab" tabindex="0">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display nowrap" id="datatable-bayar" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        <th>Tgl Daftar</th>
                                        <th>Kelompok</th>
                                        <th>Jurusan</th>
                                        <th>Gelombang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<img src="{{asset('images/load.gif')}}" id="spinner" class="spin hide">
@endsection

@section('footer')
@include('app.footer-datatable')
@include('app.footer-validation-spinner')
<script src="{{asset('datatable/1.4.0-dataTables.select.min.js')}}"></script>
<script src="{{asset('datatable/2.2.3-dataTables.buttons.min.js')}}"></script>
<script src="{{asset('datatable/3.1.3-jszip.min.js')}}"></script>
<script src="{{asset('datatable/2.2.3-buttons.html5.min.js')}}"></script>
<script>
$(function () {
    var tableSeleksi = $('#datatable-seleksi').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('seleksi-data', ['period_select'=>$ps,'grade_select'=>$gs,'major_select'=>$ms,'no_regist'=>$no_regist]) }}".replace(/&amp;/g, "&"),
        rowId: 'id',
        columns: [
            {defaultContent: ''},
            {data: 'no_regist', name: 'no_regist'},
            {data: 'name', name: 'name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'grade', name: 'grade'},
            {data: 'major', name: 'major'},
            {data: 'phase', name: 'phase'},
        ],
        responsive: true,
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
        } ],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },
        dom: 'Blfrtip',
        buttons: [
            {
                text: 'Pilih Semua',
                action: function () {
                    tableSeleksi.rows().select();
                }
            },
            {
                text: 'Batal Semua',
                action: function () {
                    tableSeleksi.rows().deselect();
                }
            },
            'excelHtml5',
            {
                text: 'Proses Seleksi',
                className: 'primary',
                action: function () {
                    const spinner = document.getElementById('spinner');
                    spinner.classList.toggle('show-spin');
                    var selectedData = tableSeleksi.rows( { selected: true } ).data().toArray();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{url('seleksi')}}",
                        dataType: 'json',
                        data: {json: JSON.stringify(selectedData)},
                        error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            // alert(err.message);
                            var exc = err.exception;
                            if(exc = 'Swift_TransportException') {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Email, Whatsapp dan PDF Gagal terbuat. Server Email Gagal Terkoneksi. Silahkan hubungi administrator!',
                                    icon: 'error',
                                    confirmButtonText: 'Mengerti'
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi Kesalahan. Silahkan hubungi administrator!',
                                    icon: 'error',
                                    confirmButtonText: 'Mengerti'
                                });
                            }
                        }
                    });
                }
            }
        ],
        order: [[ 1, 'asc' ]]
    });

    var tableDiterima = $('#datatable-diterima').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('seleksi-data-diterima', ['period_select'=>$ps,'grade_select'=>$gs,'major_select'=>$ms,'no_regist'=>$no_regist]) }}".replace(/&amp;/g, "&"),
        rowId: 'id',
        columns: [
            {defaultContent: ''},
            {data: 'no_regist', name: 'no_regist'},
            {data: 'name', name: 'name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'grade', name: 'grade'},
            {data: 'major', name: 'major'},
            {data: 'phase', name: 'phase'},
        ],
        responsive: true,
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
        } ],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },
        dom: 'Blfrtip',
        buttons: [
            {
                text: 'Pilih Semua',
                action: function () {
                    tableDiterima.rows().select();
                }
            },
            {
                text: 'Batal Semua',
                action: function () {
                    tableDiterima.rows().deselect();
                }
            },
            'excelHtml5',
            {
                text: 'Cetak Ulang',
                className: 'primary',
                action: function () {
                    const spinner = document.getElementById('spinner');
                    spinner.classList.toggle('show-spin');
                    var selectedData = tableDiterima.rows( { selected: true } ).data().toArray();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{url('seleksi/cetak-ulang')}}",
                        dataType: 'json',
                        data: {json: JSON.stringify(selectedData)}
                    });
                }
            }
        ],
        order: [[ 1, 'asc' ]]
    });

    var tableBayar = $('#datatable-bayar').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('seleksi-data-bayar', ['period_select'=>$ps,'grade_select'=>$gs,'major_select'=>$ms,'no_regist'=>$no_regist]) }}".replace(/&amp;/g, "&"),
        rowId: 'id',
        columns: [
            {defaultContent: ''},
            {data: 'no_regist', name: 'no_regist'},
            {data: 'name', name: 'name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'grade', name: 'grade'},
            {data: 'major', name: 'major'},
            {data: 'phase', name: 'phase'},
        ],
        responsive: true,
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets: 0,
        } ],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },
        dom: 'Blfrtip',
        buttons: [
            {
                text: 'Pilih Semua',
                action: function () {
                    tableBayar.rows().select();
                }
            },
            {
                text: 'Batal Semua',
                action: function () {
                    tableBayar.rows().deselect();
                }
            },
            'excelHtml5',
            {
                text: 'Cetak Ulang',
                className: 'primary',
                action: function () {
                    const spinner = document.getElementById('spinner');
                    spinner.classList.toggle('show-spin');
                    var selectedData = tableBayar.rows( { selected: true } ).data().toArray();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{url('seleksi/cetak-ulang')}}",
                        dataType: 'json',
                        data: {json: JSON.stringify(selectedData)}
                    });
                }
            }
        ],
        order: [[ 1, 'asc' ]]
    });
});
</script>
@endsection