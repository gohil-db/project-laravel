@extends('layouts/contentNavbarLayout')

@section('title', 'Site settings')

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/pages-account-settings-account.js'])
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
                    <label>Property Builder</label>
                    <select name="builder_id" class="form-control" required>
                        <option value="">Select Builder Name</option>
                        @foreach($builders as $builder)
                            <option value="{{ $builder->id }}">{{ $builder->fullname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Display on Top Slider?</label>
                    <select name="display_top" class="form-control">
                        <option value="0" >No</option>
                        <option value="1" >Yes</option>
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
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="10"></textarea>
                </div>  
                <div class="mb-3">
                    <label>Property Image</label>
                    <input type="file" name="pro_img" class="form-control">
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
                    <label for="catalog" class="form-label">Property Catalog (PDF)</label>
                    <input type="file" name="catalog" id="catalog" accept="application/pdf" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">Gallery Images</label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="videos" class="form-label">Property Videos</label>
                    <input type="file" name="videos[]" id="videos" class="form-control" multiple accept="video/*">
                </div>
                <div class="mb-3">
                    <label for="video_links" class="form-label">YouTube Video Links (comma-separated)</label>
                    <input type="text" name="video_links" id="video_links" class="form-control" placeholder="https://youtube.com/..., https://youtu.be/...">
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
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
        toolbar: {
            items: [
                'heading', '|',
        'bold', 'italic', '|',
        'link', 'blockQuote', 'bulletedList', 'numberedList', '|',
        'undo', 'redo'
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
