 document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {     
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
           
            // let filter = this.innerHTML;
            let filter = this.dataset.filter;          
            let container = document.getElementById("property-list");
            container.innerHTML = "<p class='text-center p-5'>Loading...</p>";
            fetch(`/ajax/filter-properties?filter=${filter}`)
                .then(res => res.json())
                .then(data => {                    
                    container.innerHTML = "";
                    if (data.length === 0) {
                        container.innerHTML = "<p class='text-center text-muted p-5'>No properties found.</p>";
                        return;
                    }
                    console.log(data)
                    data.forEach(property => {

                        let tags = "";
                        if (property.featured) tags += "Featured ";
                        if (property.for_sell) tags += "For Sale ";
                        if (property.for_rent) tags += "For Rent ";

                        container.innerHTML += `
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                                <div class="property-item rounded overflow-hidden">

                                    <div class="position-relative overflow-hidden">
                                        <a href="/property/${property.id}">
                                            <img class="img-fluid" src="/${property.pro_img}" alt="">
                                        </a>

                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                            ${tags}
                                        </div>

                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">
                                            ${property.type?.name ?? ""}
                                        </div>
                                    </div>

                                    <div class="p-4 pb-0">
                                        <a class="d-block h5 mb-2" href="/property/${property.id}">
                                            ${property.pro_name}
                                        </a>
                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>
                                            ${property.pro_address}
                                        </p>
                                    </div>

                                    <div class="d-flex border-top">
                                        <small class="flex-fill text-center border-end py-2">
                                            <i class="fa fa-ruler-combined text-primary me-2"></i> 
                                            ${property.pro_area} Sqft
                                        </small>

                                        <small class="flex-fill text-center border-end py-2">
                                            <i class="fa fa-bed text-primary me-2"></i>
                                            ${property.pro_bed} Bed
                                        </small>

                                        <small class="flex-fill text-center py-2">
                                            <i class="fa fa-bath text-primary me-2"></i>
                                            ${property.pro_bath} Bath
                                        </small>
                                    </div>

                                </div>
                            </div>`;
                    });
                });
        });
    });