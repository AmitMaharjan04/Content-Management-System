<!doctype html>
<html lang="en">

<head>
    <title>Trash Records</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="{{ asset('css/trash.css')}}" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="image">
                <img src="photos/11.jpeg" width="50"class="img-fluid rounded" alt="Responsive image">
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
    <main class="mt-4">
        <div class="row">
        <div class="col mx-4">
            <table class="table table-hover table-bordered table_1">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-nowrap text-center" scope="col">Name</th>
                        <th class="text-nowrap text-center" scope="col">Gender</th>
                        <th class="text-nowrap text-center" scope="col" class="table-td">Email</th>
                        <th class="text-nowrap text-center" scope="col" class="table-td">Address</th>
                        <th class="text-nowrap text-center" scope="col" class="table-td">Blood Group</th>
                        <th class="text-nowrap text-center" scope="col" class="table-td">Hobbies</th>
                        <th class="text-nowrap text-center" scope="col" class="table-td">Description</th>
                        <th class="text-nowrap text-center" scope="col" class="table-td">File</th>
                        <th scope="text-wrap"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customer as $customer)
                        <tr>
                            <td class="text-nowrap text-center">{{ $customer->name }}</td>
                            <td class="text-nowrap text-center">
                                @if ($customer->gender == 'M')
                                    Male
                                @elseif ($customer->gender == 'F')
                                    Female
                                @else
                                    Others
                                @endif
                            </td>
                            <td class="text-nowrap text-center"> {{ $customer->email }}</td>
                            <td class="text-wrap">{{ $customer->address }}</td>
                            <td class="text-nowrap text-center">{{ $customer->blood_group }}</td>
                            <td class="text-nowrap text-center">{{ $customer->hobbies }}</td>
                            <td class="text-wrap">{{ $customer->description }}</td>
                            <td class="text-nowrap">
                              <a href="{{ $customer->file }}" target="_blank" class="file">
                              View file
                              </a>
                          </td>
                          {{-- @if ($customer->file == null){
                            <td class="wrap col-2">Empty</td>
                              }
                          @else{
                              <a href="{{ $customer->file }}" target="_blank">
                                <td class="wrap col-2">  View file</td>
                              </a>
                              }
                              @endif --}}
                            <td scope="col" class="text-nowrap">
                                <a class="me-1 restore" href="{{ url('/restore') }}/{{ $customer->id }}">Restore
                                </a>
                                <a class="delete" href="{{ route('customer.deleteForced', ['id' => $customer->id]) }}" id="delete">Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script src="js/trash.js">

    </script>
</body>

</html>
