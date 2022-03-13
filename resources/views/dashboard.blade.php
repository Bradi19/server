@extends('welcome')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <ul class="nav justify-content-center|justify-content-end">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/admin/addBanner') }}">Add Banner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin/addProject') }}">Add project</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin/addNews') }}">Add News</a>
                </li>
            </ul>
        </div>

        <div class="row">
            @yield('content_admin')
        </div>
    </div>
@endsection
