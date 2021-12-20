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
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->total }}</td>
                        <td>{{ $order->shipped !== 0 ? 'Yes' : 'No' }}</td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection