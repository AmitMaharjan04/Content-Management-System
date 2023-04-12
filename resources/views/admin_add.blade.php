<!doctype html>
<html lang="en">

<head>
    <title>{{ $title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="{{ asset('css/add.css') }}" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="image">
                <img src="{{ asset('photos/11.jpeg') }}" width="50"class="img-fluid rounded" alt="Responsive image">
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/dashboard">Home</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main class="offset-3 row row-cols-2 mt-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('aerror'))
            <div class="alert alert-danger">
                {{ session('aerror') }}
            </div>
        @endif
        {!! Form::open([
            'url' => $url,
            'method' => 'post',
            'enctype' => 'multipart/form-data',
            'id' => 'formAdd',
        ]) !!}
        <div class="form-group row mb-3">
            {{ Form::label('', 'Name', ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                {!! Form::text('name', $customer->name, [
                    'placeholder' => 'enter your name',
                    'class' => 'form-control',
                    'id' => 'name',
                ]) !!}
                {{-- <input type="text" name="name"  class="form-control" id="" placeholder="Enter your name" value="{{$customer->name}}"> --}}
                <div class="alert alert-danger"  id="errorName" hidden></div>
                @if ($errors->has('name'))
                    @foreach ($errors->get('name') as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="form-group row mb-3">
            {{ Form::label('', 'Email', ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10  mb-3">
                {!! Form::text('email', $customer->email, [
                    'placeholder' => 'enter your email',
                    'class' => 'form-control',
                    'id' => 'email',
                ]) !!}
                <div class="alert alert-danger"  id="errorEmail" hidden></div>
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
            </div>
        </div>
        <fieldset class="form-group mb-3">
            <div class="row">
                {!! Form::label('','Gender',[
                'class'=>'col-form-label col-sm-2 pt-0'
              ]) !!}
                <div class="col-sm-10">
                    <div class="form-check">
                        {{-- {!! Form::radio('gender','M',$customer->gender == "M" ? "true" : "",[
          'class'=>'form-check-input'
          ])!!} <br>
        {!! Form::label('','Male',['class'=>'form-check-label']) !!} --}}
                        {{-- {!! Form::label('','Female ') !!}
        {!! Form::radio('gender','F',$customer->gender == "F" ? "true" : "")!!} <br> 
        {!! Form::label('','Others ') !!}
        {!! Form::radio('gender','O',$customer->gender == "O" ? "true" : "")!!}    --}}
                        <input class="form-check-input" type="radio" name="gender" id="" value="M"
                            checked {{ $customer->gender == 'M' ? 'checked' : '' }}>
                        <label class="form-check-label" for="">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="" value="F"
                            {{ $customer->gender == 'F' ? 'checked' : '' }}>
                        <label class="form-check-label" for="">
                            Female
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="" value="O"
                            {{ $customer->gender == 'O' ? 'checked' : '' }}>
                        <label class="form-check-label" for="">
                            Others
                        </label>
                    </div>
                </div>

            </div>
        </fieldset>
        <div class="form-group row mb-3">
            {{ Form::label('', 'Address', ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                {!! Form::text('address', $customer->address, [
                    'class' => 'form-control',
                    'id' => 'address',
                ]) !!}`
                <div class="alert alert-danger"  id="errorAddress" hidden></div>
                @if ($errors->has('address'))
                <div class="alert alert-danger">
                    {{ $errors->first('address') }}
                </div>
            @endif
            </div>
        </div>
        <div class="form-group row mb-3">
            <div class="col" id="bloodgroup">
                {!! Form::label('', 'Blood Group', ['class' => 'form-label', 'id' => 'bloodLabel']) !!}
                <select name="blood" class="form-select" aria-label="Default select example">
                    <option selected {{ $customer->blood_group == 'A+' ? 'selected' : '' }}>A+</option>
                    <option {{ $customer->blood_group == 'A-' ? 'selected' : '' }}>A-</option>
                    <option {{ $customer->blood_group == 'B+' ? 'selected' : '' }}>B+</option>
                    <option {{ $customer->blood_group == 'B-' ? 'selected' : '' }}>B-</option>
                    <option {{ $customer->blood_group == '0+' ? 'selected' : '' }}>0+</option>
                    <option {{ $customer->blood_group == '0-' ? 'selected' : '' }}>0-</option>
                    <option {{ $customer->blood_group == 'AB+' ? 'selected' : '' }}>AB+</option>
                    <option {{ $customer->blood_group == 'AB-' ? 'selected' : '' }}>AB-</option>
                </select>
            </div>
        </div>
        <div class="form-group row mb-3">
            @php
                $hobbies = $customer->hobbies;
                $hobby = explode(',', $hobbies);
            @endphp
            {!! Form::label('', 'Select your hobbies', ['class' => 'form-label']) !!}
            <div class="form-check col-3 ms-5 mb-2">
                {!! Form::checkbox('hobby[]', 'football', in_array('football', $hobby) ? 'true' : '', [
                    'class' => 'form-check-input hobby',
                ]) !!}
                {!! Form::label('', 'Football', ['class' => 'form-check-label']) !!}
            </div>
            <div class="form-check col-3 ms-4">
                <input type="checkbox" id="" name="hobby[]" class="form-check-input  hobby" value='cricket'
                    {{ in_array('cricket', $hobby) ? 'checked' : '' }}>
                {!! Form::label('', 'Cricket', ['class' => 'form-check-label']) !!}
            </div>
            <div class="form-check col-4">
                {!! Form::checkbox('hobby[]', 'gaming', in_array('gaming', $hobby) ? 'true' : '', [
                    'class' => 'form-check-input  hobby',
                ]) !!}
                {!! Form::label('', 'Gaming', ['class' => 'form-check-label']) !!}
            </div>
            <div class="form-check col-3 me-5 ms-5", style="white-space:nowrap;">
                {!! Form::checkbox('hobby[]', 'novel', in_array('novel', $hobby) ? 'true' : '', [
                    'class' => 'form-check-input  hobby',
                ]) !!}
                {!! Form::label('', 'Reading Novels', ['class' => 'form-check-label']) !!}
            </div>
            <div class="form-check col-2">
                {!! Form::checkbox('hobby[]', 'others', in_array('others', $hobby) ? 'true' : '', [
                    'class' => 'form-check-input  hobby',
                ]) !!}
                {!! Form::label('', 'Others', ['class' => 'form-check-label']) !!}
            </div>
                <div class="alert alert-danger"  id="errorHobby" hidden></div>
                @if ($errors->has('hobby'))
                <div class="alert alert-danger">
                    {{ $errors->first('hobby') }}
                </div>
            @endif
        </div>
        <div class="form-group row mb-3">
            {!! Form::label('', 'Drop your file / image', ['class' => 'form-label']) !!}
            {!! Form::file('file', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group row mb-3">
            {!! Form::label('', 'Description about the customer', ['class' => 'form-label']) !!}
            {!! Form::textarea('description', $customer->description, [
                'rows' => 4,
                'cols' => 54,
                'class' => 'form-control',
                'style' => 'resize:none',
                'id' => 'description',
            ]) !!}
            <div class="alert alert-danger"  id="errorDescription" hidden></div>
                @error('description')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
        </div>
        <div class="form-group row mb-3">
            <div class="col-sm-10">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </div>
        {{ Form::close() }}
        {{-- </form> --}}
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script src="{{ asset('js/add.js') }} "></script>
</body>

</html>
