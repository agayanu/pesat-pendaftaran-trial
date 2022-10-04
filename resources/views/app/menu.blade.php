<li class="nav-item">
    <a class="nav-link logout" href="{!! url('/logout') !!}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="nav-icon cil-account-logout logout"></i> Logout
    </a>
</li>
<li class="nav-item {{ Request::is('home') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('home') !!}">
        <i class="nav-icon cil-home"></i> Beranda
    </a>
</li>
<li class="nav-item {{ Request::is('gantipass') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('gantipass') !!}">
        <i class="nav-icon cil-lock-locked"></i> Ganti Password
    </a>
</li>
@if(Auth::user()->role === '0')
<li class="nav-title">Menu</li>
<li class="nav-item {{ Request::is('biodata') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('biodata') !!}">
        <i class="nav-icon cil-people"></i> Biodata
    </a>
</li>
@endif
@if(Auth::user()->role === '1')
<li class="nav-item {{ Request::is('operator') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('operator') !!}">
        <i class="nav-icon cil-mood-good"></i> Operator
    </a>
</li>
<li class="nav-title">Master Data</li>
<li class="nav-group">
    <a href="#" class="nav-link nav-group-toggle">
        <i class="nav-icon cil-bullhorn"></i> Info
    </a>
    <ul class="nav-group-items">
        <li class="nav-item {{ Request::is('info') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('info') !!}">
                <span class="nav-icon"></span> Sekolah
            </a>
        </li>
        <li class="nav-item {{ Request::is('info-sosmed') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('info-sosmed') !!}">
                <span class="nav-icon"></span> Sosmed
            </a>
        </li>
    </ul>
</li>
<li class="nav-group">
    <a href="#" class="nav-link nav-group-toggle">
        <i class="nav-icon cil-school"></i> Prestasi
    </a>
    <ul class="nav-group-items">
        <li class="nav-item {{ Request::is('prestasi-group') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('prestasi-group') !!}">
                <span class="nav-icon"></span> Grup
            </a>
        </li>
        <li class="nav-item {{ Request::is('prestasi-level') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('prestasi-level') !!}">
                <span class="nav-icon"></span> Tingkat
            </a>
        </li>
        <li class="nav-item {{ Request::is('prestasi-rank') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('prestasi-rank') !!}">
                <span class="nav-icon"></span> Juara
            </a>
        </li>
    </ul>
</li>
<li class="nav-group">
    <a href="#" class="nav-link nav-group-toggle">
        <i class="nav-icon cil-location-pin"></i> Wilayah
    </a>
    <ul class="nav-group-items">
        <li class="nav-item {{ Request::is('provinsi') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('provinsi') !!}">
                <span class="nav-icon"></span> Provinsi
            </a>
        </li>
        <li class="nav-item {{ Request::is('kabkot') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('kabkot') !!}">
                <span class="nav-icon"></span> Kabupaten/Kota
            </a>
        </li>
        <li class="nav-item {{ Request::is('kecamatan') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('kecamatan') !!}">
                <span class="nav-icon"></span> Kecamatan
            </a>
        </li>
    </ul>
</li>
<li class="nav-group">
    <a href="#" class="nav-link nav-group-toggle">
        <i class="nav-icon cil-user-plus"></i> Pendaftaran
    </a>
    <ul class="nav-group-items">
        <li class="nav-item {{ Request::is('periode') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('periode') !!}">
                <span class="nav-icon"></span> Periode
            </a>
        </li>
        <li class="nav-item {{ Request::is('gelombang') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('gelombang') !!}">
                <span class="nav-icon"></span> Gelombang
            </a>
        </li>
        <li class="nav-item {{ Request::is('biaya-pendaftaran') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('biaya-pendaftaran') !!}">
                <span class="nav-icon"></span> Biaya
            </a>
        </li>
        <li class="nav-item {{ Request::is('rekening') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('rekening') !!}">
                <i class="nav-icon"></i> Rekening
            </a>
        </li>
        <li class="nav-item {{ Request::is('kelompok') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('kelompok') !!}">
                <i class="nav-icon"></i> Kelompok
            </a>
        </li>
        <li class="nav-item {{ Request::is('jurusan') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('jurusan') !!}">
                <i class="nav-icon"></i> Jurusan
            </a>
        </li>
        <li class="nav-item {{ Request::is('status') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('status') !!}">
                <i class="nav-icon"></i> Status
            </a>
        </li>
        <li class="nav-item {{ Request::is('jenis-kelamin') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('jenis-kelamin') !!}">
                <i class="nav-icon"></i> Jenis Kelamin
            </a>
        </li>
        <li class="nav-item {{ Request::is('agama') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('agama') !!}">
                <i class="nav-icon"></i> Agama
            </a>
        </li>
        <li class="nav-item {{ Request::is('seleksi-master') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('seleksi-master') !!}">
                <i class="nav-icon"></i> Seleksi
            </a>
        </li>
    </ul>
</li>
<li class="nav-group">
    <a href="#" class="nav-link nav-group-toggle">
        <i class="nav-icon cil-dollar"></i> Pembayaran
    </a>
    <ul class="nav-group-items">
        <li class="nav-item {{ Request::is('metode-bayar') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('metode-bayar') !!}">
                <span class="nav-icon"></span> Metode
            </a>
        </li>
        <li class="nav-item {{ Request::is('biaya-pembayaran-rincian-master') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('biaya-pembayaran-rincian-master') !!}">
                <span class="nav-icon"></span> Rincian
            </a>
        </li>
        <li class="nav-item {{ Request::is('biaya-pembayaran') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('biaya-pembayaran') !!}">
                <span class="nav-icon"></span> Biaya
            </a>
        </li>
        <li class="nav-item {{ Request::is('rubah-biaya-pembayaran') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('rubah-biaya-pembayaran') !!}">
                <span class="nav-icon"></span> Perubahan
            </a>
        </li>
    </ul>
</li>
<li class="nav-group">
    <a href="#" class="nav-link nav-group-toggle">
        <i class="nav-icon cil-people"></i> Keluarga
    </a>
    <ul class="nav-group-items">
        <li class="nav-item {{ Request::is('keluarga') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('keluarga') !!}">
                <i class="nav-icon"></i> Keluarga
            </a>
        </li>
        <li class="nav-item {{ Request::is('keluarga-status') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('keluarga-status') !!}">
                <i class="nav-icon"></i> Status Keluarga
            </a>
        </li>
        <li class="nav-item {{ Request::is('pekerjaan') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('pekerjaan') !!}">
                <i class="nav-icon"></i> Pekerjaan
            </a>
        </li>
        <li class="nav-item {{ Request::is('pendidikan') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('pendidikan') !!}">
                <i class="nav-icon"></i> Pendidikan
            </a>
        </li>
        <li class="nav-item {{ Request::is('penghasilan') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('penghasilan') !!}">
                <i class="nav-icon"></i> Penghasilan
            </a>
        </li>
    </ul>
</li>
<li class="nav-group">
    <a href="#" class="nav-link nav-group-toggle">
        <i class="nav-icon cil-headphones"></i> Hotline
    </a>
    <ul class="nav-group-items">
        <li class="nav-item {{ Request::is('hotline') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('hotline') !!}">
                <span class="nav-icon"></span> Nama
            </a>
        </li>
        <li class="nav-item {{ Request::is('hotline-tipe') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('hotline-tipe') !!}">
                <span class="nav-icon"></span> Tipe
            </a>
        </li>
    </ul>
</li>
<li class="nav-item {{ Request::is('mundur-master') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('mundur-master') !!}">
        <i class="nav-icon cil-door"></i> Mundur
    </a>
</li>
<li class="nav-item {{ Request::is('tinggal') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('tinggal') !!}">
        <i class="nav-icon cil-house"></i> Jenis Tinggal
    </a>
</li>
<li class="nav-item {{ Request::is('golongan-darah') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('golongan-darah') !!}">
        <i class="nav-icon cil-graph"></i> Golongan Darah
    </a>
</li>
<li class="nav-item {{ Request::is('kewarganegaraan') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('kewarganegaraan') !!}">
        <i class="nav-icon cil-flag-alt"></i> Kewarganegaraan
    </a>
</li>
<li class="nav-item {{ Request::is('dokumen') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('dokumen') !!}">
        <i class="nav-icon cil-file"></i> Dokumen
    </a>
</li>
<li class="nav-item {{ Request::is('sekolah') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('sekolah') !!}">
        <i class="nav-icon cil-institution"></i> Sekolah
    </a>
</li>
<li class="nav-item {{ Request::is('kendaraan') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('kendaraan') !!}">
        <i class="nav-icon cil-garage"></i> Kendaraan
    </a>
</li>
@endif
@if(Auth::user()->role === '2')
<li class="nav-title">Menu</li>
<li class="nav-item {{ Request::is('pendaftaran') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('pendaftaran') !!}">
        <i class="nav-icon cil-user-plus"></i> Pendaftaran
    </a>
</li>
<li class="nav-item {{ Request::is('seleksi') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('seleksi') !!}">
        <i class="nav-icon cil-balance-scale"></i> Seleksi
    </a>
</li>
<li class="nav-group">
    <a href="#" class="nav-link nav-group-toggle">
        <i class="nav-icon cil-dollar"></i> Pembayaran
    </a>
    <ul class="nav-group-items">
        <li class="nav-item {{ Request::is('bayar') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('bayar') !!}">
                <span class="nav-icon"></span> Bayar
            </a>
        </li>
        <li class="nav-item {{ Request::is('selisih') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('selisih') !!}">
                <span class="nav-icon"></span> Selisih
            </a>
        </li>
        <li class="nav-item {{ Request::is('lunas') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('lunas') !!}">
                <span class="nav-icon"></span> Lunas
            </a>
        </li>
        <li class="nav-item {{ Request::is('rubah-bayar') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('rubah-bayar') !!}">
                <span class="nav-icon"></span> Perubahan
            </a>
        </li>
    </ul>
</li>
<li class="nav-group">
    <a href="#" class="nav-link nav-group-toggle">
        <i class="nav-icon cil-description"></i> Report
    </a>
    <ul class="nav-group-items">
        <li class="nav-item {{ Request::is('report-daftar-bayar') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('report-daftar-bayar') !!}">
                <span class="nav-icon"></span> Bayar Daftar
            </a>
        </li>
        <li class="nav-item {{ Request::is('report-bayar') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('report-bayar') !!}">
                <span class="nav-icon"></span> Pembayaran
            </a>
        </li>
        <li class="nav-item {{ Request::is('report-bayar-transaksi') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('report-bayar-transaksi') !!}">
                <span class="nav-icon"></span> Transaksi Pembayaran
            </a>
        </li>
        <li class="nav-item {{ Request::is('report-mundur') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('report-mundur') !!}">
                <span class="nav-icon"></span> Mundur
            </a>
        </li>
        <li class="nav-item {{ Request::is('report-wa') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('report-wa') !!}">
                <span class="nav-icon"></span> Whatsapp
            </a>
        </li>
        <li class="nav-item {{ Request::is('report-email') ? 'active' : '' }}">
            <a class="nav-link" href="{!! route('report-email') !!}">
                <span class="nav-icon"></span> Email
            </a>
        </li>
    </ul>
</li>
<li class="nav-item {{ Request::is('mundur') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('mundur') !!}">
        <i class="nav-icon cil-door"></i> Mundur
    </a>
</li>
@endif