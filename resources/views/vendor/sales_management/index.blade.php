@extends('vendor.master')
@section('title','Sales')
@section('sales_management','active')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <form method="post" enctype="multipart/form-data" action="{{ route('salesReport') }}">
                @csrf
                <div class="col-md-4 mar-top">
                    <label for="recipient-name" class=" label label-success"> Select Report Range</label>
                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                    <input type="text" id="daterange" name="daterange"  class="form-control form-control-sm" style="display: none"/>
                </div>
                <div class="col-md-8 mar-top text-left">
                    <button type="submit" class="btn btn-success" style="margin-top: 22px;">Submit</button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12 big-heading-extra text-center">Product-Wise Sale</div>
            <div class="col-md-4">
                <div class="content-panel mar-top ">
                    <h3 class="text-center small-heading">Total </h3>
                    <table class="table  table-advance table-hover ">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col"class="text-center"><i class="fas fa-box-open"></i> Product</th>
                            <th scope="col" class="text-center"><i class="fas fa-sort-amount-down"></i> Sold Total</th>
                            <th scope="col"class="text-center"><i class="fas fa-money-bill-wave"></i> Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $i => $s)
                            <tr >
                                <td class="text-center">
                                    @if(empty($s->image))
                                        <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}"  width="50px" {{--class="imgs"--}} alt="">
                                    @else
                                        @php
                                            $imgarray = json_decode($s->image);
                                        @endphp
                                        <img src="{{ asset('assets/vendor/images/products/') }}/{{$imgarray[0]->image}}" width="50px" {{--class="imgs"--}} alt="">
                                    @endif
                                    <b>{{$s->name}}</b>
                                </td>
                                <td class="text-center"><b>{{$productSoldTotal[$i]}} pc</b></td>
                                <td class="text-center">
                                    <b>৳ {{ number_format($productAmountTotal[$i])}}</b>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-center" colspan="3">
                                @php
                                    $total = array_sum($productAmountTotal)
                                @endphp
                                <h3 ><kbd>৳ {{ number_format($total)}}</kbd> </h3>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="content-panel mar-top ">
                    <h3 class="text-center small-heading">Offer </h3>
                    <table class="table  table-advance table-hover ">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col"class="text-center"><i class="fas fa-box-open"></i> Product</th>
                            <th scope="col" class="text-center"><i class="fas fa-sort-amount-down"></i> Sold Total</th>
                            <th scope="col"class="text-center"><i class="fas fa-money-bill-wave"></i> Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $i => $s)
                            <tr >
                                <td class="text-center">
                                    @if(empty($s->image))
                                        <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}"  width="50px" {{--class="imgs"--}} alt="">
                                    @else
                                        @php
                                            $imgarray = json_decode($s->image);
                                        @endphp
                                        <img src="{{ asset('assets/vendor/images/products/') }}/{{$imgarray[0]->image}}" width="50px" {{--class="imgs"--}} alt="">
                                    @endif
                                    <b>{{$s->name}}</b>
                                </td>
                                <td class="text-center"><b>{{$OfferProductSoldTotal[$i]}} pc</b></td>
                                <td class="text-center"><b>৳ {{ number_format($OfferProductAmountTotal[$i])}}</b></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-center" colspan="3">
                                @php
                                    $total_offer = array_sum($OfferProductAmountTotal)
                                @endphp
                                <h3 ><kbd>৳ {{ number_format($total_offer)}}</kbd> </h3>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="content-panel mar-top ">
                    <h3 class="text-center small-heading">Normal </h3>
                    <table class="table  table-advance table-hover ">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col"class="text-center"><i class="fas fa-box-open"></i> Product</th>
                            <th scope="col" class="text-center"><i class="fas fa-sort-amount-down"></i> Sold Total</th>
                            <th scope="col"class="text-center"><i class="fas fa-money-bill-wave"></i> Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $i => $s)
                            <tr >
                                <td class="text-center">
                                    @if(empty($s->image))
                                        <img src="{{ asset('assets/vendor/images/icon/no_image.jpg') }}"  width="50px" {{--class="imgs"--}} alt="">
                                    @else
                                        @php
                                            $imgarray = json_decode($s->image);
                                        @endphp
                                        <img src="{{ asset('assets/vendor/images/products/') }}/{{$imgarray[0]->image}}" width="50px" {{--class="imgs"--}} alt="">
                                    @endif
                                    <b>{{$s->name}}</b>
                                </td>
                                <td class="text-center"><b>{{$productSoldTotal[$i] - $OfferProductSoldTotal[$i]}} pc</b></td>
                                <td class="text-center"><b>৳ {{ number_format($productAmountTotal[$i] - $OfferProductAmountTotal[$i])}}</b></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-center" colspan="3">
                                @php
                                    $total_normal = $total - $total_offer
                                @endphp
                                <h3 ><kbd>৳ {{ number_format($total_normal)}}</kbd> </h3>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

