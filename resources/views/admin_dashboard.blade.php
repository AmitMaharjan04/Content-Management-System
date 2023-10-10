<!doctype html>
<html lang="en">

<head>
    <title>Homepage</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <link rel="stylesheet" href="css/dashboard.css">

    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="js/dashboard.js"></script>

    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" /> --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script> --}}
    <style>
        /* td:nth-child(4),td:nth-child(7){
            word-wrap: break-word;
            text-align: center;
            color: #359900;
  font-weight: bold;
        } */
        /* td:first-child{
            white-space: nowrap;
            text-align: center;
            color: #359900;
  font-weight: bold;
        } */
        td {
            /* white-space: nowrap; */
            text-align: center;
        }

        div.dataTables_wrapper div.dataTables_filter label {
            font-size: 15px;
            font-weight: 500;
        }
        .dataTables_wrapper .dataTables_filter input {
            width:180px;
        }
        div.dataTables_wrapper div.dataTables_length select {
            font-weight: 600;
            border-color: black;
        }

        div.dataTables_wrapper div.dataTables_length label {
            font-size: 15px;
        }

        div.dataTables_wrapper div.dataTables_info {
            font-size: 13px;
            font-weight: 600;
        }

        div.dataTables_wrapper div.dataTables_paginate {
            font-size: 13;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: #333;
            margin-bottom: 13px;
        }

        .dataTables_filter input:hover {
            border-color: rgb(30, 30, 158);
        }
        table.dataTable { border-collapse: collapse; }
    </style>
</head>

<body class="">
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
                    <li class="nav-item">
                        <a class="nav-link" href="/add">Add</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/trash">Move to trash</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout" href="/logout" id="logout">logout</a>
                    </li>
                </ul>
            </div>
            {{-- <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
  
  
                 <img src="/theme/asr/images/default-avatar.png" class="user-image" alt="User Image">
                 <!-- <span class="hidden-xs"> Sujan Shrestha</span> -->
               </a>
               <ul class="dropdown-menu">
                <!-- User image -->
                  <li class="user-header">
                      <div class="card text-center user-contact-list">
                      <div class="p-20">
                          <div class="avatar avatar-xxl brround d-block cover-image mx-auto" data-image-src="images/default-avatar.png">
                          </div>
                          <div class="wrapper mt-15">
                          <p class="mb-0 mt-10 fw-600">hello user</p>
                          </div>
                          <div class="">
                          <a class="btn btn-light mt-20" href="">
                              <i class="fa fa-user"></i>Profile
                          </a>
                          <a class="btn btn-light mt-20" href="">
                              <i class="fa fa-sign-out"></i>Sign out
                          </a>
                          </div>
                      </div>
                      </div>
                  </li> --}}
                {{-- @if(array_key_exists("Switch User", session('role')))
                  @php
                      $switchEmployees = \Cache::get( 'employeeDetails' );
                      if(empty($switchEmployees)){
                          $switchEmployees = DB::connection('mysql4')->table('employee as e')
                                                      ->select('e.employee_id','e.first_name','e.last_name','b.name as branch_name')
                                                      ->leftjoin('branches as b','e.branch_id','b.id')
                                                      ->where('active','Y')
                                                      ->get()
                                                      ->keyBy('employee_id')
                                                      ->toArray();
  
                          \Cache ::put('employeeDetails', $switchEmployees ,now()->addMinutes(50));
                      }
                  @endphp
                  <li class="user-body">
                      <form action="/change/employee" method="Post">
                          <label>Sign In as: </label>
                          <select name="employee_id" class="employees_select">
                              @foreach($switchEmployees as $employee)
                              <option value={{$employee->employee_id}}>{{$employee->first_name}}  {{$employee->last_name}}({{$employee->branch_name}})</option>
                              @endforeach
                          </select>
                          <input type="hidden" name="_token" id="switch_token" value="{{csrf_token()}}"/>
                          <button class="btn btn-xs btn-success" id="sign_in_button">Sign In</button>
                      </form>
                  </li>
                  @endif --}}
  
              </ul>
            </li>

        </nav>
    </header>
    <main class="mt-4 ">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-6">
                

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
                @if (session()->has('importError'))
                    <div class="alert alert-danger col-8 d-flex  justify-content-center" id="importError">
                        {{ session('importError') }}
                        <script>
                            var errorDiv = document.getElementById("importError");
                            setTimeout(function() {
                                errorDiv.parentNode.removeChild(errorDiv);
                            }, 2000);
                        </script>
                    </div>
                @endif
            </div>
            <div class="col-2"></div>
        </div>
        <div class="row">
            <div class="col mx-3" style="overflow-x:auto">
                <table class="table table-hover table-responsive table-bordered  table_1" id="test">
                    <thead class="thead-dark " style="background-color: cadetblue;">
                        <tr>
                            <th class="text-nowrap text-center" scope="">Name</th>
                            <th class="text-nowrap text-center" scope="">Gender</th>
                            <th class="text-nowrap text-center" scope="" class="table-td">Email</th>
                            <th class="text-nowrap text-center" scope="" class="table-td">Address</th>
                            <th class="text-nowrap text-center" scope="" class="table-td">Blood Group</th>
                            <th class="text-nowrap text-center" scope="" class="table-td">Hobbies</th>

                            <th class="text-nowrap text-center" scope="" class="table-td">Description</th>
                            
                            <th class="text-nowrap text-center" scope="" class="table-td">File</th>

                            <th scope="text-wrap" style="border:none;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($customer as $customer)
                            <tr>
                                <td class="text-nowrap text-center" scope="row">{{ $customer->name }}</td>
                                <td class="text-nowrap text-center">
                                    @if ($customer->gender == 'M')
                                        Male
                                    @elseif ($customer->gender == 'F')
                                        Female
                                    @else
                                        Others
                                    @endif
                                </td>
                                <td class="text-nowrap text-center">{{ $customer->email }}</td>
                                <td class="text-wrap">{{ $customer->address }}</td>
                                <td class="text-nowrap text-center">{{ $customer->blood_group }}</td>
                                <td class="text-nowrap">{{ $customer->hobbies }}</td>
                                <td class="text-wrap">{{ $customer->description }}</td>
                                <td class="text-nowrap">
                                    <a class="file" href="{{ $customer->file }}" target="_blank">
                                        @if ($customer->file != null)
                                            View file
                                        @else
                                        @endif

                                    </a>
                                </td>
                                <td scope="col" class="text-nowrap">
                                    <a class="me-3 edit" href="{{ url('/add') }}/{{ $customer->id }}">Edit
                                    </a>
                                    <a class="delete"
                                        href="{{ route('customer.delete', ['id' => $customer->id]) }}">Trash
                                    </a>
                                </td>
                            </tr>
                        @endforeach --}}
                        {{-- @foreach ($customer as $customer)
                        <tr>
                            <td scope="col" class="text-nowrap">
                                <a class="me-3 edit" href="{{ url('/add') }}/{{ $customer->id }}">Edit
                                </a>
                                <a class="delete"
                                    href="{{ route('customer.delete', ['id' => $customer->id]) }}">Trash
                                </a>
                            </td>
                        </tr>
                        @endforeach --}}

                    </tbody>
                </table>
            </div>
        </div>
        <div class="excel mb-3 ms-3">
            <a href="{{ route('excel.export') }}" class="btn btn-success">Export to Excel</a>
        </div>
        <div class="excel ms-3 mb-5">
            <form action="{{ route('excel.import') }}" id="import" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3 col-3">
                        <input class="form-control" name="file" type="file" id="formFile">
                    </div>
                    <div class="mb-3 col-1">
                        <input type="submit" class="btn btn-success" value="Import">
                    </div>
                    <div class="mb-3 col-3 alert alert-danger text-center" id="msg" hidden>
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
</body>

</html>

{{-- <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="/profile.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ session('employee_name') }}</span>
            </a>
            <ul id="dropdownmenu" class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="/images/icon_vianet.png" class="img-circle" alt="User Image">

                    <p>
                        {{ session('employee_name') }}
                    </p>
                </li>

                @if (session('role'))
                    @if (array_key_exists('Switch User', session('role')))
                        @php
                            $switchEmployees = \Cache::get('employeeDetails');
                            if (empty($switchEmployees)) {
                                $switchEmployees = DB::connection('mysql4')
                                    ->table('employee as e')
                                    ->select('e.employee_id', 'e.first_name', 'e.last_name', 'b.name as branch_name')
                                    ->leftjoin('branches as b', 'e.branch_id', 'b.id')
                                    ->where('active', 'Y')
                                    ->whereNull('dor')
                                    ->get()
                                    ->keyBy('employee_id')
                                    ->toArray();
                            
                                \Cache::put('employeeDetails', $switchEmployees, now()->addMinutes(50));
                            }
                        @endphp
                        <li class="user-body">
                            <form action="/change/employee" method="Post">
                                <label>Sign In as: </label>
                                <select name="employee_id" class="employees_select">
                                    @foreach ($switchEmployees as $employee)
                                        <option value={{ $employee->employee_id }}>{{ $employee->first_name }}
                                            {{ $employee->last_name }}({{ $employee->branch_name }})</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="_token" id="switch_token"
                                    value="{{ csrf_token() }}" />
                                <button class="btn btn-xs btn-success" id="sign_in_button">Sign In</button>
                            </form>
                        </li>
                    @endif
                @endif
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="{{ url('/user/profile') }}" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <a href="{{ url('/user/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</div>
</nav> --}}
