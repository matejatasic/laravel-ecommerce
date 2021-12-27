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
                    <th>Email</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Total Price</th>
                    <th>Shipped</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->total }}$</td>
                        <td>{{ $order->shipped !== 0 ? 'Yes' : 'No' }}</td>
                        <td>{{ date('j F, Y', strtotime($order->created_at)) }}</td>
                        <td>
                            <button class="btn btn-primary viewBtn" id="{{ $order->id }}">View</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>

    <!-- modal -->
    <div class="modal" id="viewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
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
            const modal = $('#viewModal');

            $('.viewBtn').click((e) => {
                event.stopPropagation();
                event.stopImmediatePropagation();

                let id = e.target.id;
                modal.css('display', 'block');
                
                $.get('/admin/orders/' + id, (data) => {
                    let order = data.data;
                    let months = [
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];

                    let time = new Date(order['created_at']);
                    let date = `${time.getDate()} ${months[time.getMonth()]}, ${time.getFullYear()}`

                    $('.modal-title').text('Order')
                    
                    $('.modal-body').html(`
                        <p><b>Email:</b> ${order['email']}</p>  
                        <p><b>Name:</b> ${order['name']}</p>  
                        <p><b>Address:</b> ${order['address'] ? order['address'] : 'No address'}</p>
                        <p><b>City:</b> ${order['city']}</p>    
                        <p><b>Province:</b> ${order['province']}</p>    
                        <p><b>Postal code:</b> ${order['postalcode']}</p>    
                        <p><b>Phone number:</b> ${order['phone']}</p>    
                        <p><b>Name on card:</b> ${order['name_on_card']}</p>
                        <p><b>Subtotal:</b> ${order['subtotal']}$</p>    
                        <p><b>Tax:</b> ${order['tax']}$</p>    
                        <p><b>Total:</b> ${order['total']}$</p>    
                        <p><b>Payment gateway:</b> ${order['payment_gateway']}</p>    
                        <p><b>Shipped:</b> ${order['shipped'] === '0' ? 'No' : 'Yes'}</p>
                        <p><b>Date:</b> ${date}</p>
                    `);
                });
            });
            
            $('.close').click(() => {
                modal.css('display', 'none');
            });
        });
    </script>
@endsection
