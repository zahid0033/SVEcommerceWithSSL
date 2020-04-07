@extends('installment.master')
@section('title','Customers')
@section('Customer_management','active')
@section('addCustomer','active')
@section('content')
    <h1 class="text-center">Add Customer</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="{{ route('installment.createCustomer') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="email" class="form-control" name="email"  placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Phone</label>
                        <input type="text" class="form-control" name="phone" placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Address</label>
                        <input type="text" class="form-control" name="address" placeholder="Address">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                </form>
            </div>
        </div>
    </div>

@endsection
