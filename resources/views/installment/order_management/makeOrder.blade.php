@extends('installment.master')
@section('title','Search Orders')
@section('Order_management','active')
@section('makeOrder','active')
@section('content')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        .ui-icon{
            box-sizing: content-box;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <h2 class="text-center"> Create Order </h2>

            <form method="post" action="{{ route('installment.placeOrder') }}">
                @csrf

                <div class="form-row row">
                    <div class="form-group col-md-3">
                        <div class="form-group">
                            <label for="sel1">Select list:</label>
                            <select class="form-control" id="customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->id }}-{{ $customer->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Mobile Number</label>
                        <input type="text" class="form-control" id="cus_phone" placeholder="Phone" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Email</label>
                        <input type="text" class="form-control" id="cus_email" placeholder="Email" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label >Address</label>
                        <input type="text" class="form-control" id="cus_address"  placeholder="Address" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Product Name</label>
                        <input type="text" class="form-control" placeholder="Product Name" value="{{ $product->name }}" readonly>
                        <input type="hidden" class="form-control" placeholder="Product Name" name="product_id" value="{{ $product->id }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Product Price</label>
                        <input type="text" class="form-control" placeholder="Price" id="base_price" name="product_price" value="{{ $product->price }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Reduced Price</label>
                        <input type="text" class="form-control" id="reduced_price" name="reduced_price" placeholder="New Price">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Down Payment</label>
                        <input type="number" class="form-control" id="down_payment" name="downPayment" placeholder="Down payment" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Due Amount</label>
                        <input type="number" class="form-control" id="due_amount" name="due_amount" placeholder="Due Amount" readonly required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Pay based on</label><br>
                        <label class="radio-inline"><input type="radio" name="time_difference" value="weekly" checked>Weekly</label>
                        <label class="radio-inline"><input type="radio" name="time_difference" value="monthly">Monthly</label>
                        <label class="radio-inline"><input type="radio" name="time_difference" value="yearly">Yearly</label>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Total Paid Amount</label>
                        <input type="number" class="form-control" id="total_paid" name="paid_amount" placeholder="Total paid" readonly>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-3 widget">
                        <label for="inputPassword4">Choose your way</label><br>
                        <label class="radio-inline" style="margin-bottom: 5px;"><input type="radio" name="procedure" value="per_amount" required>Install per amount</label><br>
                        <label class="radio-inline"><input type="radio" name="procedure" value="num_of_install">Number of Install </label>
{{--                        <fieldset>--}}
{{--                            <label>Select a Location: </label>--}}
{{--                            <label for="radio-1">Install per amount</label>--}}
{{--                            <input type="radio" name="procedure" value="per_amount" id="radio-1" required><br>--}}
{{--                            <label for="radio-2">Number of Install</label>--}}
{{--                            <input type="radio" name="procedure" value="num_of_install" id="radio-2">--}}
{{--                        </fieldset>--}}
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Per Installment Amount</label>
                        <input type="number" class="form-control" id="per_amount" name="installment_amount" placeholder="Per Installment Amount" readonly required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Number of Installment</label>
                        <input type="number" class="form-control" id="no_of_install" name="installment_number" placeholder="Number of Installment" readonly required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Start Date</label>
{{--                        <input type="date" class="form-control" name="date" placeholder="date" >--}}
                        <input type="text" class="form-control" id="datepicker" name="date" placeholder="date" autocomplete="off">
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12 text-center">
                        <input type="submit" class="btn btn-primary" value="submit">
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
