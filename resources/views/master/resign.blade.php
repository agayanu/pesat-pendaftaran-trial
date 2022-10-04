@extends('app.layout')

@section('header')
@include('app.header')
@endsection

@section('content')
@include('flash-message')
<div class="row justify-content-center">
    <div class="col-sm-3">
        <div class="card mb-3">
            <div class="card-header">Update: {{$trs->updated_at ?? $trs->created_at ?? ''}}</div>
            <div class="card-body">
                <form action="" method="post" class="validation-create" novalidate>
                @csrf
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Potongan (Persen) <div class="required">*</div></label>
                            <input type="number" step=".01" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{$trs->discount ?? ''}}" required>
                            @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                            <div class="invalid-feedback">Potongan Wajib Diisi!</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
                <img src="{{asset('images/load.gif')}}" id="spinner-create" class="spin hide">
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
(function() {
    'use strict';
    window.addEventListener('load', function() {
    var formsCreate = document.getElementsByClassName('validation-create');
    const spinnerCreate = document.getElementById('spinner-create');
    var validationCreate = Array.prototype.filter.call(formsCreate, function(form) {
        form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        if (form.checkValidity()) {
            spinnerCreate.classList.toggle('show-spin');
        }
        form.classList.add('was-validated');
        }, false);
    });
    }, false);
})();
</script>
@endsection