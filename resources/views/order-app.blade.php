<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$si->name}}</title>
    <link rel="shortcut icon" href="{{ asset('images/icons/'.$si->icon) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('coreui-ori/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('@coreui/icons/css/all.min.css') }}">
    <style>
        .logoatt {
            display: inline;
            font-family: fantasy;
        }
        .logo-pesat {
            text-decoration: none;
            color: #818489;
        }
        .price {
            display: inline;
            font-size: 1.5rem;
            font-weight: 600;
            color: blue;
        }
        .col-order {
            text-align: center;
            margin-top: 10px;
        }
        .badge-price {
            padding: 0.3em 0.5em;
            font-size: 0.40em;
            vertical-align: top;
        }
        @media (max-width: 600px){
            .footer {
                display: block;
            }
            .footer-item {
                text-align: center;
            }
        }
    </style>
</head>
<body>
<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <header class="header header-sticky mb-4">
        <div class="container-fluid">
            <a class="logo-pesat" href="{{ url('/') }}">
                <img width="50" height="46" src="{{ asset('images/icons/favicon.png') }}" alt="Pesat Logo"/><div class="logoatt">SMA PLUS PGRI CIBINONG</div>
            </a>
        </div>
    </header>
    <div class="body flex-grow-1 px-3">
        <div class="container">
            <div class="alert alert-info fade show" role="alert">
                <div class="row">
                    <div class="col" style="text-align: center;">
                        <h3>SMARTREG</h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>Custom</h4>
                            Rp <div class="price">~</div><br>
                            <div class="row">
                                <div class="col col-order">
                                    <div class="d-grid gap-2 col-8 mx-auto">
                                        <a href="https://wa.me/+6281284420481?text=%2AHallo+SMA+Plus+PGRI+Cibinong%2A%2C%0D%0ASaya+ingin+membeli+produk+Pesat+Pendaftaran.%0D%0A%0D%0ANama+%3A+%0D%0AInstansi%2FSekolah+%3A+%0D%0APilihan+Paket+%3A+Custom%0D%0ACustomisasi+%3A+" class="btn btn-info rounded-pill" style="color: white">Beli Sekarang</a>
                                    </div>
                                </div>
                            </div>
                            <div class="callout callout-info">
                                Komunikasikan dengan kami, apa saja yang perlu kami tambahkan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h4>Standard</h4>
                            Rp <div class="price">999.999<span class="badge badge-sm bg-danger badge-price">PROMO</span></div><br>
                            <div class="row">
                                <div class="col col-order">
                                    <div class="d-grid gap-2 col-8 mx-auto">
                                        <a href="https://wa.me/+6281284420481?text=%2AHallo+SMA+Plus+PGRI+Cibinong%2A%2C%0D%0ASaya+ingin+membeli+produk+Pesat+Pendaftaran.%0D%0A%0D%0ANama+%3A+%0D%0AInstansi%2FSekolah+%3A+%0D%0APilihan+Paket+%3A+Standard" class="btn btn-info rounded-pill" style="color: white">Beli Sekarang</a>
                                    </div>
                                </div>
                            </div>
                            <div class="callout callout-info">
                                Dapat di akses di semua gadget (Laptop/Komputer, Phone/Smartphone dan Tablet)
                            </div>
                            <div class="callout callout-info">
                                Tersedia 34K++ data sekolah di indonesia, dan masih dapat ditambahkan ataupun dikelola
                            </div>
                            <div class="collapse" id="collapseExample">
                                <div class="callout callout-info">
                                    Tersedia 7K++ data kecamatan, 500++ data Kabupaten dan Kota, dan 34 Provinsi di indonesia, dan masih dapat ditambahkan ataupun dikelola
                                </div>
                                <div class="callout callout-info">
                                    Pendaftaran dapat di setting menggunakan pembiayaan ataupun tidak
                                </div>
                                <div class="callout callout-info">
                                    Auto Generate Virtual Account Bank
                                </div>
                                <div class="callout callout-info">
                                    Item kelengkapan data siswa yang lengkap
                                </div>
                                <div class="callout callout-info">
                                    Whatsapp dan email gateway saat pendaftaran dan pembayaran
                                </div>
                                <div class="callout callout-info">
                                    Bukti Pendaftaran Online dan Offline PDF
                                </div>
                                <div class="callout callout-info">
                                    Bukti Pembayaran PDF
                                </div>
                                <div class="callout callout-info">
                                    Pemotongan otomatis detail pembayaran sesuai yang ditentukan
                                </div>
                                <div class="callout callout-info">
                                    Download Data Excel
                                </div>
                                <div class="callout callout-info">
                                    Live Report perjalanan PPDB
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col" style="text-align: center;">
                                    <button class="btn btn-primary" type="button" data-coreui-toggle="collapse" data-coreui-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        Lihat Fitur Lengkap
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="footer-item"><a href="{{route('beli-aplikasi')}}">SmartReg</a> © 2022 Departemen TIK.</div>
        <div class="ms-auto footer-item">Powered by&nbsp;<a href="https://smapluspgri.sch.id">PESAT</a></div>
    </footer>
</div>
<script src="{{ asset('@coreui/coreui/dist/js/coreui.bundle.min.js') }}"></script>
</body>
</html>