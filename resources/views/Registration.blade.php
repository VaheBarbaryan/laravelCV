<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>\
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .block {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100vw;
            height: 100vh;
        }
        form {
            display: flex;
            align-items: center;
            flex-direction: column;
            gap: 20px;
        }
        form input {
            background-color: transparent;
            color: #000;
            padding: 10px 12px;
            border: 1px solid #000;
            border-radius: 5px;
        }

    </style>
</head>
<body>
<div class="block">
    <form action=" {{ route('login-form') }}" method="post" >
        @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        @if(Session::has('message'))
            {{ session('message') }}
        @endif
        @csrf
        <h1>Registration Form</h1>
        <input class="email" type="text" name="email" placeholder="Enter your email" >
        <input class="pass" type="password" name="pass"  placeholder="Enter your password">
        <input class="btn" type="submit" name="login" value="Submit" >
    </form>
</div>
</body>
</html>