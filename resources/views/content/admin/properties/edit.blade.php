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
                    <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Edit Property </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/property-list') }}"><i class="icon-base bx bx-bell icon-sm me-1_5"></i> Properties List</a>                   
                </li>
 
            </ul>
        </div>
        <div class="card mb-6">

    {{-- Success message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" id="alert-message">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <script>
            setTimeout(() => {
                const alert = document.getElementById('alert-message');
                if (alert) alert.remove();
            }, 3000);
        </script>
    @endif

    {{-- Edit form --}}
    <form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        @method('PUT')
  <div class="card-body">
        <div class="mb-3">
            <label>Property Name</label>
            <input type="text" name="pro_name" value="{{ old('pro_name', $property->pro_name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="pro_address" value="{{ old('pro_address', $property->pro_address) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Area (sqft)</label>
            <input type="text" name="pro_area" value="{{ old('pro_area', $property->pro_area) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Bedrooms</label>
            <input type="number" name="pro_bed" value="{{ old('pro_bed', $property->pro_bed) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Bathrooms</label>
            <input type="number" name="pro_bath" value="{{ old('pro_bath', $property->pro_bath) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Property Type</label>
            <select name="type_id" class="form-control" required>
                <option value="">Select Type</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ $property->type_id == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>
         
        <div class="mb-3">
            <label>Property Image</label>
            <input type="file" name="pro_img" class="form-control">

            @if($property->pro_img && file_exists(public_path($property->pro_img)))
                <div class="mt-2">
                    <p>Current Image:</p>
                    <img src="{{ asset($property->pro_img) }}" alt="Property Image" width="150" height="100" class="rounded shadow">
                </div>
            @endif
        </div>
         {{-- Latitude --}}
        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" name="latitude" id="latitude" class="form-control"
                value="{{ old('latitude', $property->latitude) }}" placeholder="select on map">
        </div>

        {{-- Longitude --}}
        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" name="longitude" id="longitude" class="form-control"
                value="{{ old('longitude', $property->longitude) }}" placeholder="select on map">
        </div>

        {{-- Google Map Picker --}}
        <div class="mb-3">
            <label class="form-label">Select Location on Map</label>
            <div id="map" style="height: 400px; width: 100%; border-radius: 8px;"></div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('properties.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Update Property</button>
        </div>
    </div>
    </form>
</div>
</div>
</div>

<script>
    let map;
    let marker;

    function initMap() {
        // If property has saved coordinates, use them; else fallback
        const savedLat = parseFloat("{{ $property->latitude ?? 0 }}");
        const savedLng = parseFloat("{{ $property->longitude ?? 0 }}");

        const hasSavedLocation = savedLat && savedLng;
        const defaultLocation = { lat: 20.5937, lng: 78.9629 }; // India center

        map = new google.maps.Map(document.getElementById("map"), {
            center: hasSavedLocation ? { lat: savedLat, lng: savedLng } : defaultLocation,
            zoom: hasSavedLocation ? 12 : 5,
        });

        // Initialize marker if we already have coordinates
        if (hasSavedLocation) {
            marker = new google.maps.Marker({
                position: { lat: savedLat, lng: savedLng },
                map: map,
                draggable: true,
            });
        }

        // 🧭 Try to get user's current location if no saved lat/lng
        if (!hasSavedLocation && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };

                    map.setCenter(userLocation);
                    map.setZoom(14);

                    // Create marker
                    marker = new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        draggable: true,
                    });

                    // Fill the input fields
                    document.getElementById("latitude").value = userLocation.lat.toFixed(6);
                    document.getElementById("longitude").value = userLocation.lng.toFixed(6);
                },
                () => {
                    console.warn("Geolocation permission denied or unavailable.");
                    alert("Could not get your location. You can select it manually on the map.");
                }
            );
        }

        // When map is clicked
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

        // When marker is dragged
        if (marker) {
            marker.addListener('dragend', (event) => {
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
