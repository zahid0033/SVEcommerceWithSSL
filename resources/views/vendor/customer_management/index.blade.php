@extends('vendor.master')
@section('title','Customers')
@section('customer_management','active')
@section('content')
    <div class="container-fluid">
        <div class="row mar-top">
            <div class="col-md-8">
                <label  class=" label label-primary">Search</label>
                <input name="search" type="text" id="search_customer"  onKeyUp="getSearchCustomer()" placeholder="Write here to search customer" class="form-control form-control-sm " >
            </div>
            <div class="col-md-4">
                <b><span id="search_customer_total_record" style="color: #0BBA8B"></span></b>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12 text-center content-panel mar-top" style="overflow: auto">
                    <table class="table  table-advance table-hover ">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col"class="text-center"> Image</th>
                            <th scope="col" class="text-center">  Name</th>
                            <th scope="col"class="text-center"> Email</th>
                            <th scope="col"class="text-center"> Phone</th>
                            <th scope="col"class="text-center"> Gender</th>
                            <th scope="col"class="text-center"> Address</th>
                            <th scope="col"class="text-center"> </th>
                        </tr>
                        </thead>
                        <tbody id="search_customer_table">
                        @foreach($customerList as $s)
                            <tr >
                                <td class="text-center" width="20%" >
                                    @if(empty($s->image))
                                        <img class="img-circle" src="{{ asset('assets/vendor/images/profile_picture/empty.jpg') }}"width="20%" alt="" title="Unavailable">
                                    @else
                                        <img class="img-circle" src="{{ asset('assets/vendor/images/profile_picture/') }}/{{$s->image}}" width="20%" alt="" >
                                    @endif
                                </td>
                                <td class="text-center"><b>{{$s->name}}</b></td>
                                <td class="text-center"><b>{{$s->email}}</b></td>
                                <td class="text-center"><b>{{$s->phone}}</b></td>
                                <td class="text-center"><b>{{$s->gender}}</b></td>
                                <td class="text-center"><b>{{$s->address}} <mark>{{$s->city}}</mark></b></td>
                                <td>
                                    <a href="{{route('customer_details',Crypt::encrypt($s->id))}}" title="See Details" class="btn btn-primary "><i class="fas fa-arrow-circle-right"></i> </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
@endsection
