@extends('installment.master')
@section('title','Customers')
@section('Customer_management','active')
@section('customerList','active')
@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Customer List</h1>
        <a href="{{ route('installment.addCustomer') }}" class="btn btn-primary">Register Customer</a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Address</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)

                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->address }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>

    </div>
@endsection
