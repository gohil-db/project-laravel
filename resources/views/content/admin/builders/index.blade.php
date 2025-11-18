@extends('layouts/contentNavbarLayout')

@section('title', 'Agent List')

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
                    <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Builders List</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin/property-builders-create') }}"><i class="icon-base bx bx-bell icon-sm me-1_5"></i> Add New Builder</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{ url('pages/account-settings-connections') }}"><i class="icon-base bx bx-link-alt icon-sm me-1_5"></i> Connections</a>
                </li> -->
            </ul>
        </div>
        <div class="card mb-6">
        @if (session('success'))
            <div class="alert alert-success" id="alert-message">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => document.getElementById('alert-message')?.remove(), 3000);
            </script>
        @endif
    <div class="card-body">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Builder Name</th>
                <th>Business Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($builders as $key => $builder)
                <tr>
                    <td>{{ $builders->firstItem() + $key }}</td>
                    <td>{{ $builder->fullname }}</td>
                    <td>{{ $builder->business_name ?? '-' }}</td>
                    <td>{!! Str::limit($builder->description, 60) !!}</td>
                    <td>
                        @if($builder->image && file_exists(public_path($builder->image)))
                            <img src="{{ asset($builder->image) }}" width="80" height="80" class="rounded">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('property-builders.edit', $builder->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('property-builders.destroy', $builder->id) }}" method="POST" class="d-inline">
                            @csrf 
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this Builder?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-3">No builders found</td></tr>
            @endforelse
        </tbody>
    </table>
        {{-- Pagination Links --}}
        <div class="mt-3">        
            {{ $builders->links('pagination::bootstrap-5') }}
        </div>
    </div>
    </div>
</div>
</div>
@endsection
