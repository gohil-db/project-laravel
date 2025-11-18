@extends('layoutsFront.main')
@section('title', 'Property Details')

@section('content')
        <!-- Header Start -->
        <div class="container-fluid header bg-white p-0">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5 mt-lg-5">
                    <h1 class="display-5 animated fadeIn mb-4">Builder Details</h1> 
                        <nav aria-label="breadcrumb animated fadeIn">
                        <ol class="breadcrumb text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <!-- <li class="breadcrumb-item"><a href="#">Pages</a></li> -->
                            <li class="breadcrumb-item text-body active" aria-current="page">{{ $propertyBuilders->fullname }}</li>
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
        <!--  Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <!-- <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="about-img position-relative overflow-hidden p-5 pe-0">
                            <img class="img-fluid w-100" src="{{ asset($propertyBuilders->image) }}" alt="">
                        </div>
                    </div> -->
                    <div class="col-md-6 animated fadeIn">                                        
                            <div class="about-img position-relative overflow-hidden p-5 pe-0">
                                <img class="img-fluid" src="{{ asset($propertyBuilders->image) }}" alt="">
                            </div>                   
                </div>

                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <h1 class="mb-4">{{ $propertyBuilders->fullname }}</h1>
                        <p class="mb-4">Business Name: <span class="text-primary">{{ $propertyBuilders->business_name }}</span></p>
                        <p><i class="fa fa-check text-primary me-3"></i>{{ $propertyBuilders->phone }} </p>      
                        <p><i class="fab fa-facebook-f text-primary me-3"></i><a href="{{ $propertyBuilders->fb_link }}" target="_blank"> Facebook</a> </p>      
                        <p><i class="fab fa-instagram text-primary me-3"></i> <a href="{{ $propertyBuilders->insta_link }}" target="_blank" rel="noopener noreferrer">Instagram</a> </p>      
                        <p><i class="fab fa-twitter text-primary me-3"></i><a href="{{ $propertyBuilders->x_link }}" target="_blank" rel="noopener noreferrer">Twitter</a> </p>   
                           
                    </div>
                    <div class="col-md-12">
                        <h3>More about <span class="text-primary">{{ $propertyBuilders->business_name }}</span></h3>
                        <div>                   
                            {!! $propertyBuilders->description !!}
                        </div>
                    </div>                   
                    </div>
                </div>
            </div>
        </div>
        <!-- End -->
  <!-- Property List Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-0 gx-5 align-items-end">
                    <div class="col-lg-6">
                        <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                            <h2 class="mb-3">Explore  <span class="text-primary">{{ $propertyBuilders->business_name  }} </span> projects</h2>
                         
                        </div>
                    </div>                   
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                             @forelse($propertyBuilders->properties  as $property)
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="property-item rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <a href="{{ route('propertiesList.show', $property->id) }}"><img class="img-fluid" src="{{ Vite::asset('resources/img/property-1.jpg')}}"  alt=""></a>
                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                             @if($property->for_sell)
                                               For Sale
                                            @endif
                                            @if($property->for_rent)
                                                For Rent
                                            @endif
                                            @if($property->featured)
                                               Featured
                                            @endif

                                        </div>
                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">{{$property->type->name}}</div>
                                    </div>
                                    <div class="p-4 pb-0">
                                        <!-- <h5 class="text-primary mb-3">$12,345</h5> -->
                                        <a class="d-block h5 mb-2" href="{{ route('propertiesList.show', $property->id) }}">{{$property->pro_name}}</a>
                                      
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
                                <h3>No Properties found...</h3>
                            @endforelse
                            <!-- <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                                <a class="btn btn-primary py-3 px-5" href="">Browse More Property</a>
                            </div> -->
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- Property List End -->

@endsection