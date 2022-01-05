@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-12">
            <h1 class="text-center">Costumers</h1>
            <hr>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12 col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Orders</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ ucfirst($customer->role) }}</td>
                            <td>{{ count($customer->orders->where('error', null)) }}</td>
                            <td>{{ date('j F, Y', strtotime($customer->created_at)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $customers->links() }}
        </div>
    </div>
@endsection
