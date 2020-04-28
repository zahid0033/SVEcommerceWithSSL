@extends('vendor.master')
@section('title','Search Orders')
@section('Order_management','active')
@section('all_order','active')
@section('content')
    <div class="container-fluid">
        <div class="row"  id="mainContents">
            <div class="col-md-12  mar-top" style="overflow: auto" >
                <div class="col-md-3 " >
                    <label for="recipient-name" class=" label label-success"> Select Report Range</label>
                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%"  >
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                    {{--<input type="text" id="daterange" name="daterange"  class="form-control form-control-sm" style="display: none"/>--}}
                    <input type="text"  name="type"   value ="processing" class="form-control form-control-sm" style="display: none"/>
                </div>
                <div class="col-sm-2">
                    <label  class=" label label-primary">Search For</label>
                    <select name="search" id="search_type" class="form-control">
{{--
                        <option value="temp" >Unconfirmed</option>
--}}
                        <option value="main" >Confirmed</option>
                        <option value="product" >Product</option>
                    </select>
                </div>
                <div class="col-sm-5">
                    <label  class=" label label-primary">Search</label>
{{--
                    <input name="search" type="text" id="search_temp" onKeyUp="getSearch('temp')" onmouseleave="getSearch('temp')" placeholder="Write here to search from unconfirmed orders" class="form-control form-control-sm " >
--}}
                    <input name="search" type="text" id="search_main" onKeyUp="getSearch('main')" onmouseleave="getSearch('main')" placeholder="Write here to search anything confirmed orders" class="form-control form-control-sm ">
                    <input name="search" type="text" id="search_product" onKeyUp="getSearch('product')" onmouseleave="getSearch('product')" placeholder="Enter product name to search anything confirmed orders" class="form-control form-control-sm " style="display: none">
                </div>
                <div class="col-sm-1 mar-top">
                    <b><span id="search_total_record" style="color: #0BBA8B"></span></b>
                </div>
                <div class="col-sm-1 mar-top">
                    <button  class="btn btn-warning " id="printme" onclick="printDiv('printMe')" title="Print"><i class="fas fa-print"></i>  </button>
                    <form method="post" enctype="multipart/form-data" action="{{ route('excel') }}">
                        @csrf
                    <input name="excel_id" type="text" id="excel_id"    style="display: none">
                    <input type="text" id="daterange" name="daterange"  class="form-control form-control-sm" style="display: none"/>
                    <button type="submit"  class="btn btn-info mar-top " id="excelButton" title="Excel"><i class="fas fa-file-excel"></i>  </button>
                    </form>
                </div>
                {{--<div class="col-sm-1 mar-top">
                    <a href="{{route('allOrders')}}" title="Did't Print| Reload" id="noprint" class="btn btn-danger " ><i class="fas fa-sync"></i> </a> <br>
                    <form method="post" enctype="multipart/form-data" action="{{ route('printCount') }}">
                        @csrf
                        <input name="print_count" type="text" id="print_count"    style="display: none">
                        <button type="submit"  class="btn btn-success mar-top " id="printed"  title="Printed" disabled><i class="fas fa-check-circle"></i>  </button>
                    </form>
                </div>--}}


            </div>
            <div class="col-md-12 text-center content-panel mar-top" style="overflow: auto"  id='printMe'>
                <table class="table  table-advance table-hover " id="tblData">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"class="text-center"><i class="fab fa-slack-hash"></i> Order Id</th>
                        <th scope="col" class="text-center"> <i class="fas fa-puzzle-piece"></i>Payment Type</th>
                        <th scope="col"class="text-center"><i class="fas fa-mobile-alt"></i> Delivery Contact</th>
                        <th scope="col"class="text-center"><i class="fas fa-map-marker-alt"></i></i> Shipping</th>
                        <th scope="col"class="text-center"><i class="fas fa-money-bill-wave"></i> Amount</th>
                        <th scope="col"class="text-center"><i class="fas fa-user-cog"></i></i> Customer</th>
                        <th scope="col"class="text-center"><i class="fas fa-phone-volume"></i></i> Customer Phone</th>
{{--
                        <th scope="col"class="text-center"><i class="fas fa-print"></i></i> Printed</th>
--}}
                        <th scope="col"class="text-center"><i class=" fa fa-edit"></i> Status</th>
                        <th scope="col"class="text-center"> </th>
                    </tr>
                    </thead>
                    <tbody id="search_table">
                    </tbody>
                </table>

            </div>
            <div class="col-md-12 text-center " style="overflow: auto"  >
               {{-- {!! $pending_orders->links()  !!}--}}
            </div>
        </div>
    </div>
@endsection

