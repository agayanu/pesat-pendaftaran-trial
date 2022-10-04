<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - {{$si->name}}</title>
    <link rel="shortcut icon" href="{{ asset('images/icons/'.$si->icon) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('coreui-ori/css/vendors/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('simplebar/dist/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('coreui-ori/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('@coreui/icons/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style/pendaftaran.css') }}">
    <style>
        .sidebar-nav .nav-icon {
            flex: 0 0 3rem;
        }
        @media (min-width: 768px){
            .sidebar-fixed.sidebar-narrow-unfoldable:not(:hover), .sidebar-fixed.sidebar-narrow {
                z-index: 1031;
                width: 3rem;
            }
        }
        .sidebar-narrow-unfoldable:not(.sidebar-end) ~ * {
            --cui-sidebar-occupy-start: 3rem;
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
    @yield('header')
</head>
<body>
<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img class="sidebar-brand-full" width="55" height="46" src="{{ asset('images/icons/favicon.png') }}" alt="Pesat Logo"/>
        <img class="sidebar-brand-narrow" width="46" height="46" src="{{ asset('images/icons/favicon.png') }}" alt="Pesat Logo"/>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        @foreach($sisosmed as $sis)
        <li class="nav-item">
            <a class="nav-link" href="{{$sis->url}}">
                <i class="nav-icon {{$sis->icon}}"></i> {{$sis->name}}
            </a>
        </li>
        @endforeach
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <header class="header header-sticky mb-4">
        <div class="container-fluid">
            <button class="header-toggler px-md-0 me-md-3" type="button"
                onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                <i class="nav-icon icon-lg cil-menu"></i>
            </button>
            <a class="header-brand d-md-none" href="{{ url('/') }}">
                <img class="sidebar-brand-full" width="55" height="46" src="{{ asset('images/icons/favicon.png') }}" alt="Pesat Logo"/><div class="logoatt">PESAT</div>
            </a>
        </div>
    </header>
    <div class="body flex-grow-1 px-3">
        @yield('content')
    </div>
    <footer class="footer">
        <div class="footer-item"><a href="https://smapluspgri.sch.id">Pesat Pendaftaran</a> © 2022 Departemen IT.</div>
        <div class="ms-auto footer-item">Powered by&nbsp;<a href="https://smapluspgri.sch.id">PESAT</a></div>
    </footer>
</div>
@yield('footer')
<script src="{{ asset('@coreui/coreui/dist/js/coreui.bundle.min.js') }}"></script>
<script src="{{ asset('simplebar/dist/simplebar.min.js') }}"></script>
</body>
</html>