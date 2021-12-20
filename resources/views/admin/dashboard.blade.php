@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Dashboard</h1>
            <hr>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3 text-center">
                <div class="card-header">Products</div>
                <div class="card-body">
                    <h2 class="card-title">{{ $product_count }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3 text-center">
                <div class="card-header">Orders</div>
                <div class="card-body">
                    <h2 class="card-title">{{ $order_count }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3 text-center">
                <div class="card-header">Customers</div>
                <div class="card-body">
                    <h2 class="card-title">{{ $customer_count }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
