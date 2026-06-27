@extends('layouts.admin')

@section('title', 'Edit Question')

@section('content')
    <div class="card shadow-sm" style="max-width: 800px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.questions.update', $question) }}" id="question-form">
                @csrf
                @method('PUT')
                @include('admin.questions._form')
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Update Question
                </button>
                <a href="{{ route('admin.questions.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@include('admin.questions._editor-scripts')
