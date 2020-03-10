@extends('vendor.master')
@section('title','Offer Edit')
@section('Offer_management','active')
@section('content')
    <div class="container-fluid">
                <form method="post" enctype="multipart/form-data" action="{{ route('offerUpdate') }}">
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
                                    <img src="{{ asset('assets/vendor/images/offers/') }}/{{$offer->image}}" class="imgss center-block inline-block"  alt="">
                                </p>
                            </div>
                        </div>{{--1 row--}}
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <label  class=" label label-primary">Title</label>
                                <input name="title" type="text" class="form-control form-control-sm" value="{{ $offer->title }}" required  >
                            </div>
                            <div class="col-sm-4">
                                <label  class=" label label-default">Image</label>
                                <input type='file' id="image-preview" name="image" class="form-control" accept=".png, .jpg, .jpeg, .gif"  title="Choose Image"   >
                            </div>
                        </div>{{--2 row--}}
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label  class=" label label-primary">Type</label>
                                <select name="type" id="offer_type" class="form-control" title="Select offer type" disabled>
                                    @if($offer->type === 'Buy one get one')
                                        <option value="Buy one get one"  selected>Buy one get one</option>
                                        <option value="Discount" >Discount</option>
                                    @else
                                        <option value="Buy one get one"  >Buy one get one</option>
                                        <option value="Discount" selected >Discount</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label  class=" label label-primary">Status</label>
                                <select name="status" class="form-control" title="Select status">
                                    @if($offer->status === 'Active')
                                        <option value="Active" selected>Active</option>
                                        <option value="Deactive" >Deactive</option>
                                    @else
                                        <option value="Active" >Active</option>
                                        <option value="Deactive" selected>Deactive</option>
                                    @endif
                                </select>
                            </div>
                            {{--<div class="col-sm-3">
                                <label  class=" label label-default">EndDate</label>
                                <input name="enddate" type="date" class="form-control form-control-sm" value="{{ old('enddate') }}" >
                            </div>--}}
                            <div class="col-sm-3" id="offer_percentage_type" @if($offer->type === 'Buy one get one') style="display:none;" @endif>
                                <label  class=" label label-primary">Offer Percentage</label>
                                <div class="input-group">
                                    <input name="offer_percentage" id="offer_percentage"   type="number" class="form-control form-control-sm" value="{{ $offer->offer_percentage }}"  >
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
                                    </tr>
                                    </thead>
                                    <tbody>
                                      @php
                                          $product_ids = json_decode($offer->product_ids);
                                      @endphp
                                    @foreach($products as $s)
                                        <tr>
                                            <td class="text-center">
                                              @if (!empty($s->offer_id) and $s->offer_id != $offer->id) {{--  @if (empty($s->offer_id) AND $s->offer_id === $offer->id)  --}}
                                                @php
                                                  $other_offer_pids = json_decode($s->offers->product_ids)
                                                @endphp
                                                @foreach ($other_offer_pids as $pid)
                                                  @if ($s->id === (int)$pid->id)<i class="fas fa-ban" title="This Product already has an offer" style="color: red"></i>
                                                    {{-- <input class="form-check-input form-inline"  type='checkbox' name='product_ids[]' id="inlineCheckbox1" value="{{$s->id}}" disabled title="This Product already has an offer" style="border-color: #a77e2d;" > --}}
                                                  @endif
                                                @endforeach
                                              @elseif (!empty($s->offer_id) and $s->offer_id === $offer->id)
                                                  @php
                                                    $offer_pids = json_decode($s->offers->product_ids)
                                                  @endphp
                                                  @foreach ($offer_pids as $pid)
                                                    @if ($s->id === (int)$pid->id)
                                                      <input class="form-check-input form-inline"  type='checkbox' name='product_ids[]' id="inlineCheckbox1" value="{{$s->id}}" checked  >
                                                    @endif
                                                  @endforeach
                                              @else

                                                    @php
                                                      $offer_pids = json_decode($offer->product_ids)
                                                    @endphp
                                                    @foreach ($offer_pids as $value)
                                                      @php
                                                        $opids[] = (int)$value->id;
                                                      @endphp
                                                    @endforeach

                                                    {{-- @foreach ($offer_pids as $pid) --}}
                                                      @if (in_array($s->id,$opids))
                                                        <input class="form-check-input form-inline"  type='checkbox' name='product_ids[]' id="inlineCheckbox1" value="{{$s->id}}" checked  >
                                                      @else
                                                        <input class="form-check-input form-inline"  type='checkbox' name='product_ids[]' id="inlineCheckbox1" value="{{$s->id}}"   >
                                                      @endif
                                                    {{-- @endforeach --}}
                                              @endif
                                                @if(empty($s->image))
                                                    <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}"  width="50px" {{--class="imgs"--}} alt="">
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
                                            <td class="text-center" width="110px">৳  @if(!empty($s->offer_price)) <del>{{ number_format($s->price) }} </del>{{ number_format($s->offer_price) }} @else {{ number_format($s->price) }} @endif</td>
                                            <td class="text-center">@if($s->status === 'Out of Stock')<b style="color:red">{{$s->status}}</b>@else{{$s->status}}@endif</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-6 " id="free_product_type" @if($offer->type === 'Discount') style="display:none;" @endif ><hr style="border-top: 8px solid #89C0E0; background: transparent;">
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
                                    @foreach($products as $s)
                                        <tr>
                                            <td class="text-center">
                                                @if($offer->type === 'Buy one get one')
                                                    @php
                                                        $free_product_ids = json_decode($offer->free_product_ids);
                                                    @endphp
                                                    @foreach ($free_product_ids as $pid)
                                                        @if($s->id === (int)$pid->id)
                                                            <input class="form-check-input form-inline"  type='radio' name='free_product_ids[]' id="inlineCheckbox1" value="{{$s->id}}" checked>
                                                        @else
                                                          <input class="form-check-input form-inline"  type='radio' name='free_product_ids[]' id="inlineCheckbox1" value="{{$s->id}}" >
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <input class="form-check-input form-inline"  type='radio' name='free_product_ids[]' id="inlineCheckbox1" value="{{$s->id}}">
                                                @endif
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
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>{{--4 row--}}
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input name="id" type="text" value="{{$offer->id}}" class="form-control form-control-sm" style="display: none">
                                <button type="submit" class="btn btn-success  center-block"><i class="far fa-edit"></i>  Update</button>
                            </div>
                        </div>{{--5 row--}}
                    </div>
                </form>
    </div>
@endsection
