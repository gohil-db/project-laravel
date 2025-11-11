 
 <div class="container-fluid nav-bar bg-transparent">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
                <a href="/" class="navbar-brand d-flex align-items-center text-center">
                    <div class="icon p-2 me-2">
                        <!-- <img class="img-fluid" src="{{ Vite::asset('resources/img/icon-deal.png') }}"  alt="Icon" style="width: 30px; height: 30px;"> -->
                        <img class="img-fluid" src="{{ asset($setting->logo ?? '') }}"  alt="Icon" style="width: 30px; height: 30px;">
                    </div>               
                    <h1 class="m-0 text-primary">{{ $setting->site_name ?? '' }}</h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="/" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                        <a href="/about" class="nav-item nav-link {{ request()->is('about') ? 'active' : '' }}">About</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle {{ request()->is('/property/*') ? 'active' : '' }}" data-bs-toggle="dropdown">Property</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="/property/property-list" class="dropdown-item ">Property List</a>
                                <a href="/property/property-type" class="dropdown-item">Property Type</a>
                                <a href="/property/property-agent" class="dropdown-item">Property Agent</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="/" class="dropdown-item">Page 1</a>
                                <!-- <a href="404.html" class="dropdown-item">404 Error</a> -->
                            </div>
                        </div>
                        <a href="/contact" class="nav-item nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>
                    </div>
                    <a href="/admin" class="btn btn-primary px-3 d-none d-lg-flex">Add Property</a>
                </div>
            </nav>
        </div>