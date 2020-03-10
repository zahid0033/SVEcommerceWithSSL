@extends('vendor.master')
@section('title','Product Management')
@section('Product_management','active')
@section('content')
    <div class="container-fluid">
         <ul class="nav nav-tabs">
            <li class="active " ><a data-toggle="tab" href="#Products">Products</a></li>
            <li class="" ><a  data-toggle="tab" href="#Create"  >Create</a> </li>

        </ul>
        <div class="tab-content">
            <div id="Products" class="tab-pane fade in active">

                <div class="row">
                    <div class="col-md-12 text-center " style="overflow: auto">
                        <p class="small-heading">My Products </p>
                        @if($products->count() !== 0 )
                        @foreach ($products as $s)
                            <div class="col-md-3 news mb-2 mar-bott">
                                <div class="head img_hover">
                                    @if(empty($s->image))
                                    <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}" class="img" alt="">
                                    @else
                                        @php
                                        $imgarray = json_decode($s->image);
                                        @endphp
                                    <img src="{{ asset('assets/vendor/images/products/') }}/{{$imgarray[0]->image}}" class="img" alt="">
                                    @endif

                                    <div class="overlay">
                                        <a class="btn btn-default btn-xs" {{--href="{{route('brandRemove',Crypt::encrypt($s->id))}}"--}}  title="Remove" onclick="return confirm('You cant delete this now because of database reservation')"><i class="fa fa-trash"></i></a>
                                        <a class="btn btn-success"  href="{{route('productManagementEdit',Crypt::encrypt($s->id))}}" title="Edit"><i class="fa fa-edit"></i></a>
                                        <sub><mark>{{$s->status}}</mark></sub><br>
                                        <sub><b><mark style="background-color: black;color: white;">{{$s->categories->name}}</mark></b></sub>

                                    </div>
                                </div>
                                <div class=" text-center ">
                                    <h4><b>{{$s->name}}</b></h4>
                                    <h5><b> ৳ {!! $s->price !!}</b></h5>
                                </div>
                            </div>
                        @endforeach
                        {!! $products->Links() !!}
                        @else
                            <h3 >Nothing to show</h3>
                        @endif

                    </div>

                </div>
            </div>
            <div id="Create" class="tab-pane fade in " >
                <form method="post" enctype="multipart/form-data" action="{{ route('productAdd') }}">
                    @csrf
                    <div class="modal-body " >
                        <div class="form-group row">
                                <div class="col-sm-12 " style="min-height: 150px">
                                    <label  class=" label label-default">Image Preview</label>
                                    <div id="preview"></div>
                                </div>
                        </div>{{--1 row--}}
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label  class=" label label-primary">Name</label>
                                <input name="name" type="text" class="form-control form-control-sm" value="{{ old('name') }}" required >
                            </div>
                            <div class="col-sm-3">
                                <label  class=" label label-primary">Category</label>
                                <select  title="Choose Category" name="category_id" class="form-control">
                                    @foreach($categories as $s)
                                        @if(empty($s->parent_id))
                                            <optgroup label="{{$s->name}}">
                                                @foreach($categories as $s2)
                                                    @if($s2->parent_id == $s->id)
                                                        <option value="{{$s2->id}}">{{$s2->name}}</option>
                                                    @endif
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label  class=" label label-primary">Brand</label>
                                <select name="brand_id" class="form-control">
                                    @foreach($brands as $s)
                                        <option value="{{$s->id}}" >{{$s->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>{{--2 row--}}
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label  class=" label label-primary">Price</label>
                                <div class="input-group">
                                    <input name="price" id="pprice" type="number" class="form-control form-control-sm" value="{{ old('price') }}" required>
                                    <span class="input-group-addon "> <b>৳</b></span>
                                </div>
                            </div>
                            {{--<div class="col-sm-3">
                                <label  class=" label label-default">Offer Percentage</label>
                                <div class="input-group">
                                    <input name="offer_percentage" id="poffer_percentage" type="number" class="form-control form-control-sm" value="{{ old('offer_percentage') }}" onkeyup="percentage_cal()" >
                                    <span class="input-group-addon "> <b>%</b></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label  class=" label label-default">Offer Price</label>
                                <div class="input-group">
                                    <input name="offer_price" id="poffer_price" type="number" class="form-control form-control-sm" value="{{ old('offer_price') }}" >
                                    <span class="input-group-addon "> <b>৳</b></span>
                                </div>
                            </div>--}}
                            <div class="col-sm-3">
                                <label  class=" label label-default">Image</label>
                                <input type='file' id="image-preview" name="image[]" class="form-control" accept=".png, .jpg, .jpeg" multiple title="Choose Image" onclick="gritter_custom('image upload','Select good resolution images','The image you are going to select should be greater than 700X700 pixels for better quality ')"  >
                            </div>
                            <div class="col-sm-3">
                                <label  class=" label label-default">Stock</label>
                                <input name="stock" type="number" class="form-control form-control-sm" value="{{ old('stock') }}" >
                            </div>
                            <div class="col-sm-3">
                                <label  class=" label label-primary">Status</label>
                                <select name="status" class="form-control" title="Select Status">
                                    <option value="Available" >Available</option>
                                    <option value="Out of Stock" >Out of Stock</option>
                                    <option value="Disable" >Disable</option>
                                </select>
                            </div>
                        </div>{{--3 row--}}
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label  class=" label label-default">Color</label>
                                <input name="color" type="text" class="form-control form-control-sm" value="{{ old('color') }}" >
                            </div>
                            <div class="col-sm-3">
                                <label  class=" label label-default">Capacity/Size</label>
                                <input name="size_capacity" type="text" class="form-control form-control-sm" value="{{ old('size_capacity') }}" >
                            </div>
                            <div class="col-sm-2">
                                <label  class=" label label-default">Model</label>
                                <input name="model" type="text" class="form-control form-control-sm" value="{{ old('model') }}" >
                            </div>
                            <div class="col-sm-2" style="display: none">
                                <label  class=" label label-default">Offer Price</label>
                                <input name="offer_price" type="number" class="form-control form-control-sm" value="{{ old('offer_price') }}" >
                            </div>
                            <div class="col-sm-2">
                                <label  class=" label label-default">Offer Limit</label>
                                <input name="offer_limit" type="number" class="form-control form-control-sm" value="{{ old('offer_limit') }}" >
                            </div>

                        </div>{{--4 row--}}
                        {{--<div class="form-group row">

                        </div>--}}{{--5 row--}}
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label  class=" label label-primary">Description</label>
                                <textarea  name="description" class="form-control basic-example" >{{ old('description') }}</textarea>
                            </div>
                            <div class="col-sm-6">
                                <label  class=" label label-default">Specification</label>
                                <textarea id="" name="specification" class="form-control basic-example" >{{ old('specification') }}</textarea>
                            </div>
                        </div>{{--6 row--}}
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success btn-lg center-block">+ Add Product</button>
                            </div>
                        </div>{{--7 row--}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
