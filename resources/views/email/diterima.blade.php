<style>
div{font-family:Helvetica,sans-serif;}
table{font-size:13px;font-family:Helvetica,sans-serif;}
</style>
<div style="text-align:center;font-size:11px;color:#a0a0a0;max-width:800px;margin:auto;padding:10px;">
Email ini dikirim secara otomatis oleh sistem. Demi keamanan data Anda, dilarang membalas dan atau meneruskan email ini!</div>
<div style="font-size:13px;max-width:800px;margin:auto;border:1px solid #CCC;padding:10px;"> 
<img src="{{url('images/icons/'.$si->icon)}}" alt="{{$si->name}}" style="display:block;margin-left:auto;margin-right:auto;width:10%" />
<h3 style="text-align:center;">HASIL SELEKSI<br>PENERIMAAN PESERTA DIDIK BARU<br>{{$si->name}}<br>{{$si->school_year}}</h3>
<br />
<table>
    <tr>
        <td width="150px">No. Pendaftaran</td>
        <td>:</td>
        <td>{{$da['no_regist']}}</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td>{{$da['name']}}</td>
    </tr>
    <tr>
        <td>Tempat, Tanggal Lahir</td>
        <td>:</td>
        <td>{{$da['place']}}, {{$da['birthday']}}</td>
    </tr>
    <tr>
        <td style="vertical-align:top">Asal Sekolah</td>
        <td style="vertical-align:top">:</td>
        <td>{{$da['school']}}</td>
    </tr>
    <tr>
        <td>Nama Orangtua</td>
        <td>:</td>
        <td>{{$da['parent_dad']}} - {{$da['parent_mom']}}</td>
    </tr>
    <tr>
        <td>Pekerjaan Orangtua</td>
        <td>:</td>
        <td>{{$da['parent_dad_job']}} - {{$da['parent_mom_job']}}</td>
    </tr>
    <tr>
        <td>No. HP Orangtua</td>
        <td>:</td>
        <td>{{$da['parent_dad_hp']}} - {{$da['parent_mom_hp']}}</td>
    </tr>
    <tr>
        <td style="vertical-align:top">Alamat</td>
        <td style="vertical-align:top">:</td>
        <td>{{$da['address']}}</td>
    </tr>
</table>
<div class="first-nounce">
    <p><i><b>Setelah memperhatikan :</b></i></p>
    {!! $sel->first_nounce !!}
</div>
<div style="font-size: 20px;font-weight: bold;text-align: center;border: 2px solid black;padding: 5px;margin-bottom: 5px;">DITERIMA DI KELAS {{$da['grade']}} {{$da['major']}}</div>
<div class="last-nounce">
    {!! $sel->last_nounce !!}
</div>
<table>
   <tr>
      <td colspan="3" style="padding:0px">
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