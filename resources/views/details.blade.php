@extends('layoutsFront.main')
@section('title', 'Property Details')

@section('content')
        <!-- Header Start -->
        <div class="container-fluid header bg-white p-0">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5 mt-lg-5">
                    <h1 class="display-5 animated fadeIn mb-4">Property Details</h1> 
                        <nav aria-label="breadcrumb animated fadeIn">
                        <ol class="breadcrumb text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <!-- <li class="breadcrumb-item"><a href="#">Pages</a></li> -->
                            <li class="breadcrumb-item text-body active" aria-current="page">{{ $property->pro_name }}</li>
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
                            <img class="img-fluid w-100" src="{{ asset($property->pro_img) }}" alt="">
                        </div>
                    </div> -->
                    <div class="col-md-6 animated fadeIn">
                    <div class="owl-carousel header-carousel">
                        @if($property->images->count())
                          @foreach($property->images as $img)
                        <div class="owl-carousel-item">                           
                            <img class="img-fluid" src="{{ asset($img->image ?? '') }}"  alt="">
                        </div>                        
                        @endforeach
                        @else
                            <div class="about-img position-relative overflow-hidden p-5 pe-0">
                                <img class="img-fluid w-100" src="{{ asset($property->pro_img) }}" alt="">
                            </div>
                        @endif
                        
                    </div>
                </div>

                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <h1 class="mb-4">{{ $property->pro_name }}</h1>
                        <p class="mb-4">{{ $property->pro_address }}</p>
                        <p><i class="fa fa-check text-primary me-3"></i>{{ $property->pro_area }} Sqft</p>
                        <p><i class="fa fa-check text-primary me-3"></i>{{ $property->pro_bed }} Bed</p>
                        <p><i class="fa fa-check text-primary me-3"></i>{{ $property->pro_bath }} Bath</p>
                         @if($property->catalog)
                            <a href="{{ asset($property->catalog) }}" target="_blank" class="btn btn-outline-primary">
                                <i class="bi bi-file-earmark-pdf"></i> View Catalog
                            </a>
                            @else
                              <a href="#" class="btn btn-outline-primary">
                                <i class="bi bi-file-earmark-pdf"></i> Catalog Not Available
                            </a>
                        @endif

                    </div>
                    <div class="col-md-12">
                        <h3>More about <span class="text-primary">{{ $property->pro_name }}</span></h3>
                        <div>                   
                            {!! $property->description !!}
                        </div>
                    </div>
                   
            </div>
        </div>
        <!-- End -->
        <!-- Video Section Start -->
        <div class="container-xxl py-5">
            <div class="container">    
                <div class="row g-3">
                    @if($property->videos->count())
                  <h3 class="mb-3">Property Videos</h3>    
                    @foreach($property->videos as $video)
                        @php
                            $videoUrl = $video->video;

                            // Convert YouTube watch or short URLs to embed format
                            if (Str::contains($videoUrl, 'youtube.com/watch?v=')) {
                                $videoUrl = str_replace('watch?v=', 'embed/', $videoUrl);
                            } elseif (Str::contains($videoUrl, 'youtu.be/')) {
                                $videoUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $videoUrl);
                            }
                        @endphp
                        <div class="col-lg-6 mb-3">
                            @if(Str::contains($video->video, 'youtube.com') || Str::contains($video->video, 'youtu.be'))
                                <div class="ratio ratio-16x9">
                                    <iframe
                                        width="100%"
                                        height="200"
                                        src="{{ $videoUrl }}"
                                        frameborder="0"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            @else
                                <video width="100%" height="200" controls>
                                    <source src="{{ asset($video->video) }}" type="video/mp4">
                                </video>
                            @endif
                        </div>
                    @endforeach

                    @endif
                </div>
            </div>
        </div>
        <!-- Video Section End -->  
           <!--  Builder details here -->
        <div class="container-xxl py-5">
            <div class="container">
             <div class="col-md-12">
                         <h3>About <span class="text-primary">{{ $property->builder->fullname }}</span></h3>
                        <div class="row">
                            <div class="col-2">
                            <img class="img-fluid rounded" src="{{ asset($property->builder->image) }}" alt="">
                            </div>
                            <div class="col">
                                <a href="{{ route('builders.show', $property->builder_id) }}">{{ $property->builder->business_name }}</a>                    
                            </div>                    
                            <div>           
                                {!! $property->builder->description !!}
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <div class="container-xxl py-5">
            <div class="container">
                <div class="bg-light rounded p-3">
                    <div class="bg-white rounded p-4" style="border: 1px dashed rgba(0, 185, 142, .3)">
                        <div class="row g-5 align-items-center">
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                                <img class="img-fluid rounded w-100" src="{{ asset($property->pro_img) }}" alt="">
                            </div>
                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="mb-4">
                                    <h1 class="mb-3">Contact Now</h1>
                                    <p>Fillup your Details.</p>
                                </div>
                                @if(session('success'))
                                    <div class="alert alert-success mt-3">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <form action="{{ route('property.inquiry', $property->id) }}" method="POST">
                                    @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                                            <label for="name">Enter Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="number" name="number" placeholder="Enter Number" required>
                                            <label for="number">Enter Number</label>
                                        </div>
                                    </div>                                    
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" required>
                                            <label for="city">Enter City</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit"> Send </button>
                                    </div>
                                </div>
                            </form>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
         <!-- Builder Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">Property Builders</h1>
                    <p>Eirmod sed ipsum dolor sit rebum labore magna erat. Tempor ut dolore lorem kasd vero ipsum sit eirmod sit. Ipsum diam justo sed rebum vero dolor duo.</p>
                </div>
                <div class="row g-4">
                    @foreach($propertyBuilders as $agent)
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item rounded overflow-hidden">
                            <div class="position-relative">
                                <div class="text-center" style="height:300px; width:300px;">
                                <a href="{{ route('builders.show', $agent->id) }}">
                                    <img class="img-fluid" src="{{ asset($agent->image) }}"   alt="">
                                </a> 
                                </div>
                                <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                    <a class="btn btn-square mx-1" href="{{$agent->fb_link}}"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-square mx-1" href="{{$agent->x_link}}"><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-square mx-1" href="{{$agent->insta_link}}"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="text-center p-4 mt-3">
                                <a href="{{ route('builders.show', $agent->id) }}">
                                    <h5 class="fw-bold mb-0">{{$agent->fullname}}</h5>
                                    <small>{{ $agent->business_name}}</small>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- Builder End -->
        

@endsection