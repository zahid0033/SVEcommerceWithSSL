@extends('vendor.master')
@section('title','DashBoard')
@section('DashBoard','active')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12  ">

                <div class="col-sm-6 content-panel mar-top">
                    <h2 class="text-center"> <b>Order Status</b></h2>

                    <div class="col-sm-2 ">
                        <input id="doughnut_due"  type="number" value="{{$temp_due}}" style="display: none" >
                        <input id="doughnut_cancel"  type="number" value="{{$temp_cancel}}" style="display: none" >
                        <input id="doughnut_pending"  type="number" value="{{$temp_pending}}" style="display: none" >
                        <input id="doughnut_processing"  type="number" value="{{$order_processing}}" style="display: none" >
                        <input id="doughnut_shipping"  type="number" value="{{$order_shipping}}" style="display: none" >
                        <input id="doughnut_delivered"  type="number" value="{{$order_delivered}}" style="display: none" >
                        {{----}}
                        <span class="label label-danger label-mini" > Due :<b >{{$temp_due}}</b></span> <br><br>
                        <span class="label label-default label-mini">Canceled :{{$temp_cancel}}</span> <br><br>
                        <span class="label label-warning label-mini">Pending: {{$temp_pending}}</span> <br><br>
                        <span class="label label-info label-mini">Processing: {{$order_processing}}</span> <br><br>
                        <span class="label label-primary label-mini">Shipping: {{$order_shipping}}</span> <br><br>
                        <span class="label label-success label-mini">Delivered: {{$order_delivered}}</span> <br><br>
                    </div>
                    <div class="col-sm-10 ">
                        <div class=" text-right">
                            <canvas id="doughnut" height="375" width="500" ></canvas>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

