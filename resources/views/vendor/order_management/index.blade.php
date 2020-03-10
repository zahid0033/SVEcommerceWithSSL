@extends('vendor.master')
@section('title','Search Orders')
@section('Order_management','active')
@section('all_order','active')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12  mar-top" style="overflow: auto">
                <div class="col-sm-2">
                    <label  class=" label label-primary">Search For</label>
                    <select name="search" id="search_type" class="form-control">
                        <option value="temp" >Unconfirmed</option>
                        <option value="main" >Confirmed</option>
                        <option value="product" >Product</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label  class=" label label-primary">Search</label>
                    <input name="search" type="text" id="search_temp" onKeyUp="getSearch('temp')" placeholder="Write here to search from unconfirmed orders" class="form-control form-control-sm " >
                    <input name="search" type="text" id="search_main" onKeyUp="getSearch('main')" placeholder="Write here to search anything confirmed orders" class="form-control form-control-sm " style="display: none">
                    <input name="search" type="text" id="search_product" onKeyUp="getSearch('product')" placeholder="Enter product name to search anything confirmed orders" class="form-control form-control-sm " style="display: none">
                </div>
                <div class="col-sm-2 mar-top">
                    <b><span id="search_total_record" style="color: #0BBA8B"></span></b>
                </div>
                <div class="col-sm-2 mar-top">
                    <button  class="btn btn-success  center-block" onclick="printDiv('printMe')" title="print"><i class="fas fa-print"></i>  </button>
                </div>

            </div>
            <div class="col-md-12 text-center content-panel mar-top" style="overflow: auto"  id='printMe'>
                <table class="table  table-advance table-hover ">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"class="text-center"><i class="fab fa-slack-hash"></i> Order Id</th>
                        <th scope="col" class="text-center"> <i class="fas fa-puzzle-piece"></i> Trx Id</th>
                        <th scope="col"class="text-center"><i class="fas fa-mobile-alt"></i> Bkash No</th>
                        <th scope="col"class="text-center"><i class="fas fa-money-bill-wave"></i> Amount</th>
                        <th scope="col"class="text-center"><i class="fas fa-user-cog"></i></i> Customer</th>
                        <th scope="col"class="text-center"><i class="fas fa-phone-volume"></i></i> Customer Phone</th>
                        <th scope="col"class="text-center"><i class="fas fa-map-marker-alt"></i></i> Shipping</th>
                        <th scope="col"class="text-center"><i class=" fa fa-edit"></i> Status</th>
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
