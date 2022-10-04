@extends('app.layout')

@section('header')
@include('app.header')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
@endsection

@section('content')
@include('flash-message')
<div class="card mb-3">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <div>Tgl Update ({{ empty($s->updated_at) ? $s->created_at : $s->updated_at }})</div>
        <a href="{{url('seleksi-master/cetak-pdf')}}" class="btn btn-sm btn-primary">Preview Contoh</a>
      </div>
    </div>
    <div class="card-body">
        <form action="" method="post" class="needs-validation" novalidate>
        @csrf
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <label class="form-label"><b>Setelah memperhatikan :</b> <div class="required">*</div></label>
                    <textarea name="first_nounce" id="first_nounce" class="form-control @error('first_nounce') is-invalid @enderror" required>{{$s->first_nounce}}</textarea>
                    @error('first_nounce')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Setelah memperhatikan Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <div class="row">
              <div class="col-sm-12 mb-3">
                  <label class="form-label"><b>Keterangan :</b> <div class="required">*</div></label>
                  <textarea name="last_nounce" id="last_nounce" class="form-control @error('last_nounce') is-invalid @enderror" required>{{$s->last_nounce}}</textarea>
                  @error('last_nounce')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @else
                  <div class="invalid-feedback">Keterangan Wajib Diisi!</div>
                  @enderror
              </div>
          </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
<img src="{{asset('images/load.gif')}}" id="spinner" class="spin hide">
@endsection

@section('footer')
<script>
CKEDITOR.replace('first_nounce');
CKEDITOR.replace('last_nounce');
</script>
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
</script>
@endsection