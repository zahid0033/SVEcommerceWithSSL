@extends('vendor.master')
@section('title','Contact Management')
@section('Contact_management','active')
@section('content')
    <div class="container">
        <div class="row">
            <h1 class="text-center"  style="margin-bottom: 2em">Contact Details </h1>
            <div class="col-md-6">
                @if($contact->status == "Pending")
                    <span class="label label-info">{{ $contact->status }}</span>
                @elseif($contact->status == "Solved")
                    <span class="label label-success">{{ $contact->status }}</span>
                @elseif($contact->status == "Cancelled")
                    <span class="label label-danger">{{ $contact->status }}</span>
                @elseif($contact->status == "Processing")
                    <span class="label label-primary">{{ $contact->status }}</span>
                @endif
            </div>
            <div class="col-md-6" style="margin-bottom: 30px">
                <span><b>Change Status : </b></span>
                <a href="{{ route('contact_processing',Crypt::encrypt($contact->id) ) }}" title="Processing" class="btn btn-primary " onclick="return confirm('Working on it ?')"><i class="fa fa-pencil-square-o"></i> </a>
                <a href="{{ route('contact_solved',Crypt::encrypt($contact->id) ) }}" title="Solved" class="btn btn-success " onclick="return confirm('Solve the problem ?')"><i class="fas fa-check"></i> </a>
                <a href="{{ route('contact_cancel',Crypt::encrypt($contact->id) ) }}" title="Cancel" class="btn btn-danger " onclick="return confirm('Sure to be cancelled ?')"><i class="fas fa-times"></i> </a>
            </div>
            <div class="col-md-6">
                <p><b>Name : </b>{{ $contact->name }}</p>
            </div>
            <div class="col-md-6">
                <p><b>Email : </b>{{ $contact->email }}</p>
            </div>
            <div class="col-md-6">
                <p><b>Phone : </b>{{ $contact->phone }}</p>
            </div>
            <div class="col-md-6">
                <p><b>Address : </b>{{ $contact->address }}</p>
            </div>
            <div class="col-md-12">
                <p><b>Message : </b></p>
                <h2>{{ $contact->message }}</h2>
            </div>
            <div class="col-md-12">
                <p><b><u>Note</u></b></p>
                <form method="post" action="{{ route('contact_note_update') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $contact->id }}">
                    <div class="form-group">
                        <textarea name="note" id="note" cols="130" rows="8">{{ $contact->note }}</textarea>
                    </div>
                    <input type="submit" class="btn btn-success" value="Update">
                </form>
            </div>
        </div>
    </div>
@endsection
