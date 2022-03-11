@extends('welcome')
@section('content')
<div class="container-fluid">
    <form action="/admin/auth" method="POST" class="container-lg">
        <div class="mb-3">
          <label for="" class="form-label"></label>
          <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
          <small id="helpId" class="text-muted">Login</small>
        </div>
        <div class="mb-3">
            <label for="" class="form-label"></label>
            <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
            <small id="helpId" class="text-muted">Password</small>
        </div>
        <button type="submit" class="btn btn-primary|secondary|success|danger|warning|info|light|dark|link">Submit</button>
    </form>
</div>    
@endsection