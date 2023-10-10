@extends('views/admin_dashboard')

@section('success')
    <div class="alert alert-success col-8 d-flex  justify-content-center" id="success">
        {{ session('success') }}
        <script>
            var errorDiv = document.getElementById("success");
            setTimeout(function() {
                errorDiv.parentNode.removeChild(errorDiv);
            }, 2000);
        </script>
    </div>
@endsection

@section('add')
<div class="alert alert-success col-8 d-flex  justify-content-center" id="add">
    {{ session('add') }}
    <script>
        var errorDiv = document.getElementById("add");
        setTimeout(function() {
            errorDiv.parentNode.removeChild(errorDiv);
        }, 2000);
    </script>
</div>
@endsection

@section('edit')
<div class="alert alert-success col-8 d-flex  justify-content-center" id="edit">
    {{ session('edit') }}
    <script>
        console.log("in session");
        var errorDiv = document.getElementById("edit");
        setTimeout(function() {
            errorDiv.parentNode.removeChild(errorDiv);
        }, 2000);
    </script>
</div>
@endsection
