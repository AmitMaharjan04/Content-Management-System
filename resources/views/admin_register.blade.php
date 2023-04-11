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
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    <header>
    </header>
    <main>
        <label class="label-register">Register</label>
        <form class="main-form" action="{{ url('/register') }}" method="post" id="formRegister">
            {{-- <form id="myForm"> --}}
            @csrf
            <div class="form-section">
                <label for="" class="name">Name</label>
                <input type="text" name="name" class="name" id="name" value="{{old('name')}}" required>
                <div class="alert alert-danger"  id="errorName" hidden></div>
                    @error('name')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
            </div>
            <div class="form-section">
                <label for="" class="email">Email address</label>
                <input type="email" name="email" class="email" id="email" placeholder="email@example.com"
                value="{{old('email')}}"  required>
                <div class="alert alert-danger"  id="errorEmail" hidden></div>
                    @error('email')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                    @if (session()->has('email'))
                    <div class="alert alert-danger">
                        {{ session('email') }}
                    </div>
                        
                    
                @endif
            </div>
            <div class="form-section">
                <label for="" class="password">Password</label>
                <input type="password" name="password" class="password" id="password" required>
                <div class="alert alert-danger"  id="errorPassword" hidden></div>
                    @error('password')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
            </div>
            <input type="submit" class="btn" value="Register">
        </form>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="js/register.js"></script>
</body>

</html>
