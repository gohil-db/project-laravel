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
                    <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Properties List</a>
                </li>
                 <li class="nav-item">
                    <!-- <a class="nav-link" href="{{ url('pages/account-settings-notifications') }}"><i class="icon-base bx bx-bell icon-sm me-1_5"></i> Notifications</a> -->
                    <a href="{{ route('properties.create') }}" class="btn btn-primary">+ Add Property</a>
                </li>
               <!-- <li class="nav-item">
                    <a class="nav-link" href="{{ url('pages/account-settings-connections') }}"><i class="icon-base bx bx-link-alt icon-sm me-1_5"></i> Connections</a>
                </li> -->
            </ul>
        </div>
        <div class="card mb-6">

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success fade show" id="alert-message">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        {{-- Auto hide alert after 3 seconds --}}
        <script>
            setTimeout(() => {
                const alert = document.getElementById('alert-message');
                if (alert) alert.remove();
            }, 3000);
        </script>
    @endif
 <div class="card-body">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Type</th>
                <th>Property Name</th>
                <th>Address</th>
                <th>Area (sqft)</th>
                <th>Bed</th>
                <th>Bath</th>
                <th>Home Top</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($properties as $key => $property)
                <tr>
                    <td>{{ $properties->firstItem() + $key }}</td>
                    <td>
                        @if($property->pro_img && file_exists(public_path($property->pro_img)))
                            <img src="{{ asset($property->pro_img) }}" alt="Property" width="80" height="60" class="rounded">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>{{ $property->type->name ?? 'N/A' }}</td>
                    <td>{{ $property->pro_name }}</td>
                    <td>{{ $property->pro_address }}</td>
                    <td>{{ $property->pro_area ?? '-' }}</td>
                    <td>{{ $property->pro_bed ?? '-' }}</td>
                    <td>{{ $property->pro_bath ?? '-' }}</td>
                    <td>
                        <button class="btn btn-sm toggle-top-btn {{ $property->display_top ? 'btn-info' : 'btn-danger' }}" data-id="{{ $property->id }}">
                            {{ $property->display_top ? 'Yes' : 'No' }}
                        </button>
                    </td>

                    <td>
                        <button class="btn btn-sm toggle-status {{ $property->status ? 'btn-success' : 'btn-danger' }}" data-id="{{ $property->id }}">
                            {{ $property->status ? 'Active' : 'Inactive' }}
                        </button>
                        <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('properties.destroy', $property->id) }}" method="POST" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this property?')"><i class="bx bx-trash me-1"> </i>Del</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">No properties found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
        {{-- Pagination Links --}}
        <div class="mt-3">        
            {{ $properties->links('pagination::bootstrap-5') }} 
        </div>

</div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.toggle-status', function() {
        const button = $(this);
        const propertyId = button.data('id');
        $.ajax({
            url: `/properties/${propertyId}/property-status`,
            type: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    if (response.status) {
                        button.removeClass('btn-danger').addClass('btn-success').text('Active');
                    } else {
                        button.removeClass('btn-success').addClass('btn-danger').text('Inactive');
                    }
                    alert('Property status Update Successfully.');
                }
            },
            error: function() {
                alert('Error updating status.');
            }
        });
    });
</script>


<script>
    $(document).on('click', '.toggle-top-btn', function () {
        let button = $(this);
        let id = button.data('id');

        $.ajax({
            url: "/properties/" + id + "/toggle-top",
            method: "PATCH",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                if (res.success) {
                    if (res.display_top) {
                        button.removeClass('btn-danger').addClass('btn-info');
                        button.text('Yes');
                    } else {
                        button.removeClass('btn-info').addClass('btn-danger');
                        button.text('No');
                    }
                }
            },
            error: function() {
                alert("Error updating display_top!");
            }
        });
    });
</script>

@endsection
