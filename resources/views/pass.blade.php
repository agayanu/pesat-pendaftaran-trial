@extends('app.layout')

@section('header')
<style>
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
<script src="{{ asset('sweetalert2/9.js') }}"></script>
@endsection

@section('content')
@include('flash-message')
<div class="row justify-content-md-center mb-3">
    <div class="col-sm-5">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>Ganti Password</div>
                    <button class="btn btn-sm btn-primary" type="button" data-coreui-toggle="modal" data-coreui-target="#email"><i class="cil-pen" style="font-weight:bold"></i> Ganti Email</button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('gantipass') }}" method="post" class="needs-validation" novalidate>
                @csrf
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Password Lama <div class="required">*</div></label>
                            <div class="input-group" id="show-hide-old">
                                <input type="password" class="form-control @error('pass-old') is-invalid @enderror" name="pass-old" value="{{ old('pass-old') }}" required autocomplete="off">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="cil-lock-locked"></i>
                                </button>
                                @error('pass-old')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Password Lama Wajib Diisi!</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Password Baru <div class="required">*</div></label>
                            <div class="input-group" id="show-hide-new">
                                <input type="password" class="form-control @error('pass-new') is-invalid @enderror" name="pass-new" value="{{ old('pass-new') }}" required autocomplete="off">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="cil-lock-locked"></i>
                                </button>
                                @error('pass-new')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Password Baru Wajib Diisi!</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label class="form-label">Ketik Ulang Password Baru <div class="required">*</div></label>
                            <div class="input-group" id="show-hide-new-re">
                                <input type="password" class="form-control @error('pass-new-re') is-invalid @enderror" name="pass-new-re" value="{{ old('pass-new-re') }}" required autocomplete="off">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="cil-lock-locked"></i>
                                </button>
                                @error('pass-new-re')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="invalid-feedback">Ketik Ulang Password Baru Wajib Diisi!</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Ganti</button>
                </form>
            </div>
        </div>
    </div>
</div>
<img src="{{asset('images/load.gif')}}" id="spinner" class="spin hide">
<div class="modal fade" id="email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Email</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('ganti-email')}}" method="post" class="validation-create" novalidate>
                @csrf
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Email Lama <div class="required">*</div></label>
                            <input type="email" class="form-control" name="email_old" required>
                            <div class="invalid-feedback">Email Lama Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Email Baru <div class="required">*</div></label>
                            <input type="email" class="form-control" name="email_new" required>
                            <div class="invalid-feedback">Email Baru Wajib Diisi!</div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Password <div class="required">*</div></label>
                            <div class="input-group" id="show-hide-email">
                                <input type="password" class="form-control" name="password" required autocomplete="off">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="cil-lock-locked"></i>
                                </button>
                                <div class="invalid-feedback">Password Wajib Diisi!</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
                <img src="{{asset('images/load.gif')}}" id="spinner-email" class="spin hide">
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
$(document).ready(function() {
    $("#show-hide-old button").on('click', function(event) {
        event.preventDefault();
        if($('#show-hide-old input').attr("type") === "text"){
            $('#show-hide-old input').attr('type', 'password');
            $('#show-hide-old i').addClass( "cil-lock-locked" );
            $('#show-hide-old i').removeClass( "cil-lock-unlocked" );
        }
        else if($('#show-hide-old input').attr("type") === "password"){
            $('#show-hide-old input').attr('type', 'text');
            $('#show-hide-old i').addClass( "cil-lock-unlocked" );
            $('#show-hide-old i').removeClass( "cil-lock-locked" );
        }
    });

    $("#show-hide-new button").on('click', function(event) {
        event.preventDefault();
        if($('#show-hide-new input').attr("type") === "text"){
            $('#show-hide-new input').attr('type', 'password');
            $('#show-hide-new i').addClass( "cil-lock-locked" );
            $('#show-hide-new i').removeClass( "cil-lock-unlocked" );
        }
        else if($('#show-hide-new input').attr("type") === "password"){
            $('#show-hide-new input').attr('type', 'text');
            $('#show-hide-new i').addClass( "cil-lock-unlocked" );
            $('#show-hide-new i').removeClass( "cil-lock-locked" );
        }
    });

    $("#show-hide-new-re button").on('click', function(event) {
        event.preventDefault();
        if($('#show-hide-new-re input').attr("type") === "text"){
            $('#show-hide-new-re input').attr('type', 'password');
            $('#show-hide-new-re i').addClass( "cil-lock-locked" );
            $('#show-hide-new-re i').removeClass( "cil-lock-unlocked" );
        }
        else if($('#show-hide-new-re input').attr("type") === "password"){
            $('#show-hide-new-re input').attr('type', 'text');
            $('#show-hide-new-re i').addClass( "cil-lock-unlocked" );
            $('#show-hide-new-re i').removeClass( "cil-lock-locked" );
        }
    });

    $("#show-hide-email button").on('click', function(event) {
        event.preventDefault();
        if($('#show-hide-email input').attr("type") === "text"){
            $('#show-hide-email input').attr('type', 'password');
            $('#show-hide-email i').addClass( "cil-lock-locked" );
            $('#show-hide-email i').removeClass( "cil-lock-unlocked" );
        }
        else if($('#show-hide-email input').attr("type") === "password"){
            $('#show-hide-email input').attr('type', 'text');
            $('#show-hide-email i').addClass( "cil-lock-unlocked" );
            $('#show-hide-email i').removeClass( "cil-lock-locked" );
        }
    });
});

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