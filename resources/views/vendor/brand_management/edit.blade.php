@extends('vendor.master')
@section('title','Brand Edit')
@section('Brand_management','active')
@section('content')
    <div class="container-fluid">
            <div id="Create" class="tab-pane fade in">
                <form method="post" enctype="multipart/form-data" action="{{ route('brandUpdate') }}">
                    @csrf
                    <div class="modal-body">
                                    <div class="form-group row">
                                        <img src="{{ asset('assets/vendor/images/brands/') }}/{{$brand->image}}" class="imgs center-block" alt="" id="image-preview">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="recipient-name" class=" label label-primary">Name</label>
                                            <input name="name" type="text" value="{{$brand->name}}" class="form-control form-control-sm" required>
                                            <input name="id" type="text" value="{{$brand->id}}" class="form-control form-control-sm" style="display: none" >
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="recipient-name" class=" label label-primary">Image</label>
                                            <input name="image" type="file" class="form-control" onchange="previewImage(event)" >
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="recipient-name" class=" label label-primary">Status</label>
                                            <select name="status" class="form-control" disabled>
                                                @if($brand->status === 'Active')
                                                    <option value="Active" selected >Active</option>
                                                    <option value="Deactive" >Deactive</option>
                                                @else
                                                    <option value="Active"  >Active</option>
                                                    <option value="Deactive" selected>Deactive</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="recipient-name" class=" label label-primary">Address</label>
                                <input name="address" type="text" value="{{$brand->address}}" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="recipient-name" class=" label label-primary">Email</label>
                                <input name="email" type="text" value="{{$brand->email}}" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-sm-2">
                                <label for="recipient-name" class=" label label-primary">Phone</label>
                                <input name="phone" type="text" value="{{$brand->phone}}" class="form-control form-control-sm" required>
                                </select>
                            </div>
                        </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="message-text" class=" label label-primary">Description</label>
                                            <textarea  name="description" class="form-control basic-example" >{{$brand->description}}</textarea>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success  center-block"><i class="far fa-edit"></i>  Update</button>
                                        </div>
                                    </div>
                    </div>
                </form>

            </div>

    </div>
@endsection
