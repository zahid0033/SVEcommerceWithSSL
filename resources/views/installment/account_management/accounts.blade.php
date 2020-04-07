@extends('installment.master')
@section('title','Accounts')
@section('Accounts','active')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1 class="text-center">Accounts</h1>
            <div class="form-row">
                <div class="form-group col-md-4">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPassword4">Select Date</label><br>
                    <input type="text" class="form-control account_date" id="fetchDate" name="date" placeholder="date" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                </div>
            </div>

            <div id="output"></div>
        </div>
    </div>
@endsection
