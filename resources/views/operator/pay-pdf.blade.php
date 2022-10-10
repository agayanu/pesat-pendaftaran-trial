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
        .up {
            font-size: 10px;
            margin-left: auto;
            margin-right: auto;
        }
        .puraian {
            font-size: 10px;
            margin-left: 10px;
            margin-bottom: 5px;
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
        .ttotal {
            text-align: right;
        }
    </style>
</head>
<body>
    <img src="{{url('images/'.$school->letter_head)}}" width="100%" alt="">
    <div class="alert alert-danger" role="alert" style="text-align: center">
        TRIAL MODE
    </div>
	<center>
		<h4 class="head1">BUKTI PEMBAYARAN KEUANGAN SISWA BARU</h4>
        <h5 class="head2">KELAS {{strtoupper($data_daftar->grade)}}</h5>
        <h5 class="head3">{{$school->school_year}}</h5>
	</center>
    
	<table>
        <tr>
            <td>No. Pendaftaran</td>
            <td>:</td>
            <td>{{$data_daftar->no_regist}}</td>
        </tr>
        <tr>
            <td>Sudah Terima Dari</td>
            <td>:</td>
            <td>{{$data_daftar->name}}</td>
        </tr>
        <tr>
            <td class="valigntop">Asal Sekolah</td>
            <td class="valigntop">:</td>
            <td>{{$data_daftar->school_name ?? $data_daftar->remark}}</td>
        </tr>
	</table><hr class="s1">
    <p class="puraian">Uraian Pembayaran</p>
    <table class="up">
        @foreach ($dataPay as $dp)
        <tr>
            <td>{{$dp->myorder}}.&nbsp;&nbsp;</td>
            <td width="250px">{{$dp->name}}</td>
            <td>Rp. </td>
            <td class="ttotal">{{number_format($dp->amount)}}</td>
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td class="ttotal">Jumlah&nbsp;&nbsp;</td>
            <td>Rp.&nbsp;&nbsp;</td>
            <td>{{number_format($dataPaySum)}}</td>
        </tr>
    </table>
    <hr class="s1">
    <div class="sign">
        <div class="sign-width">
            <div class="sign-date">{{$school->distric}}, {{$tgl}}</div>
        </div>
        <div class="sign-width">
            <div class="sign-name-desc">Petugas Pembayaran</div>
        </div>
        <div class="sign-width">
            <div class="sign-name">( {{$op}} )</div>
        </div>
    </div>
    <hr class="s2"><hr class="s3">
    <div class="note">
        <h6>Note:</h6>
        <ul>
            <li>{{$hotline->name}} : {{$hotline->lines}} ({{$hotline->type}})</li>
        </ul>
    </div>
</body>
</html>