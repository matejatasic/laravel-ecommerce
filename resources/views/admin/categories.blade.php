@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Categories</h1>
            <hr>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li class="ml-2 mb-2">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
        </div>
        <div class="col-md-12 d-flex justify-content-end mb-3">
            <button class="btn btn-success" id="addBtn">Add</button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ date('j F, Y', strtotime($category->created_at)) }}</td>
                        <td>
                            <button class="btn btn-success btnEdit" id="{{ $category->id }}">Edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>

    <!-- modal -->
    <div class="modal" id="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white bg-primary">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- !modal -->
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(() => {
            let modal = $('.modal');

            $('.btnEdit').click((e) => {
                e.stopPropagation();
                e.stopImmediatePropagation();

                let id = e.target.id;
                modal.css('display', 'block');

                $.get('/admin/categories/edit/' + id, (data) => {
                    let category = data.data;

                    $('.modal-header').addClass('bg-success');
                    $('.modal-title').text('Edit');

                    $('.modal-body').html(`
                        <form action="/admin/categories/update/${category['id']}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="${category['name']}">
                            </div>
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" name="slug" class="form-control" value="${category['slug']}">
                            </div>
                            <input type="submit" class="btn btn-success" value="Edit">
                        </form>    
                    `);
                });
            });

            $('#addBtn').click((e) => {
                e.stopPropagation();
                e.stopImmediatePropagation();

                modal.css('display', 'block');

                lastClass = $('.modal-header').attr('class').split(' ').pop();
                $('.modal-header').removeClass(lastClass);
                $('.modal-header').addClass('bg-success');
                $('.modal-title').text('Add');

                $('.modal-body').html(`
                    <form action="/admin/categories/add" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control">
                        </div>
                        <input type="submit" class="btn btn-success" value="Add";
                    </form>
                `);
            });

            $('.close').click(() => {
                modal.css('display', 'none');
            });
        });
    </script>
@endsection
