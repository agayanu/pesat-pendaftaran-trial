<style>
div{font-family:Helvetica,sans-serif;}
table{font-size:13px;font-family:Helvetica,sans-serif;}
</style>
<div style="text-align:center;font-size:11px;color:#a0a0a0;max-width:800px;margin:auto;padding:10px;">
Email ini dikirim secara otomatis oleh sistem. Demi keamanan data Anda, dilarang membalas dan atau meneruskan email ini!</div>
<div style="font-size:13px;max-width:800px;margin:auto;border:1px solid #CCC;padding:10px;"> 
<img src="{{url('images/icons/'.$si->icon)}}" alt="{{$si->name}}" style="display:block;margin-left:auto;margin-right:auto;width:10%" />
<h3 style="text-align:center;">{{$si->name}}<br />{{$si->nickname}}</h3>
<br />
<p style="text-align:justify;">
Pendaftaran atas nama <b>{{ $daf->name }}</b>, telah berhasil dengan detail sebagai berikut: </p>
<table>
    <tr>
        <td>Gelombang</td>
        <td>:</td>
        <td><b>{{ $daf->phase }}</b></td>
    </tr>
    <tr>
        <td>Nomor Pendaftaran</td>
        <td>:</td>
        <td><b>{{ $daf->no_regist }}</b></td>
    </tr>
    <tr>
        <td>Nama Lengkap</td>
        <td>:</td>
        <td><b>{{ $daf->name }}</b></td>
    </tr>
    <tr>
        <td>NISN</td>
        <td>:</td>
        <td><b>{{ $daf->nisn }}</b></td>
    </tr>
    <tr>
        <td>Alamat Tinggal</td>
        <td>:</td>
        <td><b>{{ $daf->stay_address }}</b></td>
    </tr>
    <tr>
        <td>SMP</td>
        <td>:</td>
        <td><b>{{ $daf->remark }}</b></td>
    </tr>
    <tr>
        <td>Kelompok</td>
        <td>:</td>
        <td><b>{{ $daf->grade }}</b></td>
    </tr>
    <tr>
        <td>Jurusan</td>
        <td>:</td>
        <td><b>{{ $daf->major }}</b></td>
    </tr>
</table>
<br />
<p style="text-align:justify;">
<b>Akses Kelengkapan Data</b><br />
Gunakan informasi berikut untuk mengakses kelengkapan data anda.</p>
<table>
    <tr>
        <td>Alamat Kelengkapan Data</td>
        <td>:</td>
        <td><a href="{{url('login')}}">{{url('login')}}</a></td>
    </tr>
    <tr>
        <td>Email</td>
        <td>:</td>
        <td><b>{{ $daf->email }}</b></td>
    </tr>
    <tr>
        <td>Password</td>
        <td>:</td>
        <td><i>[disembunyikan]</i></td>
    </tr>
</table>
<br />
<table>
   <tr>
      <td colspan="3" style="padding:0px">
		Terimakasih,<br /><br />
		<b>{{$si->name}}</b>
      </td>
   </tr>
   <tr>
      <td colspan="3" style="padding:0px"><i>{{$si->address}}</i></td>
   </tr>
   @foreach($hotline as $hl)
   <tr>
      <td style="padding:0px">{{$hl->name}}</td>
      <td style="padding:0px">:</td>
      <td style="padding:0px">{{$hl->lines}} ({{$hl->type}})</td>
   </tr>
   @endforeach
</table>
</div>
<div style="text-align:justify;font-size:11px;color:#a0a0a0;max-width:800px;margin:auto;padding:10px;">
<span style="font-weight:bold">DISCLAIMER:</span><br />
Email ini dikirim secara otomatis oleh sistem, dan dapat berisi informasi konfidensial yang hanya berhak diakses oleh penerima yang sah.
Jika Anda bukan penerima yang dimaksud dalam email ini dan secara tidak sengaja menerimanya, segera hapus email ini dan Anda dilarang untuk: membalas, meneruskan, menyalin sebagian dan atau keseluruhan informasi yang ada dalam email ini untuk disimpan dan atau disebarkan tanpa izin yang sah.
Pelanggaran terhadap hal-hal tersebut dapat berkonsekwensi hukum sesuai aturan yang berlaku.</div>