@extends('vendor.master')
@section('title','Offer Management')
@section('Offer_management','active')
@section('content')
    <div class="container-fluid">
         <ul class="nav nav-tabs">
            <li class="active " ><a data-toggle="tab" href="#Offers">Offers</a></li>
            <li class="" ><a  data-toggle="tab" href="#Create"  >Create</a> </li>

        </ul>
        <div class="tab-content">
            <div id="Offers" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-md-12 text-center " style="overflow: auto">
                        <p class="small-heading">Current Offers </p>
                        @if($offers->count() !== 0 )
                        @foreach ($offers as $s)
                            <div class="col-md-3 news mb-2 mar-bott">
                                <div class="head img_hover">
                                    @if(empty($s->image))
                                    <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}" class="img" alt="">
                                    @else
                                        <img src="{{ asset('assets/vendor/images/offers/') }}/{{$s->image}}" class="img" alt="">
                                    @endif

                                    <div class="overlay">
                                      @if ($s->status !== 'Active')
                                        <a class="btn btn-danger btn-xs" href="{{route('offerRemove',Crypt::encrypt($s->id))}}"  title="Remove" onclick="return confirm('Delete this?')"><i class="fa fa-trash"></i></a>
                                      @else
                                        <a class="btn btn-default btn-xs"  title="You can't delete an active offer" ><i class="fa fa-trash"></i></a>
                                      @endif
                                        <a class="btn btn-success"  href="{{route('offerManagementEdit',Crypt::encrypt($s->id))}}" title="Edit"><i class="fa fa-edit"></i></a>
                                        <sub><mark>{{$s->status}}</mark></sub><br>
                                        {{--<sub><b><mark style="background-color: black;color: white;">{{$s->enddate}}</mark></b></sub>--}}

                                    </div>
                                </div>
                                <div class=" text-center ">
                                    <h4><b>{{$s->title}}</b></h4>
                                    <h5><b>  {{ $s->type }}</b></h5>
                                </div>
                            </div>
                        @endforeach
                        {!! $offers->Links() !!}
                        @else
                            <h3 >Nothing to show</h3>
                        @endif

                    </div>

                </div>
            </div>
            <div id="Create" class="tab-pane fade in " >
                <form method="post" enctype="multipart/form-data" action="{{ route('offerAdd') }}">
                    @csrf
                    <div class="modal-body " >
                        <div class="form-group row">
                                <div class="col-sm-12 " style="min-height: 150px">
                                    <label  class=" label label-default">Image Preview</label>
                                    <div id="preview"></div>
                                </div>
                        </div>{{--1 row--}}
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <label  class=" label label-primary">Title</label>
                                <input name="title" type="text" class="form-control form-control-sm" value="{{ old('title') }}" required >
                            </div>
                            <div class="col-sm-4">
                                <label  class=" label label-default">Image</label>
                                <input type='file' id="image-preview" name="image" class="form-control" accept=".png, .jpg, .jpeg, .gif"  title="Choose Image" onclick="gritter_custom('image upload','Select good resolution images','The image you are going to select should be greater than 700X700 pixels for better quality ')"  >
                            </div>
                        </div>{{--2 row--}}
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label  class=" label label-primary">Type</label>
                                <select name="type" id="offer_type" class="form-control" title="Select offer type">
                                    <option value="Buy one get one" >Buy one get one</option>
                                    <option value="Discount" >Discount</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label  class=" label label-primary">Status</label>
                                <select name="status" class="form-control" title="Select status">
                                    <option value="Active" >Active</option>
                                    <option value="Deactive" >Deactive</option>
                                </select>
                            </div>
                            {{--<div class="col-sm-3">
                                <label  class=" label label-default">EndDate</label>
                                <input name="enddate" type="date" class="form-control form-control-sm" value="{{ old('enddate') }}" >
                            </div>--}}
                            <div class="col-sm-3" id="offer_percentage_type" style="display:none;">
                                <label  class=" label label-primary">Offer Percentage</label>
                                <div class="input-group">
                                    <input name="offer_percentage" id="offer_percentage"   type="number" class="form-control form-control-sm" value="{{ old('offer_percentage') }}"  >
                                    <span class="input-group-addon "> <b>%</b></span>
                                </div>
                            </div>

                        </div>{{--3 row--}}
                        <div class="form-group row">
                            <div class="col-sm-6 "><hr style="border-top: 8px solid #ccc; background: transparent;">

                                <table class="table table-striped table-borderless ">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col"class="text-center">
                                            <label  class=" label label-primary">Products</label>
                                            <select  title="Choose Category" name="category_id"  >
                                                @foreach($categories as $s)
                                                    @if($s->parent_id === NULL)
                                                        <optgroup label="{{$s->name}}">
                                                            @foreach($categories as $s2)
                                                                @if($s2->parent_id === $s->id)
                                                                    <option value="{{$s2->id}}">{{$s2->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </optgroup>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </th>
                                        <th scope="col" class="text-center">Name</th>
                                        <th scope="col"class="text-center">Category</th>
                                        <th scope="col"class="text-center">Stock</th>
                                        <th scope="col"class="text-center">Price</th>
                                        <th scope="col"class="text-center">Status</th>
                                        {{--<th scope="col"class="text-center">Limit</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $s)
                                        <tr>
                                            <td class="text-center">
                                                <input class="form-check-input form-inline"  type='checkbox' name='product_ids[]' id="inlineCheckbox1" value="{{$s->id}}">
                                                @if(empty($s->image))
                                                    <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}" width="50px" {{--class="imgs"--}} alt="">
                                                @else
                                                    @php
                                                        $imgarray = json_decode($s->image);
                                                    @endphp
                                                    <img src="{{ asset('assets/vendor/images/products/') }}/{{$imgarray[0]->image}}" width="50px" {{--class="imgs"--}} alt="">
                                                @endif
                                            </td>
                                            <td class="text-center">{{$s->name}}</td>

                                            <td class="text-center">{{$s->categories->name}}</td>
                                            <td class="text-center">{{$s->stock}}</td>
                                            <td class="text-center">৳ {{ number_format($s->price) }}</td>
                                            <td class="text-center">@if($s->status === 'Out of Stock')<b style="color:red">{{$s->status}}</b>@else{{$s->status}}@endif</td>
                                            {{--<td class="text-center" width="100px"><input name="limit[]" type="number" class="form-control form-control-sm" value="{{ old('limit') }}"  >--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-6 " id="free_product_type"><hr style="border-top: 8px solid #89C0E0; background: transparent;">
                                <table class="table table-striped table-dark table-borderless">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col"class="text-center">
                                            <label  class=" label label-primary"><i class="fas fa-gift"></i></label>
                                            <select  title="Choose Category" name="category_id" >
                                                @foreach($categories as $s)
                                                    @if($s->parent_id === NULL)
                                                        <optgroup label="{{$s->name}}">
                                                            @foreach($categories as $s2)
                                                                @if($s2->parent_id === $s->id)
                                                                    <option value="{{$s2->id}}">{{$s2->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </optgroup>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </th>
                                        <th scope="col" class="text-center">Name</th>
                                        <th scope="col"class="text-center">Category</th>
                                        <th scope="col"class="text-center">Stock</th>
                                        <th scope="col"class="text-center">Price</th>
                                        <th scope="col"class="text-center">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($allProducts as $s)
                                        <tr>
                                            <td class="text-center">
                                                <input class="form-check-input form-inline"  type='radio' name='free_product_ids[]' id="inlineCheckbox1" value="{{$s->id}}">
                                                @if(empty($s->image))
                                                    <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}" width="50px" {{--class="imgs"--}} alt="">
                                                @else
                                                    @php
                                                        $imgarray = json_decode($s->image);
                                                    @endphp
                                                    <img src="{{ asset('assets/vendor/images/products/') }}/{{$imgarray[0]->image}}" width="50px" {{--class="imgs"--}} alt="">
                                                @endif
                                            </td>
                                            <td class="text-center">{{$s->name}}</td>

                                            <td class="text-center">{{$s->categories->name}}</td>
                                            <td class="text-center">{{$s->stock}}</td>
                                            <td class="text-center">{{ number_format($s->price) }}</td>
                                            <td class="text-center">@if($s->status === 'Out of Stock')<b style="color:red">{{$s->status}}</b>@else{{$s->status}}@endif</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>{{--4 row--}}
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success btn-lg center-block">Create Offer</button>
                            </div>
                        </div>{{--5 row--}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
