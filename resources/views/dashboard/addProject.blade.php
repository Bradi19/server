@extends('dashboard')
@section('stylesheet')
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
@endsection
@section('content_admin')
    <div class="conteiner-fluid">
        <div class="row">
            <div class="col-3">
                <nav class="nav nav-tabs|pills flex-column">
                    <a class="nav-link active" data-target='add' href="/admin/project/add">Add</a>
                </nav>
            </div>
            <div class="col-9">
            @section('content_banner')
                @parent
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-default">
                        <tr>
                            <th>id</th>
                            <th>title</th>
                            <th>image</th>
                            <th>body</th>
                            <th>buttons</th>
                        </tr>
                    </thead>
                    <tbody class='dataBanner'>
                        @for ($i = 0; $i < count($data); $i++)
                            <tr class='parent'>
                                <td>{{ $data[$i]['id'] }}</td>
                                <td>{{ $data[$i]['title'] }}</td>
                                @if ($data[$i]['paramsBanner'])
                                    <td><img src="{{ $data[$i]['link'] }}" /></td>
                                @else
                                    <td> Null </td>
                                @endif

                                <td class="texts"><div>{!! $data[$i]['body'] !!}</div></td>
                                <td scope="row" class="">
                                    <div class="row">
                                        <div class="col-6">
                                            <a class="nav-link" data-target='remove'
                                                href="/admin/project/remove">Remove</a>
                                        </div>
                                        <div class="col-6">
                                            <a class="nav-link" data-target='edit' href="/admin/project/edit">Edit</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endfor

                    </tbody>
                </table>
            @endsection
            @yield('content_banner')
        </div>
    </div>
</div>
<div class="modal_window">
    <div class="block__modal">
        <div class="close"><i class="fa fa-close" aria-hidden="true"></i></div>
        <div class="inputs">
            <div class="status"></div>
            <form method="POST" name="dols" url="/admin/project" class="forms" id="forms">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <input type="hidden" name='id' class="form-control" id="validationCustom01" value="">
                    </div>
                    <div class="col-12">
                        <label for="validationCustom01" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="validationCustom01" value=""
                            required>
                        <div class="valid-feedback"></div>
                    </div>
                    <div class="col-6">
                        <label for="validationCustom01" class="form-label">Language</label>
                        <select name='lang' class="form-control" required>
                            <option value="en">English</option>
                            <option value="ua">Ukraine</option>
                            <option value="ru">Russian</option>
                        </select>
                        <div class="valid-feedback"></div>
                    </div>
                    <div class="col-12">
                        <div class="blockImg"></div>
                        <label for="validationCustom02" class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" id="validationCustom02" value=""
                            onchange="myFunc(this)">
                        <div class="valid-feedback"></div>
                    </div>
                    <div class="col-12">
                        <label for="validationCustomUsername" class="form-label">Description</label>
                        <div class="input-group">
                            <textarea type="text" class="form-control " height="400" name="body"
                                id="validationCustomUsername" aria-describedby="inputGroupPrepend" value=''></textarea>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary mt-3" type="submit">Submit form</button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>


@endsection
@section('footer')
<script>
    ClassicEditor
        .create(document.querySelector('#validationCustomUsername'))
        .then((e) => {
            e.config.minHeight = 400;
            e.configwidth = '100%';
        })
        .catch(error => {
            console.error(error);
        });

    function myFunc(input) {

        var files = input.files || input.currentTarget.files;

        var reader = [];
        var images = document.querySelector('.blockImg');
        var name;
        for (var i in files) {
            if (files.hasOwnProperty(i)) {
                name = 'file' + i;

                reader[i] = new FileReader();
                reader[i].readAsDataURL(input.files[i]);

                images.innerHTML += '<img id="' + name + '" src="" />';

                (function(name) {
                    reader[i].onload = function(e) {
                        document.getElementById(name).src = e.target.result;
                    };
                })(name);

            }
        }
    }
</script>
@endsection
