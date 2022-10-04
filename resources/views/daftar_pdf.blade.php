<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Data Pendaftar {{$school->name}}</title>
    <link rel="stylesheet" href="{{asset('bootstrap/4.4.1-style.css')}}">
    <style>
        img.photo {
            height: 130px;
            position: absolute;
            left: 1px;
            top: 245px;
        }
        .valigntop {
            vertical-align: text-top;
        }
        .thanks {
            font-weight: bold;
            text-align: center;
        }
        h4.head1 {
            margin-bottom: 0px;
        }
        h5.head2 {
            margin-bottom: 0px;
        }
    </style>
</head>
<body>
    <img src="{{url('images/'.$school->letter_head)}}" width="100%" alt="">
	<center>
		<h4 class="head1">DATA PENDAFTAR</h4>
        <h5 class="head2">Penerimaan Peserta Didik Baru</h5>
        <h5 class="head3">{{$school->school_year}}</h5>
	</center>
    
    <b><i>{{$school->regist_pdf_message_top}}</i></b>
	<table>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
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
            <td>Nama</td>
            <td>:</td>
            <td>{{$data_daftar->name}}</td>
        </tr>
        <tr>
            <td width="180px">Tempat & Tanggal Lahir</td>
            <td>:</td>
            <td>{{$data_daftar->place}}, {{ date('d/m/Y', strtotime($data_daftar->birthday)) }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>
            {{$data_daftar->gender}}
            </td>
        </tr>
        <tr>
            <td>Nama Orangtua</td>
            <td>:</td>
            <td>{{$data_daftar->parent_name}}</td>
        </tr>
        <tr>
            <td class="valigntop">Asal Sekolah</td>
            <td class="valigntop">:</td>
            <td>{{$data_daftar->remark}}</td>
        </tr>
        <tr>
            <td>No. HP Siswa</td>
            <td>:</td>
            <td>{{$data_daftar->hp_student}}</td>
        </tr>
        <tr>
            <td>No. HP Orang Tua</td>
            <td>:</td>
            <td>{{$data_daftar->hp_parent}}</td>
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
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Gelombang</td>
            <td>:</td>
            <td>{{$data_daftar->phase}}</td>
        </tr>
        @if($data_daftar->phase_cost == 'Y')
        @php
        $amount = number_format($phase_cost->amount);
        @endphp
        <tr>
            <td>Biaya Pendaftaran</td>
            <td>:</td>
            <td>{{$amount}}</td>
        </tr>
        @endif
	</table><br>
    <img src="{{url('images/photo/'.$data_daftar->period.'/'.$data_daftar->photo)}}" class="photo" alt="">
    <h6>Note:*</h6>
    <ul>
        @if($data_daftar->phase_cost === 'Y')
        <li>Pembayaran Pendaftaran di Transfer melalui Nomor Rekening : <b>{{$data_daftar->no_account}}</b> Atas Nama <b>{{$data_daftar->name}}</b> Mulai Tanggal {{$date_day}} Jam {{$date_hour}}</li>
        <li>Setelah melakukan Transfer Pembayaran Pendaftaran, mohon bukti transfer disimpan</li>
        @else
        @endif
        @foreach($data_info as $di)
        <li>{{$di->name}} : {{$di->lines}} ({{$di->type_name}})</li>
        @endforeach
        <li>Silahkan lengkapi data anda di <a href="{{url('login')}}">{{url('login')}}</a></li>
    </ul>
    <p class="thanks">{{$school->regist_pdf_message_bottom}}</p>
</body>
</html>