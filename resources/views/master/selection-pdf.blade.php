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
    <img src="{{url('images/'.$school->letter_head)}}" width="100%" alt="">
	<center>
		<h4 class="head1">HASIL SELEKSI</h4>
        <h5 class="head2">PENERIMAAN PESERTA DIDIK BARU</h5>
        <h5 class="head3">{{$school->school_year}}</h5>
	</center>
    
	<table>
        <tr>
            <td width="150px">No. Pendaftaran</td>
            <td>:</td>
            <td>0001</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>Aga Yanupraba</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td>Cibinong, 01 Januari {{now()->subYears(15)->format('Y')}}</td>
        </tr>
        <tr>
            <td style="vertical-align:top">Asal Sekolah</td>
            <td style="vertical-align:top">:</td>
            <td>SMA PLUS PGRI CIBINONG</td>
        </tr>
        <tr>
            <td>Nama Orangtua</td>
            <td>:</td>
            <td>William Arthur Philip Louis - Catherine Elizabeth Middleton</td>
        </tr>
        <tr>
            <td>Pekerjaan Orangtua</td>
            <td>:</td>
            <td>PEGAWAI NEGERI - PEGAWAI NEGERI</td>
        </tr>
        <tr>
            <td>No. HP Orangtua</td>
            <td>:</td>
            <td>081212345678 - 081287654321</td>
        </tr>
        <tr>
            <td style="vertical-align:top">Alamat</td>
            <td style="vertical-align:top">:</td>
            <td>Jl. Golf Ciriung, Kecamatan Cibinong, Kabupaten Bogor</td>
        </tr>
	</table>
    <div class="first-nounce">
        <p><i><b>Setelah memperhatikan :</b></i></p>
        {!! $s->first_nounce !!}
    </div>
    <div class="nounce">DITERIMA DI KELAS UNGGULAN IPA</div>
    <div class="last-nounce">
        {!! $s->last_nounce !!}
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
</body>
</html>