@extends('website.master')
@section('content')
    <div class="container">
        <h1 class="text-center mt-5 mb-5">Grab your offer</h1> <br><br>
        <div class="row">
            @foreach($offers as $offer)
                <div class="col-md-12" style="margin-bottom: 10px;text-align: center">
                    <h2 style="text-align: center">{{ $offer->title }}</h2>
                    <a href="{{ route('pages.offerSearchByTitle',Crypt::encrypt($offer->id) ) }}"><img class="mb-3" src="{{ asset('assets/vendor/images/offers') }}/{{$offer->image}}" width="50%" height="300px" alt=""></a>
                </div>
            @endforeach

        </div>
    </div>
@endsection
