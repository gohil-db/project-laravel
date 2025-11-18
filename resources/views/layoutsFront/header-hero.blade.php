        <!-- Header Start -->
        <div class="container-fluid header bg-white p-0">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5 mt-lg-5">
                    <h1 class="display-5 animated fadeIn mb-2">Find A <span class="text-primary">Perfect Home</span> To Live With Your Family</h1>
                    <p class="animated fadeIn mb-2 pb-2">Vero elitr justo clita lorem. Ipsum dolor at sed stet
                        sit diam no. Kasd rebum ipsum et diam justo clita et kasd rebum sea elitr.</p>
                    <a href="" class="btn btn-primary py-2 px-5 me-3 animated fadeIn">Get Started</a>
                </div>
                <div class="col-md-6 animated fadeIn">
                    <div class="owl-carousel header-carousel">
                         @foreach($topSlidersProperties as $property)
                        <div class="owl-carousel-item position-relative">                        
                            <img class="img-fluid" src="{{ asset($property->pro_img ?? '') }}"  alt="">
                            <div class="position-absolute bottom-0 start-0 w-100 text-white p-3" style="background: rgba(0,0,0,0.5);">
                                <h4 class="m-0 text-white">{{ $property->pro_name }}</h4>
                            </div>
                        </div>                
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->

        