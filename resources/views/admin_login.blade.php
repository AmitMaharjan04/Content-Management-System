<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <header>
    </header>
    <main>
        <div class="main">
            <label class="login-name">Login</label>
            {{-- <div  id="messages" class="hide" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div id="messages_content"></div>
              </div> --}}

            {{-- <form class="px-4 py-3 " action="{{url('/')}}" method="post" id="formLogin"> --}}
            <form class="main-form " action="{{ url('/') }}" method="post" id="formLogin">
                @csrf
                <div class="form-section">
                    <label for="" class="label-email">Email address</label>
                    <input type="email" name="email" class="form-section-email" id="email1"
                        placeholder="email@example.com" value={{ old('email') }}>
                    <div class="alert alert-danger" id="errorEmail" hidden></div>
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class="form-section">
                    <label for="" class="label-password">Password</label>
                    <input type="password" name="password" class="form-section-password" id="password1">
                    {{-- <span class="error">This field is required</span> --}}
                    <div class="alert alert-danger" id="errorPassword" hidden></div>
                    @if ($errors->has('password'))
                        <div class="alert alert-danger">
                            {{ $errors->first('password') }}
                        </div>
                        {{-- alert alert-danger col-8 d-flex d-inline-flex h-100 justify-content-center --}}
                    @endif
                </div>
                {{-- <input type="submit" class="btn btn-primary" value="Login"> --}}
                <div class="buttons">
                    <input type="submit" class="btn" value="Login">
                    <a href="{{ url('/') }}/register" class="btn2">
                        Register
                    </a>
                </div>
            </form>
            <div class="formerror"></div>
        </div>

    </main>
    <footer>
        <div class="row">
            <div class="col-4"></div>
            <div class="col-5">
                @if (session()->has('error'))
                    <div class="alert alert-danger col-8 d-flex  justify-content-center" id="error">
                        {{ session('error') }}
                        <script>
                            var errorDiv = document.getElementById("error");
                            setTimeout(function() {
                                errorDiv.parentNode.removeChild(errorDiv);
                            }, 2000);
                        </script>
                    </div>
                @endif
                @if (session()->has('success'))
                    <div class="alert alert-success col-8 d-flex  justify-content-center" id="registered">
                        {{ session('success') }}
                        <script>
                            var errorDiv = document.getElementById("registered");
                            setTimeout(function() {
                                errorDiv.parentNode.removeChild(errorDiv);
                            }, 2000);
                        </script>
                    </div>
                @endif
            </div>
            <div class="col-3"></div>
        </div>

    </footer>
    <!-- Bootstrap JavaScript Libraries -->

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    {{-- <script src="js/admin.js"></script> --}}
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="js/login.js"></script>
</body>

</html>
{{-- form validation  --}}
