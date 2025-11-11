@extends('layouts/contentNavbarLayout')

@section('title', 'Property Types')

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
                    <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Edit Testimonial </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/testimonials-list') }}"><i class="icon-base bx bx-bell icon-sm me-1_5"></i> Testimonials List</a>                   
                </li>
 
            </ul>
        </div>
        <div class="card mb-6">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
  <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Client Name</label>
            <input type="text" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Profession</label>
            <input type="text" name="profession" value="{{ old('profession', $testimonial->profession) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $testimonial->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            @if($testimonial->image)
                <img src="{{ asset($testimonial->image) }}" width="120" class="mb-2 rounded">
            @else
                <p>No image uploaded.</p>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Change Image</label>
            <input type="file" name="image" class="form-control">
            <small class="text-muted">Upload new image to replace the current one (optional)</small>
        </div>

        <button type="submit" class="btn btn-success">Update Testimonial</button>
        <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
</div>
</div>
@endsection
