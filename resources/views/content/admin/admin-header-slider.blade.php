@extends('layouts/contentNavbarLayout')

@section('title', 'Header Slider')

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
                    <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Header Slider</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{ url('pages/account-settings-notifications') }}"><i class="icon-base bx bx-bell icon-sm me-1_5"></i> Notifications</a>
                </li>
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
             <!-- <form id="formAccountSettings" method="POST" onsubmit="return false"> -->
            <form action="{{ route('header-slider') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                    <!-- <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" /> -->
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new Image</span>
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
                    <div class="mt-6">
                        <button type="submit" class="btn btn-primary me-3">Add Image</button>
                    </div>    
            </div>
            </form>
            <!-- /Account -->
        </div>    
        <div class="card mb-6">
            <div class="card-body">
                <h5 class="card-header">Header Slider Images</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Image</th>              
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                             @foreach($sliders as $slider)
                            <tr>
                                <td><span>{{ $loop->iteration }}</span></td>
                                <td>
                                 <img src="{{ asset($slider->image) }}" name="image"  alt="Avatar" height="100px" class="rounded" />                           
                                </td>
                                <td>
                                    <form action="{{ route('header-slider.destroy', $slider) }}" method="POST" class="d-inline">
                                        @csrf 
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this image?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Account -->    
    </div>
</div>
@endsection
