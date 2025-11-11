@extends('layoutsFront.main')
@section('title', 'Properties List')

@section('content')
        <!-- Header Start -->
        <div class="container-fluid header bg-white p-0">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5 mt-lg-5">
                    <h1 class="display-5 animated fadeIn mb-4">Search Results</h1> 
                        <nav aria-label="breadcrumb animated fadeIn">
                        <ol class="breadcrumb text-uppercase">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>                         
                            <li class="breadcrumb-item text-body active" aria-current="page">Search Results</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 animated fadeIn">
                    <img class="img-fluid" src="{{ Vite::asset('resources/img/header.jpg')}}" alt="">
                </div>
            </div>
        </div>
        <!-- Header End -->
@include('layoutsFront.header-search') 

        <!-- Property List Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-0 gx-5 align-items-end">
                    <div class="col-lg-6">
                        <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                            <h1 class="mb-3">Search Results</h1>
                            <!-- <p>Eirmod sed ipsum dolor sit rebum labore magna erat. Tempor ut dolore lorem kasd vero ipsum sit eirmod sit diam justo sed rebum.</p> -->
                        </div>
                    </div>                   
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                             @forelse($searchProperties as $property)
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="property-item rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href=""><img class="img-fluid" src="{{ Vite::asset('resources/img/property-1.jpg')}}"  alt=""></a>
                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">For Sell</div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">{{$property->type->name}}</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <!-- <h5 class="text-primary mb-3">$12,345</h5> -->
                                        <a class="d-block h5 mb-2" href="{{ route('properties.show', $property->id) }}">{{$property->pro_name}}</a>
                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>{{$property->pro_address}}</p>
                                    </div>
                                    <div class="d-flex border-top">
                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>{{$property->pro_area}} Sqft</small>
                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>{{$property->pro_bed}} Bed</small>
                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>{{$property->pro_bath}} Bath</small>
                                    </div>
                                </div>
                            </div>
                             @empty
                                <p>No properties found.</p>
                            @endforelse
                           
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- Property List End -->
@endsection
