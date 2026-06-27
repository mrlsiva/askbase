@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="d-flex" style="max-width: 320px;">
            <input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search categories...">
            <button class="btn btn-outline-primary ms-2"><i class="bi bi-search"></i></button>
        </form>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Category
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Questions</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            @if ($category->image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($category->image) }}"
                                     alt="{{ $category->category_name }}" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <span class="text-muted"><i class="bi bi-image"></i></span>
                            @endif
                        </td>
                        <td class="fw-semibold">
                            @if ($category->parent)
                                <span class="text-muted ms-3"><i class="bi bi-arrow-return-right"></i></span>
                            @endif
                            {{ $category->category_name }}
                            @if ($category->parent)
                                <span class="badge bg-light text-secondary border ms-1">sub of {{ $category->parent->category_name }}</span>
                            @endif
                        </td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td><span class="badge bg-secondary">{{ $category->questions_count }}</span></td>
                        <td>
                            <form method="POST" action="{{ route('admin.categories.toggle-status', $category) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $category->status === 'Active' ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $category->status }}
                                </button>
                            </form>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline"
                                  onsubmit="return confirm('Delete this category? This will also affect related questions.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No Categories Found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $categories->links() }}
    </div>
@endsection
