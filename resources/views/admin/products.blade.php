@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Orders</h1>
            <hr>
        </div>
    </div>
    <div class="row mt-3">
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
                        <td>
                            <button class="btn btn-primary viewBtn" id="{{ $product->id }}">View</button>
                            <button class="btn btn-success editBtn" id="edit-{{$product->id}}">Edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    </div>

    <!-- modal -->
    <div class="modal" id="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white">
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

            $('.viewBtn').click((e) => {
                event.stopPropagation();
                event.stopImmediatePropagation();

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

            $('.editBtn').click((e) => {
                event.stopPropagation();
                event.stopImmediatePropagation();
            
                let id = e.target.id.split('-')[1];
                modal.css('display', 'block');
                let select = '';

                $.get('/admin/products/edit/' + id, (data) => {
                    let product = data.data;
                    let categories = data.categories;
                    
                    for(let i=0; i < categories.length; i++) {
                        select += `
                            <option value="${categories[i]['id']}">${categories[i]['name']}</option>
                        `;
                    }

                    $('.modal-header').addClass('bg-success');
                    $('.modal-title').text('Edit');

                    $('.modal-body').html(`
                        <form action="/admin/products/update/${product['id']}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT');

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" placeholder="${product['name']}">
                            </div>
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" class="form-control" name="slug" placeholder="${product['slug']}">
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
                                <input type="number" class="form-control" name="price" placeholder="${product['price']}">
                            </div>
                            <div class="form-group">
                                <label>Featured</label>
                                <select class="form-control" name="featured">
                                    <option>-</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control" name="quantity" placeholder="${product['quantity']}">
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category">
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
            
            $('.close').click(() => {
                modal.css('display', 'none');
            });
        });
    </script>
@endsection