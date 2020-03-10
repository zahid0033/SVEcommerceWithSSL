@extends('website.master')
@section('content')
    <div class="container mt-3">
        <div class="row nav-space" style="margin: 50px 0">
            <div class="col-md-6">
                <img src="{{ asset('assets/website/images/logo/nobinLogo.png') }}" width="100%" alt="">
            </div>
            <div class="col-md-6">
                {{--        /**************** accordion start *******************  */ --}}
                <div id="accordion" class="">

                    <div class="card border-0 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp; box-shadow: none !important;">
                        <div class="card-header p-0 border-0" id="heading-240">
                            <button class="btn btn-link accordion-title border-0 collapsed" data-toggle="collapse" data-target="#collapse-240" aria-expanded="false" aria-controls="#collapse-240"><i class="fa fa-minus text-center d-flex align-items-center justify-content-center h-100"></i>Our Objective</button>
                        </div>
                        <div id="collapse-240" class="collapse " aria-labelledby="heading-240" data-parent="#accordion">
                            <div class="card-body accordion-body">
                                <div class="row">
                                    <p>Under Construction </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card border-0 wow fadeInUp" style="box-shadow: none !important;,visibility: visible; animation-name: fadeInUp;">
                        <div class="card-header p-0 border-0" id="heading-241">
                            <button class="btn btn-link accordion-title border-0 collapsed" data-toggle="collapse" data-target="#collapse-241" aria-expanded="false" aria-controls="#collapse-241"><i class="fa fa-minus text-center d-flex align-items-center justify-content-center h-100"></i>Our Goal</button>
                        </div>
                        <div id="collapse-241" class="collapse " aria-labelledby="heading-241" data-parent="#accordion">
                            <div class="card-body accordion-body">
                                <div class="row">
                                    <p>Under Construction </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card border-0 wow fadeInUp" style="box-shadow: none !important;,visibility: visible; animation-name: fadeInUp;">
                        <div class="card-header p-0 border-0" id="heading-242">
                            <button class="btn btn-link accordion-title border-0 collapsed" data-toggle="collapse" data-target="#collapse-242" aria-expanded="false" aria-controls="#collapse-242"><i class="fa fa-minus text-center d-flex align-items-center justify-content-center h-100"></i>Mission Statement</button>
                        </div>
                        <div id="collapse-242" class="collapse " aria-labelledby="heading-242" data-parent="#accordion">
                            <div class="card-body accordion-body">
                                <div class="row">
                                    <p>Under Construction , </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card border-0 wow fadeInUp" style="box-shadow: none !important;,visibility: visible; animation-name: fadeInUp;">
                        <div class="card-header p-0 border-0" id="heading-243">
                            <button class="btn btn-link accordion-title border-0 collapsed" data-toggle="collapse" data-target="#collapse-243" aria-expanded="false" aria-controls="#collapse-243"><i class="fa fa-minus text-center d-flex align-items-center justify-content-center h-100"></i>Vision Statement</button>
                        </div>
                        <div id="collapse-243" class="collapse " aria-labelledby="heading-243" data-parent="#accordion">
                            <div class="card-body accordion-body">
                                <p>Under Construction </p>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 wow fadeInUp" style="box-shadow: none !important;,visibility: visible; animation-name: fadeInUp;">
                        <div class="card-header p-0 border-0" id="heading-244">
                            <button class="btn btn-link accordion-title border-0 collapsed" data-toggle="collapse" data-target="#collapse-244" aria-expanded="false" aria-controls="#collapse-244"><i class="fa fa-minus text-center d-flex align-items-center justify-content-center h-100"></i>Our Achievements</button>
                        </div>
                        <div id="collapse-244" class="collapse " aria-labelledby="heading-244" data-parent="#accordion">
                            <div class="card-body accordion-body">
                                <p>Under Construction</p>
                            </div>
                        </div>
                    </div>

                </div>
                {{--        /**************** accordion end *******************  */ --}}
            </div>
        </div>
    </div>
@endsection
