@extends('installment.master')
@section('title','Product Management')
@section('Product_Management','active')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1 class="text-center">Products</h1>
            <table class="table table-striped table-hover table-bordered" id="product_table" width="100%" cellspacing="0" >
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $key => $product)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            @if(empty($product->image))
                                <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}" class="img" alt="" style="height: 50px; width: 50px;">
                            @else
                                @php
                                    $imgarray = json_decode($product->image);
                                @endphp
                                <img src="{{ asset('assets/vendor/images/products/') }}/{{$imgarray[0]->image}}" class="img" alt="" style="height: 50px; width: 50px;">
                            @endif
                        </td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->stock}}</td>
                        <td>{{$product->price}}</td>
                        <td><a href="{{ route('installment.makeOrder',Crypt::encrypt($product->id) ) }}" title="Place Order" class="btn btn-success"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></td>
                    </tr>
                @endforeach

                </tbody>
            </table>
{{--            @foreach($products as $product)--}}
{{--                <div class="col-md-4">--}}
{{--                    <h2>{{$product->name}}</h2>--}}
{{--                    <p>{{$product->price}}/=</p>--}}
{{--                    <a href="{{ route('installment.makeOrder',Crypt::encrypt($product->id) ) }}" class="btn btn-success">Place Order</a>--}}
{{--                </div>--}}
{{--            @endforeach--}}
        </div>
    </div>
@endsection
