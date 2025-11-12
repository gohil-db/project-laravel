@extends('layouts/contentNavbarLayout')

@section('title', 'User Inquiry')

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
                    <a class="nav-link active" href="javascript:void(0);"><i class="icon-base bx bx-user icon-sm me-1_5"></i> inquiries List</a>
                </li>                
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
                    <th>Property Name</th>
                    <th>User Name</th>
                    <th>Number</th>
                    <th>City</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inquiries as $inquiry)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $inquiry->property->pro_name ?? 'N/A' }}</td>
                        <td>{{ $inquiry->name }}</td>
                        <td>{{ $inquiry->number }}</td>
                        <td>{{ $inquiry->city }}</td>
                        <td>{{ $inquiry->created_at->format('d M Y') }}</td>
                        <td>
                        <form action="{{ route('inquiries.destroy', $inquiry->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this inquiry?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No inquiries found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
 </div>
</div>
</div>
@endsection
