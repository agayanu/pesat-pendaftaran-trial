<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Tanda Terima {{$school->name}}</title>
    <link rel="stylesheet" href="{{asset('bootstrap/4.4.1-style.css')}}">
    <style>
        @page {
            margin-top:10px;
        }
        .valigntop {
            vertical-align: text-top;
        }
        h4.head1 {
            margin-bottom: 0px;
            font-size: 14px;
        }
        h5.head2 {
            margin-bottom: 0px;
            font-size: 12px;
        }
        h5.head3 {
            font-size: 12px;
        }
        table {
            font-size: 10px;
            margin-left: 30px;
        }
        .sign {
            font-size: 10px;
        }
        .sign-name {
            margin-top: 40px;
        }
        hr.s1 {
            border:none;
            height: -1px;
            background-color: black;
            margin-bottom: -5px;
        }
        hr.s2 {
            border:none;
            height: -1px;
            background-color: black;
            margin-top: 3px;
        }
        hr.s3 {
            border:none;
            height: -1px;
            background-color: black;
            margin-top: -14px;
        }
        .sign-width {
            width: 150px;
            text-align: center;
            margin-left: auto;
        }
        .note {
            margin-left: 10px;
        }
        .note h6 {
            font-size: 12px;
            margin-top: -8px;
            margin-bottom: 1px;
        }
        .note ul {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <img src="{{url('images/'.$school->letter_head)}}" width="100%" alt="">
	<center>
		<h4 class="head1">TANDA TERIMA PENDAFTARAN</h4>
        <h5 class="head2">PENERIMAAN PESERTA DIDIK BARU</h5>
        <h5 class="head3">{{$school->school_year}}</h5>
	</center>
    
	<table>
        <tr>
            <td>No Pendaftaran</td>
            <td>:</td>
            <td>{{$data_daftar->no_regist}}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{$data_daftar->email}}</td>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td>123456</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{$data_daftar->name}}</td>
        </tr>
        <tr>
            <td class="valigntop">Asal Sekolah</td>
            <td class="valigntop">:</td>
            <td>{{$data_daftar->school_name ?? $data_daftar->remark}}</td>
        </tr>
        <tr>
            <td>Kelompok</td>
            <td>:</td>
            <td>
            {{$data_daftar->grade}}
            </td>
        </tr>
        <tr>
            <td>Program Peminatan</td>
            <td>:</td>
            <td>
            {{$data_daftar->major}}
            </td>
        </tr>
        <tr>
            <td>Gelombang</td>
            <td>:</td>
            <td>{{$data_daftar->phase}}</td>
        </tr>
        @if($data_daftar->phase_cost === 'Y')
        @php
        $amount = number_format($phase_cost->amount);
        @endphp
        <tr>
            <td>Biaya Pendaftaran</td>
            <td>:</td>
            <td>{{$amount}}</td>
        </tr>
        @endif
	</table><hr class="s1">
    <div class="sign">
        <div class="sign-width">
            <div class="sign-date">{{$school->distric}}, {{$tgl}}</div>
        </div>
        <div class="sign-width">
            <div class="sign-name-desc">Petugas Pendaftaran</div>
        </div>
        <div class="sign-width">
            <div class="sign-name">( {{$op}} )</div>
        </div>
    </div>
    <hr class="s2"><hr class="s3">
    <div class="note">
        <h6>Note:</h6>
        <ul>
            @foreach($data_info as $di)
            <li>{{$di->name}} : {{$di->lines}} ({{$di->type_name}})</li>
            @endforeach
            <li>Silahkan lengkapi data anda di <a href="{{url('login')}}">{{url('login')}}</a></li>
        </ul>
    </div>
</body>
</html>