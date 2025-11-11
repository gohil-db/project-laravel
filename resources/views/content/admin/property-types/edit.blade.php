@extends('layouts/contentNavbarLayout')

@section('title', 'Agent Add')

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
                    <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Add Agent</a>
                </li>
               <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/property-agents-list') }}"><i class="icon-base bx bx-bell icon-sm me-1_5"></i> Agent List</a>
                <!--  </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('pages/account-settings-connections') }}"><i class="icon-base bx bx-link-alt icon-sm me-1_5"></i> Connections</a>
                </li> -->
            </ul>
        </div>
        <div class="card mb-6">
            <!-- Account -->
             @if(session('success'))
                <div class="alert alert-success alert-dismissible ">{{ session('success') }}</div>                
            @endif
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

            <form action="{{ route('property-types.update', $propertyType->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                    <!-- <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" /> -->
                    <img src="{{ asset($propertyType->type_img ?? '') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload Type Icon</span>
                            <i class="icon-base bx bx-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" name="image" class="account-file-input" hidden accept="image/png, image/jpeg" />
                        </label>
                        <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                            <i class="icon-base bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                        </button>
                        <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4">               
                    <div class="row g-6">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">Type Name</label>
                            <input class="form-control" type="text" id="firstName" name="name" value="{{ old('name', $propertyType->name) }}" autofocus required/>
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Description </label>
                            <input class="form-control" type="text" name="description" id="lastName" value="{{ old('description', $propertyType->description) }}" required/>
                        </div>
                         
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="btn btn-primary me-3">Save Changes</button>                       
                         <a href="{{ url('admin/property-types-list') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>                   
                
            </div>
            </form>
            <!-- /Account -->
        </div>        
    </div>
</div>
@endsection

