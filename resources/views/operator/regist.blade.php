@extends('app.layout')

@section('header')
@include('app.header')
@include('app.header-datatable')
@include('app.datetimepicker')
@include('app.tooltips')
@endsection

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-header">
        <a class="btn btn-sm btn-primary" href="{{route('pendaftaran-tambah')}}"><i class="cil-plus" style="font-weight:bold"></i> Tambah</a>
    </div>
    <div class="card-body">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Password Default: 123456</strong>
            <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-sm-2 mb-3">
                            <label class="form-label">Dari Tanggal <div class="required">*</div></label>
                            <input type="text" class="form-control @error('created_from') is-invalid @enderror" name="created_from" id="created_from" placeholder="dd-mm-yyyy" value="{{old('created_from') ?? $cf}}" required>
                            @error('created_from')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                            <div class="invalid-feedback">Dari Tanggal Wajib Diisi!</div>
                            @enderror
                        </div>
                        <div class="col-sm-2 mb-3">
                            <label class="form-label">Sampai Tanggal <div class="required">*</div></label>
                            <input type="text" class="form-control @error('created_to') is-invalid @enderror" name="created_to" id="created_to" placeholder="dd-mm-yyyy" value="{{old('created_to') ?? $ct}}" required>
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
            <div class="col-sm-2 align-self-end">
                <div class="row justify-content-end">
                    <div class="col-12 mb-3">
                        <form action="{{route('pendaftaran-download')}}" method="get" style="display: inline-block;">
                            <input type="hidden" name="created_from_d" value="{{$cf}}">
                            <input type="hidden" name="created_to_d" value="{{$ct}}">
                            <input type="hidden" name="period_select_d" value="{{$ps}}">
                            <button class="btn btn-sm btn-success tooltips" type="submit">
                                <i class="cil-cloud-download" style="font-weight: bold;font-size: 20px;"></i> Excel
                                <span class="tooltiptext">Download Excel</span>
                            </button>
                        </form>
                        <form action="{{route('pendaftaran-download-all')}}" method="get" style="display: inline-block;">
                            <input type="hidden" name="created_from_d" value="{{$cf}}">
                            <input type="hidden" name="created_to_d" value="{{$ct}}">
                            <input type="hidden" name="period_select_d" value="{{$ps}}">
                            <button class="btn btn-sm btn-success tooltips" type="submit">
                                <i class="cil-cloud-download" style="font-weight: bold;font-size: 20px;"></i> Excel All
                                <span class="tooltiptext">Download Excel All</span>
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
                        <th>Periode</th>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>Asal Sekolah</th>
                        <th>Gelombang</th>
                        <th>Kelompok</th>
                        <th>Jurusan</th>
                        <th>Status</th>
                        <th>Tgl Daftar</th>
                        <th>Tgl Diterima</th>
                        <th>User</th>
                        <th>Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
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
                <p class="lead">Data yang akan dihapus diantara lain :</p>
                <ul class="lead">
                    <li>Data Pendaftaran</li>
                    <li>Data Keluarga</li>
                    <li>Data Dokumen</li>
                    <li>Data Akun</li>
                    <li>Transaksi Pendaftaran</li>
                    <li>Transaksi Whatsapp</li>
                </ul>
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
            ajax: "{{ route('pendaftaran-data', ['created_from'=>$cf,'created_to'=>$ct,'period_select'=>$ps]) }}".replace(/&amp;/g, "&"),
            columns: [
                {data: 'period', name: 'period'},
                {data: 'no_regist', name: 'no_regist'},
                {data: 'name', name: 'name'},
                {data: 'gender', name: 'gender'},
                {data: 'school', name: 'school'},
                {data: 'phase', name: 'phase'},
                {data: 'grade', name: 'grade'},
                {data: 'major', name: 'major'},
                {data: 'status', name: 'status'},
                {data: 'regist_date', name: 'regist_date'},
                {data: 'receive_date', name: 'receive_date'},
                {data: 'user', name: 'user'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true
    });
});

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