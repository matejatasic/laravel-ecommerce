@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <h1 class="text-center">Products</h1>
            <hr>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12 col-12">
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
        <div class="col-md-12 col-sm-12 col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Details</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->details }}</td>
                            <td>{{ $product->price }}$</td>
                            <td>{{ $product->quantity}}</td>
                            <td>{{ date('j F, Y', strtotime($product->created_at)) }}</td>
                            <td class="d-flex flex-column">
                                <button class="btn btn-primary viewBtn" id="{{ $product->id }}">View</button>
                                <button class="btn btn-success editBtn" id="edit-{{ $product->id }}">Edit</button>
                                <button class="btn btn-danger deleteBtn" id="delete-{{ $product->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        </div>
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
            const modal = $('#modal');
            let lastClass;

            $('.viewBtn').click((e) => {
                e.stopPropagation();
                e.stopImmediatePropagation();

                let id = e.target.id;
                modal.css('display', 'block');
                
                $.get('/admin/products/' + id, (data) => {
                    let product = data.data;
                    let category = data.category;
                    let months = [
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];

                    let time = new Date(product['created_at']);
                    let date = `${time.getDate()} ${months[time.getMonth()]}, ${time.getFullYear()}`
                    
                    lastClass = $('.modal-header').attr('class').split(' ').pop();
                    $('.modal-header').removeClass(lastClass);
                    $('.modal-header').addClass('bg-primary');
                    $('.modal-title').text('Product')
                    
                    $('.modal-body').html(`
                        <h4 class="text-center">${product['name']}</h4>
                        <img src="/images/${product['image']}" alt="product_image" class="img-fluid">
                        <p><b>Details:</b> ${product['details']}</p>  
                        <p><b>Description:</b> ${product['description']}</p>  
                        <p><b>Price:</b> ${product['price']}$</p>  
                        <p><b>Featured:</b> ${product['featured'] === 1 ? 'Yes' : 'No'}</p>
                        <p><b>Quantity:</b> ${product['quantity']}</p>  
                        <p><b>Category:</b> ${category}</p>  
                        <p><b>Date:</b> ${date}</p>  
                    `);
                });
            });

            $('#addBtn').click((e) => {
                e.stopPropagation();
                e.stopImmediatePropagation();

                modal.css('display', 'block');
                let categories = @json($categories);
                
                let select = '';
                    
                for(let i=0; i < categories.length; i++) {
                    select += `
                        <option value="${categories[i]['id']}">${categories[i]['name']}</option>
                    `;
                }

                lastClass = $('.modal-header').attr('class').split(' ').pop();
                $('.modal-header').removeClass(lastClass);
                $('.modal-header').addClass('bg-success');
                $('.modal-title').text('Add');

                $('.modal-body').html(`
                    <form action="/admin/products/add" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Product name...">
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" name="slug" placeholder="Product slug...">
                        </div>
                        <div class="form-group">
                            <label>Details</label>
                            <textarea class="form-control" name="details" placeholder="Product details..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" placeholder="Product description..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" class="form-control" name="price" placeholder="Product price...">
                        </div>
                        <div class="form-group">
                            <label>Featured</label>
                            <select class="form-control" name="featured">
                                <option disabled selected>-</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" class="form-control" name="quantity" placeholder="Product quantity...">
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="category">
                                <option disabled selected>-</option>
                                ${select}
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" class="form-control-file" name="image">
                        </div>
                        <input type="submit" class="btn btn-success" value="Add"> 
                    </form>
                `);   
            });

            $('.editBtn').click((e) => {
                e.stopPropagation();
                e.stopImmediatePropagation();
            
                let id = e.target.id.split('-')[1];
                modal.css('display', 'block');
                let select = '';

                $.get('/admin/products/edit/' + id, (data) => {
                    let product = data.data;
                    let categories = @json($categories);
                    
                    for(let i=0; i < categories.length; i++) {
                        select += `
                            <option value="${categories[i]['id']}">${categories[i]['name']}</option>
                        `;
                    }

                    lastClass = $('.modal-header').attr('class').split(' ').pop();
                    $('.modal-header').removeClass(lastClass);
                    $('.modal-header').addClass('bg-success');
                    $('.modal-title').text('Edit');

                    $('.modal-body').html(`
                        <form action="/admin/products/update/${product['id']}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="${product['name']}">
                            </div>
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" class="form-control" name="slug" value="${product['slug']}">
                            </div>
                            <div class="form-group">
                                <label>Details</label>
                                <textarea class="form-control" name="details">${product['details']}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description">${product['description']}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" name="price" value="${product['price']}">
                            </div>
                            <div class="form-group">
                                <label>Featured</label>
                                <select class="form-control" name="featured">
                                    <option disabled selected>-</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control" name="quantity" value="${product['quantity']}">
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category">
                                    <option disabled selected>-</option>
                                    ${select}
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control-file" name="image">
                            </div>
                            <input type="submit" class="btn btn-success" value="Edit"> 
                        </form>
                    `);   
                });
            });

            $('.deleteBtn').click((e) => {
                event.stopPropagation();
                event.stopImmediatePropagation();

                let id = e.target.id.split('-')[1];
                modal.css('display', 'block');

                lastClass = $('.modal-header').attr('class').split(' ').pop();
                $('.modal-header').removeClass(lastClass);
                $('.modal-header').addClass('bg-danger');
                $('.modal-title').text('Delete');

                $('.modal-body').html(`
                    <h5>Are you sure you want to delete this product?</h5>
                    <form action="/admin/products/delete/${id}" method="POST">
                        @csrf
                        @method('DELETE')
                        
                        <input type="submit" class="btn btn-danger btn-lg" value="Delete">
                    </form>
                `);
            });
            
            $('.close').click(() => {
                modal.css('display', 'none');
            });
        });
    </script>
@endsection
