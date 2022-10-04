@extends('app.layout')

@section('header')
@include('app.header')
@endsection

@section('content')
@include('flash-message')
<div class="card">
    <div class="card-header">
        Tgl Update ({{ empty($sinfo->updated_at) ? $sinfo->created_at : $sinfo->updated_at }})
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
            <input type="hidden" name="id" value="{{$sinfo->id}}">
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label class="form-label">Nama <div class="required">*</div></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$sinfo->name}}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Nama Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-6 mb-3">
                    <label class="form-label">URL <div class="required">*</div></label>
                    <input type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{$sinfo->url}}" required>
                    @error('url')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">URL Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Nama Panggilan <div class="required">*</div></label>
                    <input type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{$sinfo->nickname}}" required>
                    @error('nickname')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Nama Panggilan Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-8 mb-3">
                    <label class="form-label">Slogan <div class="required">*</div></label>
                    <input type="text" class="form-control @error('slogan') is-invalid @enderror" name="slogan" value="{{$sinfo->slogan}}" required>
                    @error('slogan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Slogan Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label class="form-label">Alamat <div class="required">*</div></label>
                    <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required>{{$sinfo->address}}</textarea>
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Alamat Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label class="form-label">Tahun Ajaran <div class="required">*</div></label>
                    <input type="text" class="form-control @error('school_year') is-invalid @enderror" name="school_year" value="{{$sinfo->school_year}}" required>
                    @error('school_year')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Tahun Ajaran Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Icon</label>
                    @if(!empty($sinfo->icon))
                    <label class="form-label">
                        <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#view-file" data-coreui-file="{{asset('images/icons/'.$sinfo->icon)}}" data-coreui-filetitle="ICON"><i class="cil-search" style="font-weight:bold"></i></button>
                    </label>
                    @endif
                    <input type="file" class="form-control @error('icon') is-invalid @enderror" name="icon">
                    @error('icon')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Kop Surat</label>
                    @if(!empty($sinfo->letter_head))
                    <label class="form-label">
                        <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#view-file" data-coreui-file="{{asset('images/'.$sinfo->letter_head)}}" data-coreui-filetitle="KOP SURAT"><i class="cil-search" style="font-weight:bold"></i></button>
                    </label>
                    @endif
                    <input type="file" class="form-control @error('letter_head') is-invalid @enderror" name="letter_head">
                    @error('letter_head')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label class="form-label">Background</label>
                    @if(!empty($sinfo->background))
                    <label class="form-label">
                        <button class="btn btn-sm btn-success" type="button" data-coreui-toggle="modal" data-coreui-target="#view-file" data-coreui-file="{{asset('images/'.$sinfo->background)}}" data-coreui-filetitle="BACKGROUND"><i class="cil-search" style="font-weight:bold"></i></button>
                    </label>
                    @endif
                    <input type="file" class="form-control @error('background') is-invalid @enderror" name="background">
                    @error('background')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label class="form-label">Redaksi PDF (awal) <div class="required">*</div></label>
                    <textarea name="regist_pdf_message_top" rows="3" class="form-control @error('regist_pdf_message_top') is-invalid @enderror" required>{{$sinfo->regist_pdf_message_top}}</textarea>
                    @error('regist_pdf_message_top')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Redaksi PDF (awal) Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label class="form-label">Redaksi PDF (bawah) <div class="required">*</div></label>
                    <textarea name="regist_pdf_message_bottom" rows="3" class="form-control @error('regist_pdf_message_bottom') is-invalid @enderror" required>{{$sinfo->regist_pdf_message_bottom}}</textarea>
                    @error('regist_pdf_message_bottom')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Redaksi PDF (bawah) Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label class="form-label">Whatsapp API <div class="required">*</div></label>
                    <input type="text" class="form-control @error('wa_api') is-invalid @enderror" name="wa_api" value="{{$sinfo->wa_api}}">
                    @error('wa_api')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label class="form-label">Whatsapp API Key <div class="required">*</div></label>
                    <input type="text" class="form-control @error('wa_api_key') is-invalid @enderror" name="wa_api_key" value="{{$sinfo->wa_api_key}}">
                    @error('wa_api_key')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label class="form-label">Redaksi Whatsapp Registrasi<div class="required">*</div></label>
                    <textarea name="regist_wa_message" rows="3" class="form-control @error('regist_wa_message') is-invalid @enderror" required>{{$sinfo->regist_wa_message}}</textarea>
                    <div class="form-text">Kode yang tersedia: %nama%, %no_rekening_pendaftaran%, %gelombang%, %no_daftar%, %nisn%, %alamat%, %smp%, %kelompok%, %jurusan%, %url%, %email%, %alamat_sekolah%, %hotline1%</div>
                    @error('regist_wa_message')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Redaksi Whatsapp Registrasi Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label class="form-label">Redaksi Whatsapp Diterima<div class="required">*</div></label>
                    <textarea name="receive_wa_message" rows="3" class="form-control @error('receive_wa_message') is-invalid @enderror" required>{{$sinfo->receive_wa_message}}</textarea>
                    <div class="form-text">Kode yang tersedia: %nama%, %no_rekening_pembayaran%, %gelombang%, %no_daftar%, %nisn%, %alamat%, %smp%, %kelompok%, %jurusan%, %email%, %hotline1%</div>
                    @error('receive_wa_message')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Redaksi Whatsapp Diterima Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label class="form-label">Redaksi Whatsapp Pembayaran<div class="required">*</div></label>
                    <textarea name="pay_wa_message" rows="3" class="form-control @error('pay_wa_message') is-invalid @enderror" required>{{$sinfo->pay_wa_message}}</textarea>
                    <div class="form-text">Kode yang tersedia: %nama%, %gelombang%, %no_daftar%, %alamat%, %smp%, %kelompok%, %jurusan%, %email%, %hotline1%</div>
                    @error('pay_wa_message')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Redaksi Whatsapp Pembayaran Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
<div class="modal fade" id="view-file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <embed src="" id="file-name" style="max-width: 100%;">
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
</script>
@endsection