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
             <!-- <form id="formAccountSettings" method="POST" onsubmit="return false"> -->
            <form action="{{ route('property-agents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                    <!-- <img src="{{ asset($setting->logo ?? '') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" /> -->
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload Agent Photo</span>
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
                            <label for="firstName" class="form-label">Agent Name</label>
                            <input class="form-control" type="text" id="firstName" name="fullname" value="" autofocus required/>
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Designation </label>
                            <input class="form-control" type="text" name="designation" id="lastName" value="" required/>
                        </div>
                         <div class="col-md-6">
                            <label for="description" class="form-label">Description </label>
                            <input class="form-control" type="text" id="description" name="description" value="" placeholder="Description" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="fb_link">Facebook link</label>                           
                            <input type="text" id="fb_link" name="fb_link" class="form-control" value="" placeholder="fb_link" />                            
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="insta_link">Intsagram link</label>                           
                            <input type="text" id="insta_link" name="insta_link" class="form-control" value="" placeholder="insta_link" />                            
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="x_link">Twitter link</label>                           
                            <input type="text" id="x_link" name="x_link" class="form-control" value="" placeholder="x_link" />                            
                        </div>

                    </div>
                    <div class="mt-6">
                        <button type="submit" class="btn btn-primary me-3">Add</button>                       
                         <a href="{{ url('admin/property-agents-list') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>                   
                
            </div>
            </form>
            <!-- /Account -->
        </div>        
    </div>
</div>
@endsection
