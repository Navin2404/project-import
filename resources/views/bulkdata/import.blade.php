@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
    }
    .card {
        border-radius: 15px;
    }
    .card-header {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .form-label {
        font-size: 1.1rem;
    }
    .btn-primary {
        background-color: black;
        border-color:rgba(48, 49, 50, 0.24);
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color:rgb(98, 100, 101);
        border-color:rgb(100, 102, 104);
    }
</style>

<div class="container mt-2">
    @if(session('success'))
        <div class="alert alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card">
        <!-- <div class="card-header bg-primary text-white text-center">
            <h1>Import Excel File</h1>
        </div> -->
        <div class="container mt-5">
            <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h1 class="m-0">Import Excel File</h1>
            </div>
                <div class="card-body p-5">
                    <form action="{{ route('bulkdata.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="file" class="form-label fw-bold">Select Excel File</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-4">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("file").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });

    document.getElementById('importForm').addEventListener('submit', function(e) {
        var submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerText = 'Importing...';
        document.getElementById('progressBar').style.display = 'block';
    });
</script>
@endsection
