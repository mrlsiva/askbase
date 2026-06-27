@extends('layouts.admin')

@section('title', 'Add Category')

@section('content')
    <div class="card shadow-sm" style="max-width: 700px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf
                @include('admin.categories._form')
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Save Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
