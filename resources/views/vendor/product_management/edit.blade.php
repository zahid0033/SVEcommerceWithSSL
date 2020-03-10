@extends('vendor.master')
@section('title','Product Edit')
@section('Product_management','active')
@section('content')
    <div class="container-fluid">
                <form method="post" enctype="multipart/form-data" action="{{ route('productUpdate') }}">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group row">
                            <div class="col-sm-8 " style="min-height: 150px">
                                <label  class=" label label-default">Selected Image Preview</label>
                                <div id="preview"></div>
                            </div>
                            <div class="col-sm-4 form-style" style="min-height: 150px">
                                <label  class=" label label-default">Published Images</label>
                                <p >
                                    @foreach($imgarray as $s)
                                        <img src="{{ asset('assets/vendor/images/products/') }}/{{$s->image}}" class="imgss center-block inline-block"  alt="">
                                    @endforeach
                                </p>
                            </div>
                        </div>{{--1 row--}}
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label  class=" label label-primary">Name</label>
                                <input name="name" type="text" class="form-control form-control-sm" value="{{$product->name}}" required>
                            </div>
                            <div class="col-sm-3">
                                <label  class=" label label-primary">Category</label>
                                <select  title="Choose Category" name="category_id" class="form-control">
                                    @foreach($categories as $s)
                                        @if($s->parent_id === NULL)
                                            <optgroup label="{{$s->name}}">
                                                @foreach($categories as $s2)
                                                    @if($s2->parent_id == $s->id)
                                                        @if($product->category_id == $s2->id)
                                                            <option value="{{$s2->id}}" selected>{{$s2->name}}</option>
                                                        @else
                                                            <option value="{{$s2->id}}" >{{$s2->name}}</option>
                                                        @endif
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
                                        @if($product->vendor_id === $s2->id)
                                            <option value="{{$s->id}}" selected >{{$s->name}}</option>
                                        @else
                                            <option value="{{$s->id}}" >{{$s->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>{{--2 row--}}
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label  class=" label label-primary">Price</label>
                                <div class="input-group">
                                    <input name="price" id="pprice" type="number" class="form-control form-control-sm" value="{{$product->price}}" required>
                                    <span class="input-group-addon "> <b>৳</b></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label  class=" label label-default">Image</label>
                                <input type='file' id="image-preview" name="image[]" class="form-control" accept=".png, .jpg, .jpeg" multiple title="Choose Image"  >
                            </div>
                            <div class="col-sm-3">
                                <label  class=" label label-default">Stock</label>
                                <input name="stock" type="number" class="form-control form-control-sm" value="{{$product->stock}}" >
                            </div>
                            <div class="col-sm-3">
                                <label  class=" label label-primary">Status</label>
                                <select name="status" class="form-control" title="Select Status">
                                    @if($product->status === 'Available')
                                        <option value="Available" selected >Available</option>
                                        <option value="Out of Stock"  >Out of Stock</option>
                                        <option value="Disable"  >Disable</option>
                                    @elseif($product->status === 'Out of Stock')
                                        <option value="Available"  >Available</option>
                                        <option value="Out of Stock"  selected>Out of Stock</option>
                                        <option value="Disable"  >Disable</option>
                                    @else
                                        <option value="Available"  >Available</option>
                                        <option value="Out of Stock"  >Out of Stock</option>
                                        <option value="Disable" selected >Distable</option>
                                    @endif
                                </select>
                            </div>
                            {{--<div class="col-sm-3">
                                <label  class=" label label-default">Offer Percentage</label>
                                <div class="input-group">
                                    <input name="offer_percentage" id="poffer_percentage" type="number" class="form-control form-control-sm" value="{{$product->offer_percentage}}" onkeyup="percentage_cal()" >
                                    <span class="input-group-addon "> <b>%</b></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label  class=" label label-default">Offer Price</label>
                                <div class="input-group">
                                    <input name="offer_price" id="poffer_price" type="number" class="form-control form-control-sm" value="{{$product->offer_price}}" >
                                    <span class="input-group-addon "> <b>৳</b></span>
                                </div>
                            </div>--}}

                        </div>{{--3 row--}}
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label  class=" label label-default">Color</label>
                                <input name="color" type="text" class="form-control form-control-sm" value="{{$product->color}}" >
                            </div>
                            <div class="col-sm-3">
                                <label  class=" label label-default">Capacity/Size</label>
                                <input name="size_capacity" type="text" class="form-control form-control-sm" value="{{$product->size_capacity}}" >
                            </div>
                            <div class="col-sm-2">
                                <label  class=" label label-default">Model</label>
                                <input name="model" type="text" class="form-control form-control-sm" value="{{$product->model}}" >
                            </div>
                            <div class="col-sm-2">
                                <label  class=" label label-default">Offer Price</label>
                                <input name="offer_price" type="number" class="form-control form-control-sm" value="{{$product->offer_price}}" readonly >
                            </div>
                            <div class="col-sm-2">
                                <label  class=" label label-default">Offer Limit</label>
                                <input name="offer_limit" type="number" class="form-control form-control-sm" value="{{$product->offer_limit}}" >
                            </div>

                        </div>{{--4 row--}}
                        {{--<div class="form-group row">

                        </div>--}}{{--5 row--}}
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label  class=" label label-primary">Description</label>
                                <textarea  name="description" class="form-control basic-example" >{{ $product->description }}</textarea>
                            </div>
                            <div class="col-sm-6">
                                <label  class=" label label-default">Specification</label>
                                <textarea id="" name="specification" class="form-control basic-example" >{{ $product->specification }}</textarea>
                            </div>
                        </div>{{--6 row--}}
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input name="id" type="text" value="{{$product->id}}" class="form-control form-control-sm" style="display: none">
                                <button type="submit" class="btn btn-success  center-block"><i class="far fa-edit"></i>  Update</button>
                            </div>
                        </div>{{--7 row--}}
                    </div>
                </form>
    </div>
@endsection
