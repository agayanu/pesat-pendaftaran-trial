<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Diterima {{$school->name}}</title>
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
            font-size: 18px;
        }
        h5.head2 {
            margin-bottom: 0px;
            font-size: 18px;
        }
        h5.head3 {
            font-size: 18px;
        }
        table {
            font-size: 14px;
            margin-left: 30px;
        }
        .first-nounce {
            font-size: 14px;
        }
        .first-nounce p {
            margin-top: 8px;
            margin-bottom: 3px;
        }
        .nounce {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            border: 2px solid black;
            padding: 5px;
            margin-bottom: 5px;
        }
        .last-nounce {
            font-size: 14px;
        }
        .sign {
            font-size: 14px;
        }
        .sign-name {
            margin-top: 40px;
        }
        .sign-width {
            width: 190px;
            text-align: center;
            margin-left: auto;
            margin-right: 100px;
        }
    </style>
</head>
<body>
    @foreach ($data_pdf as $dp)
    <img src="{{url('images/'.$school->letter_head)}}" width="100%" alt="">
    <div class="alert alert-danger" role="alert" style="text-align: center">
        TRIAL MODE
    </div>
	<center>
		<h4 class="head1">HASIL SELEKSI</h4>
        <h5 class="head2">PENERIMAAN PESERTA DIDIK BARU</h5>
        <h5 class="head3">{{$school->school_year}}</h5>
	</center>
    
	<table>
        <tr>
            <td width="150px">No. Pendaftaran</td>
            <td>:</td>
            <td>{{$dp['no_regist']}}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{$dp['name']}}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td>{{$dp['place']}}, {{$dp['birthday']}}</td>
        </tr>
        <tr>
            <td style="vertical-align:top">Asal Sekolah</td>
            <td style="vertical-align:top">:</td>
            <td>{{$dp['school']}}</td>
        </tr>
        <tr>
            <td>Nama Orangtua</td>
            <td>:</td>
            <td>{{$dp['parent_dad']}} - {{$dp['parent_mom']}}</td>
        </tr>
        <tr>
            <td>Pekerjaan Orangtua</td>
            <td>:</td>
            <td>{{$dp['parent_dad_job']}} - {{$dp['parent_mom_job']}}</td>
        </tr>
        <tr>
            <td>No. HP Orangtua</td>
            <td>:</td>
            <td>{{$dp['parent_dad_hp']}} - {{$dp['parent_mom_hp']}}</td>
        </tr>
        <tr>
            <td style="vertical-align:top">Alamat</td>
            <td style="vertical-align:top">:</td>
            <td>{{$dp['address']}}</td>
        </tr>
	</table>
    <div class="first-nounce">
        <p><i><b>Setelah memperhatikan :</b></i></p>
        {!! $sel->first_nounce !!}
    </div>
    <div class="nounce">DITERIMA DI KELAS {{$dp['grade']}} {{$dp['major']}}</div>
    <div class="last-nounce">
        {!! $sel->last_nounce !!}
    </div>
    <div class="sign">
        <div class="sign-width">
            <div class="sign-date">{{$school->distric}}, {{$tgl}}</div>
        </div>
        <div class="sign-width">
            <div class="sign-name-desc">Ketua</div>
        </div>
        <div class="sign-width">
            <div class="sign-name">( {{$school->chairman}} )</div>
        </div>
    </div>
    @endforeach
</body>
</html>