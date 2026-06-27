@extends('layouts.admin')

@section('title', 'Add Question')

@section('content')
    <div class="card shadow-sm" style="max-width: 800px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.questions.store') }}" id="question-form">
                @csrf
                @include('admin.questions._form')
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Save Question
                </button>
                <a href="{{ route('admin.questions.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@include('admin.questions._editor-scripts')
