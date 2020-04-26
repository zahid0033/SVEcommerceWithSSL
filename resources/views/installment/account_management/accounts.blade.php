@extends('installment.master')
@section('title','Accounts')
@section('Accounts','active')
@section('content')
    <div class="container-fluid" id="accountPageLoad">
        <div class="row">
            <h1 class="text-center">Accounts</h1>

            <div class="row" style="margin-bottom: 3em">
                <div class="col-md-3" style="text-align: center">
                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                </div>
                <div class="col-md-9">
                    <form action="" method="post">
                        @csrf
                        <input class="form-control start_date" id="start" type="hidden" name="start_date">
                        <input class="form-control end_date" id="end" type="hidden" name="end_date">
                        {{--                    <input type="button" id="submit" class="btn btn-success" value="Submit">--}}
                    </form>
                </div>
            </div>

            <div id="output"></div>
            <div id="loading" class="loading"><img src="{{ asset('assets/img/icon/loading.gif') }}" alt=""></div>
        </div>
    </div>
@endsection
