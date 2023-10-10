<!doctype html>
<html lang="en">

<head>
    <title>Homepage</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="css/dashboard.css"> --}}
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            {{-- <a class="navbar-brand" href="#">Random</a> --}}
            <div class="image">
                <img src="photos/11.jpeg" width="50"class="img-fluid rounded" alt="Responsive image">
            </div>
            {{-- <img src="11.jpeg" alt="Image" width="30" height="24"> --}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/admin/dashboard">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/add">Add</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/trash">Move to trash</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout" href="/admin/logout" id="logout">logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main class="mt-4">
        {{-- <div class="col-2">
        </div> --}}
        {{-- col-8 --}}
        {{-- <div class="row"> --}}
        {{-- <div class="col-1">
            </div> --}}
        {{-- <div class="col-12 ms-3 me-3"> --}}
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                @extends('views.flash_messages.sessionMsg')
                @if (session()->has('success'))

                    <div class="alert alert-success col-8 d-flex  justify-content-center" id="success">
                        {{ session('success') }}
                        <script>
                            var errorDiv = document.getElementById("success");
                            setTimeout(function() {
                                errorDiv.parentNode.removeChild(errorDiv);
                            }, 2000);
                        </script>
                    </div>
                @endif
                @if (session()->has('add'))
                    <div class="alert alert-success col-8 d-flex  justify-content-center" id="add">
                        {{ session('add') }}
                        <script>
                            var errorDiv = document.getElementById("add");
                            setTimeout(function() {
                                errorDiv.parentNode.removeChild(errorDiv);
                            }, 2000);
                        </script>
                    </div>
                @endif
                @if (session()->has('edit'))
                    {{-- @yield('edit') --}}
                    <div class="alert alert-success col-8 d-flex  justify-content-center" id="edit">
                        {{ session('edit') }}
                        <script>
                            var errorDiv = document.getElementById("edit");
                            setTimeout(function() {
                                errorDiv.parentNode.removeChild(errorDiv);
                            }, 2000);
                        </script>
                    </div>
                @endif
                @if (session()->has('softDelete'))
                    <div class="alert alert-success col-8 d-flex  justify-content-center" id="softDelete">
                        {{ session('softDelete') }}
                        <script>
                            var errorDiv = document.getElementById("softDelete");
                            setTimeout(function() {
                                errorDiv.parentNode.removeChild(errorDiv);
                            }, 2000);
                        </script>
                    </div>
                @endif
                @if (session()->has('restore'))
                    <div class="alert alert-success col-8 d-flex  justify-content-center" id="restore">
                        {{ session('restore') }}
                        <script>
                            var errorDiv = document.getElementById("restore");
                            setTimeout(function() {
                                errorDiv.parentNode.removeChild(errorDiv);
                            }, 2000);
                        </script>
                    </div>
                @endif
                @if (session()->has('delete'))
                    <div class="alert alert-success col-8 d-flex  justify-content-center" id="delete">
                        {{ session('delete') }}
                        <script>
                            var errorDiv = document.getElementById("delete");
                            setTimeout(function() {
                                errorDiv.parentNode.removeChild(errorDiv);
                            }, 2000);
                        </script>
                    </div>
                @endif
                @if (session()->has('import'))
                    <div class="alert alert-success col-8 d-flex  justify-content-center" id="import">
                        {{ session('import') }}
                        <script>
                            var errorDiv = document.getElementById("import");
                            setTimeout(function() {
                                errorDiv.parentNode.removeChild(errorDiv);
                            }, 2000);
                        </script>
                    </div>
                @endif
            </div>
            <div class="col-3"></div>
        </div>
        {{-- recent --}}
        <div class="ms-2 row">
            {{-- <div class="row"> --}}
            {{-- <div class="col-1">
            </div> --}}
            <div class="col">
                <div class="table-responsive">
                <table class="table table-hover table-bordered ">
                    <thead class="thead-dark">
                        {{-- <div class="table-row> --}}
                        <tr>
                            <th class="text-wrap" scope="">Name</th>
                            <th class="text-wrap" scope="">Gender</th>
                            <th class="text-wrap" scope="" class="table-td">Email</th>
                            <th class="text-wrap" scope="" class="table-td">Address</th>
                            <th class="text-wrap" scope="" class="table-td">Blood Group</th>
                            <th class="text-wrap" scope="" class="table-td">Hobbies</th>
                            <th class="text-wrap" scope="" class="table-td">Description</th>
                            <th class="text-wrap" scope="" class="table-td">File</th>
                            <th scope="text-wrap"></th>
                            <th scope="text-wrap"></th>
                        </tr>
                        {{-- </div> --}}
                    </thead>
                    <tbody>
                        @foreach ($customer as $customer)
                            <tr>
                                <th class="text-wrap col-2" scope="row">{{ $customer->name }}</th>
                                <td>
                                    @if ($customer->gender == 'M')
                                        Male
                                    @elseif ($customer->gender == 'F')
                                        Female
                                    @else
                                        Others
                                    @endif
                                </td>
                                <td class="text-wrap">{{ $customer->email }}</td>
                                <td class="text-wrap">{{ $customer->address }}</td>
                                <td class="text-wrap">{{ $customer->blood_group }}</td>
                                <td class="text-wrap">{{ $customer->hobbies }}</td>
                                <td class="text-wrap">{{ $customer->description }}</td>
                                <td class="text-wrap"><a href="{{ $customer->file }}" target="_blank">View
                                        file</a>
                                </td>
                                <th scope="col">
                                    {{-- <a href="{{url('/edit')}}/{{$customer->id}}">Edit --}}
                                    <a href="{{ url('/admin/add') }}/{{ $customer->id }}">Edit
                                    </a>
                                </th>
                                <th scope="col">
                                    <a href="{{ route('admin.customer.delete', ['id' => $customer->id]) }}">Trash
                                    </a>
                                </th>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                </div>
            </div>
            {{-- <div class="col-1">
            </div> --}}
            {{-- </div> --}}
        </div>
        <div class="excel mb-3 ms-3">
            <a href="{{ route('excel.export') }}" class="btn btn-success">Export to Excel</a>
        </div>
        <div class="excel ms-3">
            <form action="{{ route('excel.import') }}" id="import" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3 col-3">
                        <input class="form-control" name="file" type="file" id="formFile">
                    </div>
                    <div class="mb-3 col-1">
                        <input type="submit" class="btn btn-success" value="Import">
                    </div>
                    <div class="mb-3 col-3 alert alert-danger" id="msg" hidden>
                    </div>
                </div>
            </form>
        </div>
        </div>
        <div class="col-2">
        </div>
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
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="js/dashboard.js"></script>
</body>

</html>
