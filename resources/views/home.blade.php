@extends('app.layout')

@section('header')
@include('app.header')
<style>
.col-photo {
    flex: 0 0 auto;
    width: 13%;
}
.img-profile {
    max-width: 100%;
    height: auto;
    border-radius: 20%;
}
.hr-profile {
    margin: 5px 0;
}
.profile {
    margin-bottom: 4px;
}
.a-menu {
    text-decoration: auto;
}
.a-menu:hover {
    background-color: #34a4e0;
}
.a-menu:hover .home-menu {
    color: white;
}
.a-menu:hover .home-menu-text {
    color: white;
}
.home-menu {
    color: #34a4e0;
    font-size: 25px;
    font-weight: 800;
}
.home-menu-text {
    font-family: fantasy;
    color: #34a4e0;
}
.col-icon {
    padding: 0;
    text-align: center;
}
.col-text {
    padding: 0;
}
.col-4-menu {
    flex: 0 0 auto;
    width: 20%;
}
.btn-photo {
    margin-bottom: 5px;
    width: 70px;
    height: 18px;
    padding-left: 1px;
    padding-top: 0;
}
@media screen and (max-width: 576px) {
    .col-photo {
        flex: 0 0 auto;
        width: 100%;
        text-align: center;
    }
    .img-profile {
        max-width: 40%;
        height: auto;
    }
    .title-profile {
        width: 133px;
    }
    .col-name {
        text-align: center;
    }
    .col-4-menu {
        flex: 0 0 auto;
        width: 100%;
    }
    .home-menu-text {
        text-align: center;
    }
}
</style>
@endsection

@section('content')
@if(Auth::user()->role === '0')
@include('flash-message')
<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-photo">
                @if(!empty($bio->photo))
                    <button class="btn btn-sm btn-photo" type="button" data-coreui-toggle="modal" data-coreui-target="#upload-photo"><i class="cil-pen" style="font-weight:bold">ubah</i></button>
                    <img src="{{ asset('images/photo/'.$bio->period.'/'.$bio->photo) }}" alt="male" class="img-profile">
                @else
                    <button class="btn btn-sm btn-photo" type="button" data-coreui-toggle="modal" data-coreui-target="#upload-photo"><i class="cil-pen" style="font-weight:bold">upload</i></button>
                    @if($bio->gender_id==2)
                        <img src="{{ asset('images/photo/user_male.png') }}" alt="male" class="img-profile">
                    @elseif($bio->gender_id==1)
                        <img src="{{ asset('images/photo/user_female.png') }}" alt="female" class="img-profile">
                    @endif
                @endif
            </div>
            <div class="col">
                <div class="row">
                    <div class="col col-name">
                        <h3>{{ $bio->name }}</h3>
                    </div>
                </div>
                <hr class="hr-profile">
                <div class="row">
                    <div class="col-sm-4">
                        <table>
                            <tr>
                                <td class="title-profile"><h5>Periode</h5></td>
                                <td><h5>:&nbsp;</h5></td>
                                <td><div class="profile">{{ $bio->period }}</div></td>
                            </tr>
                            <tr>
                                <td class="title-profile"><h5>No. Registrasi</h5></td>
                                <td><h5>:&nbsp;</h5></td>
                                <td><div class="profile">{{ $bio->no_regist }}</div></td>
                            </tr>
                            <tr>
                                <td class="title-profile"><h5>Status</h5></td>
                                <td><h5>:&nbsp;</h5></td>
                                <td><div class="profile">{{ $bio->status }}</div></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <table>
                            <tr>
                                <td class="title-profile"><h5>Kelompok</h5></td>
                                <td><h5>:&nbsp;</h5></td>
                                <td><div class="profile">{{ $bio->grade }}</div></td>
                            </tr>
                            <tr>
                                <td class="title-profile"><h5>Jurusan</h5></td>
                                <td><h5>:&nbsp;</h5></td>
                                <td><div class="profile">{{ $bio->major }}</div></td>
                            </tr>
                            <tr>
                                <td class="title-profile"><h5>Gelombang</h5></td>
                                <td><h5>:&nbsp;</h5></td>
                                <td><div class="profile">{{ $bio->phase }}</div></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <table>
                            <tr>
                                <td class="title-profile"><h5>TTL</h5></td>
                                <td><h5>:&nbsp;</h5></td>
                                <td><div class="profile">{{ $bio->place }}, {{ date_format(date_create($bio->birthday),"d/m/Y") }}</div></td>
                            </tr>
                            <tr>
                                <td class="title-profile"><h5>Agama</h5></td>
                                <td><h5>:&nbsp;</h5></td>
                                <td><div class="profile">{{ $bio->religion }}</div></td>
                            </tr>
                            <tr>
                                <td class="title-profile"><h5>Jenis Kelamin</h5></td>
                                <td><h5>:&nbsp;</h5></td>
                                <td><div class="profile">{{ $bio->gender }}</div></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-sm-3">
                <a href="{!! route('biodata') !!}" class="a-menu">
                    <div class="card a-menu">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-sm-2 col-icon">
                                    <i class="cil-people home-menu"></i>
                                </div>
                                <div class="col-4-menu col-text">
                                    <div class="home-menu-text">Biodata</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="upload-photo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="validation-create" enctype="multipart/form-data" novalidate>
                @csrf
                    <input type="hidden" name="id_regist" value="{{$bio->id}}">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label class="form-label">Pilih Photo Anda <div class="required">*</div></label>
                            <input type="file" name="photo" id="photo" class="form-control" required>
                            <div class="invalid-feedback">Photo Wajib Diisi!</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
                <img src="{{asset('images/load.gif')}}" id="spinner-create" class="spin hide">
            </div>
        </div>
    </div>
</div>
@endif
@if(Auth::user()->role === '1' || Auth::user()->role === '2')
<div class="card mb-3">
    <div class="card-body">
        @if (Auth::user()->role === '1')
        Selamat Datang Admin {{$si->name}}, <div class="text-info" style="display:inline">{{Auth::user()->name}}</div>.
        @endif
        @if (Auth::user()->role === '2')
        Selamat Datang Operator {{$si->name}}, <div class="text-info" style="display:inline">{{Auth::user()->name}}</div>.
        @endif
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-4 text-white bg-primary">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold">{{$dp}} 
                        <span class="fs-6 fw-normal">({{$dps1p}}%
                            @if ($dps1p)
                                @if ($dps1p > 0)
                                <i class="icon cil-arrow-top"></i>
                                @else
                                <i class="icon cil-arrow-bottom"></i>
                                @endif
                            @endif
                            )
                        </span>
                    </div>
                    <div>Pendaftaran</div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon cil-options"></i>
                    </button>
                </div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3">
                <div>
                    <canvas id="daftarThn" height="90px"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-4 text-white bg-info">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold">{{$bp}} 
                        <span class="fs-6 fw-normal">({{$bps1p}}%
                            @if ($bps1p)
                                @if ($bps1p > 0)
                                <i class="icon cil-arrow-top"></i>
                                @else
                                <i class="icon cil-arrow-bottom"></i>
                                @endif
                            @endif
                            )
                        </span>
                    </div>
                    <div>Pembayaran</div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon cil-options"></i>
                    </button>
                </div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3">
                <canvas id="bayarThn" height="90px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-4 text-white bg-warning">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold">{{$dtp}} 
                        <span class="fs-6 fw-normal">({{$dtps1p}}%
                            @if ($dtps1p)
                                @if ($dtps1p > 0)
                                <i class="icon cil-arrow-top"></i>
                                @else
                                <i class="icon cil-arrow-bottom"></i>
                                @endif
                            @endif
                            )
                        </span>
                    </div>
                    <div>Diterima</div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon cil-options"></i>
                    </button>
                </div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3">
                <canvas id="diterimaThn" height="90px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-4 text-white bg-danger">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold">{{$mp}} 
                        <span class="fs-6 fw-normal">({{$mps1p}}%
                            @if ($mps1p)
                                @if ($mps1p > 0)
                                <i class="icon cil-arrow-top"></i>
                                @else
                                <i class="icon cil-arrow-bottom"></i>
                                @endif
                            @endif
                            )
                        </span>
                    </div>
                    <div>Mundur</div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon cil-options"></i>
                    </button>
                </div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3">
                <canvas id="mundurThn" height="90px"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="card-title mb-0">Pendaftaran</h4>
                <div class="small text-medium-emphasis">{{$si->school_year}}</div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-6 col-lg-4">
                <div class="card mb-4" style="--cui-card-cap-bg: #3b5998">
                    <div class="card-header position-relative d-flex justify-content-center align-items-center">
                        <li class="icon icon-3xl text-white my-4 cil-wc"></li>
                        <div class="chart-wrapper position-absolute top-0 start-0 w-100 h-100">
                            <canvas id="social-box-chart-1" height="90"></canvas>
                        </div>
                    </div>
                    <div class="card-body row text-center">
                        <div class="col">
                            <div class="fs-5 fw-semibold">{{$jkl}}</div>
                            <div class="text-uppercase text-medium-emphasis small">Laki-Laki</div>
                        </div>
                        <div class="vr"></div>
                        <div class="col">
                            <div class="fs-5 fw-semibold">{{$jkp}}</div>
                            <div class="text-uppercase text-medium-emphasis small">Perempuan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card mb-4" style="--cui-card-cap-bg: #00aced">
                    <div class="card-header position-relative d-flex justify-content-center align-items-center">
                        <li class="icon icon-3xl text-white my-4 cil-group"></li>
                        <div class="chart-wrapper position-absolute top-0 start-0 w-100 h-100">
                            <canvas id="social-box-chart-1" height="90"></canvas>
                        </div>
                    </div>
                    <div class="card-body row text-center">
                        <div class="col">
                            <div class="fs-5 fw-semibold">{{$gradeU}}</div>
                            <div class="text-uppercase text-medium-emphasis small">Unggulan</div>
                        </div>
                        <div class="vr"></div>
                        <div class="col">
                            <div class="fs-5 fw-semibold">{{$gradeR}}</div>
                            <div class="text-uppercase text-medium-emphasis small">Reguler</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card mb-4" style="--cui-card-cap-bg: #8a93a2">
                    <div class="card-header position-relative d-flex justify-content-center align-items-center">
                        <li class="icon icon-3xl text-white my-4 cil-contact"></li>
                        <div class="chart-wrapper position-absolute top-0 start-0 w-100 h-100">
                            <canvas id="social-box-chart-1" height="90"></canvas>
                        </div>
                    </div>
                    <div class="card-body row text-center">
                        <div class="col">
                            <div class="fs-5 fw-semibold">{{$majorA}}</div>
                            <div class="text-uppercase text-medium-emphasis small">IPA</div>
                        </div>
                        <div class="vr"></div>
                        <div class="col">
                            <div class="fs-5 fw-semibold">{{$majorS}}</div>
                            <div class="text-uppercase text-medium-emphasis small">IPS</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h4 class="card-title mb-0">Sekolah Asal</h4>
                <div class="small text-medium-emphasis">{{$si->school_year}}</div>
            </div>
        </div>
        <canvas id="smp"></canvas>
    </div>
</div>
@endif
@endsection

@section('footer')
@if (Auth::user()->role === '0')
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
<script src="{{ asset('jquery/2.1.1.min.js') }}"></script>
<script>
$('#photo').bind('change', function() {
    var ext = $('#photo').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['jpg','jpeg']) == -1) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'File upload bukan jpg atau jpeg!'
        });
        $('#photo').val('');
    }
    else{
        var ufile = this.files[0].size;
        if(ufile > 1097152){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'File Photo Anda Melebihi 2MB!'
            });
            $('#photo').val('');
        }
    }
});
</script>
@endif
@if (Auth::user()->role === '1' || Auth::user()->role === '2')
<script src="{{asset('@coreui/vendors-injector/dist/vendors/chart.js/js/Chart.min.js')}}"></script>
<script>
const daftarThn = document.getElementById('daftarThn');
const bayarThn = document.getElementById('bayarThn');
const diterimaThn = document.getElementById('diterimaThn');
const mundurThn = document.getElementById('mundurThn');
const smp = document.getElementById('smp');
const cDaftarThn = new Chart(daftarThn, {
    type: 'line',
    data: {
        labels: ['{{$period}}', '{{$periodSub1}}', '{{$periodSub2}}'],
        datasets: [{
            label: 'Daftar',
            data: [{{$dp}}, {{$dps1}}, {{$dps2}}],
            fill: false,
            borderColor: 'rgba(255, 255, 255, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                gridLines: {
                    drawBorder:false,
                    display:false
                },
                ticks: {
                    display: false
                }
            }],
            xAxes: [{
                gridLines: {
                    drawBorder:false,
                    display:false
                },
                ticks: {
                    display: false
                }
            }]
        },
        legend: {
            display: false
        },
    }
});
const cBayarThn = new Chart(bayarThn, {
    type: 'line',
    data: {
        labels: ['{{$period}}', '{{$periodSub1}}', '{{$periodSub2}}'],
        datasets: [{
            label: 'Bayar',
            data: [{{$bp}}, {{$bps1}}, {{$bps2}}],
            fill: false,
            borderColor: 'rgba(255, 255, 255, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                gridLines: {
                    drawBorder:false,
                    display:false
                },
                ticks: {
                    display: false
                }
            }],
            xAxes: [{
                gridLines: {
                    drawBorder:false,
                    display:false
                },
                ticks: {
                    display: false
                }
            }]
        },
        legend: {
            display: false
        },

    }
});
const cDiterimaThn = new Chart(diterimaThn, {
    type: 'line',
    data: {
        labels: ['{{$period}}', '{{$periodSub1}}', '{{$periodSub2}}'],
        datasets: [{
            label: 'Diterima',
            data: [{{$dtp}}, {{$dtps1}}, {{$dtps2}}],
            fill: false,
            borderColor: 'rgba(255, 255, 255, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                gridLines: {
                    drawBorder:false,
                    display:false
                },
                ticks: {
                    display: false
                }
            }],
            xAxes: [{
                gridLines: {
                    drawBorder:false,
                    display:false
                },
                ticks: {
                    display: false
                }
            }]
        },
        legend: {
            display: false
        },
    }
});
const cMundurThn = new Chart(mundurThn, {
    type: 'line',
    data: {
        labels: ['{{$period}}', '{{$periodSub1}}', '{{$periodSub2}}'],
        datasets: [{
            label: 'Mundur',
            data: [{{$mp}}, {{$mps1}}, {{$mps2}}],
            fill: false,
            borderColor: 'rgba(255, 255, 255, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                gridLines: {
                    drawBorder:false,
                    display:false
                },
                ticks: {
                    display: false
                }
            }],
            xAxes: [{
                gridLines: {
                    drawBorder:false,
                    display:false
                },
                ticks: {
                    display: false
                }
            }]
        },
        legend: {
            display: false
        },
    }
});
const cSmp = new Chart(smp, {
    type: 'horizontalBar',
    data: {
        labels: [
            @foreach ($school as $sch)
                '{{$sch->school_name}}',
            @endforeach
        ],
        datasets: [{
            label: '#',
            data: [
                @foreach ($school as $sch)
                    '{{$sch->jml}}',
                @endforeach
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            xAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        legend: {
            display: false
        },
    }
});
</script>
@endif
@endsection