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
                    <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-user icon-sm me-1_5"></i> Propert List</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin/property-types-create') }}"><i class="icon-base bx bx-bell icon-sm me-1_5"></i> Add New Type</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{ url('pages/account-settings-connections') }}"><i class="icon-base bx bx-link-alt icon-sm me-1_5"></i> Connections</a>
                </li> -->
            </ul>
        </div>
        <div class="card mb-6">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
    <!-- <h5 class="card-header">Property Types</h5> -->
    <div class="table-responsive text-nowrap">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>              
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                 @foreach($types as $type)
                <tr>
                    <td><span>{{ $loop->iteration }}</span></td>
                    <td><span>{{ $type->name }}</span></td>
                    <td>{{ $type->description }}</td>
                    <td>
                     <!-- <img src="{{ asset('assets/img/icon-apartment.png') }}" alt="Avatar" class="rounded-circle" />                            -->
                     <img src="{{ asset($type->type_img ?? 'assets/img/icon-apartment.png') }}" alt="Avatar" class="rounded-circle" />                           
                    </td>
                    <td>
                        <a href="{{ route('property-types.edit', $type->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('property-types.destroy', $type->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this type?')">Delete</button>
                        </form>
                    </td>
                    <!-- <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);"><i class="icon-base bx bx-trash me-1"></i> Delete</a>
                            </div>
                        </div>
                    </td> -->
                </tr>   
                @endforeach   
            </tbody>
        </table>
    </div>
</div>
<!-- </div> -->
</div>
</div>
</div>
@endsection
