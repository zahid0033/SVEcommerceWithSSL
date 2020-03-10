@extends('vendor.master')
@section('title','Brand Management')
@section('Brand_management','active')
@section('content')
    <div class="container-fluid">
         <ul class="nav nav-tabs">
            <li class="active " ><a data-toggle="tab" href="#Brands">Brands</a></li>
            <li class="" ><a data-toggle="tab" href="#Create">Create</a></li>
        </ul>
        <div class="tab-content">
            <div id="Brands" class="tab-pane fade in active">

                <div class="row">
                    <div class="col-md-12 text-center " style="overflow: auto">
                        <p class="small-heading">My Brands </p>
                        @if($brands->count() !== 0 )
                        @foreach ($brands as $s)
                            <div class="col-md-4 news mb-2 mar-bott">
                                <div class="head img_hover">
                                    @if(empty($s->image))
                                    <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}" width="80%" alt="">
                                    @else
                                    <img src="{{ asset('assets/vendor/images/brands/') }}/{{$s->image}}" width="60%" alt="">
                                    @endif

                                    <div class="overlay">
                                        <a class="btn btn-default btn-xs" href="{{route('brandRemove',Crypt::encrypt($s->id))}}"  title="Remove" onclick="return confirm('Delete this?')"><i class="fa fa-trash"></i></a>
                                        <a class="btn btn-success"  href="{{route('brandManagementEdit',Crypt::encrypt($s->id))}}" title="Edit"><i class="fa fa-edit"></i></a>
                                        <sub><mark>{{$s->status}}</mark></sub>
                                    </div>
                                </div>
                                <div class=" text-center ">
                                    <h3><b>{{$s->name}}</b></h3>
                                    <h5><b>{!! $s->description !!}</b></h5>
                                </div>
                            </div>
                        @endforeach
                        {!! $brands->Links() !!}
                        @else
                            <h3 >Nothing to show</h3>
                        @endif

                    </div>

                </div>
            </div>
            <div id="Create" class="tab-pane fade in ">
                @if($brands->count() === 0 )
                <form method="post" enctype="multipart/form-data" action="{{ route('brandAdd') }}">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group row">
                            <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}" class="imgs center-block" alt="" id="image-preview">
                        </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="recipient-name" class=" label label-primary">Name</label>
                                            <input name="name" type="text" class="form-control form-control-sm" value="{{ old('name') }}" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="recipient-name" class=" label label-primary">Image</label>
                                            <input name="image" type="file" class="form-control" onchange="previewImage(event)" onclick="gritter_custom('image upload','Select good resolution images','The image you are going to select should be greater than 700X700 pixels for better quality ')">
                                        </div>
                                        <div class="col-sm-2" >
                                            <label for="recipient-name" class=" label label-primary">Status</label>
                                            <select name="status" class="form-control" disabled title="Restricted">
                                                <option value="Active" >Active</option>
                                                <option value="Deactive"  ><>Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="recipient-name" class=" label label-primary">Address</label>
                                <input name="address" type="text" class="form-control form-control-sm" value="{{ old('address') }}" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="recipient-name" class=" label label-primary">Email</label>
                                <input name="email" type="text" class="form-control form-control-sm" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="recipient-name" class=" label label-primary">Phone</label>
                                <input name="phone" type="text" class="form-control form-control-sm" value="{{ old('phone') }}" required>
                            </div>
                        </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="message-text" class=" label label-primary">Description</label>
                                            <textarea  name="description" class="form-control basic-example" >{{ old('description') }}</textarea>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success  center-block">+ Add Brand</button>
                                        </div>
                                    </div>
                    </div>
                </form>
                @else
                    <h3 class="text-center">You Can't Owe more than one brand now</h3>
                @endif
            </div>
        </div>
    </div>
@endsection
