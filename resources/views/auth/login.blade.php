<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/icons/'.$si->icon) }}" type="image/x-icon">
    <title>Login - SMA Plus PGRI Cibinong</title>
    <link rel="stylesheet" href="{{ asset('coreui-ori/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('@coreui/icons/css/all.min.css') }}">
    <style>
        .login-bg-container {
            background-image: url(images/{{$si->background}});
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            filter: blur(8px);
            box-shadow: inset 0 0 0 2000px rgb(16 16 16 / 28%);
            transform: scale(1.1);
            -webkit-transform: scale(1.1);
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
        }
        .tmplogo {
            margin-top: 10px;
        }
        .logopesat {
            width: 90px;
            margin-bottom: 5px;
        }
        .pesattext {
            font-size: 50px;
            font-weight: bold;
            font-family: fantasy;
            background: -webkit-linear-gradient(#eee, #333);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .submit {
            text-align: right;
        }
        @media only screen and (max-width: 600px) {
            .tmplogo {
                text-align: center;
            }
        }
    </style>
</head>
<body>
<div class="login-bg-container"></div>
<div class="min-vh-100 d-flex flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-4">
            @include('flash-message')
                <div class="card">
                    <div class="card-body">
                        <div class="tmplogo">
                            <img src="{{ asset('images/icons/'.$si->icon) }}" alt="Logo {{$si->nickname}}" class="logopesat">
                            <font class="pesattext">{{$si->nickname}}</font>
                        </div>
                        {{$si->slogan}}
                        <form action="" method="POST">
                            @csrf
                            <div class="input-group mb-3 mt-3">
                                <span class="input-group-text">
                                    <i class="icon cil-user"></i>
                                </span>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Email" value="{{ old('email') }}" autofocus>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <i class="icon cil-lock-locked"></i>
                                </span>
                                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" autocomplete="on" placeholder="Password" value="{{ old('password') }}">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input">
                                        <label class="form-check-label">Ingatkan saya</label>
                                    </div>
                                </div>
                                <div class="col submit">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('@coreui/coreui/dist/js/coreui.bundle.min.js') }}"></script>
</body>
</html>