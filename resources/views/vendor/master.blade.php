<!DOCTYPE html>
<html lang="en">
@include('vendor.includes.header_link')
<body>

<section id="container" >
    <!-- **********************************************************************************************************************************************************
    TOP BAR CONTENT & NOTIFICATIONS
    *********************************************************************************************************************************************************** -->
    <!--header start-->
@include('vendor.includes.header')
<!--header end-->

    <!-- **********************************************************************************************************************************************************
    MAIN SIDEBAR MENU
    *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
{{--@if(Auth::user()->role === 'Admin')
    @include('vendor.includes.admin_sidebar')
@endif
@if(Auth::user()->role === 'vendor')--}}
    @include('vendor.includes.vendor_sidebar')
{{--@endif--}}

<!--sidebar end-->

    <!-- **********************************************************************************************************************************************************
    MAIN CONTENT
    *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="col-md-12 text-center  ">
                <!-- validation -->
                @if(count($errors) > 0)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p align="center" ><marquee direction="up" behavior = "slide" width="350px"><strong >
                                @foreach($errors->all() as $err)
                                    ⚠️{{$err}} <br>
                                    @endforeach</strong></marquee></p>
                    </div>
                @endif
            <!-- /validation -->
                <!-- message -->
                @if(session('msg'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p align="center" ><marquee direction="up" behavior = "slide" height="20px" width="350px"><strong >{{session('msg')}}!</strong></marquee></p>
                    </div>
            @endif
            <!-- /message -->
                {{--modal category add--}}
                <form method="post" enctype="multipart/form-data" action="{{ route('categoryAdd') }}">
                    @csrf
                    <div class="modal fade" id="modal_category_add"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><b>+ Add Category</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Name</label>
                                        <input name="name" type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Description</label>
                                        <textarea name="description" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Image</label>
                                        <input name="image" type="file" class="form-control" >
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="Active" >Active</option>
                                            <option value="Deactive" >Deactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Parent ID</label>
                                        <input name="parent_id" id="categoryAdd_parentId" type="text" class="form-control" readonly >
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">ADD +</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                {{--modal category add #--}}
                {{--modal category update--}}{{--
                <form method="post" enctype="multipart/form-data" action="{{ route('categoryUpdate') }}">
                    @csrf
                    <div class="modal fade" id="modal_category_update"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><b>Update </b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Id</label>
                                        <input id="cat_update_id" name="id" type="text" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Name</label>
                                        <input id="cat_update_name" name="name" type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Description</label>
                                        <textarea id="cat_update_des" name="description" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Image</label>
                                        <input id="cat_update_img" name="image" type="file" class="form-control" >
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Status</label>
                                        <select name="status" class="form-control">
                                            <option selected value="Active" >Active</option>
                                            <option value="Deactive" >Deactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Update </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                --}}{{--modal category update #--}}
                {{--modal category update--}}
                <form method="post" enctype="multipart/form-data" action="{{ route('categoryUpdate') }}">
                    @csrf
                    <div class="modal fade" id="modal_category_update"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><b>Update </b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Id</label>
                                        <input id="cat_update_id" name="id" type="text" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Name</label>
                                        <input id="cat_update_name" name="name" type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Description</label>
                                        <textarea id="cat_update_des" name="description" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Image</label>
                                        <input id="cat_update_img" name="image" type="file" class="form-control" >
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Status</label>
                                        <select name="status" class="form-control">
                                            <option selected value="Active" >Active</option>
                                            <option value="Deactive" >Deactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Update </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                {{--modal category update #--}}
                {{--modal order cancel reason--}}
                <form method="post" enctype="multipart/form-data" action="{{ route('orderCancel') }}">
                    @csrf
                    <div class="modal fade" id="modal_order_cancel_reason"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><b>Order Cancel </b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Id</label>
                                        <input id="order_cancel_id" name="id" type="number" class="form-control" readonly style="display:none;">
                                        <input id="order_cancel_order_id" name="order_id" type="text" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Cancel By</label>
                                        <input  name="name" type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-form-label">Reason</label>
                                        <textarea  name="reason" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Cancel Order </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                {{--modal category update #--}}
                {{--modal order trx and number update--}}
                <form method="post" enctype="multipart/form-data" action="{{ route('updatePayment') }}">
                    @csrf
                    <div class="modal fade" id="modal_order_payment_update"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><b>Order Payment Update </b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">OrderId</label>
                                        <input id="order_payment_id" name="id" type="number" class="form-control" readonly style="display:none;">
                                        <input id="order_payment_for" name="orderfor" type="text" class="form-control" readonly style="display:none;">
                                        <input id="order_payment_order_id" name="order_id" type="text" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">TrxID</label>
                                        <input id="order_payment_trx"  name="trx_id" type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-form-label">BKash Number</label>
                                        <input id="order_payment_number" name="sender_mobile_number" type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Update payment </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                {{--modal category update #--}}
                {{--modal order shipping --}}
                <form method="post" enctype="multipart/form-data" action="{{ route('orderShipping') }}">
                    @csrf
                    <div class="modal fade" id="modal_order_shipping"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><b>Order Shipment Info </b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">OrderId</label>
                                        <input id="order_shippment_id" name="id" type="number" class="form-control" readonly style="display:none;">
                                        <input id="order_shipping_order_id" name="order_id" type="text" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Shippment Tracking No (C/N)</label>
                                        <input id="order_shipment_cn"  name="shipping_tracking_number" type="number" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-form-label">Courier Name</label>
                                        <input id="order_shipment_courier" name="courier_name" type="text" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-form-label">Shipment Date</label>
                                        <input id="order_shipment_date" name="shipping_date" type="date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                {{--modal category update #--}}

            </div>
            @yield('content')
        </section>
    </section>

    <!--main content end-->
    <!--footer start-->
@include('vendor.includes.footer')
<!--footer end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->
@include('vendor.includes.footer_link')


</body>
</html>
