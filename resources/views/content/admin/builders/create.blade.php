@extends('layouts/contentNavbarLayout')

@section('title', 'Agent Add')

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/pages-account-settings-account.js'])
@endsection

@section('content')
<style>
.ck-editor__editable_inline {
    min-height: 300px; /* adjust as you like */
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="nav-align-top">
            <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Add Builder</a>
                </li>
               <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin/property-agents-list') }}"><i class="icon-base bx bx-bell icon-sm me-1_5"></i> Builder List</a>
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
            <form action="{{ route('property-builders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                    <!-- <img src="{{ asset($setting->logo ?? '') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" /> -->
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload Photo</span>
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
                            <label for="firstName" class="form-label">Full Name</label>
                            <input class="form-control" type="text" id="firstName" name="fullname" value="" autofocus required/>
                        </div>
                        <div class="col-md-6">
                            <label for="business_name" class="form-label">Business Name </label>
                            <input class="form-control" type="text" name="business_name" id="business_name" value="" required/>
                        </div>                        
                         <div class="col-md-6">
                            <label for="phone" class="form-label">Phone </label>
                            <input class="form-control" type="text" id="phone" name="phone" value="" placeholder="Phone" required/>
                           
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
                         <div class="col-md-12">
                            <label for="description" class="form-label">Description </label>                         
                            <textarea class="form-control" name="description" id="description" row="10"></textarea>
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
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
        toolbar: {
            items: [
                'heading', '|',
        'bold', 'italic', '|',
        'link', 'blockQuote', 'bulletedList', 'numberedList', '|',
        'undo', 'redo'
            ]
        },
        fontColor: {
            colors: [
                { color: 'hsl(0, 0%, 0%)', label: 'Black' },
                { color: 'hsl(0, 75%, 60%)', label: 'Red' },
                { color: 'hsl(30, 75%, 60%)', label: 'Orange' },
                { color: 'hsl(120, 75%, 60%)', label: 'Green' },
                { color: 'hsl(240, 75%, 60%)', label: 'Blue' }
            ]
        }
    })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
