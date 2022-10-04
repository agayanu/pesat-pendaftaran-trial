@extends('app.layout')

@section('header')
<link rel="stylesheet" href="{{ asset('datetimepicker/css/bootstrap-datetimepicker.css') }}">
<style>
@font-face{
    font-family:'Glyphicons Halflings';
    src:url(fonts/glyphicons-halflings-regular.woff) format('woff'),url(fonts/glyphicons-halflings-regular.ttf) format('truetype')
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

.required {
    color: red;
    display: inline;
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
<script src="{{ asset('sweetalert2/9.js') }}"></script>
@endsection

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-header">Biodata</div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link @if(empty(Session::get('biodatatab'))) active @endif" id="datapribadi-tab" data-coreui-toggle="tab" data-coreui-target="#datapribadi"
                    type="button" role="tab" aria-controls="datapribadi" aria-selected="true"><i class="cil-user"></i> Data Pribadi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link @if(Session::get('biodatatab') === 'address') active @endif" id="alamat-tab" data-coreui-toggle="tab" data-coreui-target="#alamat"
                    type="button" role="tab" aria-controls="alamat" aria-selected="false"><i class="cil-location-pin"></i> Alamat</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link @if(Session::get('biodatatab') === 'school') active @endif" id="asalsekolah-tab" data-coreui-toggle="tab" data-coreui-target="#asalsekolah"
                    type="button" role="tab" aria-controls="asalsekolah" aria-selected="false"><i class="cil-bank"></i> Asal Sekolah</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link @if(Session::get('biodatatab') === 'parent') active @endif" id="orangtua-tab" data-coreui-toggle="tab" data-coreui-target="#orangtua"
                    type="button" role="tab" aria-controls="orangtua" aria-selected="false"><i class="cil-wc"></i> Orang Tua</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link @if(Session::get('biodatatab') === 'file') active @endif" id="lampiran-tab" data-coreui-toggle="tab" data-coreui-target="#lampiran"
                    type="button" role="tab" aria-controls="lampiran" aria-selected="false"><i class="cil-note-add"></i> Lampiran</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link @if(Session::get('biodatatab') === 'achievement') active @endif" id="prestasi-tab" data-coreui-toggle="tab" data-coreui-target="#prestasi"
                    type="button" role="tab" aria-controls="prestasi" aria-selected="false"><i class="cil-star"></i> Prestasi</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade @if(empty(Session::get('biodatatab'))) active show @endif" id="datapribadi" role="tabpanel" aria-labelledby="datapribadi-tab">
                @include('student.personaldata')
            </div>
            <div class="tab-pane fade @if(Session::get('biodatatab') === 'address') active show @endif" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
                @include('student.address')
            </div>
            <div class="tab-pane fade @if(Session::get('biodatatab') === 'school') active show @endif" id="asalsekolah" role="tabpanel" aria-labelledby="asalsekolah-tab">
                @include('student.school')
            </div>
            <div class="tab-pane fade @if(Session::get('biodatatab') === 'parent') active show @endif" id="orangtua" role="tabpanel" aria-labelledby="orangtua-tab">
                @include('student.parent')
            </div>
            <div class="tab-pane fade @if(Session::get('biodatatab') === 'file') active show @endif" id="lampiran" role="tabpanel" aria-labelledby="lampiran-tab">
                @include('student.file')
            </div>
            <div class="tab-pane fade @if(Session::get('biodatatab') === 'achievement') active show @endif" id="prestasi" role="tabpanel" aria-labelledby="prestasi-tab">
                @include('student.achievement')
            </div>
        </div>
    </div>
</div>
<img src="{{asset('images/load.gif')}}" id="spinner" class="spin hide">
@endsection

@section('footer')
<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    const spinner = document.getElementById('spinner');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
            Swal.fire({
                title: 'Peringatan!',
                text: 'Silahkan cek kembali form anda',
                icon: 'error',
                confirmButtonText: 'Mengerti'
            });
        }
        if (form.checkValidity()) {
            spinner.classList.toggle('show-spin');
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation-file');
    const spinner = document.getElementById('spinner');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        if (form.checkValidity()) {
            spinner.classList.toggle('show-spin');
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

@foreach($orangtua as $ot)
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation-{{$ot->id}}');
    const spinner = document.getElementById('spinner');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
            Swal.fire({
                title: 'Peringatan!',
                text: 'Silahkan cek kembali form anda',
                icon: 'error',
                confirmButtonText: 'Mengerti'
            });
        }
        if (form.checkValidity()) {
            spinner.classList.toggle('show-spin');
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
@endforeach

$('#Birthday').datetimepicker({
    locale: 'id',
    format: 'YYYY-MM-DD'
});
@foreach($orangtua as $ot)
$('#Birthday_Orangtua_{{$ot->id}}').datetimepicker({
    locale: 'id',
    format: 'YYYY-MM-DD'
});
@endforeach

var uploadFile = document.getElementById('upload-file');
uploadFile.addEventListener('show.coreui.modal', function (event) {
  var button = event.relatedTarget
  var recipient = button.getAttribute('data-coreui-uploadfile')
  var recipientTitle = button.getAttribute('data-coreui-uploadfiletitle')
  var modalTitle = uploadFile.querySelector('.modal-title')
  var modalBodyInput = uploadFile.querySelector('.modal-body #upload-file-id')

  modalTitle.textContent = 'Unggah File ' + recipientTitle
  modalBodyInput.value = recipient
});

var viewFile = document.getElementById('view-file');
viewFile.addEventListener('show.coreui.modal', function (event) {
  var button = event.relatedTarget
  var recipient = button.getAttribute('data-coreui-file')
  var recipientTitle = button.getAttribute('data-coreui-filetitle')
  var modalTitle = viewFile.querySelector('.modal-title')
  var modalBodyInput = viewFile.querySelector('.modal-body #file-name')

  modalTitle.textContent = 'Lihat File ' + recipientTitle
  modalBodyInput.src = recipient
});

var lihatPrestasi = document.getElementById('lihat-prestasi');
lihatPrestasi.addEventListener('show.coreui.modal', function (event) {
  var button = event.relatedTarget
  var group = button.getAttribute('data-coreui-group')
  var name = button.getAttribute('data-coreui-name')
  var rank = button.getAttribute('data-coreui-rank')
  var level = button.getAttribute('data-coreui-level')
  var year = button.getAttribute('data-coreui-year')
  var remark = button.getAttribute('data-coreui-remark')
  var modalTitle = lihatPrestasi.querySelector('.modal-title')
  var modalGroup = lihatPrestasi.querySelector('.modal-body #group')
  var modalName = lihatPrestasi.querySelector('.modal-body #name')
  var modalRank = lihatPrestasi.querySelector('.modal-body #rank')
  var modalLevel = lihatPrestasi.querySelector('.modal-body #level')
  var modalYear = lihatPrestasi.querySelector('.modal-body #year')
  var modalRemark = lihatPrestasi.querySelector('.modal-body #remark')

  modalTitle.textContent = 'Lihat Data ' + name
  modalGroup.value = group
  modalName.value = name
  modalRank.value = rank
  modalLevel.value = level
  modalYear.value = year
  modalRemark.value = remark
});

var editPrestasi = document.getElementById('edit-prestasi');
editPrestasi.addEventListener('show.coreui.modal', function (event) {
  var button = event.relatedTarget
  var id = button.getAttribute('data-coreui-id')
  var group = button.getAttribute('data-coreui-group')
  var name = button.getAttribute('data-coreui-name')
  var rank = button.getAttribute('data-coreui-rank')
  var level = button.getAttribute('data-coreui-level')
  var year = button.getAttribute('data-coreui-year')
  var remark = button.getAttribute('data-coreui-remark')
  var modalTitle = editPrestasi.querySelector('.modal-title')
  var modalId = editPrestasi.querySelector('.modal-body #id')
  var modalGroup = editPrestasi.querySelector('.modal-body #group')
  var modalName = editPrestasi.querySelector('.modal-body #name')
  var modalRank = editPrestasi.querySelector('.modal-body #rank')
  var modalLevel = editPrestasi.querySelector('.modal-body #level')
  var modalYear = editPrestasi.querySelector('.modal-body #year')
  var modalRemark = editPrestasi.querySelector('.modal-body #remark')

  modalTitle.textContent = 'Edit Data ' + name
  modalId.value = id
  modalGroup.value = group
  modalName.value = name
  modalRank.value = rank
  modalLevel.value = level
  modalYear.value = year
  modalRemark.value = remark
});

var hapusPrestasi = document.getElementById('hapus-prestasi');
hapusPrestasi.addEventListener('show.coreui.modal', function (event) {
  var button = event.relatedTarget
  var name = button.getAttribute('data-coreui-name')
  var url = button.getAttribute('data-coreui-url')
  var modalTitle = hapusPrestasi.querySelector('.modal-title')
  var modalForm = hapusPrestasi.querySelector('.modal-body #hapus-form')
  var modalPesan = hapusPrestasi.querySelector('.modal-body #pesan')

  modalTitle.textContent = 'Hapus Data ' + name
  modalForm.action = url
  modalPesan.textContent = 'Yakin akan menghapus ' + name + ' ???'
});
</script>
<script src="{{ asset('jquery/ajax-1.12.0.js') }}"></script>
<script type="text/javascript">
$('#search-tinggal').on('keyup',function(){
    $('#tbody-search-tinggal').html('<tr><td colspan="4" style="text-align: center;">Tunggu sebentar ...</td></tr>');
    $value=$(this).val();
    $.ajax({
        type : 'get',
        url : '{{url('cari-kec')}}',
        data : {'search':$value, 'address':'stay'},
        success:function(data){
            if(data){
                $('#tbody-search-tinggal').html(data);
            }else{
                $('#tbody-search-tinggal').html('<tr><td colspan="4" style="text-align: center;">Tidak ditemukan! Coba kata kunci yang lain!</td></tr>');
            }
        }
    });
});
$('#search-rumah').on('keyup',function(){
    $('#tbody-search-rumah').html('<tr><td colspan="4" style="text-align: center;">Tunggu sebentar ...</td></tr>');
    $value=$(this).val();
    $.ajax({
        type : 'get',
        url : '{{url('cari-kec')}}',
        data : {'search':$value, 'address':'home'},
        success:function(data){
            if(data){
                $('#tbody-search-rumah').html(data);
            }else{
                $('#tbody-search-rumah').html('<tr><td colspan="4" style="text-align: center;">Tidak ditemukan! Coba kata kunci yang lain!</td></tr>');
            }
        }
    });
});
$('#search-smp').on('keyup',function(){
    $('#tbody-search-smp').html('<tr><td colspan="7" style="text-align: center;">Tunggu sebentar ...</td></tr>');
    $value=$(this).val();
    $.ajax({
        type : 'get',
        url : '{{url('cari-smp')}}',
        data : {'search':$value},
        success:function(data){
            if(data){
                $('#tbody-search-smp').html(data);
            }else{
                $('#tbody-search-smp').html('<tr><td colspan="7" style="text-align: center;">Tidak ditemukan! Coba kata kunci yang lain!</td></tr>');
            }
        }
    });
});
</script>
<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
@endsection