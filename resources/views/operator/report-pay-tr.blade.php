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
                <form action="{{route('report-bayar-transaksi-download')}}" method="get" class="mb-3">
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
                        <th>Metode</th>
                        <th>Jumlah</th>
                        <th>Tgl Transaksi</th>
                        <th>Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Show</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Periode</label>
                        <input type="text" class="form-control" id="period" disabled>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Gelombang</label>
                        <input type="text" class="form-control" id="phase" disabled>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Nomor</label>
                        <input type="text" class="form-control" id="no_regist" disabled>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" disabled>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Kelompok</label>
                        <input type="text" class="form-control" id="grade" disabled>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="major" disabled>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Metode</label>
                        <input type="text" class="form-control" id="method" disabled>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Tgl Transfer</label>
                        <input type="text" class="form-control" id="transfer_date" disabled>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">No. Transfer</label>
                        <input type="text" class="form-control" id="transfer_no" disabled>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="remark" disabled>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="text" class="form-control" id="amount" disabled>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Tgl Transaksi</label>
                        <input type="text" class="form-control" id="tr_at" disabled>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label class="form-label">Update</label>
                        <input type="text" class="form-control" id="update" disabled>
                    </div>
                </div>
            </div>
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
        ajax: "{{ route('report-bayar-transaksi-data', ['period_select'=>$ps,'created_from'=>$cf,'created_to'=>$ct]) }}".replace(/&amp;/g, "&"),
        columns: [
            {data: 'period', name: 'period'},
            {data: 'phase', name: 'phase'},
            {data: 'no_regist', name: 'no_regist'},
            {data: 'name', name: 'name'},
            {data: 'grade', name: 'grade'},
            {data: 'major', name: 'major'},
            {data: 'method', name: 'method'},
            {data: 'amount', name: 'amount', render: DataTable.render.number()},
            {data: 'tr_at', name: 'tr_at'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true
    });
});
</script>
<script>
var show = document.getElementById('show');
show.addEventListener('show.coreui.modal', function (event) {
    var button = event.relatedTarget;
    var periode = button.getAttribute('data-coreui-periode');
    var gelombang = button.getAttribute('data-coreui-gelombang');
    var noDaftar = button.getAttribute('data-coreui-nodaftar');
    var nama = button.getAttribute('data-coreui-nama');
    var kelompok = button.getAttribute('data-coreui-kelompok');
    var jurusan = button.getAttribute('data-coreui-jurusan');
    var metode = button.getAttribute('data-coreui-metode');
    var tglTransfer = button.getAttribute('data-coreui-tgltransfer');
    var noTransfer = button.getAttribute('data-coreui-notransfer');
    var keterangan = button.getAttribute('data-coreui-keterangan');
    var jumlah = button.getAttribute('data-coreui-jumlah');
    var tglTransaksi = button.getAttribute('data-coreui-tgltransaksi');
    var update = button.getAttribute('data-coreui-update');
    var modalTitle = show.querySelector('.modal-title');
    var modalBodyPeriode = show.querySelector('.modal-body #period');
    var modalBodyGelombang = show.querySelector('.modal-body #phase');
    var modalBodyNoDaftar = show.querySelector('.modal-body #no_regist');
    var modalBodyNama = show.querySelector('.modal-body #name');
    var modalBodyKelompok = show.querySelector('.modal-body #grade');
    var modalBodyJurusan = show.querySelector('.modal-body #major');
    var modalBodyMetode = show.querySelector('.modal-body #method');
    var modalBodyTglTransfer = show.querySelector('.modal-body #transfer_date');
    var modalBodyNoTransfer = show.querySelector('.modal-body #transfer_no');
    var modalBodyKeterangan = show.querySelector('.modal-body #remark');
    var modalBodyJumlah = show.querySelector('.modal-body #amount');
    var modalBodyTglTransaksi = show.querySelector('.modal-body #tr_at');
    var modalBodyUpdate = show.querySelector('.modal-body #update');

    modalTitle.textContent = 'Show ' + nama;
    modalBodyPeriode.value = periode;
    modalBodyGelombang.value = gelombang;
    modalBodyNoDaftar.value = noDaftar;
    modalBodyNama.value = nama;
    modalBodyKelompok.value = kelompok;
    modalBodyJurusan.value = jurusan;
    modalBodyMetode.value = metode;
    modalBodyTglTransfer.value = tglTransfer;
    modalBodyNoTransfer.value = noTransfer;
    modalBodyKeterangan.value = keterangan;
    modalBodyJumlah.value = jumlah;
    modalBodyTglTransaksi.value = tglTransaksi;
    modalBodyUpdate.value = update;
});
</script>
@endsection