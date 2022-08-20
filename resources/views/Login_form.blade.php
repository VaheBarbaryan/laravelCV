<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ITResources</title>
    <link rel="shortcut icon" href="{{ asset('/img/itr_favicon.png') }}" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <link href="{{asset('/css/style.min.css')}}" rel="stylesheet">
    <link href="{{asset('/css/create_cv.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <!-- Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css?family=PT+Sans');

        body {
            background: #fff;
            font-size: 20px;
            font-family: 'PT Sans', sans-serif;
        }

        h1 {
            padding-top: 1.5rem;
        }

        /*a {*/
        /*    color: #333;*/
        /*}*/

        /*a:hover {*/
        /*    color: #009879;*/
        /*    text-decoration: none;*/
        /*}*/

        .card {
            border: 0.40rem solid #f8f9fa;
            box-shadow: 0 10px 15px rgba(0,0,0, .1);
            top: 50%;
            transform: translateY(-50%);
        }

        .form-control {
            background-color: #f8f9fa;
            padding: 25px 15px;
            margin-bottom: 1.3rem;
        }

        .form-control:focus {

            color: #000000;
            background-color: #ffffff;
            border: 3px solid #3490dc;
            outline: 0;
            box-shadow: none;

        }

        .btn {
            padding: 0.6rem 1.2rem;
            background: #3490dc;
            border: 2px solid #3490dc;
        }

        .btn-primary:hover {


            background-color: #2572dc;
            border-color: #2572dc;
            transition: .3s;

        }

        .block {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100vw;
            height: 100vh;
        }

        /*form {*/
        /*    display: flex;*/
        /*    align-items: center;*/
        /*    flex-direction: column;*/
        /*    gap: 20px;*/
        /*}*/
        /*form input {*/
        /*    background-color: transparent;*/
        /*    color: #000;*/
        /*    padding: 10px 12px;*/
        /*    border: 1px solid #000;*/
        /*    border-radius: 5px;*/
        /*}*/

    </style>
</head>
<body>
<div class="block">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <h1 class="card-title text-center">Մուտքագրվել</h1>
                    <div class="card-body py-md-4">
                        <form action=" {{ route('login-form') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="email">Էլ․ փոստ</label>
                                <input class="form-control mb-0 {{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" name="email" id="email" placeholder="Էլ․ փոստ" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="pass">Գաղտնաբառ</label>
                                <input class="form-control mb-0 {{ $errors->has('pass') ? ' is-invalid' : '' }}" type="password" name="pass" id="pass" placeholder="Գաղտնաբառ">
                                @if ($errors->has('pass'))
                                    <span class="invalid-feedback" role="alert">
                                        {{ $errors->first('pass') }}
                                    </span>
                                @endif
                                <div class="d-flex justify-content-end mt-2">
                                    <a href="{{ route('forgot-password') }}" class="font-14" >Մոռացել ե՞ք գաղտնաբառը</a>
                                </div>
                            </div>

                            <input class="btn btn-primary" type="submit" name="login" value="Մուտք" style="font-size: 20px; ">
                            <div class="flex justify-content-between mt-4 font-16">
                                <span>Դեռ գրանցվաժ չե՞ք՝   <a href="{{ route('register-form') }}">Գրանցվեք</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
