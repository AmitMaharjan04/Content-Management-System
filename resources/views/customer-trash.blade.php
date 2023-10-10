<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Trash Bins</title>
</head>
<body>
    <div class="container">
        <a href=" {{ url('/customer')}}">
            <button type="button" class="btn btn-primary btn-lg">Add</button>
        </a>
        <a href=" {{ url('/customer/view')}}">
            <button type="button" class="btn btn-primary btn-lg">Goto Customer</button>
        </a>
        <table class="table" border="1" cellpadding="10" width="100%" align="center">
            
            
                 {{-- <pre>
                {{print_r($customers);}}
                </pre> --}}
            
            <thead>
                
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Gender</th>
                </tr>
            </thead>
            
            <tbody>
                
                @foreach ($customers as $customer)
                <tr>
                    
                    <td align="center">{{$customer->name}}</td>
                    <td align="center">{{$customer->email}}</td>
                    <td align="center">{{$customer->address}}</td>
                    <td align="center">
                        @if ($customer->Gender=="M")
                            Male
                        @elseif($customer->Gender=="F")
                            Female
                        @else
                            Others
                        @endif
                    </td>
                    <td>
                        <a href="{{route('customer.force-delete', ['id'=>$customer->id])}}">
                            {{-- <a href= "{{ url('/customer/delete')}}/{{$customer->}}" --}}
                            <button class="btn btn-danger">Delete</button>
                        </a>
                        <a href="{{route('customer.restore',['id'=>$customer->id])}}">
                            <button class="btn btn-primary">Restore</button>
                        </a>
                    </td>
                    {{-- <td align="center">{{$customer->Gender}}</td> --}}
                </tr>
                @endforeach
               
            </tbody>
        </table>
    </div>
</body>
</html>