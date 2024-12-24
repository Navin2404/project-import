@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bulk Data Management</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    
    <!-- File Upload Form -->
    <form action="{{ route('bulkdata.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Upload Excel File</label>
            <!-- <input type="file" class="form-control" name="file" required> -->
        </div>
        <a class="btn btn-primary" href="{{ route('bulkdata.import.page') }}">Import Data</a>
    </form>

    <hr>

    <!-- Display Data -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>
                    <form action="{{ route('bulkdata.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="d-flex">
                            <input type="text" name="name" value="{{ $item->name }}" class="form-control me-2" required>
                            <input type="text" name="email" value="{{ $item->email }}" class="form-control me-2" required>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $data->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
