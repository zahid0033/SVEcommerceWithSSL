@extends('master')
@section('content')
    <div class="container" style="margin: 50px auto">
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 20px">
                <h1 style="text-align: center;margin: 50px 0">My Profile</h1>
            </div>
        </div>
        <form method="post" action="{{ route('pages.profile_edit') }}" class="clearfix" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <div class="col-md-8">
                <input type="hidden" name="id" value="{{$customer->id}}">
                <div class="form-group myProfile">
                    <span><b>Name : </b></span>
                    <input class="input" type="text" name="name" placeholder="Name" value="{{$customer->name}}" required>
                </div>
                <div class="form-group myProfile">
                    <span><b>Email : </b></span>
                    <input class="input" type="text" name="email" placeholder="Email" value="{{$customer->email}}" required>
                </div>
                <div class="form-group myProfile">
                    <span><b>Address : </b></span>
                    <input class="input" type="text" name="address" placeholder="Address" value="{{$customer->address}}" required>
                </div>
                <div class="form-group myProfile">
                    <span><b>City : </b></span>
                    <input class="input" type="text" name="city" placeholder="City" value="{{$customer->city}}" required>
                </div>
                <div class="form-group myProfile">
                    <span><b>Phone : </b></span>
                    <input class="input" type="text" name="phone" placeholder="Phone" value="{{$customer->phone}}" required>
                </div>
                <div class="form-group myProfile">
                    <span><b>Gender : </b></span>
                    <input class="input" type="text" name="gender" placeholder="Gender" value="{{$customer->gender}}" required>
                </div>


            </div>
            <div class="col-md-4 profile_image">
                <input class="input" type="file" name="image">
            </div>
        </div>
            <input type="submit" class="btn btn-primary" value="Update">
        </form>
    </div>
@endsection
