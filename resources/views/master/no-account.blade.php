@extends('app.layout')

@section('header')
@include('app.header')
@endsection

@section('content')
@include('flash-message')
<div class="card">
    <div class="card-header">
        Tgl Update ({{ empty($na->updated_at) ? $na->created_at : $na->updated_at }})
    </div>
    <div class="card-body">
        <form action="" method="post" class="needs-validation" novalidate>
        @csrf
            <input type="hidden" name="id" value="{{$na->id}}">
            <div class="row">
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Pendaftaran <div class="required">*</div></label>
                    <input type="text" class="form-control @error('account') is-invalid @enderror" name="account" value="{{$na->account}}" required>
                    @error('account')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Pendaftaran Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Jumlah Digit <div class="required">*</div></label>
                    <input type="text" class="form-control @error('account_digit') is-invalid @enderror" name="account_digit" value="{{$na->account_digit}}" required>
                    @error('account_digit')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Jumlah Digit Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Minimal Acak <div class="required">*</div></label>
                    <input type="text" class="form-control @error('account_min') is-invalid @enderror" name="account_min" value="{{$na->account_min}}" required>
                    @error('account_min')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Minimal Acak Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Maksimal Acak <div class="required">*</div></label>
                    <input type="text" class="form-control @error('account_max') is-invalid @enderror" name="account_max" value="{{$na->account_max}}" required>
                    @error('account_max')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Maksimal Acak Wajib Diisi!</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Pembayaran <div class="required">*</div></label>
                    <input type="text" class="form-control @error('account2') is-invalid @enderror" name="account2" value="{{$na->account2}}" required>
                    @error('account2')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Pendaftaran Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Jumlah Digit <div class="required">*</div></label>
                    <input type="text" class="form-control @error('account2_digit') is-invalid @enderror" name="account2_digit" value="{{$na->account2_digit}}" required>
                    @error('account2_digit')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Jumlah Digit Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Minimal Acak <div class="required">*</div></label>
                    <input type="text" class="form-control @error('account2_min') is-invalid @enderror" name="account2_min" value="{{$na->account2_min}}" required>
                    @error('account2_min')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Minimal Acak Wajib Diisi!</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">Maksimal Acak <div class="required">*</div></label>
                    <input type="text" class="form-control @error('account2_max') is-invalid @enderror" name="account2_max" value="{{$na->account2_max}}" required>
                    @error('account2_max')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                    <div class="invalid-feedback">Maksimal Acak Wajib Diisi!</div>
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