@extends('layouts/contentNavbarLayout')

@section('title', 'Site settings')

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/pages-account-settings-account.js'])
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="nav-align-top">
            <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-user icon-sm me-1_5"></i>+ Add Property </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/property-list') }}"><i class="icon-base bx bx-bell icon-sm me-1_5"></i> Properties List</a>                   
                </li>
 
            </ul>
        </div>
        <div class="card mb-6">

    <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
       <div class="card-body">
         <div class="mb-3">
            <label>Property Type</label>
            <select name="type_id" class="form-control" required>
                <option value="">Select Type</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Property Name</label>
            <input type="text" name="pro_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="pro_address" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Area (sqft)</label>
            <input type="text" name="pro_area" class="form-control">
        </div>

        <div class="mb-3">
            <label>Bedrooms</label>
            <input type="number" name="pro_bed" class="form-control">
        </div>

        <div class="mb-3">
            <label>Bathrooms</label>
            <input type="number" name="pro_bath" class="form-control">
        </div>       

        <div class="mb-3">
            <label>Property Image</label>
            <input type="file" name="pro_img" class="form-control">
        </div>
        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" name="latitude" id="latitude" class="form-control" readonly placeholder="select on map" >
        </div>

        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" name="longitude" id="longitude" class="form-control" readonly placeholder="select on map" >
        </div>
        {{-- Google Map Picker --}}
        <div class="mb-3">
            <label class="form-label">Select Location on Map</label>
            <div id="map" style="height: 400px; width: 100%; border-radius: 8px;"></div>
        </div>
        <button class="btn btn-success">Save</button>
        <a href="{{ route('properties.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
    </form>
</div>
</div>
</div>
{{-- Google Maps API --}}

<script>
    let map;
    let marker;

    function initMap() {
        const defaultLocation = { lat: 20.5937, lng: 78.9629 }; // India center

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: 5,
        });

        // ✅ Try to get user current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };

                    map.setCenter(userLocation);
                    map.setZoom(14);

                    marker = new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        draggable: true,
                    });

                    document.getElementById("latitude").value = userLocation.lat.toFixed(6);
                    document.getElementById("longitude").value = userLocation.lng.toFixed(6);
                },
                () => {
                    console.warn("Location permission denied.");
                    alert("Could not get your location. You can select it manually on the map.");
                }
            );
        }

        // ✅ Click on map → update marker + fields
        map.addListener("click", (event) => {
            const clickedLocation = event.latLng;

            if (marker) {
                marker.setPosition(clickedLocation);
            } else {
                marker = new google.maps.Marker({
                    position: clickedLocation,
                    map: map,
                    draggable: true,
                });
            }

            document.getElementById("latitude").value = clickedLocation.lat().toFixed(6);
            document.getElementById("longitude").value = clickedLocation.lng().toFixed(6);
        });

        // ✅ Drag marker → update fields
        if (marker) {
            marker.addListener("dragend", (event) => {
                document.getElementById("latitude").value = event.latLng.lat().toFixed(6);
                document.getElementById("longitude").value = event.latLng.lng().toFixed(6);
            });
        }
    }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADIspkSf3W_n0nCMWTN80TWTvkKb6y3LE&callback=initMap">
</script>

@endsection
