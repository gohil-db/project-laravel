@extends('layouts/contentNavbarLayout')

@section('title', 'Site settings')

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/pages-account-settings-account.js'])
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<style>
.ck-editor__editable_inline {
    min-height: 300px; /* adjust as you like */
}
</style>
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
        <label>Property Builder</label>
        <select name="builder_id" class="form-control" required>
            <option value="">Select Builder Name</option>
            @foreach($builders as $builder)
                <option value="{{ $builder->id }}" {{ $property->builder_id == $builder->id ? 'selected' : '' }}>{{ $builder->fullname }}</option>
            @endforeach
        </select>
        </div>
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
            <label class="form-label">Tags</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="for_sell" id="for_sell" value="1" {{ old('for_sell', $property->for_sell ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="for_sell">For Sell</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="for_rent" id="for_rent" value="1" {{ old('for_rent', $property->for_rent ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="for_rent">For Rent</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $property->featured ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="featured">Featured</label>
            </div>
        </div>
        
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" style="min-height:300px;"> {{ old('description', $property->description ?? '') }}</textarea>
        </div>
    <div class="row">
        <div class="my-3 col-md-6 border border-primary">     
            <label>Change Property Image</label>
            <input type="file" name="pro_img" class="form-control">      
            @if($property->pro_img && file_exists(public_path($property->pro_img)))
                <div class="mt-2">
                    <p>Current Property Image:</p>
                    <img src="{{ asset($property->pro_img) }}" alt="Property Image" width="150" height="100" class="rounded shadow">
                </div>
            @endif
             
        </div>  

        <div class="my-3 col-md-6 border border-primary">       
             <label for="catalog" class="form-label">Change Catalog (PDF)</label>
            <input type="file" name="catalog" id="catalog" accept="application/pdf" class="form-control">     
              @if($property->catalog && file_exists(public_path($property->catalog)))
                <div class="mt-2">                    
                    <p>Current Catelog (PDF):</p>
                    <a href="{{ asset($property->catalog) }}" target="_blank">{{ asset($property->catalog) }}</a>                    
                </div>
            @endif
           
        </div>
    </div>
       
      <div class="card">
        <h5 class="card-header">Product Gallery Images</h5>
        <div class="card-body">
            <div class="mb-3">
                <h5 class="mt-2 card-title">Existing Images</h5>                   
                @if($property->images->count())
                    <div class="row" id="image-list">
                        @foreach($property->images as $image)
                    
                    <div id="image-{{ $image->id }}" class="col-md-3 border border-primary text-center">
                        <img src="{{ asset($image->image) }}" class="img-fluid my-2" alt="Property Image">
                        <button type="button" class="btn btn-sm btn-danger mb-1" onclick="deleteImage({{ $image->id }})">Delete</button>
                    </div>
                        @endforeach
                    </div>                    
                @endif
            </div> 
        </div>
        <div class="card-footer">
             <label for="images" class="form-label">Add More Gallery Images</label>
                <input type="file" name="images[]" id="images" multiple accept="image/*" class="form-control">
        </div>
      </div>
        <div class="card mt-2">
          <h5 class="card-header">Product Videos</h5>
            <div class="card-body">
                <div class="mb-3">
                    @if($property->videos->count())
                    <h5 class="mt-2 card-title">Existing Videos</h5>
                    <div class="row" id="video-list">
                        @foreach($property->videos as $video)
                        <div class="col-md-4 mb-3 text-center video-item border border-primary" id="image-{{ $video->id }}"  data-id="{{ $video->id }}">
                            @if(Str::contains($video->video, 'youtube.com') || Str::contains($video->video, 'youtu.be'))
                                <iframe width="100%" height="200" src="{{ $video->video }}" frameborder="0" allowfullscreen></iframe>
                            @else
                                <video width="100%" height="200" controls>
                                    <source src="{{ asset($video->video) }}" type="video/mp4">
                                </video>
                            @endif                
                            <button type="button" class="btn btn-sm btn-danger mb-1" onclick="deleteVideo({{ $video->id }})"> <i class="bx bxs-trash"></i> Delete</button>                   

                        </div>
                        @endforeach
                    </div>
                @endif
                </div>
            </div>
             <div class="card-footer">
                 <div class="mb-3">
                    <label for="videos" class="form-label">Add New Property Videos</label>
                    <input type="file" name="videos[]" id="videos" class="form-control" multiple accept="video/*">
                </div>
                <div>OR</div>
                <div class="mb-3">
                    <label for="video_links" class="form-label">Add YouTube Video Links (comma-separated)</label>
                    <input type="text" name="video_links" id="video_links" class="form-control" placeholder="https://youtube.com/..., https://youtu.be/...">
                </div>
            </div>
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

<script>
function deleteImage(imageId) {
    if (confirm('Are you sure you want to delete this image?')) {
        fetch(`/delete-image/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            // Safely handle both JSON and non-JSON responses
            let data;
            try {
                data = await response.json();
            } catch (e) {
                console.error('Invalid JSON:', e);
                alert('Unexpected response from server.');
                return;
            }

            if (response.ok && data.success) {
                alert(data.message);
                const imgDiv = document.getElementById('image-' + imageId);
                if (imgDiv) imgDiv.remove();
            } else {
                alert(data.message || 'Error deleting image.');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Error deleting image.');
        });
    }
}

function deleteVideo(videoId) {
    if (confirm('Are you sure you want to delete this Video?')) {
        fetch(`/delete-video/${videoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            // Safely handle both JSON and non-JSON responses
            let data;
            try {
                data = await response.json();
            } catch (e) {
                console.error('Invalid JSON:', e);
                alert('Unexpected response from server.');
                return;
            }

            if (response.ok && data.success) {
                alert(data.message);
                const imgDiv = document.getElementById('image-' + videoId);
                if (imgDiv) imgDiv.remove();
            } else {
                alert(data.message || 'Error deleting video.');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Error deleting video.');
        });
    }
}
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'fontColor', 'fontBackgroundColor', '|',
                'bulletedList', 'numberedList', '|',
                'link', 'blockQuote', 'undo', 'redo'
            ]
        },
        fontColor: {
            colors: [
                { color: 'hsl(0, 0%, 0%)', label: 'Black' },
                { color: 'hsl(0, 75%, 60%)', label: 'Red' },
                { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
                { color: 'hsl(120, 75%, 60%)', label: 'Green' },
                { color: 'hsl(240, 75%, 60%)', label: 'Blue' }
            ]
        }
    })
        .catch(error => {
            console.error(error);
        });
</script>


@endsection
