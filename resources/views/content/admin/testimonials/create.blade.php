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
                    <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Add Testimonial</a>
                </li>
               <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/testimonials-list') }}"><i class="icon-base bx bx-bell icon-sm me-1_5"></i> Testimonial List</a>
                </li>      
            </ul>
        </div>
        <div class="card mb-6">

    <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
        <div class="mb-3">
            <label>Client Name</label>
            <input type="text" name="client_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Profession</label>
            <input type="text" name="profession" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" rows="4" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Client Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ url('admin/testimonials-list') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</div>
</div>
@endsection
