<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <form action={{ $url }} method="post">
        @csrf
        <div class="container">
            <h1> {{ $title }}</h1>
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" value= {{$customer->name}}>
                <span class="text-danger">
                    @error('name')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" name="email" value= {{ $customer->email}}>
                <span class="text-danger">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="">Address</label>
                <input type="text" name="address" value= {{ $customer->address}}>
                <span class="text-danger">
                    @error('address')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="">Gender</label>
                <input type="radio" id="male" name="gender" value="M"  {{$customer->gender == "M" ? "checked" : ""}}  >
                    <label for="">Male</label><br>
                    <input type="radio" id="female" name="gender" value="F" {{ $customer->gender == "F" ? "checked" : ""}}>
                    <label for="">Female</label><br>
                    <input type="radio" id="others" name="gender" value="O" {{ $customer->gender == "O" ? "checked" : ""}}>
                    <label for="">Others</label>
                <span class="text-danger">
                    @error('gender')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" name="password">
                <span class="text-danger">
                    @error('password')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <input type="submit" value=submit>
            </div>
        </div>
    </form>
</body>

</html>