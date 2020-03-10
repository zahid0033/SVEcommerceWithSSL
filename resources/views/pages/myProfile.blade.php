@extends('master')
@section('content')
    <div class="container" style="margin: 50px auto">
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 20px">
                <h1 style="text-align: center;margin: 50px 0">My Profile</h1>
                <a href="{{ route('pages.editMyProfile',Crypt::encrypt($customer->id) ) }}" class="btn btn-success" style="float: right">Edit Information</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group myProfile">
                    <span><b>Name : </b></span>
                    <span>{{$customer->name}}</span>
                </div>
                <div class="form-group myProfile">
                    <span><b>Email : </b></span>
                    <span>{{ $customer->email }}</span>
                </div>
                <div class="form-group myProfile">
                    <span><b>Address : </b></span>
                    <span>{{ $customer->address }}</span>
                </div>
                <div class="form-group myProfile">
                    <span><b>City : </b></span>
                    <span>{{ $customer->city }}</span>
                </div>
                <div class="form-group myProfile">
                    <span><b>Phone : </b></span>
                    <span>{{ $customer->phone }}</span>
                </div>
                <div class="form-group myProfile">
                    <span><b>Gender : </b></span>
                    <span>{{ $customer->gender }}</span>
                </div>

            </div>
            <div class="col-md-4 profile_image">
                <img src="{{ asset('assets/vendor/images/profile_picture') }}/{{$customer->image}}" alt="">
            </div>
        </div>
    </div>
@endsection
