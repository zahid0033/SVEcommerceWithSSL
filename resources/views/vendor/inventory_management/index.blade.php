@extends('vendor.master')
@section('title','Inventtory Management')
@section('Inventory_management','active')
@section('content')
    <div class="container-fluid">
       <div id="Offers" class="tab-pane fade in active">
                <div class="row">
                    <div class="btn-group col-md-12 mar-top">
                        @foreach($sub_categories as $s)
                            <button type="button" class="btn btn-round btn-info">{{$s->name}}</button>
                        @endforeach
                        <div class="btn-group">
                            <button type="button" class="btn btn-round btn-default dropdown-toggle" data-toggle="dropdown">
                                Dropdown
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Dropdown link</a></li>
                                <li><a href="#">Dropdown link</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12 text-center content-panel mar-top" style="overflow: auto">
                        <table class="table  table-advance table-hover ">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col"class="text-center">
                                </th>
                                <th scope="col" class="text-center"> <i class="fa fa-bullhorn"></i> Name</th>
                                <th scope="col"class="text-center"><i class="fas fa-tags"></i> Category</th>
                                <th scope="col"class="text-center"><i class="fas fa-store"></i> Stock</th>
                                <th scope="col"class="text-center"><i class="fas fa-money-bill-wave"></i> Price</th>
                                <th scope="col"class="text-center"><i class="fa fa-question-circle"></i> Offer</th>
                                <th scope="col"class="text-center"><i class=" fa fa-edit"> Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $s)
                                <tr >
                                    <td class="text-center">
                                        @if(empty($s->image))
                                            <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}" width="60px" alt="">
                                        @else
                                            @php
                                                $imgarray = json_decode($s->image);
                                            @endphp
                                            <img src="{{ asset('assets/vendor/images/products/') }}/{{$imgarray[0]->image}}" width="60px" alt="">
                                        @endif
                                    </td>
                                    <td class="text-center"><b>{{$s->name}}</b></td>

                                    <td class="text-center"><b>{{$s->categories->name}}</b></td>
                                    <td class="text-center"><b>{{$s->stock}}</b></td>
                                    <td class="text-center"><b>৳  @if(!empty($s->offer_price)) <del style="color: red">{{ number_format($s->price) }} </del>{{ number_format($s->offer_price) }} @else {{ number_format($s->price) }} @endif</b></td>
                                    <td class="text-center">@if(!empty($s->offer_id))<span class="label label-info label-mini">{{$s->offers->type}}</span>@else -- --  @endif</td>
                                    <td class="text-center">@if($s->status === 'Out of Stock')<span class="label label-danger label-mini">{{$s->status}}</span>@elseif($s->status === 'Available')<span class="label label-success label-mini">{{$s->status}}</span>@else<span class="label label-default label-mini">{{$s->status}}</span> @endif</td>
                                    <td>
                                        <a href="{{route('productManagementEdit',Crypt::encrypt($s->id))}}" class="btn btn-primary btn-xs"><i class="fas fa-arrow-circle-right"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $products->links()  !!}
                    </div>
                </div>
            </div>

    </div>
@endsection
