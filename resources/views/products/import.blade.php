@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Import Products</h1>

    {{-- Display success or error messages --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- File Upload Form --}}
    <div class="container">
        <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="row">
            @csrf
            <div class="form-group col-md-6">
                <label for="file">Upload Excel File (Import)</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary mt-3">Import</button>
            </div>
        </form>

        <hr>

        <form action="{{ route('products.update') }}" method="POST" enctype="multipart/form-data" class="row">
            @csrf
            <div class="form-group col-md-6">
                <label for="update_file">Upload Excel File (Update)</label>
                <input type="file" name="update_file" id="update_file" class="form-control" required>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success mt-3">Update</button>
            </div>
        </form>
    </div>


    {{-- Product List --}}
    <h2 class="mt-5">Product List</h2>

    @if($products->isEmpty())
        <p>No products available. Please import a file.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Product SKU</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination Links --}}
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
