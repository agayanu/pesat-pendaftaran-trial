@extends('app.layout')

@section('header')
@include('app.header')
<script src="{{ asset('jquery/2.1.1.min.js') }}"></script>
@include('app.select2')
@endsection

@section('content')
@include('flash-message')
<div class="row justify-content-center">
    <div class="col-sm-6">
        <div class="card mb-3">
            <div class="card-body">
                <form action="" method="post" class="validation-create" novalidate>
                @csrf
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Nama <div class="required">*</div></label>
                            <select name="id_regist" id="id_regist" class="form-select @error('id_regist') is-invalid @enderror" required>
                                <option value="">Cari Nomor, Nama atau Email</option>
                            </select>
                            @error('id_regist')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                            <div class="invalid-feedback">Nama Wajib Diisi!</div>
                            @enderror
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Keterangan <div class="required">*</div></label>
                            <input type="remark" name="remark" class="form-control @error('remark') is-invalid @enderror" required>
                            @error('remark')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @else
                            <div class="invalid-feedback">Keterangan Wajib Diisi!</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
                <img src="{{asset('images/load.gif')}}" id="spinner-create" class="spin hide">
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script>
$(document).ready(function () {
    $("#id_regist").select2({
        ajax: {
            url: "{{route('mundur-search', ['period_select'=>$ps])}}".replace(/&amp;/g, "&"),
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    _token: "{{ csrf_token() }}",
                    term: params.term,
                    page: params.current_page
                };
            },
            processResults: function(data, params) {
                params.current_page = params.current_page || 1;
                return {
                    results: data[0].data,
                    pagination: {
                        more: (params.current_page * 30) < data[0].total
                    }
                };
            },
            autoWidth: true,
            cache: true
        },
        minimumInputLength: 1,
        templateResult: formatRegist,
        templateSelection: formatRegistSelection
    });

    function formatRegist(regist) {
        if (regist.loading) {
            return regist.text;
        }

        var $container = $(
            "<div class='select2-result-regist clearfix'>" +
            "<div class='select2-result-regist__name'></div>" +
            "<div class='select2-result-regist__email'></div>" +
            "</div>" +
            "</div>" +
            "</div>"
        );

        $container.find(".select2-result-regist__name").text(regist.name);
        $container.find(".select2-result-regist__email").text(regist.email);

        return $container;
    }

    function formatRegistSelection(regist) {
        return regist.name || regist.text;
    }
});

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