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
<!-- <div class="container mt-4"> -->

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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($properties as $key => $property)
                <tr>
                    <td>{{ $key + 1 }}</td>
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
                        <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('properties.destroy', $property->id) }}" method="POST" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this property?')">Delete</button>
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
<!-- </div> -->
</div>
</div>
</div>
</div>
@endsection
