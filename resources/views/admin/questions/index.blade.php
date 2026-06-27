@extends('layouts.admin')

@section('title', 'Questions')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <form method="GET" action="{{ route('admin.questions.index') }}" class="d-flex flex-wrap gap-2">
            <input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="Search questions..." style="min-width: 220px;">
            <select name="category_id" class="form-select" style="min-width: 180px;">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($selectedCategoryId == $category->id)>{{ $category->category_name }}</option>
                    @foreach ($category->children as $child)
                        <option value="{{ $child->id }}" @selected($selectedCategoryId == $child->id)>
                            &nbsp;&nbsp;&mdash; {{ $child->category_name }}
                        </option>
                    @endforeach
                @endforeach
            </select>
            <select name="status" class="form-select" style="min-width: 160px;">
                <option value="">All Statuses</option>
                <option value="Published" @selected($selectedStatus === 'Published')>Published</option>
                <option value="Draft" @selected($selectedStatus === 'Draft')>Draft</option>
            </select>
            <button class="btn btn-outline-primary"><i class="bi bi-funnel"></i> Filter</button>
        </form>
        <a href="{{ route('admin.questions.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Add Question
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Category</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td class="fw-semibold">{{ \Illuminate\Support\Str::limit($question->question, 60) }}</td>
                        <td>
                            <span class="badge bg-info-subtle text-info-emphasis">
                                @if ($question->category->parent)
                                    {{ $question->category->parent->category_name }} &rarr;
                                @endif
                                {{ $question->category->category_name }}
                            </span>
                        </td>
                        <td>{{ $question->display_order }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.questions.toggle-status', $question) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $question->status === 'Published' ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $question->status }}
                                </button>
                            </form>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" class="d-inline"
                                  onsubmit="return confirm('Delete this question?');">
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
                        <td colspan="6" class="text-center text-muted py-4">No Questions Found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $questions->links() }}
    </div>
@endsection
