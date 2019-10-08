<!doctype html>
<html lang="vi">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" type="text/css" media="screen">
   >

</head>

<body class="app flew-row align-items-center d-flex min-vh-100">
<div class="container">
    <div class="row justify-content-center">

        <div class="text-center box">
            <div class="logo">
                <div></div>
            </div>

            @if (count($errors) > 0)
                <div class="alert alert-danger">

                    <span>
                        @foreach($errors->all() as $error)
                            <strong>{{ $error }}</strong>
                        @endforeach
                    </span>
                </div>
            @endif

            <form class="card-body" action="{{url()->current()}}" method="post">
                {{csrf_field()}}
                <h2>LOGIN</h2>

                <div class="form-group text-left mt-4">
                    <label>Email</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                           placeholder="Email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group text-left mt-4">
                    <label>Password</label>
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                           placeholder="Password" name="password" required>

                </div>
                <button class="btn btn-pink w-100" type="submit">
                    Login
                </button>
            </form>
        </div>
    </div>

</div>

</body>

</html>
