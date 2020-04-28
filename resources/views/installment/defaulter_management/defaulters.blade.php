@extends('installment.master')
@section('title','Defaulters')
@section('Defaulters','active')
@section('content')
    <div class="container-fluid" id="defaulterPageLoad" >
        <h1 class="text-center">Missing Orders</h1>

        <div class="row" style="margin-bottom: 3em">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="text-align: center">
                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>
            <div class="col-md-4">
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

    <!-- Modal start to view the note -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b id="customer_name">title</b></h5>
                </div>
                <div class="modal-body" id="note_details">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end for view -->
    <!-- Modal start to update the note -->
    <div class="modal fade" id="noteUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b id="customer_name_title">title</b></h5>
                </div>
                <div class="modal-body" id="note_details">
                    <form>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Note</label>
                            <input type="hidden" class="form-control" id="order_id" name="note_id"  placeholder="Enter Note">
                            <input type="text" class="form-control" id="prev_note" name="prev_note"  placeholder="Enter Note">
                        </div>
                        <input type="button" id="call_note_update" class="btn btn-primary" value="submit">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




@endsection

