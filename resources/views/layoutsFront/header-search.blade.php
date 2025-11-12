        <!-- Search Start -->
        <div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
            <form action="{{ route('property.search') }}" method="GET">
            <div class="container">
                <div class="row g-2">
                    <div class="col-md-10">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="search" id="search"  class="form-control border-0 py-3 position-relative" autocomplete="off" placeholder="Search Property">
                                <div id="suggestions" class="list-group position-absolute  d-none shadow-sm"></div>
                            </div>
                            <div class="col-md-4">                                                
                                <select name="type_id" class="form-select border-0 py-3">
                                    <option value="">Property Type</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 position-relative">
                                 <input type="text" name="location" id="location" class="form-control border-0 py-3"  placeholder="Location" autocomplete="off">
                                 <span id="loader" 
                                    style="
                                        position:absolute;
                                        right:15px;
                                        top:50%;
                                        transform:translateY(-50%);
                                        display:none;
                                    ">
                                    ⏳
                                </span>
                                <!-- Hidden inputs for lat/lng -->
                                <input type="hidden" name="lat" id="lat" value="22.282240">
                                <input type="hidden" name="lng" id="lng" value="70.775603">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-dark border-0 w-100 py-3">Search</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <!-- Search End -->

<script>
    let propertiesList = @json($properties);
document.addEventListener("DOMContentLoaded", () => {

    const searchInput = document.getElementById("search");
    const suggestionsBox = document.getElementById("suggestions");

    searchInput.addEventListener("input", function () {

        let query = this.value.trim();

        if (query.length === 0) {
            suggestionsBox.classList.add("d-none");
            return;
        }

        // Filter matching property names
        let filtered = propertiesList.filter(p =>
            p.pro_name.toLowerCase().includes(query.toLowerCase())
        );

        let html = "";

        if (filtered.length > 0) {
            filtered.forEach(p => {
                html += `
                    <button type="button" 
                        class="list-group-item list-group-item-action">
                        ${p.pro_name}
                    </button>`;
            });
        } else {
            // When no results → show typed value
            html = `
                <button type="button" 
                    class="list-group-item list-group-item-action">
                    ${query}
                </button>`;
        }

        suggestionsBox.innerHTML = html;
        suggestionsBox.classList.remove("d-none");
    });

    // On click fill the textbox and hide suggestions
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("list-group-item")) {
            searchInput.value = e.target.innerText;
            suggestionsBox.classList.add("d-none");
        }
          // ✅ Close suggestions when clicking outside
        if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.classList.add("d-none");
        }
    });

     searchInput.addEventListener("keydown", function (e) {
        if (e.key === "Tab") {
            suggestionsBox.classList.add("d-none");
            propertyType.focus();
        }
    });
});
</script>




<script>
document.getElementById("location").addEventListener("click", function () {

    // Show message
    const loader = document.getElementById("loader");
     loader.style.display = "inline";       // Show loader
    document.getElementById("location").value = "Checking permission...";

    if (!navigator.geolocation) {
        alert("Your browser does not support location services.");
        return;
    }

    // Ask permission & get location
    navigator.geolocation.getCurrentPosition(
        function (position) {
            // ✅ User allowed location
            let lat = position.coords.latitude;
            let lng = position.coords.longitude;

            document.getElementById("lat").value = lat;
            document.getElementById("lng").value = lng;

            document.getElementById("location").value = "Fetching address...";
            loader.style.display = "none";
            // ✅ Reverse Geocode (Lat → Address)
            const geocoder = new google.maps.Geocoder();
            const latlng = { lat: lat, lng: lng };

            geocoder.geocode({ location: latlng }, function (results, status) {
                ////if billing is enable that itme code working properly

                // if (status === "OK" && results[0]) {
                //     document.getElementById("location").value =
                //         results[0].formatted_address;
                // } else {
                //     document.getElementById("location").value =
                //         "Location found (" + lat + ", " + lng + ")";
                // }

                if (status === "OK") {
                    loader.style.display = "none";
                    if (results[0]) {
                        document.getElementById("location").value = results[0].formatted_address;
                    }
                }else{
                    document.getElementById("location").value = "Billing not Enable"
                    loader.style.display = "none";
                }
            });
        },

        function (error) {
            // ✅ User denied or error
            loader.style.display = "none";
            if (error.code === error.PERMISSION_DENIED) {
                alert("Please allow location permission to auto-detect your location.");
                document.getElementById("location").value = "";
            } else {
                alert("Unable to get your location.");
                document.getElementById("location").value = "";
            }
        }
    );
});
</script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADIspkSf3W_n0nCMWTN80TWTvkKb6y3LE"></script>
